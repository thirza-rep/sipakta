@props(['active', 'icon' => 'grid'])

@php
$classes = ($active ?? false)
            ? 'flex items-center gap-4 px-6 py-4 rounded-2xl bg-teal-600 text-white font-black shadow-lg shadow-teal-600/20 transition-all duration-300'
            : 'flex items-center gap-4 px-6 py-4 rounded-2xl text-slate-500 font-bold hover:bg-slate-50 hover:text-teal-600 transition-all duration-300 group';

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
    <div class="{{ ($active ?? false) ? 'text-white' : 'text-slate-300 group-hover:text-teal-500' }} transition-colors">
        {!! $iconSvg !!}
    </div>
    <span class="text-base tracking-tight uppercase tracking-widest text-[11px] font-black">{{ $slot }}</span>
</a>
