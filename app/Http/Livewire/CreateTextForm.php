<?php

namespace App\Http\Livewire;

use App\Jobs\BoomText;
use App\Models\Text;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        if( $withRandomPassphrase ) {
            $this->passphrase = Str::random(10);
            session(['passphrase'=>$this->passphrase]);
        }

        $private_key = resolve('snowflake')->id();

        $user_id = Auth::id();

        $passphrase = $this->passphrase;
        if( null !== $passphrase && !strlen($passphrase) )
            $passphrase = null;
        elseif( null !== $passphrase )
            $passphrase = Hash::make($passphrase);


        $text = Text::create([
            'private_key' => $private_key,
            'user_id' => $user_id,
            'content' => Crypt::encryptString($this->content),
            'password' => $passphrase,
            'expires_at' => now()->addMinutes($this->lifetime)
        ]);

        // create delayed job to delete text (if in production)
        if( 'production' === config('app.env') ) BoomText::dispatch($text->id)->delay($text->expires_at);

        // create session to allow viewing share link/secret content
        session(['private_key'=>$text->private_key]);

        // redirect to private page with share link/secret content
        return redirect()->to(route('text.private', $text));
    }
}
