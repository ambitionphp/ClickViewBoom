<x-app-layout>
    <div class="py-2">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <h1 class="font-semibold text-xl mb-2">Secrets since release</h1>

            <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="bg-gray-200 px-2 py-1 rounded text-center">
                    <div>
                        <span class="text-lg font-semibold">
                            {{ $api }}
                        </span>
                    </div>
                    <span class="text-xs uppercase">
                        API Secrets
                    </span>
                </div>
                <div class="bg-gray-200 px-2 py-1 rounded text-center">
                    <div>
                        <span class="text-lg font-semibold">
                            {{ $web }}
                        </span>
                    </div>
                    <span class="text-xs uppercase">
                        Web Secrets
                    </span>
                </div>
                <div class="bg-gray-200 px-2 py-1 rounded text-center">
                    <div>
                        <span class="text-lg font-semibold">
                            {{ $total }}
                        </span>
                    </div>
                    <span class="text-xs uppercase">
                        Total Secrets
                    </span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
