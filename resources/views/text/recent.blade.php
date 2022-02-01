<x-app-layout>
    <div class="py-2">
        <div class="max-w-xl mx-auto px-6 lg:px-8">
            <div class="">
                <div class="md:flex mb-5 md:mb-0">
                    <div class="md:grow">
                        <h2 class="font-semibold text-gray-600 text-xl leading-tight mb-2">
                            Recent secrets
                            <span class="text-xs inline-block py-1 px-1.5 ml-1 leading-none text-center whitespace-nowrap align-baseline font-bold bg-gray-200 text-gray-700 rounded">
                                {{ $texts->count() }}
                            </span>
                        </h2>
                        <p class="text-sm mb-1 md:mb-4">
                            When a secret is viewed all data is deleted from our servers therefore you will no longer see it below.
                        </p>
                    </div>
                    <div class="md:flex-none self-center">
                        <livewire:emergency-flush />
                    </div>
                </div>

                @foreach($texts AS $text)
                    <div class="bg-gray-200 p-2 border text-xs rounded mb-3">
                        <span class="font-semibold">
                            #<a href="{{ route('text.private', $text) }}">{{ $text->id }}</a>
                        </span>
                        <span class="pl-2">
                            <i class="fas fa-lock{{ ! $text->password ? '-open' : '' }} fa-fw text-gray-400"></i>
                        </span>
                        <span class="pl-2">
                            expires {{ $text->expires_at->shortRelativeDiffForHumans() }}
                        </span>
                        <span class="float-right">
                            <a href="{{ route('text.private', $text) }}" class="text-gray-500">
                                <i class="fas fa-edit"></i>
                            </a>
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
