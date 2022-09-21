<?php $cpt=0; ?>

@foreach ($les_absences as $absence)
	
	@if ( $absence->mois == ($i+1) )
		
		<?php $cpt++; ?>

		{{-- expr --}}
	@endif

	{{-- expr --}}
@endforeach

<p> {!! $cpt !!} </p>