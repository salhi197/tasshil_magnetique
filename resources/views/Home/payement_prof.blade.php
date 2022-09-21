@extends('layouts.app')

@section('content')
	
	<div class="page-header">
		
		<h4 class="page-title">Détails sur le payement du Prof : {!! $groupe->prof !!}
		</h4>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body"  id="table-print">
					<div class="clearfix">
						<div class="float-left">
							<h3 onclick="come_back(this)" id="groupe{{$groupe->id}}" class="card-title mb-0" style="cursor:pointer;" >Groupe : {!! $groupe->niveau !!} | {!! $groupe->matiere !!} | {!! $groupe->jour !!} | {!! substr($groupe->heure_debut,0,5) !!}-{!! substr($groupe->heure_fin,0,5) !!}</h3>
						</div>
					</div>

					<hr>

					<div class="row">

						<div class="col-lg-6 ">
							<p class="h3">Informations sur le Prof : </p>
							<address>
								Nom : {!! $groupe->prof !!}<br>
								@if ($groupe->pourcentage_prof<100)
									
									Poucentage Prof : {!! $groupe->pourcentage_prof !!} %
									<br>
								 @else
								 	Salaire Prof : {!! $groupe->pourcentage_prof !!} DA
									<br>
									{{-- expr --}}
								@endif
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
									<th class="text-center">Total Présences</th>
									@if ($groupe->pourcentage_prof<100)
										
										<th class="text-center">{!! $groupe->pourcentage_prof !!}% Prof</th>
									 @else

									 	<th class="text-center">Salaire</th>
										{{-- expr --}}
									@endif
									<th class="text-center">Date</th>
									<th class="text-center">Signature</th>
								</tr>

								@for ($i = 0; $i <$le_mois; $i++)
									
									<tr>
										<td class="text-center alert alert-info">{!! $i+1 !!}</td>
										
										<td class="text-center">

											@foreach ($presences as $presence)
												
												@if ($presence->mois == ($i+1) && ($presence->num%4 == 1))
														
													{!! $presence->presences !!}

													{{-- expr --}}
												@endif

											@endforeach

 										</td>

										<td class="text-center">
 
											@foreach ($presences as $presence)
												
												@if ($presence->mois == ($i+1) && ($presence->num%4 == 2))
														
													{!! $presence->presences !!}

													{{-- expr --}}
												@endif

											@endforeach

 										</td>

 										<td class="text-center">
										

											@foreach ($presences as $presence)
												
												@if ($presence->mois == ($i+1) && ($presence->num%4 == 3))
														
													{!! $presence->presences !!}

													{{-- expr --}}
												@endif

											@endforeach

										</td>
										
										<td class="text-center">			

											@foreach ($presences as $presence)
												
												@if ($presence->mois == ($i+1) && ($presence->num%4 == 0))
														
													{!! $presence->presences !!}

													{{-- expr --}}
												@endif

											@endforeach

										</td>

										<td class="text-center">	

											@foreach ($presences_mois as $presence_moi)
												
												@if ($presence_moi->mois == ($i+1))
													
													{!! $presence_moi->presences !!} Présences

													{{-- expr --}}
												@endif

												{{-- expr --}}
											@endforeach

										</td>

										<td class="text-center">			

											@foreach ($presences_mois as $presence_moi)
												
												@if ($presence_moi->mois == ($i+1))
													
													{!! $presence_moi->presences*($groupe->tarif/4)*($groupe->pourcentage_prof/100) !!} DA

													<input style="display:none;" type="number" id="le_payement_du_mois{{$i+1}}" value="{{ $presence_moi->presences*($groupe->tarif/4)*($groupe->pourcentage_prof/100) }}">

													{{-- expr --}}
												@endif

												{{-- expr --}}
											@endforeach
										</td>

										<td class="text-center">	

											@if ($i<count($les_payements))
												
												<p style="color:green;">Payement éffectué le : {!! $les_payements[$i]->created_at !!} </p>

											@else

												<label class="custom-switch">
													
													<input onchange="afficher_suur(this)" id="payement_prof{{$i}}" type="checkbox" class="custom-switch-input">

													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-description">Payement éffectué</span>
												</label>

												<label id="payement_prof_effectuee{{$i}}" style="display:none;" class="custom-switch">

													<input type="checkbox" class="custom-switch-input" onchange="afficher_payement_prof_2(this,{{ $i }});" seance="{{$numero_de_la_seance_dans_le_mois }}" groupe="{{ $groupe->id }}" prof="{{ $groupe->prof }}" >
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-description">étes vous sur ?</span>

												</label>
												
											 	{{-- expr --}}
											@endif 
										</td>

										@if (!($i<count($les_payements)))
											
											<td class="text-center">.</td>
										@else

											<td style="background:seagreen;" class="text-center">éffectué	</td>
										@endif


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

	<script src="{{ asset('js/gerer_retard.js') }}"></script>

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