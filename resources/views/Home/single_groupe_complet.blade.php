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
						<div class="float-right">
							<h3 class="card-title">Date Création: {!! $groupe->created_at !!}</h3>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-lg-6 ">
							<p class="h3">Informations du Groupe : </p>
							<address>
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
								Pourcentage prof : {!! $groupe->pourcentage_prof !!} %<br>
							</address>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<button type="button" style="color: #ffffff; margin: 1% 0%;" class="btn btn-primary"  id="btnPrint"> Imprimer </button>
					</div>


					<div class="col-md-3">
						<input id="myInput1" placeholder="Recherche ..." type="text" class="form-control">
					</div>
				</div>
			

























			<div class="card-body">
				
				<div class="table-responsive">
					
					<table id="table-1" class="table table-striped table-bordered text-nowrap">
						<thead>
							<tr>
								<th style="cursor: pointer; font-size: 10px;" >N°</th>
								<th style="cursor: pointer; font-size: 10px;" >Nom</th>
								<th style="cursor: pointer; font-size: 10px;" >Prénom</th>
								<th style="cursor: pointer; font-size: 10px;" >Séances</th>
							</tr>
						</thead>
                        
                        <tbody id="all_the_eleves">

                            @for($i=0 ; $i < count($eleves_groupe) ; $i++)

                                <tr>

                                    <form>

                                        {{ csrf_field() }}  

                                        <td style="width:5%;">

                                            {!! $i+1 !!}                                                
                                        </td>

                                        <td style="width:5%;" >

                                            {!! $eleves_groupe[$i]->nom  !!}
                                        </td>

                                        <td style="width:5%;" > 
                                        	
											{!! $eleves_groupe[$i]->prenom !!}
                                        </td>


                                        <td style="/*font-size:13px;*/ width:85%;">
                                        		
                                        	@include('includes.seances_tous',['eleves_groupe'=>$eleves_groupe,
                                        		'numero_de_la_seance_dans_le_mois'=>$numero_de_la_seance_dans_le_mois,'seances_eleves'=>$seances_eleves])

                                        	{{--  --}}																						
                                        </td>

		                            	{{--  --}}
                                    </form>
                                    {{--  --}}
                                </tr>
                                {{-- expr --}}
                            @endfor
                            {{--  --}}
                        </tbody>
 					</table>
				</div>
				</div>


				<div class="card-footer text-left row" style="color:blue;">

					@foreach ($nb_presences as $nb_presence)
						
						<label class="col-md-3" for="payement_prof_mois{{$nb_presence->num_mois}}">Payement Du prof mois {!! $nb_presence->num_mois !!} :  

							{!! ($nb_presence->nb_presence)*($groupe->tarif/4)*(($groupe->pourcentage_prof)/100) !!} DA

						</label>
						{{-- expr --}}
					@endforeach

				</div>
			</div>
		</div><!-- COL-END -->

		<a class="btn btn-outline-info text-center col-md-6" style="color: blue;" href="/home/groupes/{{$groupe->id}}">Retour au Groupe</a>

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
	
	{{--  --}}
@endsection

@section('scripts')

<script type="text/javascript">
	
	$(document).ready(function(){

	    console.log($("#btnPrint").html());
	    $("#btnPrint").on('click',function(){
		// 		var divContents = $("#datable-1").html();
	            $('#table-1').printThis();
	    })

		$("#myInput1").on("keyup", function() 
		{
			var value = $(this).val().toLowerCase();
			$("#all_the_eleves tr").filter(function() 
			{
		  		$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});

	});

	
	



	//
</script>
@endsection