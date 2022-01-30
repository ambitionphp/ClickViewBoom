<?php

namespace App\Http\Livewire;

use App\Models\Text;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class PrivateText extends Component
{
    public $text;
    public $decrypted = null;
    public $boom = 0;
    public $passphrase;

    public $generatedPassphrase;

    public function mount()
    {
        $session = session()->pull('private_key');
        $passphrase = session()->pull('passphrase');
        if( $passphrase ) {
            $this->generatedPassphrase = $passphrase;
        }
        dd([
            request()->get('token'),
            md5($this->text->expires_at)
        ]);
        if( ( $session &&  intval($session) === $this->text->private_key ) || ( request()->has('token') && request()->get('token') === md5($this->text->expires_at) ) ) {
            if( $this->text->password ) {
                $this->decrypted = 'This message is encrypted with your passphrase.';
            }
            else {
                try {
                    $this->decrypted = \Illuminate\Support\Facades\Crypt::decryptString($this->text->content);
                } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                    $this->decrypted = null;
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.private-text');
    }

    public function boomText($confirm=null)
    {
        if( 2 === intval($confirm) ) {
            if( $this->text->password ) {
                $this->validate([
                    'passphrase' => ['required']
                ]);
            }
            if( !$this->text->password || Hash::check($this->passphrase, $this->text->password) ) {
                Text::find($this->text->id)->delete();
                return redirect()->to(route('text.private', $this->text));
            }
        }
        $this->boom = $confirm;
    }
}
