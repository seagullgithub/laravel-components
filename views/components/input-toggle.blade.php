<label class="inline-flex items-center cursor-pointer">
    <input type="checkbox" {{$attributes}} class="sr-only peer">
    <div class="
        relative 
        w-9 h-5 
        bg-gray-400 
        peer
        peer-focus:outline-none
        peer-focus:ring-4 
        peer-focus:ring-brand-soft
        dark:peer-focus:ring-brand-soft 
        rounded-full 
        peer-checked:bg-blue-500
        peer-checked:after:translate-x-full
        rtl:peer-checked:after:-translate-x-full
        peer-checked:after:border-buffer
        after:content-['']
        after:absolute
        after:top-0.5
        after:inset-s-0.5
        after:bg-white
        after:rounded-full
        after:h-4
        after:w-4
        after:transition-all
">
    </div>
    <span class="select-none ms-3 text-sm font-medium text-heading">{{$label}}</span>
</label>