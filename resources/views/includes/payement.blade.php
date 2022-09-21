@if ($numero_de_la_seance_dans_le_mois%4 == 0)
	
	<?php $le_mois = $le_mois-1; ?>	

	{{-- expr --}}
@endif

<?php $complet = false;?>
<?php $avance = 0;?>
<?php $il_paye = 0;?>



@foreach ($eleves_gratuits as $eleve_gratuit)

	@if ($eleve_gratuit->id_eleve == $eleves_groupe[$i]->id)
		
		<p style="color:blueviolet; font-size:11px;" class="text-center alert alert-info">ne paye pas </p> 		
		
		<?php $il_paye++; ?>
		
		{{-- expr --}}
	@endif

	{{-- expr --}}
@endforeach







@if ($il_paye==0)
	

	<form target="_blank" class="form-inline" method="POST" action="/imprimer_bon">	

		{{ csrf_field() }} 		

		@if ($numero_de_la_seance_dans_le_mois%4==1 && $le_mois != 1)
			
			@foreach ($payments as $payment)
				
				@if ($payment->id_eleve == $eleves_groupe[$i]->id && $payment->payment_du_mois >=0)		

					<p style="color:green;" class="text-center"> Payé : {!! $payment->payment_du_mois !!} DA </p> 

					<?php $avance = $payment->payment_du_mois;?>

					@if ($payment->payment_du_mois==$groupe->tarif)
						
						<?php $complet = true;?>
						
						{{-- expr --}}
					@endif

					{{--  --}}
				@endif	

				{{-- expr --}}
			@endforeach

			@if (!$complet)
				
				<input name="montant" onkeyup="verif_prix_tarif(this,{{ $groupe->tarif }})" id="input_payement{{ $eleves_groupe[$i]->id }}" value="0" max="{{ $groupe->tarif-$avance }}" type="number" min="0" class="form-control col-md-12">
			
				{{-- expr --}}
			@endif
			
		 @else

			@foreach ($payments as $payment)

				@if ($payment->id_eleve == $eleves_groupe[$i]->id && $payment->payment_du_mois >= $groupe->tarif)

					<p style="color:green;">Complet {!! $payment->payment_du_mois !!} DA </p>

			    	<input style="display:none;" onkeyup="verif_prix_tarif(this,{{ $groupe->tarif }})" id="input_payement{{ $eleves_groupe[$i]->id }}" value="0" type="number" min="0" max="{{ $groupe->tarif-$payment->payment_du_mois }}" class="form-control col-md-12">

			    	

					{{--  --}}
				@endif

				@if ($payment->id_eleve == $eleves_groupe[$i]->id && $payment->payment_du_mois < $groupe->tarif)

					<p style="color:green;" class="text-center"> Payé : {!! $payment->payment_du_mois !!} DA </p> 

			    	<input name="montant" onkeyup="verif_prix_tarif(this,{{ $groupe->tarif }})" id="input_payement{{ $eleves_groupe[$i]->id }}" value="0" type="number" min="0" max="{{ $groupe->tarif-$payment->payment_du_mois }}" class="form-control col-md-12">

			    	
					<p style="color:red;" class="text-center"> Reste : {!! $groupe->tarif-$payment->payment_du_mois !!} DA </p> 	    	

					{{--  --}}
				@endif


				{{--  --}}
			@endforeach
			
			{{--  --}}
		@endif
		
		<input style="display:none;" name="mois" value="{{ $le_mois }}" type="number">
		<input style="display:none;" name="id_eleve" value="{{ $eleves_groupe[$i]->id }}" type="number">
		<input style="display:none;" name="id_groupe" value="{{ $groupe->id }}" type="number">
		<input style="display:none;" name="tarif" value="{{ $groupe->tarif }}" type="number">

		<input class="btn btn-sm btn-primary" value="Imprimer Bon" type="submit" name="submit" value="submit">

	</form>	
	

	{{-- expr --}}
@endif