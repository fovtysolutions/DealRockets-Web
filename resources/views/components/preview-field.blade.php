@props(['label', 'value' => null])

<div class="col-md-6 d-flex flex-column">
    <h5 style="align-content: center; width: 100%;">{{ $label }}</h5>
    <div class="border rounded p-2 bg-light" style="flex: 1;align-content: center;">
        {{ $slot->isEmpty() ? $value : $slot }}
    </div>
</div>
