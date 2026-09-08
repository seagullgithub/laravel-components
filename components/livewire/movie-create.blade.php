<?php

use App\Models\Movie;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

new class extends Component {
    public string $name;
    public string $url;
    public int $vendor_id;

    public function render() {
        return view('components.livewire.movie-create');
    }

    public function create() {
        Movie::create($this->only(['name', 'url', 'vendor_id']));

        Toaster::success('added ' . $this->name);
        return $this->redirect('/');
    }
}

?>

<form wire:submit="create">
    @csrf

    {{-- name --}}
    <div class="mb-3">
        <label for="name" class="form-label">name</label>
        <x-input-text wire:model="name" />
        <x-form-error field="name" />
    </div>

    {{-- url --}}
    <div class="mb-3">
        <label for="url" class="form-label">url</label>
        <x-input-text wire:model="url" />
        <x-form-error field="url" />
    </div>

    {{-- vendor --}}
    <div class="mb-3">
        <div class="space-x-4">
            @foreach(App\Models\Vendor::all() as $vendor)
            <label>
                <input type="radio" wire:model="vendor_id" value="{{ $vendor->id }}">
                {{ $vendor->name }}
            </label>
            @endforeach
        </div>
        <x-form-error field="vendor_id" />
    </div>

    {{-- buttons --}}
    <div class="flex justify-end gap-2">
        <x-button type="button" onclick="
                    if (document.referrer.match(window.location.hostname) != null) {
                        history.back();
                    } else {
                       window.location = '{{route('home')}}'; 
                    }
                    " class="bg-red-500! hover:bg-red-400! active:bg-red-600!">
            cancel</x-button>
        <x-button type="submit">save</x-button>
    </div>

</form>