<?php 
	
	$numItems = count($seances_eleves);
	$pp = 0;
?>

@foreach ($seances_eleves as $seance_eleve)
	
	{{-- @if(++$pp != $numItems) --}}

		
		@if ( ((floor(($seance_eleve->num-1)/4)+1)==$i+1) )

			<div class="form-check">
	  	
			  	<label style="font-size: 13px;" class="form-check-label" for="mois{{$i}}_seance{{$seance_eleve->num}}">	  		
			  		
			  		{!! $seance_eleve->num%4 ? $seance_eleve->num%4 : 4 !!} | {!! $seance_eleve->matiere !!} - {!! $seance_eleve->id_prof !!}
			  	</label>

				{{--  --}} 
			</div>												
			{{-- expr --}}
		@endif
	 	
	 	

		{{--  --}}
	{{-- @endif --}}


	
	{{-- expr --}}
@endforeach



