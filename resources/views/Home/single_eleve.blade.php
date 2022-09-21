@extends('layouts.app')

@section('content')
	
	<div style="display:none;" class="card-body">
		<button id="my_modal" type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal3">View modal</button>
	</div>


	<div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog"  aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="example-Modal3">Modifier Numéro de Téléphone</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				
				<form method="post" action="/home/groupes/{{$groupe->id}}/eleve/{{$eleve->id}}/modif_num">

					<div class="modal-body">
							<div class="form-group">
								<label for="numtel" class="form-control-label">Num Tel</label>
								<input value="{{ $eleve->num_tel }}" name="numtel" type="number" class="form-control" id="numtel">
							</div>
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Enregistrer</button>
					</div>
				</form>
					
				
			</div>
		</div>
	</div>

	<div class="page-header">
		
		<h4 class="page-title">Détails sur le payement de l'élève : {!! $eleve->nom !!} {!! $eleve->prenom !!}</h4>
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
							<p class="h3">Informations sur l'élève : </p>
							<address ondblclick="ajouternumtel();">
								Nom : {!! $eleve->nom !!}<br>
								Prénom : {!! $eleve->prenom !!}<br>
								Numéro tel : {!! $eleve->num_tel !!}<br>
							</address>
						</div>

						<div class="col-lg-6 ">
							<p class="h3">Frais D'inscription : </p>
							<address>
								
								<form method="post" action="/home/groupes/{{$groupe->id}}/eleve/{{$eleve->id}}/completer_frais">
								
									<label for="frais">Frais : {!! $eleve->frais !!} DA</label>

									@if ($eleve->frais == $frais)
										
										<p class="alert alert-sccess" style="color:green;">Frais d'inscriptions Complets</p>
									 @else
		
										<input type="number" max="{{$frais}}" id="frais" name="frais" class="is-invalid state-invalid form-control col-md-6" value="{{ $frais-$eleve->frais }}">
										<br>
										
										<button type="submit" class="col-md-6 btn btn-outline-warning">Valider</button>

										{{-- expr --}}
									@endif
								</form>

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
									<th class="text-center">Cochages</th>
									<th class="text-center">Dates Séances</th>
									<th class="text-center">Payé</th>
									<th class="text-center">Retard</th>
								</tr>

								@for ($i = 0; $i <$le_mois; $i++)
									<tr>
										<td class="text-center" style="width: 2%;">{!! $i+1 !!}</td>
										
										<td class="text-left" style="width: 25%;">
                                        	@include('includes.single_eleve.cochages',['groupe'=>$groupe,'eleve'=>$eleve,'payement_eleve'=>$payement_eleve,'seances_eleves'=>$seances_eleves,"i"=>$i,"num_seance_groupe"=>$num_seance_groupe])
										</td>


										<td class="text-left">
                                        	@include('includes.single_eleve.dates',['groupe'=>$groupe,'eleve'=>$eleve,'payement_eleve'=>$payement_eleve,'seances_eleves'=>$seances_eleves,"i"=>$i])
										</td>

 										<td class="text-center" style="width: 25%;">
											
											@include('includes.single_eleve.payement',['groupe'=>$groupe,'eleve'=>$eleve,'payement_eleve'=>$payement_eleve,'seances_eleves'=>$seances_eleves,"i"=>$i])

											{{--  --}}
										</td>
										
										<td class="text-left" style="width: 25%;">			

											@include('includes.single_eleve.retards',['groupe'=>$groupe,'eleve'=>$eleve,'payement_eleve'=>$payement_eleve,'seances_eleves'=>$seances_eleves,"i"=>$i,'les_presences'=>$les_presences,'les_absences'=>$les_absences])

										</td>
									</tr>

									{{-- expr --}}
								@endfor

							</tbody>
						</table>

						<hr>

						<h4>
							Voir aussi le payement de l'éléve 
								{!! $eleve->nom !!} {!! $eleve->prenom !!} 
								dans les groupes : 
								
								@foreach($autres_groupes as $groupe)
									<a style="color:green;" href="/home/groupes/{{$groupe->id}}/eleve/{{$eleve->id}}"> {{App\Groupe::get_matiere($groupe->id) ?? ''}} </a> | 
								@endforeach
						</h4>

						<hr>

						<button  data-toggle="modal" data-target="#myModalsup" class="btn btn-outline-danger col-md-12" >Supprimer L'élève</button>

                        <div id="myModalsup" class="modal fade" role="dialog">

                          	<div class="modal-dialog modal-lg">

                                <!-- Modal content-->

                                <div class="modal-content">

                                   <div class="modal-header">

                                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                                        <h4 class="modal-title">Voulez-vous vraiment supprimer cet Elève ?</h4>
                                  	</div>

                                  	<div class="modal-body">

                                        <a class="col-md-5 btn btn-danger" onclick="supprimereleve(event,this)"  data-dismiss="modal" style="color: #ffffff;" id_groupe="{{ $groupe->id }}" id="eleve{{$eleve->id}}">OUI,je supprime</a>

                                        <a data-dismiss="modal" class="col-md-6  btn btn-primary" style="color: #ffffff;" >NON,je ne veux pas supprimer</a>
                                        {{--  --}}
                                  	</div>

                                  	<div class="modal-footer">

                                        <a class="btn btn-warning" data-dismiss="modal" style="color: #ffffff;">Fermer</a>
                                  	</div>
                                </div>
                                {{--  --}}
                          	</div>

                        </div>  
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