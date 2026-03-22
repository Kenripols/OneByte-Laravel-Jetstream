<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\QRPlate;
use Livewire\WithPagination;


class BatchViewer extends Component
{
    protected $paginationTheme = 'tailwind';
    use WithPagination;

    public $batches = [];
    public $selectedBatch = 'disponibles';
    public $search = '';
    public $searchInAll = false;
    public function mount()
    {
    
       $batches = QrPlate::whereNotNull('batch_id')
        ->distinct()
        ->orderBy('batch_id')
        ->pluck('batch_id');

        $this->batches = collect(['disponibles'])
            ->merge($batches);
    }
    
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
        $query = QrPlate::query();

        // filtro por batch
    if (!$this->searchInAll) {
        if ($this->selectedBatch === 'disponibles') {
            $query->whereNull('batch_id');
        } elseif (!empty($this->selectedBatch)) {
            $query->where('batch_id', $this->selectedBatch);
        }
    }

        // búsqueda
        if ($this->search) {
            $query->where('code', 'like', '%' . $this->search . '%');
        }

        $qrs = $query->latest()->paginate(20);

        return view('livewire.admin.batch-viewer', [
            'qrs' => $qrs
        ]);
    }
    public function getDisponiblesCountProperty(){
            return QrPlate::whereNull('batch_id')->count();
    }
}
