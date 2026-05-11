<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\QRPlate;
use Livewire\WithPagination;


class BatchViewer extends Component
{
    protected $paginationTheme = 'tailwind';
    use WithPagination;

    public $selectedBatch = 'disponibles';

    public $search = '';

    public $searchInAll = false;

    public function updatedSearch()
    {
        $this->searchInAll = false;
        $this->resetPage();
    }

    public function updatedSelectedBatch()
    {
        $this->resetPage();
    }

    public function searchAll()
    {
        $this->searchInAll = true;
        $this->resetPage();
    }

    public function render()
    {
        $batchIds = QRPlate::query()
            ->whereNotNull('batch_id')
            ->select('batch_id')
            ->distinct()
            ->orderBy('batch_id')
            ->pluck('batch_id');

        $batches = collect(['disponibles'])->merge($batchIds);

        $query = QRPlate::query();

        if (! $this->searchInAll) {
            if ($this->selectedBatch === 'disponibles') {
                $query->whereNull('batch_id');
            } elseif ($this->selectedBatch !== '' && $this->selectedBatch !== null) {
                $query->where('batch_id', (int) $this->selectedBatch);
            }
        }

        if ($this->search) {
            $query->where('code', 'like', '%' . $this->search . '%');
        }

        $qrs = $query->latest()->paginate(20);

        return view('livewire.admin.batch-viewer', [
            'qrs' => $qrs,
            'batches' => $batches,
        ]);
    }

    public function getDisponiblesCountProperty()
    {
        return QRPlate::whereNull('batch_id')->count();
    }
}
