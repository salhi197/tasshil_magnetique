@extends('layouts.app')
@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
	<h4 class="page-title">Niveaux</h4>
</div>
<!-- PAGE-HEADER END -->

<div id="modif_effectue" class="alert alert-icon alert-success" role="alert">
	<i class="fa fa-check-circle-o mr-2" aria-hidden="true"></i> 
	Niveau Modifié avec succée
</div>

<div id="suppression_effectue" class="alert alert-icon alert-warning" role="alert">
	<i class="fa fa-exclamation mr-2" aria-hidden="true"></i> 
	Vous venez de supprimer une Niveau
</div>




<a type="button" style="color: #ffffff; margin-top: 5%; margin-bottom:1%;" class="btn btn-primary" data-toggle="modal" data-target="#myModal"> <i class="mdi mdi-plus"></i> Ajouter un Niveau </a>

<div id="myModal" class="modal fade" role="dialog">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

           	<div class="modal-header">

                <a type="button" class="close" data-dismiss="modal">&times;</a>

                <h4 class="modal-title">Nouveau Niveau</h4>
          	</div>

            <div class="modal-body">

                <form class="form-inline row">

                    {{ csrf_field() }}  

                    <div id="in_niveau" class="form-group col-md-6 col-sm-12">

                        <label for="niveauduniveau">Niveau Scolaire</label>

                        <input type="number" onchange="afficher_filiere1(this);" value="1" min="1" max="6" id="niveauduniveau" required="true" name="niveau" class="form-control col-md-12">

                        {{--  --}}
                    </div>


                    <div id="in_cycle" class="form-group col-md-6 col-sm-12">

                        <label for="cycleduniveau">Cycle</label>

                        <select id="cycleduniveau" onchange="afficher_filiere(this);" required class="form-control col-md-12">

                            <option value="PS"> Préscolaire </option>
                            <option value="AP"> Primaire </option>
                            <option value="AM"> Moyen </option>
                            <option value="AS"> Secondaire </option>
                            <option value="Univ"> Universitaire </option>                            
                        </select>

                        {{--  --}}
                    </div>

                    <br><br>

                    <div id="in_filiere" class="form-group col-md-4 col-sm-12">

                        <label for="filiereduniveau">Filière</label>

                        <select id="filiereduniveau" required name="max" class="form-control col-md-12">

                            <option value="lettre"> lettre </option>
                            <option value="Scientifique"> Scientifique </option>
                            <option value="Mathelème"> Mathelème </option>
                            <option value="Math-technique"> Math-technique </option>
                            <option value="Gestion"> Gestion </option>
                            <option value="Langues"> Langues </option>                            

                        </select>

                        {{--  --}}
                    </div>

                  	<a style="color: #2070F5; margin-top: 5%;" id="ajout{{ $last_id }}" data-dismiss="modal" onclick="ajouterniveau(event,this)" class="btn btn-outline-primary col-md-12">Ajouter</a>
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
				
				<div class="card-title">Niveaux 
					
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
								<th style="cursor: pointer;" class="wd-15p">Niveau scolaire</th>
								<th style="cursor: pointer;" class="wd-15p">Cycle</th>
								<th style="cursor: pointer;" class="wd-20p">Filière</th>
								<th style="cursor: pointer;" class="wd-15p">Actions</th>
							</tr>
						</thead>
                        
                        <tbody id="all_the_niveaux">

                            @for($i=0 ; $i < count($niveaux) ; $i++)

                                <tr id="niveau{{$niveaux[$i]->id}}">

                                    <form>

                                        {{ csrf_field() }}  

                                        <td>

                                            {!! $i+1 !!}                                                
                                        </td>

                                        <td>

                                            @if($niveaux[$i]->niveau == 1)

                                                <span>{!! $niveaux[$i]->niveau  !!}ère Année</span>

                                             @else
                                                <span>{!! $niveaux[$i]->niveau  !!}ème Année</span>
                                            @endif

                                        </td>

                                        <td> 
                                        	
											<span>{!! $niveaux[$i]->cycle !!}</span>
                                        </td>

                                        <td> 

                                            @if($niveaux[$i]->cycle=="AS"||$niveaux[$i]->cycle=="Univ")

                                                <span>{!! $niveaux[$i]->filiere !!}</span> 

                                             @else                                               
                                                <span>------</span> 
                                            @endif

                                        </td>


                                        <td> 

                                            @if ($i>100)
                                                
                                                <a  style="margin: auto; width: 50%; padding: 10px; color: #fff;" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModalsup-{{$niveaux[$i]->id}}"> supprimer</a>

                                                <div id="myModalsup-{{$niveaux[$i]->id}}" class="modal fade" role="dialog">

                                                  <div class="modal-dialog modal-lg">

                                                        <!-- Modal content-->

                                                        <div class="modal-content">

                                                           <div class="modal-header">

                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                                                                <h4 class="modal-title">Voulez-vous vraiment supprimer cette Niveau</h4>
                                                          </div>

                                                          <div class="modal-body">

                                                                <a class="col-md-5 btn btn-danger" onclick="supprimerniveau(event,this)" data-dismiss="modal" style="color: #ffffff;" id="mod{{$niveaux[$i]->id}}">OUI,je supprime</a>

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

                                             @else
                                                
                                                <li style="margin: auto; width: 50%; padding: 10px;" class="icons-list-item"><i class="ion-ios7-checkmark-empty" data-toggle="tooltip" title="ion-ios7-checkmark-empty"></i></li>


                                             {{--  --}}
                                            @endif
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
		<script src="{{ asset('js/modifierlesniveaux.js') }}"></script>
		<!-- SECTION WRAPPER -->
	</div>
</div>

	
@endsection