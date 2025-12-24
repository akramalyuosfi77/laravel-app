@props([
    'name',
    'role',
    'image',
    'contacts' => [],
    'socials' => [],
])

<div class="developer-card anim-zoom anim-hover">
    <div class="dev-card-header">
        <img src="{{ $image }}" alt="{{ $name }}" class="dev-image" loading="lazy">
        <div class="dev-info">
            <h3>{{ $name }}</h3>
            <p>{{ $role }}</p>
        </div>
    </div>
    <div class="dev-card-body">
        <ul class="dev-contact-list">
            @foreach($contacts as $contact)
                <li>
                    @isset($contact['icon'])
                        <i class="{{ $contact['icon'] }}"></i>
                    @endisset
                    <span>{{ $contact['text'] ?? '' }}</span>
                </li>
            @endforeach
        </ul>
        @if(count($socials))
            <div class="dev-socials">
                @foreach($socials as $social)
                    <a href="{{ $social['url'] }}" title="{{ $social['title'] ?? '' }}" target="_blank" rel="noopener">
                        <i class="{{ $social['icon'] }}"></i>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>


