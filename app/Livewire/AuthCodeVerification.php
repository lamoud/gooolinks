<?php

namespace App\Livewire;

use Livewire\Component;

class AuthCodeVerification extends Component
{
    public $recovery = false;

    public function setRecoveryStatus( $status )
    {
        $this->recovery = $status;
    }
    
    public function render()
    {
        return view('livewire.auth-code-verification');
    }
}
