@extends('layouts.app')
@section('content')


<!-- PAGE-HEADER -->
<div class="page-header">
    <h4 class="page-title">Matière</h4>
</div>
<!-- PAGE-HEADER END -->

<div id="modif_effectue" class="alert alert-icon alert-success" role="alert">
    <i class="fa fa-check-circle-o mr-2" aria-hidden="true"></i> 
    Enseignant Modifiée avec succée
</div>

<div id="suppression_effectue" class="alert alert-icon alert-warning" role="alert">
    <i class="fa fa-exclamation mr-2" aria-hidden="true"></i> 
    Vous venez de supprimer un matiere
</div>




<a type="button" style="color: #ffffff; margin-top: 5%; margin-bottom:1%;" class="btn btn-primary" data-toggle="modal" data-target="#myModal"> <i class="mdi mdi-plus"></i> Ajouter une Matière </a>

<div id="myModal" class="modal fade" role="dialog">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <a type="button" class="close" data-dismiss="modal">&times;</a>

                <h4 class="modal-title">Nouvelle Matière</h4>
            </div>

            <div class="modal-body">

                <form class="form-inline">

                    {{ csrf_field() }}  

                    <div class="form-group col-md-10 col-sm-12">

                        <label for="nomdumatiere">Nom </label>

                        <input autofocus style="margin:auto; width:50%;" type="text" id="nomdumatiere" required="true" name="nom" class="form-control col-md-10">

                        {{--  --}}
                    </div>
                    

                    <a style="color: #2070F5; margin-top: 5%;" id="ajout{{ $last_id }}" data-dismiss="modal" onclick="ajoutermatiere(event,this)" class="btn btn-outline-primary col-md-12">Ajouter</a>
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
                
                <div class="card-title">Matière 
                    
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
                                <th style="cursor: pointer;" class="wd-20p">Action</th>
                            </tr>
                        </thead>
                        
                        <tbody id="all_the_matieres">

                            @for($i=0 ; $i < count($matieres) ; $i++)

                                <tr id="matiere{{$matieres[$i]->id}}">

                                    <form>

                                        {{ csrf_field() }}  

                                        <td>

                                            {!! $i+1 !!}                                                
                                        </td>

                                        <td>

                                            <span>{!! $matieres[$i]->nom  !!}</span>

                                        </td>

                                        <td>                                              

                                            @if ($i<20)
                                                
                                                <li style="margin: auto; width: 50%; padding: 10px;" class="icons-list-item"><i class="ion-ios7-checkmark-empty" data-toggle="tooltip" title="ion-ios7-checkmark-empty"></i></li>

                                                {{-- expr --}}
                                             @else

                                                <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModalsup-{{$matieres[$i]->id}}" style="color: #fff;"> supprimer</a>

                                                <div id="myModalsup-{{$matieres[$i]->id}}" class="modal fade" role="dialog">

                                                  <div class="modal-dialog modal-lg">

                                                        <!-- Modal content-->

                                                        <div class="modal-content">

                                                           <div class="modal-header">

                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                                                                <h4 class="modal-title">Voulez-vous vraiment supprimer cet Enseignant</h4>
                                                          </div>

                                                          <div class="modal-body">

                                                                <a class="col-md-5 btn btn-danger" onclick="supprimermatiere(event,this)" data-dismiss="modal" style="color: #ffffff;" id="mod{{$matieres[$i]->id}}">OUI,je supprime</a>

                                                                <a data-dismiss="modal" class="col-md-6  btn btn-primary" style="color: #ffffff;" >NON,je ne veux pas supprimer</a>
                                                                {{--  --}}
                                                          </div>

                                                          <div class="modal-footer">

                                                                <a class="btn btn-warning" data-dismiss="modal" style="color: #ffffff;">Fermer</a>
                                                          </div>
                                                        </div>
                                                        {{--  --}}
                                                  </div>
                                                @endif  
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
        <script src="{{ asset('js/modifierlesmatieres.js') }}"></script>
        <!-- SECTION WRAPPER -->
    </div>
</div>

    
@endsection