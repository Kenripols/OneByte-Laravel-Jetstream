<?php

namespace App\Livewire;

use Livewire\Component;

class QrPendingBanner extends Component
{
    public $qr;
    public $showModal = false;
   
     protected $listeners = ['openQrModal' => 'openModal'];
    
public function mount()
    {
        if (auth()->check() && auth()->user()->qr_pending_id) {
            $this->qr = auth()->user()->qrPending;
        }
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.qr-pending-banner');
    }
}