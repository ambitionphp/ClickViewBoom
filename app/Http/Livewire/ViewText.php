<?php

namespace App\Http\Livewire;

use App\Models\Text;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ViewText extends Component
{
    public $text;
    public $decrypted;
    public $visible = false;
    public $passphrase;

    public function render()
    {
        return view('livewire.view-text');
    }

    public function viewSecret()
    {
        if( $this->text->password ) {
            $this->validate(['passphrase' => ['required']]);
        }

        if( ! $this->text->password || ( $this->text->password && Hash::check($this->passphrase, $this->text->password) ) ) {
            try {
                $this->decrypted = \Illuminate\Support\Facades\Crypt::decryptString($this->text->content);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                $this->decrypted = null;
            }
            Text::find($this->text->id)->delete();
            $this->visible = true;
        }
    }
}
