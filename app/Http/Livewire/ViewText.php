<?php

namespace App\Http\Livewire;

use App\Helpers\Secretbox;
use App\Models\Text;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ViewText extends Component
{
    private $text;
    public $text_id;
    public $decrypted;
    public $visible = false;
    public $passphrase;

    public function mount(Text $text)
    {
        $this->text = $text;
        $this->text_id = (string) $text->id;
    }

    public function render()
    {
        return view('livewire.view-text', [
            'text' => $this->text
        ]);
    }

    public function viewSecret()
    {
        $text = Text::find($this->text_id);
        if( $text->password ) {
            $this->validate(['passphrase' => ['required']]);
        }

        if( ! $text->password || Hash::check($this->passphrase, $text->password) ) {
            try {
                $this->decrypted = \Illuminate\Support\Facades\Crypt::decryptString($text->content);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                $this->decrypted = null;
            }

            if( $this->decrypted && $text->password ) {
                $secretbox = new Secretbox;
                $this->decrypted = $secretbox->decrypt($this->decrypted, $this->passphrase);
            }
            Text::find($text->id)->delete();
            $this->visible = true;
        }
    }
}
