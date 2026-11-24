@props(['label', 'value', 'icon', 'tone' => 'primary', 'href' => null, 'hint' => null])

@php($tag = $href ? 'a' : 'div')

<{{ $tag }} @if ($href) href="{{ $href }}" @endif class="card raee-kpi">
    <span class="raee-kpi__icon raee-kpi__icon--{{ $tone }}">
        <i class="bi bi-{{ $icon }}" aria-hidden="true"></i>
    </span>
    <span>
        <span class="raee-kpi__label d-block">{{ $label }}</span>
        <span class="raee-kpi__value d-block">{{ number_format($value) }}</span>
        @if ($hint)
            <span class="small text-body-secondary">{{ $hint }}</span>
        @endif
    </span>
</{{ $tag }}>
