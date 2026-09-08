@props(['icon', 'class' => ''])
@include("components.icons.$icon", $attributes->merge([ 'class' => "inline align-text-top w-auto h-[1em] $class"]))