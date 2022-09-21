@extends('layouts.app')
@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
	<h4 class="page-title">
        Liste des Inscriptions : 

    </h4>
</div>
<!-- PAGE-HEADER END -->

<!-- <div id="modif_effectue" class="alert alert-icon alert-success" role="alert">
	<i class="fa fa-check-circle-o mr-2" aria-hidden="true"></i> 
	Dawra Modifiée avec succée
</div>

<div id="suppression_effectue" class="alert alert-icon alert-warning" role="alert">
	<i class="fa fa-exclamation mr-2" aria-hidden="true"></i> 
	Vous venez de supprimer une Dawra
</div> -->

<a type="button" style="color: #ffffff; margin-top: 5%; margin-bottom:1%;" class="btn btn-primary" data-toggle="modal" data-target="#myModal"> <i class="mdi mdi-plus"></i> Ajouter </a>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
           	<div class="modal-header">
                <a type="button" class="close" data-dismiss="modal">&times;</a>
          	</div>
            <div class="modal-body">
                <form class="form-inline" method="POST" action="/home/inscriptions/ajouter">
                    {{ csrf_field() }}  
                    <div class="form-group col-md-4 col-sm-12">
                        <label for="salledugroupe">Photo :   </label>
                        <input type="file" min=""  name="photo" class="col-md-12">
                    </div>

                    <div class="form-group col-md-4 col-sm-12">
                        <label for="salledugroupe">Nom  </label>
                        <input type="text" min=""  name="nom" class="form-control col-md-12">
                    </div>

                    <div class="form-group col-md-4 col-sm-12">
                        <label for="salledugroupe">Prénom :   </label>
                        <input type="text" min=""  name="prenom" class="form-control col-md-12">
                    </div>
                    
                    <div class="form-group col-md-4 col-sm-12">
                        <label for="salledugroupe">Genre :   </label>
                        <select name="sexe" class="form-control">
                            <option value="femme">Fille</option>
                            <option value="homme">Garçon</option>
                        </select>
                    </div>
                    

                    <div class="form-group col-md-4 col-sm-12">
                        <label for="salledugroupe">Téléphone :   </label>
                        <input type="text" min="" required name="telephone" class="form-control col-md-12">
                    </div>


                    <div class="form-group col-md-4 col-sm-12">
                        <label for="niveaudugroupe">Niveau </label>
                        <select name="niveau" id="niveaudugroupe" class="form-control select2-show-search col-md-12">
                            @foreach ($niveaux as $niveau)
                                <option value="{{ $niveau->niveau }}-{{ $niveau->cycle}}-{{$niveau->filiere }}">{!! $niveau->niveau !!}-{!! $niveau->cycle !!}-{!! $niveau->filiere !!}</option>
                            @endforeach                                                        
                        </select>
                    </div>


                    <div class="form-group col-md-4 col-sm-12">
                        <label for="matieredugroupe">Matière </label>
                        <select name="matieres[]" id="matieredugroupe" class="form-control  select2-show-search  col-md-12 " multiple>
                            @foreach ($matieres as $matiere)
                                <option value="{{ $matiere->nom }}">{!! $matiere->nom !!}</option>
                            @endforeach                            
                        </select>
                    </div>
                    <input type="submit" style="color: #2070F5; margin-top: 5%;" class="btn text-white btn-primary col-md-12" value="Ajouter">

                </form>

          </div>

          <div class="modal-footer">

                <a type="button" style="color: #ffffff;" class="btn btn-warning" data-dismiss="modal">Fermer</a>

          </div>

        </div>

        
  </div>

</div>                    













































<!-- ROW-1 OPEN -->
<div class="row">
	<div class="col-md-12 col-lg-12">
		<div class="card">
			
			<div class="card-header">
				
				<div class="card-title " >Groupes 
					
					<span id="alert" class="alert alert-sccess"> </span> 

					
				</div>
			</div>
			
			<div class="card-body">
				
				<div class="table-responsive">
					
					<table data-page-length='50' id="datable-1" class="table table-striped table-bordered text-nowrap w-100">
						<thead>
							<tr>
								<th style="cursor: pointer;" class="wd-15p">N°</th>
                                <th style="cursor: pointer;" class="wd-15p">Nombre Séance</th>
                                <th style="cursor: pointer;" class="wd-15p">Matière</th>
                                <th style="cursor: pointer;" class="wd-15p">Niveau</th>
                                <th style="cursor: pointer;" class="wd-15p">Prof</th>
                                <th style="cursor: pointer;" class="wd-15p">%_Prof</th>
                                <th style="cursor: pointer;" class="wd-15p">%_école</th>
                                <th style="cursor: pointer;" class="wd-15p">NB</th>
								<th style="cursor: pointer;" class="wd-15p">Création</th>
                                {{-- <th style="cursor: pointer;" class="wd-15p">Actions</th> --}}
							</tr>
						</thead>
                        
                        <tbody id="all_the_groupes">

                            @foreach($inscriptions as $key=>$inscription)
                                
                            @endforeach
                            
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
<script type="text/javascript">

$(document).ready(function(){
    console.log($("#btnPrint").html());
    $("#btnPrint").on('click',function(){
//            var divContents = $("#datable-1").html();
            $('#datable-1').printThis();
    })
});



</script>
@endsection