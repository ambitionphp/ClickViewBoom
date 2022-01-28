<div>
    <form wire:submit.prevent="generate">
        <div class="shadow-xl sm:rounded-lg">
                <textarea
                    wire:model.defer="content"
                    class="
                        form-control
                        block
                        w-full
                        px-3
                        py-1.5
                        text-base
                        font-normal
                        text-gray-700
                        bg-white bg-clip-padding
                        border border-solid
                        {{ $errors->has('content') ? 'border-red-600' : 'border-gray-300' }}
                        rounded
                        transition
                        ease-in-out
                        m-0
                        focus:text-gray-700 focus:bg-white focus:border-gray-800 focus:outline-none
                      "
                    rows="3"
                    placeholder="Secret content goes here"
                ></textarea>
        </div>

        <div class="shadow-xl sm:rounded-lg bg-gray-50 border border-solid border-gray-30 rounded mt-5">
            <div class="inline-block bg-gray-50 text-xs text-gray-700 font-semibold px-2 py-1 border border-gray-200 border-b border-t-0 border-l-0 rounded-br">
                Privacy Options
            </div>
            <div class="mt-2 mb-5 px-3 xl:w-96 mx-auto">
                <div class="md:grid md:grid-cols-3 md:gap-5 mb-4">
                    <div class="md:col-span-1 flex justify-between self-center">
                        <div class="md:px-4 block w-full text-gray-500 sm:px-0 md:text-right">
                            Passphrase:
                        </div>
                    </div>
                    <div class="mt-2 md:mt-0 md:col-span-2">
                        <input
                            wire:model.defer="passphrase"
                            type="text"
                            class="
                                    form-control
                                    block
                                    w-full
                                    px-2
                                    py-1
                                    text-sm
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
                            placeholder="A word or phrase that's difficult to guess"
                        />
                    </div>
                </div>
                @auth
                <div class="md:grid md:grid-cols-3 md:gap-5 mb-4">
                    <div class="md:col-span-1 flex justify-between self-center">
                        <div class="md:px-4 block w-full text-gray-500 sm:px-0 md:text-right">
                            Recipient:
                        </div>
                    </div>
                    <div class="mt-2 md:mt-0 md:col-span-2">
                        <input
                            wire:model.defer="recipient"
                            type="email"
                            class="
                                    form-control
                                    block
                                    w-full
                                    px-2
                                    py-1
                                    text-sm
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
                            placeholder="contact@clickviewboom.com"
                        />
                    </div>
                </div>
                @endauth
                <div class="md:grid md:grid-cols-3 md:gap-5">
                    <div class="md:col-span-1 flex justify-between self-center">
                        <div class="md:px-4 block w-full text-gray-500 sm:px-0 md:text-right">
                            Lifetime:
                        </div>
                    </div>
                    <div class="mt-2 md:mt-0 md:col-span-2">
                        <select
                            wire:model.defer="lifetime"
                            class="
                                    form-select appearance-none
                                    block
                                    w-full
                                    px-2
                                    py-1
                                    text-sm
                                    font-normal
                                    text-gray-600
                                    bg-white bg-clip-padding bg-no-repeat
                                    border border-solid border-gray-300
                                    rounded
                                    transition
                                    ease-in-out
                                    m-0
                                    focus:text-gray-700 focus:bg-white focus:border-gray-800 focus:outline-none">
                            <option value="10080">7 days</option>
                            <option value="4320">3 days</option>
                            <option value="1440">1 day</option>
                            <option value="720">12 hours</option>
                            <option value="240">4 hours</option>
                            <option value="60">1 hour</option>
                            <option value="30">30 minutes</option>
                            <option value="5">5 minutes</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="shadow-xl pt-5 sm:rounded-lg">
            <button type="submit" class="w-full px-4 py-2 bg-gray-800 text-center border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition shadow-xl">
                Create a secret link*
            </button>
        </div>

        <div class="shadow-xl pt-3 sm:rounded-lg">
            <button type="button" wire:click="generate(1)" class="w-full px-4 py-2 bg-gray-500 text-center border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 active:bg-gray-600 focus:outline-none focus:border-gray-600 focus:ring focus:ring-gray-600 disabled:opacity-25 transition shadow-xl">
                Create with random passphrase
            </button>
        </div>

        <div class="mt-6 mb-5 block w-full"></div>

        <p class="text-center text-sm text-gray-400 mb-2">
            * A secret link only works once and then disappears forever.
        </p>
        <p class="text-center text-sm text-gray-400">
            Sign up for a <a href="{{ route('register') }}" class="font-semibold">free account</a> to set passphrases for extra security along with additional privacy options. We'll even email the link for you if you want.
        </p>
    </form>
</div>
