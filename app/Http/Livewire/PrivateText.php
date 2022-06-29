<?php

namespace App\Http\Livewire;

use App\Models\Text;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class PrivateText extends Component
{
    private $text;
    public $text_id;
    public $decrypted = null;
    public $boom = 0;
    public $passphrase;

    public $generatedPassphrase;

    public function mount(Text $text)
    {
        $this->text = $text;
        $this->text_id = (string) $text->id;

        $session = session()->pull('private_key');
        $passphrase = session()->pull('passphrase');
        if( $passphrase ) {
            $this->generatedPassphrase = $passphrase;
        }

        if( ( $session &&  intval($session) === $this->text->private_key ) || ( request()->has('token') && request()->get('token') === md5($this->text->expires_at->toJSON()) ) ) {
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
        $text = Text::find($this->text_id);
        return view('livewire.private-text', [
            'text' => $text
        ]);
    }

    public function boomText($confirm=null)
    {
        $text = Text::find($this->text_id);

        if( 2 === intval($confirm) ) {
            if( $text->password ) {
                $this->validate([
                    'passphrase' => ['required']
                ]);
            }
            if( !$text->password || Hash::check($this->passphrase, $text->password) ) {
                Text::find($text->id)->delete();
                return redirect()->to(route('text.private', $text));
            }
        }
        $this->boom = $confirm;
    }
}
