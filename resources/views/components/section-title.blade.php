@props(['title', 'subtitle' => null])

<div {{ $attributes->class(['section-title anim-zoom']) }}>
    <h2 class="anim-underline">{{ $title }}</h2>
    @if($subtitle)
        <p>{{ $subtitle }}</p>
    @endif
</div>


