<form method="{{ $method }}" {{ $attributes }}>
    @csrf
    @method($method)
    @from($name)
    @include('partials.alert')
    @endfrom
    <input type="hidden" name="_name" value="{{ $name }}">
    {{ $slot }}
</form>