<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:80',
            'type' => 'required|in:tip,news',
            'image' => 'nullable|string',            
            'publish_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:publish_at',
        ]);

        $data['is_active'] = true;

        $post = Post::create($data);

        return response()->json($post);
    }
    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => 'required|max:80',
            'type' => 'required|in:tip,news',
            'image' => 'nullable|string',
            'publish_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:publish_at',
            'is_active' => 'boolean',
        ]);

        $post->update($data);

        return response()->json($post);
    }
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json(['ok' => true]);
    }
}
