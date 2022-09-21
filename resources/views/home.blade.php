@extends('layouts.app')

@section('content')

    <div class="page-header">
        <h4 class="page-title">Profile</h4>
    </div>

    <!-- PAGE-HEADER END -->

    <!-- ROW-1 OPEN -->
    <div class="row" id="user-profile">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="wideget-user">
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="wideget-user-desc d-flex">
                                    <div class="wideget-user-img">
                                        <img class="" src="../../assets/images/users/male/32.ico" alt="img">
                                    </div>
                                    <div class="user-wrap">
                                        <h4>The English Gate</h4>
                                        <h6 class="text-muted mb-3">Opérationel dés Aout 2021 </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="border-0">
                        <div class="tab-content">
                            <div class="tab-pane active show" id="tab-51">
                                <div id="profile-log-switch col-md-12">
                                    <hr class="row col-md-12">
                                    <div class="table-responsive col-md-6">

                                        <form method="POST" action="/home/saisir_frais">

                                            <strong>
                                            
                                                <label for="frais"> 
                                                    
                                                    Frais 

                                                    <input type="number" name="frais" class="form-control" value="{{$ecole[0]->frais}}"> 
                                                </label>
                                            </strong>
                                            <button class="btn btn-outline-primary">Valider</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>    
                    </div>    



                    <div class="border-0">
                        <div class="tab-content">
                            <div class="tab-pane active show" id="tab-51">
                                <div id="profile-log-switch col-md-12">
                                    <hr class="row col-md-12">
                                    <div class="table-responsive col-md-12">

                                        <table data-page-length='50' id="datable-1" class="table table-striped table-bordered text-nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th style="cursor: pointer;" class="wd-15p">N°</th>
                                                    <th style="cursor: pointer;" class="wd-15p">Nom</th>
                                                    <th style="cursor: pointer;" class="wd-20p">Prénom</th>
                                                    <th style="cursor: pointer;" class="wd-15p">Num Tél</th>
                                                    <th style="cursor: pointer;" class="wd-15p">Frais</th>
                                                    <th style="cursor: pointer;" class="wd-15p">Date Ajout</th>
                                                </tr>
                                            </thead>
                                            
                                            <tbody id="all_the_profs">

                                                @foreach ($eleves as $eleve)

                                                    <tr id="eleve_{{$eleve->id}}" style="cursor:pointer;" onclick="edit_eleve(this);" class="text-center">

                                                        <td id="id_eleve{{$eleve->id}}">{!! $eleve->id !!}</td>
                                                        <td id="nom_eleve_{{ $eleve->id }}">{!! $eleve->nom !!}</td>
                                                        <td id="prenom_eleve_{{ $eleve->id }}">{!! $eleve->prenom !!}</td>
                                                        <td id="numtel_eleve_{{ $eleve->id }}">{!! $eleve->num_tel !!}</td>
                                                        
                                                        @if ($eleve->frais == $ecole[0]->frais)
                                                            <td id="frais_eleve{{ $eleve->id }}" class="alert alert-success">{!! $eleve->frais !!}</td>
                                                         @else

                                                            <td id="frais_eleve{{ $eleve->id }}" class="alert alert-warning">{!! $eleve->frais !!}</td>
                                                            {{-- expr --}}
                                                        @endif

                                                        
                                                        <td>{!! $eleve->created_at !!}</td>

                                                    </tr>

                                                    {{-- expr --}}
                                                @endforeach

                                            </tbody>    
                                        </table>

                                        {{--  --}}
                                    </div>
                                </div>
                            </div>
                        </div>    
                    </div>    


                    {{--  --}}
                </div>    
            </div>
        </div>
    </div>            



































<a id="btn_modal" type="button" style="display: none; color: #ffffff; margin-top: 5%; margin-bottom:1%;" class="btn btn-primary" data-toggle="modal" data-target="#myModal"> <i class="mdi mdi-plus"></i> Détails sur l'élève </a>

<div id="myModal" class="modal fade" role="dialog">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <a type="button" class="close" data-dismiss="modal">&times;</a>

                <h4 class="modal-title">Détails sur l'élève</h4>
            </div>

            <div class="modal-body">

                <form class="form-inline" method="POST" action="/home/edit_eleve">

                    {{ csrf_field() }}  

                    <div style="display: none;" class="form-group col-md-3 col-sm-12">

                        <label for="id">id</label>

                        <input type="text" id="id" name="id" class="id form-control col-md-12">

                        {{--  --}}
                    </div>


                    <div class="form-group col-md-3 col-sm-12">

                        <label for="nom">Nom</label>

                        <input type="text" id="nom" required="true" name="nom" class="form-control col-md-12">

                        {{--  --}}
                    </div>

                    <div class="form-group col-md-3 col-sm-12">

                        <label for="prenom">Prénom</label>

                        <input type="text" id="prenom" required="true" name="prenom" class="form-control col-md-12">

                        {{--  --}}
                    </div>

                    <div class="form-group col-md-3 col-sm-12">

                        <label for="num_tel">num_tel</label>

                        <input type="text" id="num_tel" required="true" name="num_tel" class="form-control col-md-12">

                        {{--  --}}
                    </div>


                    <div class="form-group col-md-3 col-sm-12">

                        <label for="frais">Frais D'inscription </label>

                        <input type="number" id="frais" required="true" name="frais" class="form-control col-md-12" value="0">

                        {{--  --}}
                    </div>


                    <button type="submit" style="color: #2070F5; margin-top: 5%;" class="btn btn-outline-primary col-md-12 btn_ajouter">Valider</button>
                </form>


                <form style="margin-top:2%;" target="_blank" class="col-md-12 row" method="post" action="/home/imprimer_bon/eleve/all">

                    {{ csrf_field() }}

                    <div style="display: none;" class="form-group col-md-3 col-sm-12">

                        <label for="id">id</label>

                        <input type="text" name="id_eleve" class="id id form-control col-md-12">

                        {{--  --}}
                    </div>


                    <label for="date_debut" class="form-control col-md-6">Date_début
                            
                        <input type="date" onchange="show_payement();" id="date_debut" name="date_debut" class="form-control" value="{{Date('Y-m-d')}}">
                    </label> 

                    <label for="date_fin" class="form-control col-md-6">Date_fin
                            
                        <input type="date" onchange="show_payement();" id="date_fin" name="date_fin" class="form-control" value="{{Date('Y-m-d')}}">
                    </label>

                    <table style="margin-top:2%;" class="text-center table table-striped table-bordered text-nowrap w-100">
                        
                        <thead id="thead">
                            <tr>
                                
                                <th>Le</th>
                                <th>élève</th>
                                <th>Montant</th>
                                <th>Type</th>

                            </tr>

                        </thead>

                        
                            

                        </tbody>

                    </table>

                    <input type="submit" class="btn btn-primary col-md-12" value="Imprimer Bon" name="imprimer_bon"> 
                    
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













    <button id="payements_all" style="display:none;" onclick="show_payement();">appler show</button>





    <script>
        
        function edit_eleve(objet) 
        {


            $("#payements_eleve").remove();

            $("#thead").after("<tbody id='payements_eleve'>  </tbody>");
                
            var id_eleve = (objet.id.substr(6));

            var frais = $("#frais_eleve"+id_eleve).text();
            var nom = $("#nom_eleve_"+id_eleve).text();
            var prenom = $("#prenom_eleve_"+id_eleve).text();
            var num_tel = $("#numtel_eleve_"+id_eleve).text();

            frais = parseInt(frais);

            $("#frais").val(frais);
            $("#nom").val(nom);
            $("#prenom").val(prenom);
            $("#num_tel").val(num_tel);
            $(".id").val(id_eleve);

            $("#btn_modal").click();

            //
        }


        function show_payement()
        {
            
            var id_eleve = $("#id").val();
            var date_debut = $("#date_debut").val();
            var date_fin = $("#date_fin").val();

            $.ajax({
                headers: 
                {
                   'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },                    
                type:"POST",
                url:"/home/get_payment/ajax",
                data:{id_eleve:id_eleve,date_debut:date_debut,date_fin:date_fin},

                success:function(data) 
                {
                    var tr="";
                        
                    // Groupes

                    for (var i = 0; i < data.payements_groupes.length; i++) 
                    {

                        var td1 = "<td>"+ data.payements_groupes[i].created_at +"</td>"

                        var td2 = "<td>"+ data.payements_groupes[i].nom +" | "+ data.payements_groupes[i].prenom +"</td>"

                        var td3 = "<td>"+ data.payements_groupes[i].payement +" DA</td>"

                        var td4 = "<td>"+ data.payements_groupes[i].matiere+" Groupe #"+data.payements_groupes[i].id_groupe+"</td>"

                        tr+= "<tr>"+td1+""+td2+""+td3+""+td4+"</tr>"
                    }

                    // Dawarat 

                    for (var i = 0; i < data.payements_dawarat.length; i++) 
                    {

                        var td1 = "<td>"+ data.payements_dawarat[i].created_at +"</td>"

                        var td2 = "<td>"+ data.payements_dawarat[i].nom +" | "+ data.payements_dawarat[i].prenom +"</td>"

                        var td3 = "<td>"+ data.payements_dawarat[i].montant +" DA</td>"

                        var td4 = "<td>"+ data.payements_dawarat[i].matiere+" Dawra #"+data.payements_dawarat[i].id_dawra+"</td>"

                        tr+= "<tr>"+td1+""+td2+""+td3+""+td4+"</tr>"
                    }

                    // Frais

                    for (var i = 0; i < data.frais.length; i++) 
                    {

                        var td1 = "<td>"+ data.frais[i].updated_at +"</td>"

                        var td2 = "<td>"+ data.frais[i].nom +" | "+ data.frais[i].prenom +"</td>"

                        var td3 = "<td>"+ data.frais[i].frais +" DA</td>"

                        var td4 = "<td>Frais D'inscriptions</td>"

                        tr+= "<tr>"+td1+""+td2+""+td3+""+td4+"</tr>"
                    }


                    $("#payements_eleve").html(tr);


                    //
                }
            }); 


            //
        }

        //
    </script>



    {{--  --}}
@endsection
