## ClickViewBOOM

This is my take at destructive private text. ClickViewBOOM is using Laravel 8, Livewire & Tailwind. Private texts are stored to the database as encrypted content using snowflake IDs. Private texts can include a passphrase which is used to not only view the text but also to encrypt/decrypt it as well. Once a text is protected by passphrase it can never be decrypted or viewed without the passphrase.

I'm a software engineer that has been writing code in some shape or form since 1998 (I was 11 back then). I've never taken any profession classes or courses on web development, everything I know has come from genuine interest and passion for code. With that being said, a lot of my knowledge has come from open-source projects. This is my opportunity to give back (while providing transparency to those who actually use my service).

For the future I plan on cleaning up the code and transferring all the text strings to language files. If you have any suggestions or find any bugs feel free to make an issue report!

[Live demo](https://clickviewboom.com)

## Anonymity Report
Below I will go over a few of the general functions to display what data (or lack of) the app logs.

## Registration
Simple registration only logs username and hashed password.
```injectablephp
public function create(array $input)
{
    Validator::make($input, [
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => $this->passwordRules(),
        'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
    ])->validate();

    return User::create([
        'email' => $input['email'],
        'password' => Hash::make($input['password']),
    ]);
}
```

## Create a secret
Does not log any ip, user agent, etc. Content is encrypted (twice if passphrase is provided). Passphrase isi hashed as well.
```injectablephp
public function create($content, $ttl, $random = 0, $passphrase = null, $recipient = null) {
    $password = $this->passphrase($random, $passphrase);

    $text = Text::create([
        'private_key' => $this->private_key,
        'user_id' => $this->user_id,
        'content' => Crypt::encryptString($password['exists'] ? $this->encryptFromPassphrase($password['plain'], $content) : $content),
        'password' => $password['hash'],
        'expires_at' => now()->addMinutes($ttl)
    ]);

    if( $recipient ) {
        dispatch(function () use ($recipient, $text) {
            Mail::to($recipient)->send(new SecretReceived($text));
        })->afterResponse();
    }

    // create session to allow viewing share link/secret content
    session(['private_key'=>$text->private_key]);

    $this->analaytics();

    return $text;
}
```

## View secret
Passphrase is confirmed if secret is protected by one. Content is decrypted and secret instantly deleted.
```injectablephp
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
            if( $this->decrypted && $this->text->password ) {
                $secretbox = new Secretbox;
                $this->decrypted = $secretbox->decrypt($this->decrypted, $this->passphrase);
            }
            Text::find($this->text->id)->delete();
            $this->visible = true;
        }
    }
```

## Analytics
Analytics are simply integer base one record per day contains an integer value for secrets created by api, web and total.
```injectablephp
private function analaytics() {
    $record = Analaytic::firstOrCreate([
        'date' => now()->toDateString()
    ]);

    $record->increment($this->type);
    $record->increment('total');
}
```
