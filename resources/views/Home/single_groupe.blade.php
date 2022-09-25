<?php 
use App\Eleve;
use App\Groupe;
?>
@extends('layouts.app')
@section('content')

	<!-- ROW-1 OPEN -->
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				
				<div class="card-body">
					<div class="clearfix">
						<div class="float-left">
							<h3 class="card-title mb-0">Groupe #{!! $groupe->id !!} {!! $groupe->jour !!} | {!! substr($groupe->heure_debut,0,5) !!}-{!! substr($groupe->heure_fin,0,5) !!}</h3>
						</div>
						<div class="text-right">
							<h3 class="card-title">Numéro Séance Actuelle: {!! Groupe::current_seance($groupe->id)%4 !!}  </h3>
						
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-lg-6 ">
							<p class="h3" style="cursor:pointer;"  data-toggle="modal" data-target="#myModal_modif" >Informations du Groupe : </p>

							@include('includes.single_groupe.modifier_groupe',['salles'=>$salles,'niveaux'=>$niveaux,'matieres'=>$matieres,'profs'=>$profs,'groupe'=>$groupe])

							<address>
							Date Création: {!! $groupe->created_at !!}<br>

								Année scolaire : {!! $groupe->annee_scolaire !!}<br>
								Niveau : {!! $groupe->niveau !!} <br>
								Matière : {!! $groupe->matiere !!} <br>
								Tarif : {!! $groupe->tarif !!} DA 
							</address>
						</div>
						<div class="col-lg-6 text-right">
							<p class="h3">Informations Prof : </p>
							<address>
								Prof : {!! $groupe->prof !!}<br>
								Num tel : {!! $numtel->tel !!} <br>
								{{-- Pourcentage prof : {!! $groupe->pourcentage_prof !!} %<br> --}}
							</address>
						</div>
					</div>
				</div>
			<div class="row">
			<div class="col-md-3">
					<a type="button" style="color: #ffffff; margin: 1% 0%;" class="btn btn-primary" data-toggle="modal" data-target="#myModal"> <i class="mdi mdi-plus"></i> Ajouter un élève </a>
				</div>
				<div class="col-md-3">
					<button type="button" style="color: #ffffff; margin: 1% 0%;" class="btn btn-primary"  id="btnPrint"> Imprimer </button>
				</div>


				<div class="col-md-3">
					<input id="myInput1" placeholder="Recherche ..." type="text" class="form-control">
				</div>
			</div>
			

			<div id="myModal" class="modal fade" role="dialog">

			    <div class="modal-dialog modal-lg">

			        <div class="modal-content">

			           	<div class="modal-header">

			                <h4 class="modal-title">Nouvel Elève</h4>
			          	</div>

			            <div class="modal-body">

			                <form id="ajout" target="_blank" class="form-inline" method="POST" action="/home/groupes/{{$id}}/ajouter">

			                	{{ csrf_field() }}  
			                    <div class="form-group col-md-3 col-sm-12">

			                        <label for="nom">Matricule :</label>

			                        <input type="text" onkeyup="verif_existance();" id="matricule" required name="matricule" groupe="{{$groupe->id}}" class="form-control col-md-12" autofocus>

			                    </div>


			                    <div class="form-group col-md-3 col-sm-12">

			                        <label for="nom">nom</label>

			                        <input type="text" onkeyup="verif_existance();" id="nom" required name="nom" groupe="{{$groupe->id}}" class="form-control col-md-12" autofocus>

			                        {{--  --}}
			                    </div>

			                    <div class="form-group col-md-3 col-sm-12">

			                        <label for="prenom">Prenom</label>

			                        <input type="text" onkeyup="verif_existance();" id="prenom" required name="prenom" class="form-control col-md-12">

			                        {{--  --}}
			                    </div>

			                    <div class="form-group col-md-3 col-sm-12">

			                        <label for="num_tel">Num Tel</label>

			                        <input type="tel" onkeyup="verif_tel(this)" id="num_tel" name="num_tel" value="0" class="form-control col-md-12">

			                        {{--  --}}
			                    </div>

			                    <div  id="payement" class="form-group col-md-3 col-sm-12">

			                        <label for="payment">Payement</label>

			                        <input type="number" min="0" max="{{$groupe->tarif}}" value="0" name="payment" class="form-control col-md-12">

			                        {{--  --}}
			                    </div>

			                    <div  id="frais" style="display:none;" class="form-group col-md-3 col-sm-12">

			                        <label for="frais">Frais D'inscriptions</label>

			                        <input type="number" min="0" max="{{$groupe->tarif}}" value="0" name="frais" class="form-control col-md-12">

			                        {{--  --}}
			                    </div>


								<div style="margin-top: 2%" class="form-group col-md-12">
									
									<label class="custom-switch">
										<input type="checkbox" onchange="hide_payement(this);" id="ilpaye" name="cotisations" class="custom-switch-input col-md-12" value="1" checked>
										<span class="custom-switch-indicator"></span>
										<span class="custom-switch-description">L'élève paye ses cotisations</span>
									</label>
								</div>

								<input type="submit" style="color: #2070F5; margin-top: 5%;" class="btn btn-outline-primary col-md-12" value="Ajouter" id="btn_ajouter">

								{{-- <p id="il_existe_deja" style="font-size: 1.2em;" class="invalid-feedback text-center">L'Elève existe déja</p> --}}
			                </form>
			            </div> 

			          	<div class="modal-footer">

			                <a type="button" style="color: #ffffff;" class="btn btn-warning" data-dismiss="modal">Fermer</a>

			          	</div>


			        </div>

			    </div>
		    
			</div>           
























			<div class="card-body">
				
				<div class="table-responsive">
					
					<table data-page-length='50' id="table-1" class="table table-striped table-bordered text-nowrap w-100">
						<caption>
							Groupe #{!! $groupe->id !!} {!! $groupe->jour !!} | {!! substr($groupe->heure_debut,0,5) !!}-{!! substr($groupe->heure_fin,0,5) !!} | Niveau : {!! $groupe->niveau !!} |
								Matière : {!! $groupe->matiere !!} | 
								Tarif : {!! $groupe->tarif !!} DA | Prof : {!! $groupe->prof !!} 
						</caption>
						<thead>
							<tr>
								<th style="cursor: pointer;" class="wd-15p">N°</th>
								<th style="cursor: pointer;" class="wd-15p">Nom</th>
								<th style="cursor: pointer;" class="wd-15p">Prénom</th>
								<th style="cursor: pointer;" class="wd-15p">Num tel</th>
								<th style="cursor: pointer;" class="wd-15p">Séances</th>
								<th style="cursor: pointer; color: green;" class="wd-15p">Payé</th>
								<th style="cursor: pointer; color: red;" class="wd-15p">Retard</th>
							</tr>
						</thead>
                        
                        <tbody id="all_the_eleves">

                            @for($i=0 ; $i < count($eleves_groupe) ; $i++)

                                <tr id="l_eleve{{$eleves_groupe[$i]->id}}">

                                    <div>

                                        {{ csrf_field() }}  

                                        <td style="width:5%;">

                                            {!! $i+1 !!}                                                
                                        </td>

                                        <td style="width:5%;">

                                            {!! $eleves_groupe[$i]->nom  !!}
                                        </td>

                                        <td style="width:5%;"> 
                                        	
											{!! $eleves_groupe[$i]->prenom !!}
                                        </td>

                                        <td style="width:5%;"> 
                                        	
											{!! $eleves_groupe[$i]->num_tel !!}
                                        </td>


                                        <td style="width:40%;" class="text-center">
                                        		Mois : {{Groupe::get_the_month($groupe->id)}} | {{Eleve::calculePresncesMois($eleves_groupe[$i]->id,$groupe->id)}}
                                        	<!-- @include('includes.seances',['eleves_groupe'=>$eleves_groupe,
                                        		'numero_de_la_seance_dans_le_mois'=>$numero_de_la_seance_dans_le_mois,'seances_eleves'=>$seances_eleves,'eleves_gratuits'=>$eleves_gratuits]) -->

                                        	{{--  --}}																						
                                        </td>

                                        <td style="width:20%;">

                                        	@include('includes.payement',['eleves_groupe'=>$eleves_groupe,
                                        		'numero_de_la_seance_dans_le_mois'=>$numero_de_la_seance_dans_le_mois,'groupe'=>$groupe,'payments'=>$payments,'le_mois'=>$le_mois,'eleves_gratuits'=>$eleves_gratuits])

                                        	{{--  --}}
                                        </td>


                                        <td style="width:20%; cursor:pointer;" onclick="goto_the_link(this)" id="eleve{{$eleves_groupe[$i]->id}}" groupe="{{ $groupe->id }}">


                                        	@include('includes.retard',['eleves_groupe'=>$eleves_groupe,
                                        		'numero_de_la_seance_dans_le_mois'=>$numero_de_la_seance_dans_le_mois,'groupe'=>$groupe,'ancien_payments'=>$ancien_payments,'le_mois'=>$le_mois,'eleves_gratuits'=>$eleves_gratuits])

                                        	
                                        </td>

		                            	{{--  --}}
                                    </div>
                                    {{--  --}}
                                </tr>
                                {{-- expr --}}
                            @endfor
                            {{--  --}}
                        </tbody>
 					</table>
				</div>
				</div>



				<div class="card-footer text-right">
					
					<!-- <a id="valider_les_coches" style="color:#ffffff;"
					class="btn btn-primary mb-1" onclick="valider_coches(this);">Valider les coches</a> -->

					<!-- <button id="valider" style="display:none;" 
					class="btn btn-outline-success" 
					groupe="{{ json_encode($groupe->id) }}" 
					value="{{ json_encode($eleves_groupe) }}"
					seances_eleves="{{ json_encode($seances_eleves) }}"
					numero_de_la_seance_dans_le_mois="{{ json_encode($numero_de_la_seance_dans_le_mois) }}"
					eleves_gratuits="{{ json_encode($eleves_gratuits) }}" 
					onclick="valider_tous(this)" >
					
						OUI, Valider
					</button> -->

					<!-- <button id="ne_pas_valider" onclick="retour(this)" style="display:none;" class="btn btn-outline-danger">NOn, Pas Encore</button> -->

					<!-- <p style="display:none;" id="patientez" class="alert alert-info"> Traitement en cours veuillez Patienter s'il vous plait </p> -->
					<a class="btn btn-success" href="{{route('cloturer',['id_groupe'=>$groupe->id])}}">
						Cloturer
					</a>
					{{--  --}}
				</div>


					


				<span class="card-footer row text-left" style="color:blue; display: inline-block;">
					@foreach ($nb_presences as $nb_presence)
						
						@if($nb_presence->num_mois<=count($payements_prof))
							<label style="margin-right: 8%;  cursor: pointer;" groupe="{{ $groupe->id }}" prof="{{ $groupe->prof }}" onclick="afficher_payement_prof_1(this,{{ $nb_presence->num_mois }})" class="col-md-5 alert alert-success" id="payement_prof_mois{{$nb_presence->num_mois}}">
							{!! date_format(date_create($payements_prof[$nb_presence->num_mois-1]->created_at),"d/m/Y H:i:s") !!} | 
						@else
							<label style="margin-right: 8%;  cursor: pointer;" groupe="{{ $groupe->id }}" prof="{{ $groupe->prof }}" onclick="afficher_payement_prof_1(this,{{ $nb_presence->num_mois }})" class="col-md-5 alert alert-warning" id="payement_prof_mois{{$nb_presence->num_mois}}">
						@endif

							@if ($groupe->pourcentage_prof<100)
								
								Payement Du prof mois {!! $nb_presence->num_mois !!} :  

								{!! ($nb_presence->nb_presence)*($groupe->tarif/4)*(($groupe->pourcentage_prof)/100) !!} DA
								<input style="display:none;" id="le_payement_du_mois{{$nb_presence->num_mois}}" type="number" value="{{ ($nb_presence->nb_presence)*($groupe->tarif/4)*(($groupe->pourcentage_prof)/100) }}">
								
								<label style="display:none;" class="custom-switch">
									
									<input seance="{{$numero_de_la_seance_dans_le_mois }}" 	 		groupe="{{ $groupe->id }}" 
											prof="{{ $groupe->prof }}" 
											onchange="afficher_payement_prof_2(this,{{$nb_presence->num_mois }});" 
											id="payement_prof_effectuee{{$nb_presence->num_mois}}" 
											type="checkbox" 
											name="custom-switch-checkbox" 
											class="custom-switch-input">

									<span class="custom-switch-indicator"></span>
									<span class="custom-switch-description">Payement éffectué</span>
								</label>

							 @else

							 	Payement Du prof mois {!! $nb_presence->num_mois !!} :  

								{!! $groupe->pourcentage_prof !!} DA
								<input style="display:none;" id="le_payement_du_mois{{$nb_presence->num_mois}}" type="number" value="{{ $groupe->pourcentage_prof }}">

								{{-- expr --}}
							@endif
						</label>

						{{-- expr --}}
					@endforeach
				</span>

			</div>
		</div><!-- COL-END -->

		<a class="btn btn-outline-info text-center col-md-6" style="color: blue;" href="/home/groupes/{{$groupe->id}}/tout"> Voir toutes les séances de groupe</a>

	    <a class="btn btn-outline-danger text-center col-md-6" style="color:red;" data-toggle="modal" data-target="#myModalsup-{{$groupe->id}}" style="color: #fff;" onclick="event.preventDefault();"> Archiver</a>

	    <div id="myModalsup-{{$groupe->id}}" class="modal fade" role="dialog">

	      	<div class="modal-dialog modal-lg">

	            <!-- Modal content-->

	            <div class="modal-content">

	               <div class="modal-header">

	                    <h4 class="modal-title">Voulez-vous vraiment Archiver ce Groupe ?</h4>
	              	</div>

	              	<div class="modal-body">

	                    <a class="col-md-5 col-sm-12 btn btn-danger" onclick="supprimergroupe(event,this)" data-dismiss="modal" style="color: #ffffff;" id="mod{{$groupe->id}}">OUI,Archiver</a>

	                    <a data-dismiss="modal" class="col-md-6 col-sm-12 btn btn-primary" style="color: #ffffff;" >NON,je ne veux pas archiver</a>

	              	</div>

	              	<div class="modal-footer">

	                    <a class="btn btn-warning" data-dismiss="modal" style="color: #ffffff;">Fermer</a>
	              	</div>
	            </div>

	      	</div>
	    </div>                    




		<script src="{{ asset('js/gerer_groupe.js') }}"></script>
	</div>
	<!-- ROW-1 CLOSED -->


	<script type="text/javascript">
		
		/*var numero_de_la_seance_dans_le_mois = {{ $numero_de_la_seance_dans_le_mois }};

		quel_mois = parseInt({{ $le_mois }});
		
		console.log(quel_mois);
		
		var nb_eleves = {{ count($eleves_groupe) }};

		for (var i = 0; i <nb_eleves; i++) 
		{
			
			for (var j = quel_mois-1; j <= quel_mois+1; j++) 
			{
				
				var le_mois = "etudiant"+i+"-le_mois"+(j+1);
				
				//document.getElementById(le_mois).style.display = "none";

				//
			}

			//
		}

		if (quel_mois >= 3) 
		{

			for (var i = 0; i <nb_eleves; i++) 
			{
				
				for (var j = quel_mois-1; j <= quel_mois; j++) 
				{
					
					var le_mois = "etudiant"+i+"-le_mois"+(j+1);

					//document.getElementById(le_mois).style.display = "inline-block";

					//
				}

				//
			}

			//
		}
		else
		{

			for (var i = 0; i <nb_eleves; i++) 
			{
				
				for (var j = 1; j <= 2; j++) 
				{
					
					var le_mois = "etudiant"+i+"-le_mois"+(j+1);

					//document.getElementById(le_mois).style.display = "inline-block";

					//
				}

				//
			}

			//
		}*/

		//
	</script>

	
	{{--  --}}
@endsection

@section('scripts')
<script type="text/javascript">
	
	var nb_eleves = {{ count($eleves_groupe) }};

	$(document).ready(function(){
	    
	    $("#btnPrint").on('click',function(){
		// 		var divContents = $("#datable-1").html();
	            $('#table-1').printThis();
	    })

	    if (nb_eleves>25) 
	    {

			$("#myInput1").on("change", function() 
			{	
				var value = $(this).val().toLowerCase();
				$("#all_the_eleves tr").filter(function() 
				{
			  		$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
				});
			});
	    	
	    	//
	    }
	    else
	    {

			$("#myInput1").on("keyup", function() 
			{	
				var value = $(this).val().toLowerCase();
				$("#all_the_eleves tr").filter(function() 
				{
			  		$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
				});
			});
	    	
	    	//
	    }

	
	});

	/**/
</script>

<script>
	
	function manage_add()
	{
	    
	    $('#ajout').submit();
		
	    setTimeout(location.reload(),5000);

		// body...	    
	}
	
	/**/
</script>

@endsection