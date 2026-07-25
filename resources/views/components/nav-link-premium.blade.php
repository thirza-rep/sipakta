@props(['active', 'icon' => 'grid'])

@php
$classes = ($active ?? false)
            ? 'flex items-center gap-3 px-5 py-3 rounded-2xl bg-teal-50 text-teal-700 font-black shadow-inner shadow-teal-600/5 transition-all duration-300'
            : 'flex items-center gap-3 px-5 py-3 rounded-2xl text-slate-400 font-bold hover:bg-slate-50 hover:text-slate-600 transition-all duration-300 group';

$iconSvg = match($icon) {
    'grid' => '',
    'search' => '',
    'user' => '',
    'users' => '',
    'book' => '',
    'chart' => '',
    'clock' => '',
    'shield' => '',
    default => '',
};
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <div class="{{ ($active ?? false) ? 'text-teal-600' : 'text-slate-300 group-hover:text-teal-500' }} transition-colors">
        {!! $iconSvg !!}
    </div>
    <span class="text-sm tracking-tight">{{ $slot }}</span>
</a>
