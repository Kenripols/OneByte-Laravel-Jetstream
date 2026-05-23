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
        if (auth()->check() && auth()->user()->claimed_qr_id) {
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

    public function forgetQr()
    {
        if (! $this->qr) {
            return;
        }

        $this->qr->forget(auth()->id());
        auth()->user()->update(['claimed_qr_id' => null]);

        $this->qr = null;
        $this->showModal = false;

        session()->forget('claimed_qr_id');
    }

    public function render()
    {
        return view('livewire.qr-pending-banner');
    }
}