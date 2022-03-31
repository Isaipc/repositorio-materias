@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif

@guest
@else
<h3 class="mx-auto text-center">
    Bienvenid@

    <strong class="text-uppercase">
        {{ Auth::user()->name }}
    </strong>
</h3>
@endguest