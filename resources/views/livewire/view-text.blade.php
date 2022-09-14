<div class="max-w-xl mx-auto px-6 sm:px-6 lg:px-8">
    <div class="pb-3">
        @if( ! $visible )
        <form wire:submit.prevent="viewSecret">
            @if( $text && $text->password )
                <h2 class="font-semibold text-gray-600 text-xl leading-tight mb-1">This message requires a passphrase:</h2>
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
                                border border-solid
                                @error('password')
                                border-red-600
                                @else
                                border-gray-300
                                @enderror
                                rounded
                                transition
                                ease-in-out
                                m-0
                                placeholder:text-gray-400
                                focus:text-gray-600 focus:bg-white focus:border-gray-800 focus:outline-none
                              "
                        placeholder="Enter passphrase"
                    />
                    @error('password') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
            @else
                <h2 class="font-semibold text-gray-600 text-xl leading-tight mb-1">Click to continue:</h2>
            @endif

            <div class="shadow-xl pt-1 sm:rounded-lg">
                <button type="submit" class="w-full px-4 py-2 bg-red-500 text-center border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600 active:bg-red-600 focus:outline-none focus:border-red-600 focus:ring focus:ring-red-600 disabled:opacity-25 transition shadow-xl">
                    View secret
                </button>
            </div>
            <div class="mt-3 text-sm text-gray-500">
                (careful: we will only show it once.)
            </div>
        </form>
        @else
            <h2 class="font-semibold text-gray-600 text-xl leading-tight mb-1">This message is for you:</h2>
            <div class="shadow-xl sm:rounded-lg bg-gray-200 p-2">
                <textarea
                    class="
                        form-control
                        block
                        w-full
                        px-3
                        py-1.5
                        text-base
                        font-normal
                        text-gray-700
                        bg-gray-50 bg-clip-padding
                        border border-solid border-gray-300
                        rounded
                        transition
                        ease-in-out
                        m-0
                        focus:text-gray-700 focus:bg-white focus:border-gray-800 focus:outline-none
                      "
                    rows="3"
                    placeholder="Secret content goes here"
                    readonly
                >{{ $decrypted }}</textarea>
            </div>
        @endif
    </div>
</div>
