@props(['title', 'subtitle' => null])

<div class="raee-page-header">
    <div>
        <h1 class="raee-page-title">{{ $title }}</h1>
        @if ($subtitle)
            <p class="raee-page-subtitle">{{ $subtitle }}</p>
        @endif
    </div>

    @unless ($slot->isEmpty())
        <div class="d-flex flex-wrap gap-2">
            {{ $slot }}
        </div>
    @endunless
</div>
