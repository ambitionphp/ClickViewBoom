<?php
namespace App\Helpers;

class Secretbox
{
    public function encrypt(string $plaintext, string $password): string
    {
        // create a random salt for key derivation
        $salt = random_bytes(SODIUM_CRYPTO_PWHASH_SALTBYTES);
        $key = $this->deriveKeyFromUserPassword($password, $salt);
        $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        $ciphertext = sodium_crypto_secretbox($plaintext, $nonce, $key);

        sodium_memzero($password);
        sodium_memzero($key);

        return $salt.$nonce.$ciphertext;
    }

    public function decrypt(string $ciphertext, string $password): string
    {
        $salt = substr($ciphertext, 0, SODIUM_CRYPTO_PWHASH_SALTBYTES);
        $nonce = substr($ciphertext, SODIUM_CRYPTO_PWHASH_SALTBYTES, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        $ciphertext = substr($ciphertext, SODIUM_CRYPTO_PWHASH_SALTBYTES + SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        $key = $this->deriveKeyFromUserPassword($password, $salt);

        $plaintext = sodium_crypto_secretbox_open($ciphertext, $nonce, $key);
        sodium_memzero($password);
        sodium_memzero($key);
        sodium_memzero($nonce);

        if ($plaintext === false) {
            throw new \InvalidArgumentException('Bad ciphertext');
        }

        return $plaintext;
    }

    private function deriveKeyFromUserPassword(string $password, string $salt): string
    {
        $key = sodium_crypto_pwhash(
            SODIUM_CRYPTO_SECRETBOX_KEYBYTES,
            $password,
            $salt,
            SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
            SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE
        );
        sodium_memzero($password);

        return $key;
    }
}

function assertThat(bool $expressionResult, string $message) {
    if (!$expressionResult) {
        throw new \RuntimeException($message);
    }
}
