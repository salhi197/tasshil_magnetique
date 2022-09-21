<?php 
	
	$numItems = count($seances_eleves)+1;
	$pp = 0;
?>

@foreach ($seances_eleves as $seance_eleve)
	
	{{-- @if(++$pp != $numItems) --}}

		
		@if ( ((floor(($seance_eleve->num-1)/4)+1)==$i+1) )

			<span style="margin-right : 10%;" class="form-check form-check-inline">
	  	
			  	<label style="margin-right: 20%;" class="form-check-label" for="mois{{$i}}_seance{{$seance_eleve->num}}">	  		
			  		{!! $seance_eleve->num%4 ? $seance_eleve->num%4 : 4 !!}
			  	</label>

			
				@if ($seance_eleve->presence == 1)
					
					<input class="form-check-input" type="checkbox" id="mois{{$i}}_seance{{$seance_eleve->num}}" disabled checked>

				 @elseif($seance_eleve->presence == 0 && $seance_eleve->num != $num_seance_groupe)

					<span class="badge bg-danger"></span>

				 @elseif($seance_eleve->presence == 2)	

				 	<span class="badge bg-success"></span>

					{{-- expr --}}
				@endif

			</span>												
			{{-- expr --}}
		@endif

	
	 	
	 	

		{{--  --}}
	{{-- @endif --}}


	
	{{-- expr --}}
@endforeach



