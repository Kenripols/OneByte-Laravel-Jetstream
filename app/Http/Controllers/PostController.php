<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function feed(Request $request)
    {
        $now = now();
        // Si publish_at o expires_at son null, importante que sea NULL, no 00/00/0000
        // el post se considera siempre visible en ese aspecto
        $posts = Post::where('is_active', true)->where(function ($q) use ($now) {
            $q->whereNull('publish_at')->orWhere('publish_at', '<=', $now);
        })->where(function ($q) use ($now) {
            $q->whereNull('expires_at')->orWhere('expires_at', '>=', $now);
        })
        ->latest()
        ->take(10)
        ->get();

        return response()->json($posts);
    }

    public function index(Request $request)
    {
        $query = Post::with('pet');

        $type = $request->query('type');
        if (in_array($type, ['tip', 'news', 'lost'], true)) {
            $query->where('type', $type);
        }

        $isActive = $request->query('is_active');
        if (in_array($isActive, ['0', '1'], true)) {
            $query->where('is_active', (int) $isActive);
        }

        $allowedSorts = ['id', 'title', 'type', 'is_active', 'publish_at', 'created_at'];
        $sort = $request->query('sort', 'created_at');
        $direction = $request->query('direction', 'desc');

        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'created_at';
        }
        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'desc';
        }

        $query->orderBy($sort, $direction);

        $posts = $query->paginate(15)->withQueryString();

        return view('admin.posts.index', compact('posts', 'sort', 'direction'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|max:80',
            'type' => 'required|in:tip,news',
            'publish_at' => 'nullable|date|required_if:type,news',
            'expires_at' => 'nullable|date|after:publish_at|required_if:type,news',
        ];

        $rules['image'] = $request->expectsJson()
            ? 'nullable|string'
            : 'nullable|image|max:2048';

        $data = $request->validate($rules);

        $data['is_active'] = true;
        if ($data['type'] === 'tip') {
            $data['publish_at'] = null;
            $data['expires_at'] = null;
        }
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create($data);

        if ($request->expectsJson()) {
            return response()->json($post);
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Publicación creada correctamente.');
    }

    public function edit(Post $post)
    {
        if (!in_array($post->type, ['tip', 'news'], true)) {
            return redirect()->route('admin.posts.index')
                ->with('error', 'Solo se pueden editar publicaciones de tipo tip o news.');
        }

        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        if (!in_array($post->type, ['tip', 'news'], true)) {
            return redirect()->route('admin.posts.index')
                ->with('error', 'Solo se pueden editar publicaciones de tipo tip o news.');
        }

        $rules = [
            'title' => 'required|max:80',
            'type' => 'required|in:tip,news',
            'is_active' => 'nullable|boolean',
            'publish_at' => 'nullable|date|required_if:type,news',
            'expires_at' => 'nullable|date|after:publish_at|required_if:type,news',
        ];

        $rules['image'] = $request->expectsJson()
            ? 'nullable|string'
            : 'nullable|image|max:2048';

        $data = $request->validate($rules);

        if (!$request->expectsJson()) {
            $data['is_active'] = $request->boolean('is_active');
        }
        if ($request->hasFile('image')) {
            if (!empty($post->image) && !str_starts_with($post->image, 'http')) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = $request->file('image')->store('posts', 'public');
        } elseif (!$request->expectsJson()) {
            // Keep existing image if admin did not upload a new one.
            unset($data['image']);
        }
        if ($data['type'] === 'tip') {
            $data['publish_at'] = null;
            $data['expires_at'] = null;
        }

        $post->update($data);

        if ($request->expectsJson()) {
            return response()->json($post);
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Publicación actualizada correctamente.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Publicación eliminada (borrado lógico).');
    }
}
