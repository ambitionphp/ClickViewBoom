<x-app-layout>
    <div>
        <div class="max-w-xl mx-auto py-2 px-6 lg:px-8">

            <h1 class="font-semibold text-xl mb-2">About {{ config('app.name') }}</h1>

            <p class="text-sm mb-3">I am Steven aka AmbitionPHP and I built {{ config('app.name') }} to give back to the development community. There are a few apps that provide a similar service, some of which even being open-source however I wanted to share my take at sharing private text with perhaps newer technology.</p>

            <p class="text-sm mb-3">{{ config('app.name') }} was created using Laravel 8, Livewire & TailWindCSS. You can view, download and even contribute to the source code this app uses anytime <a href="https://github.com/ambitionphp/ClickViewBoom" target="_blank">on github</a>.</p>
        </div>
    </div>
</x-app-layout>
