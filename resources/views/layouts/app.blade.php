@if(auth()->user()->lang == "en")
    @include('layouts.app1')
@else
    @include('layouts.app2')
@endif

