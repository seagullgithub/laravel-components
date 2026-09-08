<div class="flex justify-end gap-2">
    <x-button type="button" onclick="
        if (document.referrer.match(window.location.hostname) != null) {
            history.back();
        } else {
            window.location = '{{ $cancelRoute }}'; 
        }
        " class="bg-red-500! hover:bg-red-400! active:bg-red-600!">
        cancel</x-button>
    <x-button type="submit">save</x-button>
</div>