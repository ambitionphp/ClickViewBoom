<x-app-layout>
    <div>
        <div class="max-w-xl mx-auto py-2 px-6 lg:px-8">
            <h1 class="font-semibold text-xl mb-2">API Overview</h1>

            <ul class="nav nav-pills flex flex-col md:flex-row flex-wrap list-none pl-0 mb-2">
                <li class="nav-item" role="presentation">
                    <a href="{{ route('docs.api') }}" class="
                      nav-link
                      block
                      font-medium
                      text-xs
                      leading-tight
                      uppercase
                      rounded
                      px-6
                      py-3
                      my-2
                      md:mr-2
                      focus:outline-none focus:ring-0
                    ">Overview</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ route('docs.api.secrets') }}" class="
                      nav-link
                      block
                      font-medium
                      text-xs
                      leading-tight
                      uppercase
                      rounded
                      px-6
                      py-3
                      my-2
                      md:mr-2
                      focus:outline-none focus:ring-0
                      bg-gray-700
                      text-white
                    ">Secrets</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ route('docs.api.postman') }}" class="
                      nav-link
                      block
                      font-medium
                      text-xs
                      leading-tight
                      uppercase
                      rounded
                      px-6
                      py-3
                      my-2
                      md:mr-2
                      focus:outline-none focus:ring-0
                    ">Run in Postman</a>
                </li>
            </ul>

            <div class="mb-4">
                <h3 class="font-semibold text-l mb-2">
                    Create a secret
                </h3>

                <div class="px-2 py-1 bg-yellow-500 rounded mb-2">
                    <code class="text-xs text-slate-900">
                        POST {{ url('/api/v1/create') }}
                    </code>
                </div>

                <div class="text-sm mb-2">
                    Use this method to create a new secret.
                </div>

                <h5 class="font-semibold text-sm">Parameters</h5>
                <ul class="list-disc text-gray-800 text-sm mb-3 pl-4">
                    <li><span class="font-bold">secret:</span> the secret value which is encrypted before being stored.</li>
                    <li><span class="font-bold">passphrase:</span> a string that the recipient must know to view the secret. This value is also used to encrypt the secret and is bcrypted before being stored so we only have this value in transit.</li>
                    <li><span class="font-bold">passphraseRandom:</span> set to 1 generate a random passphrase that will be returned to you once only.</li>
                    <li><span class="font-bold">ttl:</span> the maximum amount of time, in minutes, that the secret should survive (i.e. time-to-live). Once this time expires, the secret will be deleted and not recoverable.</li>
                    <li><span class="font-bold">recipient:</span> an email address. We will send a friendly email containing the secret link (NOT the secret itself).</li>
                </ul>

                <div class="p-2 bg-slate-900 rounded mb-2">
                    <code class="text-xs text-stone-100">
                        curl --location --request POST '{{ url('/api/v1/create') }}' --header 'Authorization: Bearer YOUR_API_KEY' --form 'secret="this is my secret text"' --form 'ttl="1440"' --form 'passphraseRandom="1"'
                    </code>
                </div>

                <div class="p-2 bg-slate-900 rounded mb-4">
                    <code class="text-xs text-stone-100">
                        {<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;"id": "724043791732736",<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;"private_key": "399606533984256",<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;"passphrase": "NFpoP7mxyI",<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;"url": "{{ url('/secret/724043791732736') }}",<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;"expires_at": "2022-01-29T23:57:05.000000Z"<br />
                        }
                    </code>
                </div>
                <h5 class="font-semibold text-sm">Attributes</h5>
                <ul class="list-disc text-gray-800 text-sm mb-3 pl-4">
                    <li><span class="font-bold">id:</span> the ID of the secret</li>
                    <li><span class="font-bold">private_key:</span> private key used to boom a secret via api</li>
                    <li><span class="font-bold">passphrase:</span> either true, false or the randomly generated passphrase</li>
                    <li><span class="font-bold">url:</span> the URL for secret</li>
                    <li><span class="font-bold">expires_at:</span> when the secret expires and is deleted if not already viewed</li>
                </ul>
            </div>

            <hr class="mt-2 mb-4 border-gray-200" />

            <div class="mb-4">
                <h3 class="font-semibold text-l mb-2">
                    Retrieve a secret
                </h3>

                <div class="px-2 py-1 bg-yellow-500 rounded mb-2">
                    <code class="text-xs text-slate-900">
                        POST {{ url('/api/v1/secret') }}
                    </code>
                </div>

                <div class="text-sm mb-2">
                    Use this method to retrieve a secret. It should go without saying but, once retrieved the secret will be deleted.
                </div>

                <h5 class="font-semibold text-sm">Parameters</h5>
                <ul class="list-disc text-gray-800 text-sm mb-3 pl-4">
                    <li><span class="font-bold">secret:</span> the ID of the secret you wish to view.</li>
                    <li><span class="font-bold">passphrase:</span> the passphrase is required only if the secret was create with one.</li>
                </ul>

                <div class="p-2 bg-slate-900 rounded mb-2">
                    <code class="text-xs text-stone-100">
                        curl --location --request POST '{{ url('/api/v1/secret') }}' --header 'Authorization: Bearer YOUR_API_KEY' --form 'secret="574333164589056"'
                    </code>
                </div>

                <div class="p-2 bg-slate-900 rounded mb-4">
                    <code class="text-xs text-stone-100">
                        {<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;"id": 574333164589056,<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;"secret": "this is my text"<br />
                        }
                    </code>
                </div>
                <h5 class="font-semibold text-sm">Attributes</h5>
                <ul class="list-disc text-gray-800 text-sm mb-3 pl-4">
                    <li><span class="font-bold">id:</span> the ID of the secret</li>
                    <li><span class="font-bold">secret:</span> the decrypted secret text</li>
                </ul>
            </div>

            <hr class="mt-2 mb-4 border-gray-200" />

            <div class="mb-4">
                <h3 class="font-semibold text-l mb-2">
                    Boom a secret
                </h3>

                <div class="px-2 py-1 bg-yellow-500 rounded mb-2">
                    <code class="text-xs text-slate-900">
                        POST {{ url('/api/v1/boom') }}
                    </code>
                </div>

                <div class="text-sm mb-2">
                    Use this method to boom a secret that you've created at hasn't been viewed yet.
                </div>

                <h5 class="font-semibold text-sm">Parameters</h5>
                <ul class="list-disc text-gray-800 text-sm mb-3 pl-4">
                    <li><span class="font-bold">private_key:</span> the ID of the secret you wish to view.</li>
                </ul>

                <div class="p-2 bg-slate-900 rounded mb-2">
                    <code class="text-xs text-stone-100">
                        curl --location --request POST '{{ url('/api/v1/boom') }}' --header 'Authorization: Bearer YOUR_API_KEY' --form 'private_key="574333164589056"'
                    </code>
                </div>

                <div class="p-2 bg-slate-900 rounded mb-4">
                    <code class="text-xs text-stone-100">
                        {<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;"id": 574333164589056,<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;"deleted": true,<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;"deleted_at": "2022-01-29T00:28:09.055648Z"<br />
                        }
                    </code>
                </div>
                <h5 class="font-semibold text-sm">Attributes</h5>
                <ul class="list-disc text-gray-800 text-sm mb-3 pl-4">
                    <li><span class="font-bold">id:</span> the ID of the secret</li>
                    <li><span class="font-bold">deleted:</span> will always be true</li>
                    <li><span class="font-bold">deleted_at:</span> the date and time the secret was deleted at (the time the api request ran)</li>
                </ul>
            </div>

            <hr class="mt-2 mb-4 border-gray-200" />

            <div class="mb-4">
                <h3 class="font-semibold text-l mb-2">
                    Retrieve recent secrets
                </h3>

                <div class="px-2 py-1 bg-yellow-500 rounded mb-2">
                    <code class="text-xs text-slate-900">
                        GET {{ url('/api/v1/recent') }}
                    </code>
                </div>

                <div class="text-sm mb-2">
                    Use this method to retrieve your recent secrets.
                </div>

                <h5 class="font-semibold text-sm">Parameters</h5>
                <ul class="list-disc text-gray-800 text-sm mb-3 pl-4">
                    <li>none</li>
                </ul>

                <div class="p-2 bg-slate-900 rounded mb-2">
                    <code class="text-xs text-stone-100">
                        curl --location --request GET '{{ url('/api/v1/recent') }}' --header 'Authorization: Bearer YOUR_API_KEY'
                    </code>
                </div>

                <div class="p-2 bg-slate-900 rounded mb-4">
                    <code class="text-xs text-stone-100">
                        {<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;"total": 8,<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;"texts": [<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"id": 724043791732736,<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"passphrase": true,<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"url": "{{ url('/secret/724043791732736') }}",<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"expires_at": "2022-01-29T23:57:05.000000Z"<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;},<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"id": 649802526363648,<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"passphrase": false,<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"url": "{{ url('/secret/649802526363648') }}",<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"expires_at": "2022-02-04T19:02:04.000000Z"<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}<br />
                        }
                    </code>
                </div>
                <h5 class="font-semibold text-sm">Attributes</h5>
                <ul class="list-disc text-gray-800 text-sm mb-3 pl-4">
                    <li><span class="font-bold">total:</span> total number of recent secrets</li>
                    <li>
                        <span class="font-bold">texts:</span> an array of your recent secrets
                        <ul class="list-disc text-gray-800 text-sm mb-3 pl-4">
                            <li><span class="font-bold">id:</span> the ID of the secret</li>
                            <li><span class="font-bold">passphrase:</span> if the secret is protected by passphrase</li>
                            <li><span class="font-bold">url:</span> the URL for the secret</li>
                            <li><span class="font-bold">expires_at:</span> when the secret expires and is deleted if not already viewed</li>
                        </ul>
                    </li>
                </ul>

            </div>

        </div>
    </div>
</x-app-layout>
