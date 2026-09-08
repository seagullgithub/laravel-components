<?php

use App\Models\Movie;
use Livewire\Attributes\On; 
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination; 

new class extends Component {
    use WithPagination;

    #[Url(except: '')]
    public string $filterSearch = '';
    #[Url]
    public array $filterVendors = [];
    #[Url]
    public string $filterStatus = 'all';
    #[Url]
    public int $perPage = 20;

    protected $listeners = ['filterChanged'];

    #[On('filtersChanged')]
    public function filtersChanged($search, $vendors, $status) {
        $this->filterSearch = $search;
        $this->filterVendors = $vendors;
        $this->filterStatus = $status;
        //$this->perPage = $perPage;

        $this->resetPage(); 
    }

    public function render() {
        return view('components.livewire.movie-table');
    }

    public function getMoviesProperty() {
        $query = Movie::query();
        // $query = Movie::with('vendor');

        // status
        // if ($this->filterStatus) {
            if ($this->filterStatus == 'todo') {
                // $query->where('status', false);
                // $query->orWhereNull('status', 'is null');
                $query->whereRaw('("status" = 0 or "status" is null)');
            }
            if ($this->filterStatus == 'done') {
                $query->where('status', true);
            }
        // }

        // vendors
        // $query->when($this->filterVendors, function ($q) {
        //     return $q->whereIn('vendor_id', $this->filterVendors);
        // });
        // refactored to:
        if (!empty($this->filterVendors)) {
            $query->whereIn('vendor_id', $this->filterVendors);
        }

        if ($this->filterSearch) {
            $query->where('name', 'like', '%' . $this->filterSearch . '%');
        }

        return $query->paginate($this->perPage);
    }

};
?>

@php $movies = $this->movies; @endphp

<div class="content-block">

    <div class="">
        <div class="float-right">found {{ $movies->count() }} movies ({{ Movie::count() }} total) </div>
    </div>

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

                {{-- state --}}
                <td class="p-2 text-center">

                    <button onclick="toggleState({{ $item->id }})" class="group cursor-pointer"
                        data-status="{{ $item->status ? 'true' : 'false'}}" data-id="{{ $item->id }}">
                        <x-icon icon="circle-check" class="group-data-[status=false]:hidden" />
                        <x-icon icon="circle" class="group-data-[status=true]:hidden" />
                    </button>

                </td>

                {{-- name --}}
                <td class="p-2 active:text-mauve-50" onclick="writeToClipboard('{{ $item->name }}')">
                    {{$item->name}}</td>

                {{-- url --}}
                <td class="p-2">
                    <x-link-external :href="$item->url" classIcon="text-mauve-500 hover:text-black">
                        {{ Str::limit($item->url, 26, $end='...') }}
                    </x-link-external>
                </td>

                {{-- vendor --}}
                <td class="p-2 text-center">
                    <x-vendor vendor="{{$item->vendor->name}}" title="{{ $item->vendor->name }}" />
                </td>

                {{-- actions --}}
                <td class=" p-2 flex items-center justify-center gap-2">
                    <a href="{{ route('movies.edit', $item->id) }}" class="" title="edit">
                        <x-icon icon="edit" class="text-gray-500 hover:text-black cursor-pointer" />
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $movies->links('components.pagination') }}
    </div>
</div>