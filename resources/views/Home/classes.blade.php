@extends('layouts.app')
@section('content')


<!-- PAGE-HEADER -->
<div class="page-header">
	<h4 class="page-title">Salles</h4>
</div>
<!-- PAGE-HEADER END -->

<div id="modif_effectue" class="alert alert-icon alert-success" role="alert">
	<i class="fa fa-check-circle-o mr-2" aria-hidden="true"></i> 
	Salle Modifiée avec succée
</div>

<div id="suppression_effectue" class="alert alert-icon alert-warning" role="alert">
	<i class="fa fa-exclamation mr-2" aria-hidden="true"></i> 
	Vous venez de supprimer une salle
</div>




<a type="button" style="color: #ffffff; margin-top: 5%; margin-bottom:1%;" class="btn btn-primary" data-toggle="modal" data-target="#myModal"> <i class="mdi mdi-plus"></i> Ajouter une Salle </a>

<div id="myModal" class="modal fade" role="dialog">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

           	<div class="modal-header">

                <a type="button" class="close" data-dismiss="modal">&times;</a>

                <h4 class="modal-title">Nouvelle Salle</h4>
          	</div>

            <div class="modal-body">

                <form class="form-inline">

                    {{ csrf_field() }}  

                    <div class="form-group col-md-4 col-sm-12">

                        <label for="nomduclasse">Nom </label>

                        <input type="text" id="nomduclasse" required="true" name="nom" class="form-control">

                        {{--  --}}
                    </div>


                    <div class="form-group col-md-4 col-sm-12">

                        <label for="minduclasse">Nb Places Min</label>

                        <input type="number" min="1" value="25" id="minduclasse" required name="min" class="form-control">

                        {{--  --}}
                    </div>

                    <br><br>

                    <div class="form-group col-md-4 col-sm-12">

                        <label for="maxduclasse">Nb Places max</label>

                        <input type="number" min="1" value="35" id="maxduclasse" required name="max" class="form-control">

                        {{--  --}}
                    </div>

                  	<a style="color: #2070F5; margin-top: 5%;" id="ajout{{ $last_id }}" data-dismiss="modal" onclick="ajouterclasse(event,this)" class="btn btn-outline-primary col-md-12">Ajouter</a>
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
				
				<div class="card-title">Salles 
					
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
								<th style="cursor: pointer;" class="wd-20p">Nombre de places Min</th>
								<th style="cursor: pointer;" class="wd-15p">Nombre de places Max</th>
								<th style="cursor: pointer;" class="wd-15p">Actions</th>
							</tr>
						</thead>
                        
                        <tbody id="all_the_classes">

                            @for($i=0 ; $i < count($classes) ; $i++)

                                <tr id="classe{{$classes[$i]->id}}">

                                    <form>

                                        {{ csrf_field() }}  

                                        <td>

                                            {!! $i+1 !!}                                                
                                        </td>

                                        <td>

                                            <input type="text" id="nomclasse{{$classes[$i]->id}}" class="form-control" value="{!! $classes[$i]->num !!}">  
                                            <span style="display: none;">{!! $classes[$i]->num  !!}</span>

                                        </td>

                                        <td> 

											<input type="number" id="nb_min{{$classes[$i]->id}}" class="form-control" value="{!! $classes[$i]->nb_places_min !!}"> 	
											<span style="display: none;">{!! $classes[$i]->nb_places_min !!}</span>                                                    
                                        </td>

                                        <td> 
                                        	
											<input type="number" id="nb_max{{$classes[$i]->id}}" class="form-control" value="{!! $classes[$i]->nb_places_max !!}"> 	
											<span style="display: none;">{!! $classes[$i]->nb_places_max !!}</span>
                                        </td>

                                        <td> 

                                            <button class="btn btn-primary btn-sm eng" id="{{$classes[$i]->id}}" onclick="modifierclasse(event,this)">Enregistrer
                                            </button>                                             

                                            <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModalsup-{{$classes[$i]->id}}" style="color: #fff;"> supprimer</a>

                                            <div id="myModalsup-{{$classes[$i]->id}}" class="modal fade" role="dialog">

                                              <div class="modal-dialog modal-lg">

                                                    <!-- Modal content-->

                                                    <div class="modal-content">

                                                       <div class="modal-header">

                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>

                                                            <h4 class="modal-title">Voulez-vous vraiment supprimer cette Salle</h4>
                                                      </div>

                                                      <div class="modal-body">

                                                            <a class="col-md-5 btn btn-danger" onclick="supprimerclasse(event,this)" data-dismiss="modal" style="color: #ffffff;" id="mod{{$classes[$i]->id}}">OUI,je supprime</a>

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
		<script src="{{ asset('js/modifierlesclasses.js') }}"></script>
		<!-- SECTION WRAPPER -->
	</div>
</div>

	
@endsection