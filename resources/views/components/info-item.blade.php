@props(['icon', 'title', 'description'])

<div {{ $attributes->class(['info-item anim-slide-left']) }}>
    <div class="icon">{{ $icon }}</div>
    <div>
        <h4>{{ $title }}</h4>
        <p>{{ $description }}</p>
    </div>
</div>


