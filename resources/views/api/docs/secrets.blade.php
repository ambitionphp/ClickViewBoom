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
            </ul>


        </div>
    </div>
</x-app-layout>
