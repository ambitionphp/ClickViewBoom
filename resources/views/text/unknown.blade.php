<x-app-layout>
    <div class="py-2">
        <div class="max-w-xl mx-auto px-6 lg:px-8">
            <div class="pb-3">
                <h2 class="font-semibold text-gray-600 text-xl leading-tight mb-1">Unknown secret</h2>

                <div class="bg-yellow-100 rounded-lg py-2 px-3 mb-4 text-sm text-yellow-700 mb-3" role="alert">
                    <span class="mr-1">💣</span> It either never existed or has already been viewed.
                </div>

                <div class="shadow-xl pt-1 sm:rounded-lg">
                    <a href="{{ url('/') }}" class="block w-full px-4 py-2 bg-red-500 text-center border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600 active:bg-red-600 focus:outline-none focus:border-red-600 focus:ring focus:ring-red-600 disabled:opacity-25 transition shadow-xl">
                        Share a secret of your own
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
