<?php

use Livewire\Component;
use Livewire\Attributes\Url;

new class extends Component {

    #[Url(except: '')]
    public string $filterSearch = '';
    #[Url]
    public array $filterVendors = [];
    #[Url]
    public string $filterStatus = 'all';

    public function render() {
        $this->dispatch('filtersChanged', 
            search: $this->filterSearch,
            vendors: $this->filterVendors,
            status: $this->filterStatus,
        );
        return $this->view();
    }

    public function resetFilter() {
        $this->reset('filterSearch', 'filterVendors', 'filterStatus');
    }

};
?>

<div class="content-block flex gap-8 justify-center items-center">

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
    <input type="text" wire:model.live.debounce.250ms="filterSearch" placeholder="search ... " class="px-2 border">

    {{-- button: reset --}}
    <x-button type="button" wire:click="resetFilter">
        clear
    </x-button>

</div>