@foreach (['success', 'info', 'danger'] as $type)
@if (Session::has($type))
<div class="alert alert-{{ $type }}">
	{{ session($type) }}
</div>
@endif
@endforeach