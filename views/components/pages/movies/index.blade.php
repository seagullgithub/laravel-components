<?php

use Livewire\Component;
use App\Models\Movie;

new class extends Component {
    public $movies;
    public $filterSearch = '';
    public $filterVendors = [];
    public $filterStatus = 'all';

    protected $queryString = [
        'filterSearch' => ['except' => ''],
        'filterVendors',
        'filterStatus'
    ];

    public function render() {
        $this->search();
        return $this->view();
    }

    public function search() {
        $query = Movie::query();

        // status
        if ($this->filterStatus) {
            if ($this->filterStatus == 'todo') {
                // $query->where('status', false);
                // $query->orWhereNull('status', 'is null');
                $query->whereRaw('("status" = 0 or "status" is null)');
            }
            if ($this->filterStatus == 'done') {
                $query->where('status', true);
            }
        }

        // vendors
        $query->when($this->filterVendors, function ($q) {
            return $q->whereIn('vendor_id', $this->filterVendors);
        });

        if ($this->filterSearch) {
            $query->where('name', 'like', '%' . $this->filterSearch . '%');
        }

        $this->movies = $query->get();
    }

};
?>

<div>

    {{-- status --}}
    <fieldset class="flex space-x-2">
        <div>status:</div>

        <label>
            <input type="radio" wire:model.live="filterStatus" value="all">
            all
        </label>
        <label>
            <input type="radio" wire:model.live="filterStatus" value="todo">
            todo
        </label>
        <label>
            <input type="radio" wire:model.live="filterStatus" value="done">
            done
        </label>
    </fieldset>

    {{-- vendors --}}
    <fieldset class="flex space-x-2">
        <div>vendor:</div>

        @foreach (App\Models\Vendor::all() as $vendor )
        <label>
            <input type="checkbox" value="{{ $vendor->id }}" wire:model.live="filterVendors">
            {{ $vendor->name }}
        </label>
        @endforeach
    </fieldset>

    {{-- search --}}
    <input type="text" wire:model.live.debounce.250ms="filterSearch" placeholder="search ... " class="border">



    {{-- table --}}
    <table class="table-auto w-full">

        <thead class="font-bold bg-mauve-300 mb-4">
            <tr class="">
                <th class="px-2 py-2">status</th>
                <th class="px-2 py-2">name</th>
                <th class="px-2 py-2">url</th>
                <th class="px-2 py-2">vendor</th>
                <th class="px-2 py-2">actions</th>
            </tr>
        </thead>

        <tbody class="divide-mauve-300 divide-y">
            @foreach ($movies as $item)
            <tr wire:key="movie-{{ $item->id}}" class="hover:bg-mauve-200">

                <td class="p-2 text-center">

                    <button onclick="toggleState({{ $item->id }})" class="group cursor-pointer"
                        data-status="{{ $item->status ? 'true' : 'false'}}" data-id="{{ $item->id }}">
                        <x-icon icon="circle-check" class="group-data-[status=false]:hidden" />
                        <x-icon icon="circle" class="group-data-[status=true]:hidden" />
                    </button>

                </td>

                <td class="p-2 active:text-mauve-50" onclick="writeToClipboard('{{ $item->name }}')">
                    {{$item->name}}</td>

                <td class="p-2">
                    <x-link-external :href="$item->url" classIcon="text-mauve-500 hover:text-black">
                        {{ Str::limit($item->url, 26, $end='...') }}
                    </x-link-external>
                </td>

                <td class="p-2 text-center">
                    <x-vendor vendor="{{$item->vendor->name}}" title="{{ $item->vendor->name }}" />
                </td>

                <td class=" p-2 flex items-center justify-center gap-2">

                    <a href="{{ route('movies.edit', $item->id) }}" class="" title="edit">
                        <x-icon icon="edit" class="text-gray-500 hover:text-black cursor-pointer" />
                    </a>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>