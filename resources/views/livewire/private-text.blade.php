<div class="max-w-xl mx-auto px-6 sm:px-6 lg:px-8">
    @if( ! $boom )
        @if($decrypted)
            <div class="pb-3">
                <h2 class="font-semibold text-gray-600 text-xl leading-tight mb-1">Share this link:</h2>
                <input
                    type="url"
                    class="
                                    form-control
                                    block
                                    w-full
                                    px-3
                                    py-1.5
                                    text-base
                                    font-normal
                                    text-gray-600
                                    bg-yellow-200 bg-clip-padding
                                    border border-solid border-yellow-400
                                    rounded
                                    transition
                                    ease-in-out
                                    m-0
                                    placeholder:text-gray-400
                                    focus:text-gray-600 focus:border-yellow-500 focus:outline-none
                                    copy-paste
                                  "
                    value="{{ route('text.secret', $text) }}"
                    data-clipboard-text="{{ route('text.secret', $text) }}"
                    onfocus="this.select();"
                    onmouseup="return false;"
                    readonly
                    autofocus
                />
                @if( $text->password )
                    <div class="font-semibold text-gray-400 text-sm pt-2">
                        Requires a passphrase.
                    </div>
                    @if( $generatedPassphrase )
                    <div class="text-gray-600 mt-1 mb-1">
                        <span class="font-semibold">Passphrase:</span>
                    </div>
                    <input
                        type="url"
                        class="
                                    form-control
                                    block
                                    w-full
                                    px-3
                                    py-1.5
                                    text-base
                                    font-normal
                                    text-gray-600
                                    bg-yellow-200 bg-clip-padding
                                    border border-solid border-yellow-400
                                    rounded
                                    transition
                                    ease-in-out
                                    m-0
                                    placeholder:text-gray-400
                                    focus:text-gray-600 focus:border-yellow-500 focus:outline-none
                                    copy-paste
                                  "
                        value="{{ $generatedPassphrase }}"
                        data-clipboard-text="{{ $generatedPassphrase }}"
                        onfocus="this.select();"
                        onmouseup="return false;"
                        readonly
                    />
                    @endif
                @endif
            </div>
            <div class="pb-3">
                <div class="text-gray-600 mb-1">
                    <span class="font-semibold">Secret:</span> <span class="text-sm">(you will only see this once)</span>
                </div>
                <textarea
                    class="
                        form-control
                        block
                        w-full
                        px-3
                        py-1.5
                        text-base
                        font-normal
                        text-gray-400
                        bg-gray-50 bg-clip-padding
                        border border-solid border-gray-300
                        rounded
                        transition
                        ease-in-out
                        m-0
                        placeholder:text-gray-400
                        focus:text-gray-500 focus:border-gray-400 focus:outline-none
                      "
                    rows="{{ $text->password ? 1 : 3 }}"
                    placeholder="Secret content goes here"
                    readonly
                >{{ $decrypted }}</textarea>
            </div>
        @endif
        <div class="">
            <h2 class="font-semibold text-gray-600 text-xl leading-tight">
                Expires {{ $text->expires_at->diffForHumans(['parts' => 1, 'options' => \Carbon\CarbonInterface::ROUND]) }}.
                <span class="text-sm">({{ $text->expires_at }} UTC)</span>
            </h2>
        </div>

        <hr class="my-4 border-gray-200" />

        <div class="shadow-xl pt-1 sm:rounded-lg">
            <button type="button" wire:click="boomText(1)" class="w-full px-4 py-2 bg-gray-500 text-center border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 active:bg-gray-600 focus:outline-none focus:border-gray-600 focus:ring focus:ring-gray-600 disabled:opacity-25 transition shadow-xl">
                <span class="mr-1">💣</span> Boom this secret*
            </button>
        </div>

        <p class="my-3 text-center text-gray-600 text-sm">* Booming a secret will delete it before it has been read (click to confirm).</p>

        <hr class="my-4 border-gray-200" />

        <div class="shadow-xl pt-1 sm:rounded-lg">
            <a href="{{ url('/') }}" class="block w-full px-4 py-2 bg-red-500 text-center border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600 active:bg-red-600 focus:outline-none focus:border-red-600 focus:ring focus:ring-red-600 disabled:opacity-25 transition shadow-xl">
                Create another secret
            </a>
        </div>
    @else
        <div class="pb-3">
            <h2 class="font-semibold text-gray-600 text-xl leading-tight mb-1">Secret: {{ $text->id }}</h2>
            <div class="mt-1 mb-2">
                <input
                    wire:model.defer="passphrase"
                    type="password"
                    class="
                                    form-control
                                    block
                                    w-full
                                    px-3
                                    py-1.5
                                    text-base
                                    font-normal
                                    text-gray-400
                                    bg-gray-50 bg-clip-padding
                                    border border-solid border-gray-300
                                    rounded
                                    transition
                                    ease-in-out
                                    m-0
                                    placeholder:text-gray-400
                                    focus:text-gray-600 focus:bg-white focus:border-gray-800 focus:outline-none
                                  "
                    placeholder="Enter passphrase"
                />
            </div>
            <div class="shadow-xl pt-1 sm:rounded-lg">
                <button type="button" wire:click="boomText(2)" class="w-full px-4 py-2 bg-orange-400 text-center border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-500 active:bg-orange-500 focus:outline-none focus:border-orange-500 focus:ring focus:ring-orange-500 disabled:opacity-25 transition shadow-xl">
                    Confirm: Boom this secret
                </button>
            </div>
            <div class="shadow-xl pt-1 sm:rounded-lg">
                <button type="button" wire:click="boomText(0)" class="w-full px-4 py-2 bg-gray-400 text-center border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring focus:ring-gray-500 disabled:opacity-25 transition shadow-xl">
                    Cancel
                </button>
            </div>
        </div>
    @endif
</div>
