<?php

namespace App\Http\Livewire;

use Livewire\Component;

class EmergencyFlush extends Component
{
    public $confirmed = false;

    public function render()
    {
        return view('livewire.emergency-flush');
    }

    public function confirmed() {
        auth()->user()->texts()->delete();
        return redirect()->route('recent');
    }
}
