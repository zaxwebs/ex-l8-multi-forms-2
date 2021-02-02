@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-6 mb-3">
		<h1>Form A</h1>
		<x-form action="{{ route('processor') }}" name="form-a">
			<x-input form="form-a" label="Email" name="email" />
			<div class="mb-3">
				<button type="submit" class="btn btn-primary">Validate</button>
			</div>
		</x-form>
	</div>
</div>
@endsection