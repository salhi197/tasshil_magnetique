@extends('layouts.app')
@section('content')


<!-- PAGE-HEADER -->
<div class="page-header">
	<h4 class="page-title">Enseignants</h4>
</div>
<!-- PAGE-HEADER END -->

<div id="modif_effectue" class="alert alert-icon alert-success" role="alert">
	<i class="fa fa-check-circle-o mr-2" aria-hidden="true"></i> 
	Enseignant Modifiée avec succée
</div>

<div id="suppression_effectue" class="alert alert-icon alert-warning" role="alert">
	<i class="fa fa-exclamation mr-2" aria-hidden="true"></i> 
	Vous venez de supprimer un Prof
</div>




<a type="button" style="color: #ffffff; margin-top: 5%; margin-bottom:1%;" class="btn btn-primary" data-toggle="modal" data-target="#myModal"> <i class="mdi mdi-plus"></i> Ajouter un Prof </a>

<div id="myModal" class="modal fade" role="dialog">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

           	<div class="modal-header">

                <a type="button" class="close" data-dismiss="modal">&times;</a>

                <h4 class="modal-title">Nouvel Enseignant</h4>
          	</div>

            <div class="modal-body">

                <form class="form-inline">

                    {{ csrf_field() }}  

                    <div class="form-group col-md-4 col-sm-12">

                        <label for="nomduprof">Nom </label>

                        <input type="text" onkeyup="verif_prof();" id="nomduprof" required="true" name="nom" class="form-control">

                        {{--  --}}
                    </div>


                    <div class="form-group col-md-4 col-sm-12">

                        <label for="prenomduprof">Prénom</label>

                        <input type="text" onkeyup="verif_prof();" id="prenomduprof" required name="prenom" class="form-control">

                        {{--  --}}
                    </div>


                    <div class="form-group col-md-4 col-sm-12">

                        <label for="telduprof">Num Tél</label>

                        <input type="tel" onkeyup="verif_tel(this);" id="telduprof" required name="tel" class="form-control">

                        {{--  --}}
                    </div>

                    
                    <div style="margin-top: 2%;" class="form-group col-md-6 col-sm-12">

                        <label for="cycleduprof">Cycle </label>

                        <select name="cycle" id="cycleduprof" class="form-control col-md-7">
                            
                            
                            <option value="Secondaire"> Secondaire </option>
                            <option value="Préscolaire"> Préscolaire </option>
                            <option value="Primaire"> Primaire </option>
                            <option value="Moyen"> Moyen </option>
                            <option value="Universitaire"> Universitaire </option>
                            
                            {{--  --}}                            
                        </select>                        

                    </div>

                    <div style="margin-top: 2%;" class="form-group col-md-6">

                        <label for="matiereduprof">Matière </label>

                        <select name="matiere" id="matiereduprof" class="form-control col-md-6 ">
                            
                            @foreach ($matieres as $matiere)
                                
                                <option value="{{ $matiere->nom }}">{!! $matiere->nom !!}</option>

                                {{-- expr --}}
                            @endforeach
                                                        
                            {{--  --}}
                        </select>

                        {{--  --}}
                    </div>


                  	<a style="color: #2070F5; margin-top: 5%;" id="ajout{{ $last_id }}" data-dismiss="modal" onclick="ajouterprof(event,this)" class="btn btn-outline-primary col-md-12 btn_ajouter">Ajouter</a>
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
				
				<div class="card-title">Enseignants 
					
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
								<th style="cursor: pointer;" class="wd-15p">Nom</th>
								<th style="cursor: pointer;" class="wd-20p">Prénom</th>
								<th style="cursor: pointer;" class="wd-15p">Num Tél</th>
                                <th style="cursor: pointer;" class="wd-15p">Cycle</th>
                                <th style="cursor: pointer;" class="wd-15p">Matière</th>
                                <th style="cursor: pointer;" class="wd-15p">Date Ajout</th>
								<th style="cursor: pointer;" class="wd-15p">Actions</th>
							</tr>
						</thead>
                        
                        <tbody id="all_the_profs">

                            @for($i=0 ; $i < count($profs) ; $i++)

                                <tr id="prof{{$profs[$i]->id}}">

                                    <form>

                                        {{ csrf_field() }}  

                                        <td>

                                            {!! $i+1 !!}                                                
                                        </td>

                                        <td>

                                            {{-- <input type="text" id="nomprof{{$profs[$i]->id}}" class="form-control" value="{!! $profs[$i]->nom !!}">   --}}
                                            <span>{!! $profs[$i]->nom  !!}</span>

                                        </td>

                                        <td> 

                                            {{-- <input type="text" id="nomprof{{$profs[$i]->id}}" class="form-control" value="{!! $profs[$i]->prenom !!}">  --}} 
                                            <span>{!! $profs[$i]->prenom  !!}</span>
                              
                                        </td>

                                        <td> 
                                        	
                                            <input type="text" id="telprof{{$profs[$i]->id}}" class="form-control" value="{!! $profs[$i]->tel !!}">  
                                            <span style="display: none;">{!! $profs[$i]->tel  !!}</span>
                                        </td>


                                        <td> 
                                            
                                            {{-- <input type="text" id="nomprof{{$profs[$i]->id}}" class="form-control" value="{!! $profs[$i]->cycle !!}">   --}}
                                            <span>{!! $profs[$i]->cycle  !!}</span>
                                        </td>


                                        <td> 
                                            
                                            {{-- <input type="text" id="nomprof{{$profs[$i]->id}}" class="form-control" value="{!! $profs[$i]->matiere !!}">   --}}
                                            <span>{!! $profs[$i]->matiere !!}</span>
                                        </td>


                                        <td> 
                                            
                                            <span>{!! date('d/m/Y H:i:s',strtotime($profs[$i]->created_at)) !!}</span>
                                        </td>

                                        <td> 

                                            <button class="btn btn-primary btn-sm eng" id="{{$profs[$i]->id}}" onclick="modifierprof(event,this)">Enregistrer
                                            </button>                                             

                                            <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModalsup-{{$profs[$i]->id}}" style="color: #fff;"> supprimer</a>

                                            <div id="myModalsup-{{$profs[$i]->id}}" class="modal fade" role="dialog">

                                              <div class="modal-dialog modal-lg">

                                                    <!-- Modal content-->

                                                    <div class="modal-content">

                                                       <div class="modal-header">

                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>

                                                            <h4 class="modal-title">Voulez-vous vraiment supprimer cet Enseignant</h4>
                                                      </div>

                                                      <div class="modal-body">

                                                            <a class="col-md-5 btn btn-danger" onclick="supprimerprof(event,this)" data-dismiss="modal" style="color: #ffffff;" id="mod{{$profs[$i]->id}}">OUI,je supprime</a>

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
		<script src="{{ asset('js/modifierlesprofs.js') }}"></script>
		<!-- SECTION WRAPPER -->
	</div>
</div>

	
@endsection