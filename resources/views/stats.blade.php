<x-app-layout>
    <div class="py-2">
        <div class="max-w-xl mx-auto px-6">
            <h1 class="font-semibold text-xl mb-2">Statistics</h1>

            <p class="text-sm mb-5">{{ config('app.name') }} does not use third party analytics or log any identifying information about it's users.</p>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                <div class="col-span-1 bg-gray-200 px-2 py-1 rounded text-center">
                    <div>
                        <span class="text-lg font-semibold">
                            {{ $users }}
                        </span>
                    </div>
                    <span class="text-xs uppercase">
                        Users
                    </span>
                </div>
                <div class="col-span-1 bg-gray-200 px-2 py-1 rounded text-center">
                    <div>
                        <span class="text-lg font-semibold">
                            {{ $api }}
                        </span>
                    </div>
                    <span class="text-xs uppercase">
                        API Secrets
                    </span>
                </div>
                <div class="col-span-1 bg-gray-200 px-2 py-1 rounded text-center">
                    <div>
                        <span class="text-lg font-semibold">
                            {{ $web }}
                        </span>
                    </div>
                    <span class="text-xs uppercase">
                        Web Secrets
                    </span>
                </div>
                <div class="col-span-1 bg-gray-200 px-2 py-1 rounded text-center">
                    <div>
                        <span class="text-lg font-semibold">
                            {{ $total }}
                        </span>
                    </div>
                    <span class="text-xs uppercase">
                        Total Secrets
                    </span>
                </div>
                <div class="col-span-2 md:col-span-4 pt-2">
                    {!! $chart->container() !!}
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
        {!! $chart->script() !!}
    @endpush
</x-app-layout>
