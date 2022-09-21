@foreach ($payement_eleve as $payement)
	
	@if ($payement->num_mois == $i+1)
			
		<p> {!! $payement->payement !!} DA | Date : {!! substr($payement->created_at,0,16) !!} </p>
		
{{-- 		@if ($payement->paye)
			
			<p>L'élève ne paye pas</p>
		@endif
 --}}
		{{-- expr --}}
	@endif



	{{-- expr --}}
@endforeach