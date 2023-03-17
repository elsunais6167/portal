@if(count($errors) )
@foreach ($errors->all() as $error)
<div class="justify-content-center d-flex">
<p class="alert alert-danger">{{ $error}} </p>
</div>
@endforeach
@endif

@if(session()->has('success'))
<div class="justify-content-center d-flex">
<p class="alert alert-success"> {{ session()->get('success')}} </p>
</div>
@endif
