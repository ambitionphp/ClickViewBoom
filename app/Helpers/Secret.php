<?php
namespace App\Helpers;

use App\Jobs\BoomText;
use App\Mail\SecretReceived;
use App\Models\Text;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Encryption\Encrypter;

class Secret {

    public $private_key;
    public $user_id;

    public function __construct($user) {
        $this->user_id = $user;
        $this->private_key = $this->private_key();
    }

    private function private_key() {
        return resolve('snowflake')->id();
    }

    public function create($content, $ttl, $random = 0, $passphrase = null, $recipient = null) {

        $password = $this->passphrase($random, $passphrase);

        $text = Text::create([
            'private_key' => $this->private_key,
            'user_id' => $this->user_id,
            'content' => Crypt::encryptString($password['exists'] ? $this->encryptFromPassphrase($password['plain'], $content) : $content),
            'password' => $password['hash'],
            'expires_at' => now()->addMinutes($ttl)
        ]);

        // create delayed job to delete text (if in production)
        if( 'production' === config('app.env') ) BoomText::dispatch($text->id)->delay($text->expires_at);

        if( $recipient ) {
            dispatch(function () use ($recipient, $text) {
                Mail::to($recipient)->send(new SecretReceived($text));
            })->afterResponse();
        }

        // create session to allow viewing share link/secret content
        session(['private_key'=>$text->private_key]);

        return $text;
    }

    private function encryptFromPassphrase($passphrase, $content) {
        $secretbox = new Secretbox;
        return $secretbox->encrypt($content, $passphrase);
    }

    public static function decryptFromPassphrase($passphrase, $content) {
        $secretbox = new Secretbox;
        return $secretbox->decrypt($content, $passphrase);
    }

    private function passphrase($random, $passphrase) {
        if( $random ) {
            $passphrase = Str::random(10);
            session(['passphrase'=>$passphrase]);
        }
        return [
            'plain' => $passphrase && strlen($passphrase) ? $passphrase : null,
            'hash' => $passphrase && strlen($passphrase) ? Hash::make($passphrase) : null,
            'random' => $random,
            'exists' => $passphrase && strlen($passphrase)
        ];
    }

}
