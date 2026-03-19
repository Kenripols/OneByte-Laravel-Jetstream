<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\QrPlate;
use Livewire\WithPagination;

class BatchViewer extends Component
{
    use WithPagination;

    public $batches = [];
    public $selectedBatch = 'disponibles';
    public $search = '';
    public $searchInAll = false;
    public $disponiblesCount = 0;
    public function mount()
    {
    
        $batches = QrPlate::select('batch_id')
            ->distinct()
            ->pluck('batch_id')
            ->filter();

        $this->batches = collect(['disponibles'])
            ->merge($batches);
    $this->disponiblesCount = QrPlate::whereNull('batch_id')->count(); //contar para que muestre en el combobox
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