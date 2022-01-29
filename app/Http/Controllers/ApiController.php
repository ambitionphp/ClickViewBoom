<?php

namespace App\Http\Controllers;

use App\Helpers\Secret;
use App\Helpers\Secretbox;
use App\Jobs\BoomText;
use App\Mail\SecretReceived;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Text;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    public function user(Request $request) {
        return response()->json([
            'id' => $request->user()->id,
            'email' => $this->hideEmailAddress($request->user()->email),
            'texts' => $request->user()->texts->count(),
            'created_at' => $request->user()->created_at
        ]);
    }

    private function hideEmailAddress($email)
    {
        if(filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            list($first, $last) = explode('@', $email);
            $first = str_replace(substr($first, '3'), str_repeat('*', strlen($first)-3), $first);
            $last = explode('.', $last);
            $last_domain = str_replace(substr($last['0'], '1'), str_repeat('*', strlen($last['0'])-1), $last['0']);
            return $first.'@'.$last_domain.'.'.$last['1'];
        }
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'secret' => ['required'],
            'ttl' => ['required', 'integer', 'in:5,30,60,240,720,1440,4320,10080'],
        ]);

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->messages(),
            ]);
        }

        $secret = new Secret(Auth::id(), true);
        $text = $secret->create(
            $request->get('secret'),
            $request->get('ttl'),
            $request->has('passphraseRandom'),
            $request->get('passphrase'),
            $request->get('recipient')
        );

        return response()->json([
            'id' => $text->id,
            'private_key' => $text->private_key,
            'passphrase' => session('passphrase') ?? (bool) $text->password,
            'url' => route('text.secret', $text),
            'expires_at' => $text->expires_at
        ]);
    }

    public function secret(Text $text, Request $request) {

        $validator = Validator::make($request->all(), [
            'secret' => ['required']
        ]);

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->messages(),
            ]);
        }

        $errors = [];

        $text = Text::find( $request->get('secret') );

        if( ! $text ) {
            $errors[] = 'Secret has never existed or has already been viewed.';
        }

        if( !count($errors) && $text->password && ( ! $request->has('passphrase') || ! Hash::check($request->get('passphrase'), $text->password) ) ) {
            $errors[] = 'Passphrase not set or incorrect.';
        }

        if( count($errors) ) {
            return response()->json([
                'success' => false,
                'errors' => $errors,
            ]);
        }

        try {
            $decrypted = \Illuminate\Support\Facades\Crypt::decryptString($text->content);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            $decrypted = null;
        }

        if( $decrypted && $text->password ) {
            $secretbox = new Secretbox;
            $decrypted = $secretbox->decrypt($decrypted, $request->get('passphrase'));
        }

        Text::find($text->id)->delete();

        return response()->json([
            'id' => $text->id,
            'secret' => $decrypted
        ]);
    }

    public function boom(Text $text, Request $request) {

        $validator = Validator::make($request->all(), [
            'private_key' => ['required']
        ]);

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->messages(),
            ]);
        }

        $text = Text::where('private_key', $request->get('private_key'))->first();

        if( ! $text ) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'Secret has never existed or has already been viewed.'
                ],
            ]);
        }

        $id = $text->id;
        $text->delete();
        return response()->json([
            'id' => $id,
            'deleted' => true,
            'deleted_at' => now()
        ]);
    }

    public function recent(Request $request) {
        $texts = $request->user()->texts()->orderBy('id', 'desc')->get()->map(function($item) {
            return [
                'id' => $item->id,
                'passphrase' => (bool) $item->password,
                'url' => route('text.secret', $item),
                'expires_at' => $item->expires_at
            ];
        });
        return response()->json([
            'total' => $texts->count(),
            'texts' => $texts
        ]);
    }
}
