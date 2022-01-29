<?php

namespace App\Http\Livewire;

use App\Helpers\Secret;
use App\Jobs\BoomText;
use App\Mail\SecretReceived;
use App\Models\Text;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;
use Illuminate\Support\Facades\Crypt;

class CreateTextForm extends Component
{
    public $content;
    public $passphrase;
    public $lifetime = 10080;
    public $recipient;

    protected $rules = [
        'content' => 'required',
    ];

    public function render()
    {
        return view('livewire.create-text-form');
    }

    public function generate($withRandomPassphrase=false)
    {
        $this->validate();

        $secret = new Secret(Auth::id());
        $text = $secret->create(
            $this->content,
            $this->lifetime,
            $withRandomPassphrase,
            $this->passphrase,
            $this->recipient
        );

        // redirect to private page with share link/secret content
        return redirect()->to(route('text.private', $text));
    }
}
