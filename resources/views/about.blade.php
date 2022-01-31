<x-app-layout>
    <div>
        <div class="max-w-xl mx-auto py-2 px-6 lg:px-8">

            <h1 class="font-semibold text-xl mb-2">About {{ config('app.name') }}</h1>

            <p class="text-sm mb-3">I am Steven Sarkisian (AmbitionPHP) and I created {{ config('app.name') }} to give back to the development community. There are a few apps that provide a similar service, some of which even being open-source however I wanted to share my take at sharing private text with perhaps newer technology.</p>

            <p class="text-sm mb-5">{{ config('app.name') }} was created using Laravel 8, Livewire & TailWindCSS. You can view, download and even contribute to the source code this app uses anytime <a href="https://github.com/ambitionphp/ClickViewBoom" target="_blank">on github</a>.</p>

            <h1 class="font-semibold text-xl mb-2">Security & Technical</h1>

            <div>
                <ul class="list-disc">
                    <li>All secret texts are encrypted before stored.</li>
                    <li>Secret texts with a passphrase are first encrypted using the passphrase before being encrypted again with our base encryption.</li>
                    <li>Passphrase protected texts cannot be recovered without the passphrase. Sorry, but this keeps things secure.</li>
                    <li>Texts are instantly deleted upon being viewed. In fact, the texts are removed from our database before it's even displayed to you.</li>
                    <li>We do not store your ip, user agent, device details or any identifying information. We also do not use any third party analytic services and we are completely ad-free.</li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
