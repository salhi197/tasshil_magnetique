@extends('layouts.app')

@section('content')
	
	<div class="page-header">
		
		<h4 class="page-title">Détails sur le payement du Prof 
		</h4>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body"  id="table-print">
					<div class="clearfix">
						<div class="float-left">
							<h3 onclick="come_back(this)" id="groupe{{$groupe->id}}" class="card-title mb-0" style="cursor:pointer;" >Groupe : {!! $groupe->niveau !!} | {!! $groupe->jour !!} | {!! substr($groupe->heure_debut,0,5) !!}-{!! substr($groupe->heure_fin,0,5) !!}</h3>
						</div>
					</div>

					<hr>

					<div class="row">

						<div class="col-lg-6 ">
							<p class="h3">Informations sur le Prof : </p>
							<address>
								Poucentage Prof : {!! $groupe->pourcentage_prof !!} %<br>
							</address>
						</div>

						<div class="col-lg-6 ">
							<p class="h3">Informations sur le Groupe : </p>
							<address>
								Tarif Groupe : {!! $groupe->tarif !!} DA<br>
								Nobres d'élèves qui ne payent pas : {!! count($eleves_ne_payent_pas) !!} élèves : <br>

								@foreach ($eleves_ne_payent_pas as $eleve)
									L'élève : {!! $eleve->nom !!} 
									{!! $eleve->prenom !!}<br>
									{{-- expr --}}
								@endforeach
							</address>
						</div>


						<div class="col-md-3">
							<button type="button" style="color: #ffffff; margin: 1% 0%;" class="btn btn-primary"  id="btnPrint"> Imprimer </button>
						</div>

						{{--  --}}
					</div>
					
					<div class="table-responsive push">
						
						<table class="table table-bordered table-hover">
							
							<tbody>
								<tr class="">
									<th class="text-center">Mois </th>
									<th class="text-center">Séance 1</th>
									<th class="text-center">Séance 2</th>
									<th class="text-center">Séance 3</th>
									<th class="text-center">Séance 4</th>
								</tr>

								@for ($i = 0; $i <$le_mois; $i++)
									
									<tr>
										<td class="text-center alert alert-info">{!! $i+1 !!}</td>
										
										<td class="text-left">

											@foreach ($presences as $presence)
												
												@if ($presence->mois == ($i+1) && ($presence->num%4 == 1))
														
													{!! $presence->presences !!} Présences | prof: {!! $presence->id_prof !!}<p style="color:seagreen;" >Payement :  {!! $presence->presences*($groupe->tarif/4)*($groupe->pourcentage_prof/100)  !!} DA</p> 

													{{-- expr --}}
												@endif

											@endforeach
										</td>

										<td class="text-left">

											@foreach ($presences as $presence)
												
												@if ($presence->mois == ($i+1) && ($presence->num%4 == 2))
														
													{!! $presence->presences !!} Présences | prof: {!! $presence->id_prof !!}<p style="color:seagreen;" >Payement :  {!! $presence->presences*($groupe->tarif/4)*($groupe->pourcentage_prof/100)  !!} DA</p> 

													{{-- expr --}}
												@endif

											@endforeach
										</td>

 										<td class="text-left">

											@foreach ($presences as $presence)
												
												@if ($presence->mois == ($i+1) && ($presence->num%4 == 3))
														
													{!! $presence->presences !!} Présences | prof: {!! $presence->id_prof !!}<p style="color:seagreen;" >Payement :  {!! $presence->presences*($groupe->tarif/4)*($groupe->pourcentage_prof/100)  !!} DA</p> 

													{{-- expr --}}
												@endif

											@endforeach

										</td>
										
										<td class="text-left">			

											@foreach ($presences as $presence)
												
												@if ($presence->mois == ($i+1) && ($presence->num%4 == 0))
														
													{!! $presence->presences !!} Présences | prof: {!! $presence->id_prof !!}<p style="color:seagreen;" >Payement :  {!! $presence->presences*($groupe->tarif/4)*($groupe->pourcentage_prof/100)  !!} DA</p> 

													{{-- expr --}}
												@endif

											@endforeach

										</td>

									</tr>

									{{-- expr --}}
								@endfor

							</tbody>
						</table>
					</div>
				</div>

				{{--  --}}
			</div>
		</div><!-- COL-END -->
	</div>

	<!-- ROW-1 CLOSED -->

	<script src="{{ asset('js/gerer_retard_special.js') }}"></script>

@endsection

@section('scripts')

	<script type="text/javascript">
	$(document).ready(function(){
	    console.log($("#btnPrint").html());
	    $("#btnPrint").on('click',function(){
	//            var divContents = $("#datable-1").html();
	            $('#table-print').printThis();
	    })
	});



	</script>
@endsection