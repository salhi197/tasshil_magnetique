<?php $cpt=0; ?>

@foreach ($les_presences as $presence)
	
	@if ( $presence->mois == ($i+1) )
		
		<?php $cpt++; ?>

		{{-- expr --}}
	@endif

	{{-- expr --}}
@endforeach

<p> {!! $cpt !!} </p>