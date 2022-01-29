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
                      bg-gray-700
                      text-white
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
                    Base URI
                </h3>

                <div class="px-2 py-1 bg-yellow-500 rounded mb-2">
                    <code class="text-xs text-slate-900">
                        {{ url('/api') }}
                    </code>
                </div>

                <div class="text-sm">
                    All API access is over HTTPS and starts with /api. All responses are JSON.
                </div>
            </div>

            <hr class="mt-2 mb-4 border-gray-200" />

            <div class="mb-4">
                <h3 class="font-semibold text-l mb-2">
                    Authentication
                </h3>

                <div class="p-2 bg-slate-900 rounded mb-2">
                    <code class="text-xs text-stone-100">
                        curl --header 'Authorization: Bearer YOUR_API_KEY'
                    </code>
                </div>

                <div class="text-sm">
                    Your API Key must be included in the Authorization header as a Bearer token.
                </div>
            </div>

            <hr class="mt-2 mb-4 border-gray-200" />

            <div class="mb-4">
                <h3 class="font-semibold text-l mb-2">
                    User Details
                </h3>

                <div class="px-2 py-1 bg-yellow-500 rounded mb-1">
                    <code class="text-xs text-slate-900">
                        {{ url('/api/v1/user') }}
                    </code>
                </div>

                <div class="text-sm mb-2">
                    Authenticated user details.
                </div>

                <h5 class="font-semibold text-sm">Parameters</h5>
                <ul class="list-disc text-gray-800 text-sm mb-3 pl-4">
                    <li>none</li>
                </ul>

                <div class="p-2 bg-slate-900 rounded mb-2">
                    <code class="text-xs text-stone-100">
                        curl --location --request GET '{{ url('/api/v1/user') }}' --header 'Authorization: Bearer YOUR_API_KEY'
                    </code>
                </div>

                <div class="p-2 bg-slate-900 rounded mb-4">
                    <code class="text-xs text-stone-100">
                        {<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;"id": 326395079299072,<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;"email": "sel********@g****.com",<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;"texts": 4,<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;"created_at": "2022-01-27T21:36:58.000000Z"<br />
                        }
                    </code>
                </div>
                <h5 class="font-semibold text-sm">Attributes</h5>
                <ul class="list-disc text-gray-800 text-sm mb-3 pl-4">
                    <li><span class="font-bold">id:</span> your user ID</li>
                    <li><span class="font-bold">email:</span> your email address</li>
                    <li><span class="font-bold">text:</span> number of currently active texts</li>
                    <li><span class="font-bold">created_at:</span> when you signed up</li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
