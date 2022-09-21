@extends('layouts.app')
@section('content')

<!-- PAGE-HEADER -->
<div class="page-header" >
	<h4 class="page-title">Groupes de l'année scolaire {!! $annee_scolaire !!}</h4>
</div>
<!-- PAGE-HEADER END -->

<div id="modif_effectue" class="alert alert-icon alert-success" role="alert">
	<i class="fa fa-check-circle-o mr-2" aria-hidden="true"></i> 
	Groupe Modifiée avec succée
</div>

<div id="suppression_effectue" class="alert alert-icon alert-warning" role="alert">
	<i class="fa fa-exclamation mr-2" aria-hidden="true"></i> 
	Vous venez de supprimer un groupe
</div>




<a type="button" style="color: #ffffff; margin-top: 5%; margin-bottom:1%;" class="btn btn-primary" data-toggle="modal" data-target="#myModal"> <i class="mdi mdi-plus"></i> Ajouter un groupe </a>
<button type="button" style="color: #ffffff; margin-top: 5%; margin-bottom:1%;" class="btn btn-primary"  id="btnPrint"> Imprimer </button>

<div id="myModal" class="modal fade" role="dialog">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

           	<div class="modal-header">

                <a type="button" class="close" data-dismiss="modal">&times;</a>

                <h4 class="modal-title">Nouveau Groupe</h4>
          	</div>

            <div class="modal-body">

                <form class="form-inline" method="POST" action="/home/groupes/ajouter/ajax">

                    {{ csrf_field() }}  

                    <div class="form-group col-md-4 col-sm-12">

                        <label for="jourdugroupe">jour </label>

                        <select id="jourdugroupe" onchange="fit_salles();" required="true" name="jour" class="form-control col-md-12 select2-show-search">
                            <option value="Dimanche"> Dimanche </option>
                            <option value="Lundi"> Lundi </option>
                            <option value="Mardi"> Mardi </option>
                            <option value="Mercredi"> Mercredi </option>
                            <option value="Jeudi"> Jeudi </option>
                            <option value="Vendredi"> Vendredi </option>
                            <option value="Samedi"> Samedi </option>
                        </select>

                        {{--  --}}
                    </div>


                    <div class="form-group col-md-4 col-sm-12">

                        <label for="heure_debutdugroupe">Heure Début</label>

                        <input type="time" onchange="fit_salles();" id="heure_debutdugroupe" required name="heure_debut" class="form-control col-md-12">

                        {{--  --}}
                    </div>


                    <div class="form-group col-md-4 col-sm-12">

                        <label for="heure_findugroupe">Heure Fin</label>

                        <input type="time" onchange="fit_salles();" id="heure_findugroupe" required name="heure_fin" class="form-control col-md-12">

                        {{--  --}}
                    </div>


                    <div class="form-group col-md-4 col-sm-12">

                        <label for="salledugroupe">salle </label>

                        <select id="salledugroupe" onchange="fit_salles();" required="true" name="salle" class="form-control col-md-12 select2-show-search">

                            @foreach ($salles as $salle)
                                
                                <option value="{{ $salle->num }}"> {!! $salle->num !!} </option>

                                {{-- expr --}}
                            @endforeach

                        </select>

                        {{--  --}}
                    </div>
                    
                    <div class="form-group col-md-4 col-sm-12">

                        <label for="niveaudugroupe">Niveau </label>

                        <select name="niveau" onchange="fit_tarif(this)" id="niveaudugroupe" class="form-control col-md-12 select2-show-search">
                            
                            @foreach ($niveaux as $niveau)
                            
                                <option value="{{ $niveau->niveau }}-{{ $niveau->cycle}}-{{$niveau->filiere }}">{!! $niveau->niveau !!}-{!! $niveau->cycle !!}-{!! $niveau->filiere !!}</option>
                            
                            @endforeach                            
                            
                            
                            {{--  --}}
                        </select>

                        {{--  --}}
                    </div>


                    <div class="form-group col-md-4 col-sm-12">

                        <label for="matieredugroupe">Matière </label>

                        <select name="matiere" onchange="fit_prof(this)" id="matieredugroupe" class="form-control col-md-12 select2-show-search">
                            
                            @foreach ($matieres as $matiere)
                            
                                <option value="{{ $matiere->nom }}">{!! $matiere->nom !!}</option>
                            
                            @endforeach                            
                            
                            
                            {{--  --}}
                        </select>

                        {{--  --}}
                    </div>


                    <div class="form-group col-md-4 col-sm-12">

                        <label for="profdugroupe"> Prof </label>

                        <select name="prof" id="profdugroupe" class="form-control col-md-12 select2-show-search">
                            
                            @foreach ($profs as $prof)
                            
                                <option id="{{ $prof->nom }}-{{ $prof->prenom }}" value="{{ $prof->nom }}-{{ $prof->prenom }}">{!! $prof->nom !!}-{!! $prof->prenom !!} </option>
                            
                            @endforeach                            
                            
                            
                            {{--  --}}
                        </select>

                        {{--  --}}
                    </div>


                    <div class="form-group col-md-4 col-sm-12">

                        <div class="col-md-6 form-check">
                        
                            <input class="form-control" required type="radio" name="type_payement" value="pourcentage" id="pourcentage">
                            
                            <label class="form-check-label" for="pourcentage">
                                %Pourcentage
                            </label>
                        </div>


                        <div class="col-md-6 form-check">
                        
                            <input class="form-control" required type="radio" name="type_payement" value="salaire" id="salaire">
                            
                            <label class="form-check-label" for="salaire">
                                Salaire DA
                            </label>
                        </div>

                    </div> 


                    <div style="display:none;" class="form-group col-md-4 col-sm-12">

                        <label for="pourcentage_profdugroupe"> % Prof </label>

                        <input type="number" value="50" min="30" max="100" id="pourcentage_profdugroupe" name="pourcentage_prof" class="form-control col-md-12">

                        {{--  --}}
                    </div>


                    <div style="display:none;" class="form-group col-md-4 col-sm-12">

                        <label for="salaire_profdugroupe"> Salaire DA </label>

                        <input type="number" min="0" id="salaire_profdugroupe" name="salaire_prof" class="form-control col-md-12">

                        {{--  --}}
                    </div>


                    <div style="display:none;" class="form-group col-md-4 col-sm-12">

                        <label for="pourcentage_ecoledugroupe"> % Ecole </label>

                        <input type="number" disabled value="50" id="pourcentage_ecoledugroupe" required name="pourcentage_ecole" class="form-control col-md-12">

                        {{--  --}}
                    </div>

                    <div class="form-group col-md-4 col-sm-12">

                        <label for="tarif"> Tarif Mensuel DA</label>

                        <input type="number" min="0" value="1800" id="tarif" required name="tarif" class="form-control col-md-12">

                        {{--  --}}
                    </div>



                    <input type="submit" style="color: #2070F5; margin-top: 5%;" class="btn btn-outline-primary col-md-12" value="Ajouter">

                  	{{-- <a style="color: #2070F5; margin-top: 5%;" id="ajout{{ $last_id }}" data-dismiss="modal" onclick="ajoutergroupe(event,this)" class="btn btn-outline-primary col-md-12">Ajouter</a> --}}
                </form>

                {{--  --}}
          </div>

          <div class="modal-footer">

                <a type="button" style="color: #ffffff;" class="btn btn-warning" data-dismiss="modal">Fermer</a>

          </div>

        </div>

        {{--  --}}
  </div>

</div>                    













































<!-- ROW-1 OPEN -->
<div class="row">
	<div class="col-md-12 col-lg-12">
		<div class="card">
			
			<div class="card-header">
				
				<div class="card-title " >Groupes 
					
					<span id="alert" class="alert alert-sccess"> </span> 

					{{--  --}}
				</div>
			</div>
			
			<div class="card-body">
				
				<div class="table-responsive">
					
					<table data-page-length='50' id="datable-1" class="table table-striped table-bordered text-nowrap w-100">
						<thead>
							<tr>
								<th style="cursor: pointer;" class="wd-15p">N°</th>
								<th style="cursor: pointer;" class="wd-15p">Jour</th>
								<th style="cursor: pointer;" class="wd-20p">Début</th>
								<th style="cursor: pointer;" class="wd-15p">Fin</th>
                                <th style="cursor: pointer;" class="wd-15p">Salle</th>
                                <th style="cursor: pointer;" class="wd-15p">Matière</th>
                                <th style="cursor: pointer;" class="wd-15p">Niveau</th>
                                <th style="cursor: pointer;" class="wd-15p">Prof</th>
                                <th style="cursor: pointer;" class="wd-15p">%/salaire_Prof</th>
                                <th style="cursor: pointer;" class="wd-15p">Payement</th>
                                <th style="cursor: pointer;" class="wd-15p">NB</th>
								<th style="cursor: pointer;" class="wd-15p">Création</th>
                                {{-- <th style="cursor: pointer;" class="wd-15p">Actions</th> --}}
							</tr>
						</thead>
                        
                        <tbody id="all_the_groupes">

                            @for($i=0 ; $i < count($groupes) ; $i++)

                                <tr onclick="goto_the_link(this);" style="cursor:pointer;" id="groupe{{$groupes[$i]->id}}">

                                    <form>

                                        {{ csrf_field() }}  

                                        <td>

                                            {!! $i+1 !!}                                                
                                        </td>

                                        <td>
                                            <span>{!! $groupes[$i]->jour  !!}</span>

                                        </td>

                                        <td> 
                                            <span>{!! substr($groupes[$i]->heure_debut,0,5)  !!}</span>                              
                                        </td>


                                        <td> 
                                            <span>{!! substr($groupes[$i]->heure_fin,0,5) !!}</span>                              
                                        </td>

                                        <td> 
                                            <span>{!! $groupes[$i]->classe  !!}</span>                              
                                        </td>

                                        <td> 
                                            
                                            <span>{!! $groupes[$i]->matiere !!}</span>
                                        </td>

                                        <td> 
                                            <span>{!! $groupes[$i]->niveau  !!}</span>                              
                                        </td>

                                        <td> 
                                            <span>{!! $groupes[$i]->prof  !!}</span>                              
                                        </td>


                                        <td class="text-center"> 

                                            @if ($groupes[$i]->pourcentage_prof<100)
    
                                                <span>
                                                    {!! $groupes[$i]->pourcentage_prof  !!}%
                                                </span>                              
                                             
                                             @else   

                                                <span>
                                                    {!! $groupes[$i]->pourcentage_prof !!} DA
                                                </span>                              

                                             
                                                {{-- expr --}}
                                            @endif

                                        </td>

                                        <td class="text-center"> 
                                            @if ($groupes[$i]->pourcentage_prof<100)
    
                                                <span>
                                                    Pourcentage
                                                </span>                              
                                             
                                             @else   

                                                <span>
                                                    Salaire
                                                </span>                              

                                             
                                                {{-- expr --}}
                                            @endif
                                        </td>

                                        <td> 

                                            @foreach ($eleves_groupe as $groupee)
                                                
                                                @if($groupee->id_groupe==$groupes[$i]->id)
                                                   
                                                    <span>{!! $groupee->nb_eleves !!}</span>                              

                                                    {{-- expr --}}
                                                @endif

                                                {{-- expr --}}
                                            @endforeach

                                        </td>

                                        <td> 
                                            
                                            <span>{!! substr(date('d/m/Y H:i:s',strtotime($groupes[$i]->created_at)),0,10) !!}</span>
                                        </td>

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
			<!-- TABLE WRAPPER -->
		</div>
		
		<!-- SECTION WRAPPER -->
	</div>
</div>

@endsection


@section('scripts')
    
    <script src="{{ asset('js/modifierlesgroupes.js') }}"></script>

    <script type="text/javascript">

        $(document).ready(function()
        {

            $('.select2-show-search').select2({
                'width': '100%'
            });
            


            console.log($("#btnPrint").html());
            $("#btnPrint").on('click',function(){
        //            var divContents = $("#datable-1").html();
                    $('#datable-1').printThis();
            })
        });
    </script>
@endsection