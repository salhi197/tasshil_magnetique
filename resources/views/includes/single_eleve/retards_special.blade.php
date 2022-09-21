<?php 
	
	$numItems = count($retards);
	$pp = 0;
?>

@foreach ($retards as $retard)
	
	{{-- @if(++$pp != $numItems) --}}

		<?php $vv = 0; ?>
		
		@if ($retard->num_mois == ($i+1))
			
			@if ( (($groupe->tarif - $retard->payment_du_mois)==0) || (($retard->exoneree>0)) )
				
				<p style="color:green;" class="text-center"> Payement Complet {!! $retard->payment_du_mois !!} DA </p>	
			 		

			 @else

				<p style="color:red;" id="le_retard{{$i+1}}" class="text-center"> Manque : {!! $groupe->tarif - $retard->payment_du_mois !!} DA </p>
				
				<li id="Payement_Complet{{$i+1}}" class="list-group-item">
					Payement Complet ?
					<div class="material-switch pull-right">
						<input id="complet{{$i+1}}" value="1" onchange="hide_or_show_tarif(this)" type="checkbox"/>
						<label for="complet{{$i+1}}" class="label-primary"></label>
					</div>
				</li>

				<div class="row" id="complement{{$i+1}}">

					<label for="mois{{$i+1}}"> Montant </label> 

					<input  style="margin:2% 1%;" id="mois{{$i+1}}" autofocus class="form-control col-md-4" type="number" max="{{ $groupe->tarif - $retard->payment_du_mois }}" value="{{ $groupe->tarif - $retard->payment_du_mois }}">


					<button style="margin:2% 1%;" onclick="completer_payement(this)" id="Valider{{$i+1}}" current_seance="{{$current}}" id_eleve="{{$eleve->id}}" id_groupe="{{$groupe->id}}" class="btn btn-primary col-md-5"> Valider </button>
				
				</div>

				<li id="suur{{$i+1}}" style="margin-top:1%;display:none;" class="list-group-item">
					étes-vous sur ?
					<div class="material-switch pull-right">
						
						<input onchange="suur(this)" eleve="{{$eleve->id}}" groupe="{{$groupe->id}}" id="sur{{$i+1}}" tarif="{{$groupe->tarif}}" onchange="" type="checkbox"/>
						
						<label for="sur{{$i+1}}" class="label-success"></label>
					</div>
				</li>

				{{-- expr --}}
			@endif


			{{-- expr --}}
		@endif		
	{{-- @endif --}}

	{{-- expr --}}
@endforeach
	

