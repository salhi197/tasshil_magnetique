@extends('layouts.app')

<?php use App\Classe; ?>

@section('content')

	<div class="page-header row">
		
		<h4 class="page-title col-md-6">Calendrier des salles / jours</h4>
	</div>
	<button type="button" style="color: #ffffff; margin-top: 5%; margin-bottom:1%;" class="btn btn-info col-md-3"  id="btnPrint_vendredi"> Imprimer </button>

	<!-- vendredi OPEN -->
	<div {{-- class="row" --}} style="border:black solid 2px;">
		<div {{-- class="col-md-12 col-lg-12" --}}>
			<div class="card">
				<div class="card-header">
					<h3 class="card-title row col-md-12">
						<span class="col-md-5">Vendredi</span> 
					</h3>
				</div>
				<div {{-- class="table-responsive" --}} id="Vendredi">
					<table class="table card-table table-vcenter table-secondary">
						<thead  class="bg-secondary text-white">
							<tr>
								<th style="width:10%;">Salles/Horaires <br> Vendredi</th>
								
								@foreach ($horaires_vendredi as $horaire)
									
									<th style="width:10%;">{!! substr($horaire->heure_debut,0,5) !!} - {!! substr($horaire->heure_fin,0,5) !!}</th>
									{{-- expr --}}
								@endforeach
							</tr>
						</thead>
						<tbody>

							@for ($i = 0; $i < count($salles) ; $i++)
								
								<tr>
									<th style="width:10%;">{!! $salles[$i]->num !!}</th>

									@foreach(Classe::what_exists($salles[$i],$horaires_vendredi,$salles_profs_vendredi) as $element)
										
										@if (property_exists($element,"prof"))

											@if ($element->prof != 'vide')
												
												<td class="text-left" style="width:10%;"> 
													
													<p style="font-weight:bold;">{!! $element->prof !!}</p> 
													{!! $element->matiere !!} | {!! $element->niveau !!}
												</td>

											@else
											
												<td style="width:10%;"></td>	

												{{-- expr --}}
											@endif
										@else

											<td class="text-left" style="width:10%;"> 
												
												<p style="font-weight:bold;">Spécial</p> 
												{!! $element->niveau !!}
											</td>										
										@endif

										{{-- expr --}}
									@endforeach
								</tr>

								{{-- expr --}}
							@endfor

						</tbody>
					</table>
				</div>
				<!-- table-responsive -->
			</div>
		</div>
	</div>
	<!-- vendredi CLOSED -->

	<hr>
	<hr>





	<!-- samedi OPEN -->
	<div {{-- class="row" --}} style="border:black solid 2px;">
		<div {{-- class="col-md-12 col-lg-12" --}}>
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Samedi</h3>
				</div>
				<div {{-- class="table-responsive" --}} id="Samedi">
					<table class="table card-table table-vcenter table-secondary" >
						<thead  class="bg-secondary text-white">
							<tr>
								<th style="width:10%;">Salles/Horaires <br> Samed </th>
								
								@foreach ($horaires_samedi as $horaire)
									
									<th style="width:10%;">{!! substr($horaire->heure_debut,0,5) !!} - {!! substr($horaire->heure_fin,0,5) !!}</th>
									{{-- expr --}}
								@endforeach
							</tr>
						</thead>
						<tbody>

							@for ($i = 0; $i < count($salles) ; $i++)
								
								<tr>
									<th style="width:10%;">{!! $salles[$i]->num !!}</th>

									@foreach(Classe::what_exists($salles[$i],$horaires_samedi,$salles_profs_samedi) as $element)

										@if (property_exists($element,"prof"))
										
											@if ($element->prof != 'vide')
												
												<td class="text-left" style="width:10%;"> 
													
													<p style="font-weight:bold;">{!! $element->prof !!}</p> 
													{!! $element->matiere !!} | {!! $element->niveau !!}
												</td>

											@else
											
												<td style="width:10%;"></td>	

												{{-- expr --}}
											@endif
										@else	

											<td class="text-left" style="width:10%;"> 
												
												<p style="font-weight:bold;">Spécial</p> 
												{!! $element->niveau !!}
											</td>

										@endif
										{{-- expr --}}
									@endforeach
								</tr>

								{{-- expr --}}
							@endfor

						</tbody>
					</table>
				</div>
				<!-- table-responsive -->
			</div>
		</div>
	</div>
	<!-- samedi CLOSED -->

	<hr>
	<hr>




	<!-- Dimanche OPEN -->
	<div {{-- class="row" --}} style="border:black solid 2px;">
		<div {{-- class="col-md-12 col-lg-12" --}}>
			<div class="card">
				<div class="card-header">
					<h3 class="card-title" >Dimanche</h3>
				</div>
				<div {{-- class="table-responsive" --}}  id="Dimanche" >
					<table class="table card-table table-vcenter table-secondary">
						<thead  class="bg-secondary text-white">
							<tr>
								<th style="width:10%;">Salles/Horaires <br> Dimanche </th>
								
								@foreach ($horaires_dimanche as $horaire)
									
									<th style="width:10%;">{!! substr($horaire->heure_debut,0,5) !!} - {!! substr($horaire->heure_fin,0,5) !!}</th>
									{{-- expr --}}
								@endforeach
							</tr>
						</thead>
						<tbody>

							@for ($i = 0; $i < count($salles) ; $i++)
								
								<tr>
									<th style="width:10%;">{!! $salles[$i]->num !!}</th>

									@foreach(Classe::what_exists($salles[$i],$horaires_dimanche,$salles_profs_dimanche) as $element)

										@if (property_exists($element,"prof"))
										
											@if ($element->prof != 'vide')
												
												<td class="text-left" style="width:10%;"> 
													
													<p style="font-weight:bold;">{!! $element->prof !!}</p> 
													{!! $element->matiere !!} | {!! $element->niveau !!}
												</td>

											@else
											
												<td style="width:10%;"></td>	

												{{-- expr --}}
											@endif
										@else	

											<td class="text-left" style="width:10%;"> 
												
												<p style="font-weight:bold; color: seagreen;">Spécial</p> 
												{!! $element->niveau !!}
											</td>

											{{--  --}}
										@endif


										{{-- expr --}}
									@endforeach
								</tr>

								{{-- expr --}}
							@endfor

						</tbody>
					</table>
				</div>
				<!-- table-responsive -->
			</div>
		</div>
	</div>
	<!-- Dimanche CLOSED -->

	<hr>
	<hr>



	<!-- lundi OPEN -->
	<div {{-- class="row" --}} style="border:black solid 2px;">
		<div {{-- class="col-md-12 col-lg-12" --}}>
			<div class="card">
				<div class="card-header">
					<h3 class="card-title" >Lundi</h3>
				</div>
				<div {{-- class="table-responsive" --}}  id="Lundi" >
					<table class="table card-table table-vcenter table-secondary">
						<thead  class="bg-secondary text-white">
							<tr>
								<th style="width:10%;">Salles/Horaires <br> Lundi </th>
								
								@foreach ($horaires_lundi as $horaire)
									
									<th style="width:10%;">{!! substr($horaire->heure_debut,0,5) !!} - {!! substr($horaire->heure_fin,0,5) !!}</th>
									{{-- expr --}}
								@endforeach
							</tr>
						</thead>
						<tbody>

							@for ($i = 0; $i < count($salles) ; $i++)
								
								<tr>
									<th style="width:10%;">{!! $salles[$i]->num !!}</th>

									@foreach(Classe::what_exists($salles[$i],$horaires_lundi,$salles_profs_lundi) as $element)
										
										@if (property_exists($element,"prof"))
											
											@if ($element->prof != 'vide')

												<td class="text-left" style="width:10%;"> 
													
													<p style="font-weight:bold;">{!! $element->prof !!}</p> 
													{!! $element->matiere !!} | {!! $element->niveau !!}
												</td>
											
												{{--  --}}
											@else
											
												<td style="width:10%;"></td>	

												{{-- expr --}}
											@endif

										@else

											<td class="text-left" style="width:10%;"> 
												
												<p style="font-weight:bold;">Spécial</p> 
												{!! $element->niveau !!}
											</td>

											{{-- expr --}}
										@endif



										{{-- expr --}}
									@endforeach
								</tr>

								{{-- expr --}}
							@endfor

						</tbody>
					</table>
				</div>
				<!-- table-responsive -->
			</div>
		</div>
	</div>
	<!-- lundi CLOSED -->

	<hr>
	<hr>



	<!-- mardi OPEN -->
	<div {{-- class="row" --}} style="border:black solid 2px;">
		<div {{-- class="col-md-12 col-lg-12" --}}>
			<div class="card">
				<div class="card-header">
					<h3 class="card-title" >Mardi</h3>
				</div>
				<div {{-- class="table-responsive" --}}  id="Mardi" >
					<table class="table card-table table-vcenter table-secondary">
						<thead  class="bg-secondary text-white">
							<tr>
								<th style="width:10%;">Salles/Horaires <br> Mardi </th>
								
								@foreach ($horaires_mardi as $horaire)
									
									<th style="width:10%;">{!! substr($horaire->heure_debut,0,5) !!} - {!! substr($horaire->heure_fin,0,5) !!}</th>
									{{-- expr --}}
								@endforeach
							</tr>
						</thead>
						<tbody>

							@for ($i = 0; $i < count($salles) ; $i++)
								
								<tr>
									<th style="width:10%;">{!! $salles[$i]->num !!}</th>

									@foreach(Classe::what_exists($salles[$i],$horaires_mardi,$salles_profs_mardi) as $element)
										
										@if (property_exists($element,"prof"))

											@if ($element->prof != 'vide')
												
												<td class="text-left" style="width:10%;"> 
													
													<p style="font-weight:bold;">{!! $element->prof !!}</p> 
													{!! $element->matiere !!} | {!! $element->niveau !!}
												</td>

											@else
											
												<td style="width:10%;"></td>	

												{{-- expr --}}
											@endif

										@else

											<td class="text-left" style="width:10%;"> 
												
												<p style="font-weight:bold; color:seagreen;">Spécial</p> 
												{!! $element->niveau !!}
											</td>


											{{-- expr --}}
										@endif
									@endforeach
								</tr>

								{{-- expr --}}
							@endfor

						</tbody>
					</table>
				</div>
				<!-- table-responsive -->
			</div>
		</div>
	</div>
	<!-- mardi CLOSED -->

	<hr>
	<hr>



	<!-- mercredi OPEN -->
	<div {{-- class="row" --}} style="border:black solid 2px;">
		<div {{-- class="col-md-12 col-lg-12" --}}>
			<div class="card">
				<div class="card-header">
					<h3 class="card-title" >Mercredi</h3>
				</div>
				<div {{-- class="table-responsive" --}}  id="Mercredi" >
					<table class="table card-table table-vcenter table-secondary">
						<thead  class="bg-secondary text-white">
							<tr>
								<th style="width:10%;">Salles/Horaires <br> Mercredi </th>
								
								@foreach ($horaires_mercredi as $horaire)
									
									<th style="width:10%;">{!! substr($horaire->heure_debut,0,5) !!} - {!! substr($horaire->heure_fin,0,5) !!}</th>
									{{-- expr --}}
								@endforeach
							</tr>
						</thead>
						<tbody>

							@for ($i = 0; $i < count($salles) ; $i++)
								
								<tr>
									<th style="width:10%;">{!! $salles[$i]->num !!}</th>

									@foreach(Classe::what_exists($salles[$i],$horaires_mercredi,$salles_profs_mercredi) as $element)
										
										@if (property_exists($element,"prof"))

											@if ($element->prof != 'vide')
												
												<td class="text-left" style="width:10%;"> 
													
													<p style="font-weight:bold;">{!! $element->prof !!}</p> 
													{!! $element->matiere !!} | {!! $element->niveau !!}
												</td>

											@else
											
												<td style="width:10%;"></td>	

												{{-- expr --}}
											@endif
										@else

											<td class="text-left" style="width:10%;"> 
												
												<p style="font-weight:bold;">Spécial</p> 
												{!! $element->niveau !!}
											</td>										
										@endif
										{{-- expr --}}
									@endforeach
								</tr>

								{{-- expr --}}
							@endfor

						</tbody>
					</table>
				</div>
				<!-- table-responsive -->
			</div>
		</div>
	</div>
	<!-- mercredi CLOSED -->

	<hr>
	<hr>



	<!-- jeudi OPEN -->
	<div {{-- class="row" --}} style="border:black solid 2px;">
		<div {{-- class="col-md-12 col-lg-12" --}}>
			<div class="card">
				<div class="card-header">
					<h3 class="card-title" >Jeudi</h3>
				</div>
				<div {{-- class="table-responsive" --}}  id="Jeudi" >
					<table class="table card-table table-vcenter table-secondary">
						<thead  class="bg-secondary text-white">
							<tr>
								<th style="width:10%;">Salles/Horaires <br> Jeudi </th>
								
								@foreach ($horaires_jeudi as $horaire)
									
									<th style="width:10%;">{!! substr($horaire->heure_debut,0,5) !!} - {!! substr($horaire->heure_fin,0,5) !!}</th>
									{{-- expr --}}
								@endforeach
							</tr>
						</thead>
						<tbody>

							@for ($i = 0; $i < count($salles) ; $i++)
								
								<tr>
									<th style="width:10%;">{!! $salles[$i]->num !!}</th>

									@foreach(Classe::what_exists($salles[$i],$horaires_jeudi,$salles_profs_jeudi) as $element)
										
										@if (property_exists($element,"prof"))

											@if ($element->prof != 'vide')
												
												<td class="text-left" style="width:10%;"> 
													
													<p style="font-weight:bold;">{!! $element->prof !!}</p> 
													{!! $element->matiere !!} | {!! $element->niveau !!}
												</td>

											@else
											
												<td style="width:10%;"></td>	

												{{-- expr --}}
											@endif
										@else

											<td class="text-left" style="width:10%;"> 
												
												<p style="font-weight:bold;">Spécial</p> 
												{!! $element->niveau !!}
											</td>

											{{--  --}}										
										@endif
										{{-- expr --}}
									@endforeach
								</tr>

								{{-- expr --}}
							@endfor

						</tbody>
					</table>
				</div>
				<!-- table-responsive -->
			</div>
		</div>
	</div>
	<!-- jeudi CLOSED -->

	<hr>
	<hr>

	{{--  --}}
@endsection


@section('scripts')
	
	<script type="text/javascript">

		$(document).ready(function(){
		    console.log($("#btnPrint_vendredi").html());
		    $("#btnPrint_vendredi").on('click',function(){
		//            var divContents = $("#datable-1").html();
		            $('#Vendredi,#Samedi,#Dimanche,#Lundi,#Mardi,#Mercredi,#Jeudi').printThis();
		    })
		});


		//
	</script>
@endsection
