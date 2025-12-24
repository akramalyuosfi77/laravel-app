@props(['icon', 'title', 'description', 'cta' => null, 'ctaLink' => '#', 'delay' => 0, 'animation' => 'anim-zoom'])

<div class="card-base {{ $animation }}" style="transition-delay: {{ $delay }}ms">
    <div class="card-icon floating">
        @if(str_starts_with($icon, 'fa'))
            <i class="{{ $icon }}"></i>
        @else
            {{ $icon }}
        @endif
    </div>
    <h3>{{ $title }}</h3>
    <p>{{ $description }}</p>
    @if($cta)
        <a href="{{ $ctaLink }}" class="btn-primary">{{ $cta }}</a>
    @endif
</div>
