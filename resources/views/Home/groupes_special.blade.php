@extends('layouts.app')
@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
	<h4 class="page-title">Groupes Spéciaux de l'année scolaire {!! $annee_scolaire !!}</h4>
</div>
<!-- PAGE-HEADER END -->

<div id="modif_effectue" class="alert alert-icon alert-success" role="alert">
	<i class="fa fa-check-circle-o mr-2" aria-hidden="true"></i> 
	Groupe Spécial Modifiée avec succée
</div>

<div id="suppression_effectue" class="alert alert-icon alert-warning" role="alert">
	<i class="fa fa-exclamation mr-2" aria-hidden="true"></i> 
	Vous venez de supprimer un groupe spécial
</div>




<a type="button" style="color: #ffffff; margin-top: 5%; margin-bottom:1%;" class="btn btn-primary" data-toggle="modal" data-target="#myModal"> <i class="mdi mdi-plus"></i> Ajouter un groupe spécial </a>
<button type="button" style="color: #ffffff; margin-top: 5%; margin-bottom:1%;" class="btn btn-primary"  id="btnPrint"> Imprimer </button>

<div id="myModal" class="modal fade" role="dialog">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

           	<div class="modal-header">

                <a type="button" class="close" data-dismiss="modal">&times;</a>

                <h4 class="modal-title">Nouveau Groupe Spécial</h4>
          	</div>

            <div class="modal-body">

                <form class="form-inline" method="POST" action="/home/groupes_special/ajouter/ajax">

                    {{ csrf_field() }}  

                    <div class="form-group col-md-4 col-sm-12">

                        <label for="jourdugroupe">jour </label>

                        <select id="jourdugroupe" onchange="fit_salles();" required="true" name="jour" class="form-control col-md-12">
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

                        <input type="time" min="08:00" onchange="fit_salles();" id="heure_debutdugroupe" required name="heure_debut" class="form-control col-md-12">

                        {{--  --}}
                    </div>


                    <div class="form-group col-md-4 col-sm-12">

                        <label for="heure_findugroupe">Heure Fin</label>

                        <input type="time" min="08:00" onchange="fit_salles();" id="heure_findugroupe" required name="heure_fin" class="form-control col-md-12">

                        {{--  --}}
                    </div>


                    <div class="form-group col-md-4 col-sm-12">

                        <label for="salledugroupe">salle </label>

                        <select id="salledugroupe" onchange="fit_salles();" required="true" name="salle" class="form-control col-md-12">

                            @foreach ($salles as $salle)
                                
                                <option value="{{ $salle->num }}"> {!! $salle->num !!} </option>

                                {{-- expr --}}
                            @endforeach

                        </select>

                        {{--  --}}
                    </div>
                    
                    <div class="form-group col-md-4 col-sm-12">

                        <label for="niveaudugroupe">Niveau </label>

                        <select name="niveau" id="niveaudugroupe" class="form-control select2-show-search col-md-12">
                            
                            @foreach ($niveaux as $niveau)
                            
                                <option value="{{ $niveau->niveau }}-{{ $niveau->cycle}}-{{$niveau->filiere }}">{!! $niveau->niveau !!}-{!! $niveau->cycle !!}-{!! $niveau->filiere !!}</option>
                            
                            @endforeach                            
                            
                            
                            {{--  --}}
                        </select>

                        {{--  --}}
                    </div>

                    <div class="form-group col-md-4 col-sm-12">

                        <label for="pourcentage_profdugroupe"> % Prof </label>

                        <input type="number" onchange="fit_prctg(this);" value="50" min="30" max="100" id="pourcentage_profdugroupe" required name="pourcentage_prof" class="form-control col-md-12">

                        {{--  --}}
                    </div>


                    <div style="display:none;" class="form-group col-md-4 col-sm-12">

                        <label for="pourcentage_ecoledugroupe"> % Ecole </label>

                        <input type="number" disabled value="50" id="pourcentage_ecoledugroupe" required name="pourcentage_ecole" class="form-control col-md-12">

                        {{--  --}}
                    </div>

                    <div class="form-group col-md-4 col-sm-12">

                        <label for="tarif"> Tarif </label>

                        <input type="number" min="0" value="1800" id="tarif" required name="tarif" class="form-control col-md-12">

                        {{--  --}}
                    </div>



                    <input type="submit" style="color: #2070F5; margin-top: 5%;" class="btn btn-outline-primary col-md-12" value="Ajouter">

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
	<div class="col-md-12 col-lg-12 ">
		<div class="card">
			
			<div class="card-header text-center">
				
				<div class="card-title alert alert-info">Groupes Spéciaux
					
					<span id="alert" class="alert alert-sccess"> </span> 

					{{--  --}}
				</div>
			</div>
			
			<div class="card-body">
				
				<div class="table-responsive">
					
					<table data-page-length='50' id="datable-1" class="table table-striped table-bordered text-nowrap w-100">
						<thead>
							<tr>
								<th style="cursor: pointer;" class="wd-15p text-center alert alert-info">N°</th>
								<th style="cursor: pointer;" class="wd-15p text-center alert alert-info">Jour</th>
								<th style="cursor: pointer;" class="wd-20p text-center alert alert-info">Début</th>
								<th style="cursor: pointer;" class="wd-15p text-center alert alert-info">Fin</th>
                                <th style="cursor: pointer;" class="wd-15p text-center alert alert-info">Salle</th>
                                <th style="cursor: pointer;" class="wd-15p text-center alert alert-info">Niveau</th>
                                <th style="cursor: pointer;" class="wd-15p text-center alert alert-info">%_Prof</th>
                                <th style="cursor: pointer;" class="wd-15p text-center alert alert-info">%_école</th>
                                <th style="cursor: pointer;" class="wd-15p text-center alert alert-info">NB</th>
								<th style="cursor: pointer;" class="wd-15p text-center alert alert-info">Création</th>
                                {{-- <th style="cursor: pointer;" class="wd-15p">Actions</th> --}}
							</tr>
						</thead>
                        
                        <tbody id="all_the_groupes">

                            @for($i=0 ; $i < count($groupes) ; $i++)

                                <tr onclick="goto_the_link(this);" style="cursor:pointer;" id="groupe{{$groupes[$i]->id}}">

                                    <form>

                                        {{ csrf_field() }}  

                                        <td class="text-center">

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
                                            <span>{!! $groupes[$i]->salle  !!}</span>                              
                                        </td>

                                        <td class="text-center"> 
                                            <span>{!! $groupes[$i]->niveau  !!}</span>                              
                                        </td>

                                        <td> 
                                            <span>{!! $groupes[$i]->pourcentage_prof  !!}%</span>                              
                                        </td>

                                        <td> 
                                            <span>{!! $groupes[$i]->pourcentage_ecole  !!}%</span>                              
                                        </td>

                                        <td> 

                                            @foreach ($eleves_groupe as $groupee)
                                                
                                                @if($groupee->id_groupe_special==$groupes[$i]->id)
                                                   
                                                    <span>{!! $groupee->nb_eleves !!}</span>                              

                                                    {{-- expr --}}
                                                @endif

                                                {{-- expr --}}
                                            @endforeach

                                        </td>

                                        <td class="text-center"> 
                                            
                                            <span>{!! substr(date('d/m/Y H:i:s',strtotime($groupes[$i]->created_at)),0,10) !!}</span>
                                        </td>

                                    </form>
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
		<script src="{{ asset('js/modifierlesgroupes_special.js') }}"></script>
		<!-- SECTION WRAPPER -->
	</div>
</div>

@endsection


@section('scripts')
<script type="text/javascript">

$(document).ready(function()
{

    
    $('.select2-show-search').select2({
        'width': '100%'
    });
    


    console.log($("#btnPrint").html());
    $("#btnPrint").on('click',function(){
        var divContents = $("#datable-1").html();
            $('#datable-1').printThis();
    })
});



</script>
@endsection