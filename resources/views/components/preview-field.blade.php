@props(['label', 'value' => null])

<div class="col-md-6 d-flex gap-3">
    <strong style="align-content: center; width: 100px;">{{ $label }}:</strong><br>
    <div class="border rounded p-2 bg-light" style="flex: 1;align-content: center;">
        {{ $slot->isEmpty() ? $value : $slot }}
    </div>
</div>
