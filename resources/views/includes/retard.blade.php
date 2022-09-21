<?php $vp = 0 ?>

@if ($numero_de_la_seance_dans_le_mois%4 == 0)
	
	<?php $le_mois = $le_mois-1; ?>	
	
	{{-- expr --}}
@endif


<?php $il_paye = 0;?>

@foreach ($eleves_gratuits as $eleve_gratuit)

	@if ($eleve_gratuit->id_eleve == $eleves_groupe[$i]->id)
		
	    <li style="margin: auto; width: 100%; padding: 10px;" class="icons-list-item">
	    	<i class="ion-ios7-checkmark-empty" data-toggle="tooltip" title="Cliquez pour + de détails"></i>
	    </li>
		
		<?php $il_paye++; ?>
		
		{{-- expr --}}
	@endif

	{{-- expr --}}
@endforeach


@if ($il_paye==0)
	

	@foreach ($ancien_payments as $ancien_payment)

		@if ($ancien_payment->id_eleve == $eleves_groupe[$i]->id && $ancien_payment->exoneree==0 )
			
			<?php $vp++; ?>

			<p style="color:red;" >Retard Mois {!! $ancien_payment->num_mois !!} : {!! $groupe->tarif - $ancien_payment->payment_du_mois !!} DA</p>	

			{{-- expr --}}
		@endif

		{{--  --}}
	@endforeach

	@if ($vp==0)

	    <li style="margin: auto; width: 100%; padding: 10px;" class="icons-list-item">
	    	<i class="ion-ios7-checkmark-empty" data-toggle="tooltip" title="Cliquez pour + de détails"></i>
	    </li>

		{{-- expr --}}
	@endif


	{{-- expr --}}
@endif
	
