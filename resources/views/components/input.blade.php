<div class="mb-3">
    @if($label)
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    @endif
    <input type="{{ $type }}" class="form-control @invalid($name, $form) is-invalid @endinvalid" id="{{ $id }}"
        name="{{ $name }}" value="@from($form){{ old($name) }}@endfrom($form)" />
    @invalid($name, $form)
    <div class="invalid-feedback">
        {{ $errors->first($name) }}
    </div>
    @endinvalid
</div>