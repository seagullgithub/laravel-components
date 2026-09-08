<nav class="bg-mauve-300">
    <div class="flex justify-between mx-auto py-2 max-w-4/5">

        {{-- logo --}}
        <div class="text-3xl font-bold">
            <a href="{{ route('home') }}">
                movie capture list
            </a>
        </div>


        {{-- menu dropdown --}}
        <div x-data="{ open: false }" class="relative">

            <x-button @click="open = !open">admin</x-button>

            <div x-show="open" @click.away="open = false"
                class="absolute right-0 bg-white border p-8 py-2 rounded shadow-xl">

                <div class="font-bold">movies</div>
                <ul class="pl-2 space-y-1">
                    <li><a href="{{ route('movies.index') }}">index</a></li>
                    <li><a href="{{ route('movies.create') }}">create</a></li>
                </ul>

                <div class="font-bold">vendors</div>
                <ul class="pl-2 space-y-1">
                    <li><a href="{{ route('vendors.index') }}">index</a></li>
                    <li><a href="{{ route('vendors.create') }}">create</a></li>
                </ul>

            </div>
        </div>
        {{-- menu dropdown | END --}}

    </div>
</nav>