@extends('layouts.app')

@section('content')
	
	<div class="page-header">
		<h4 class="page-title">Caisse : Gain Net : {!! $sum - $depenses_payement_profs - $depense_autre !!} DA </h4>
	</div>


	<div class="row">

		<form class="col-md-12 row" method="post" action="/home/caisse/filter">

			{{ csrf_field() }}

			<label for="date_debut" class="form-control col-md-4">
					
				<input type="date" id="date_debut" name="date_debut" class="form-control" value="{{$date_debut}}">
			</label> 

			<label for="date_fin" class="form-control col-md-4">
					
				<input type="date" id="date_fin" name="date_fin" class="form-control" value="{{$date_fin}}">
			</label> 

			<input type="submit" value="filtrer" name="filtrer" class="btn btn-sm btn-info col-md-4">

		</form>

		<div class="col-lg-6 col-md-6 col-sm-12" style="cursor:pointer;" onclick="show_recette();">

			<div class="card">
				<div class="card-header">
					<h5 class="text-center card-title" style="color:#11F966;">Recette {!! $date_debut !!} | {!! $date_fin !!}</h5>
				</div>
				<div class="card-header">
					<h5 class="text-center card-title">Recette : {!! $sum !!} DA</h5>
				</div>

				<div class="card-body">
					<div id="echart2" class="chartsh ">
						
						<h5> Groupes : {!! $recettes_semaines_groupe[0]->montant ?? '0' !!} DA </h5>
						<h5> Dawarat : {!! $recettes_semaines_dawra[0]->montant ?? '0' !!} DA </h5>
						<h5> Frais d'inscriptions : {!! $recette_frais[0]->montant ?? '0' !!} DA </h5>
						<h5> Groupes speciaux :	 {!! $recettes_semaines_groupe_special[0]->montant ?? '0' !!} DA </h5>

					</div>
				</div>


			</div>
		</div>


		<div class="col-lg-6 col-md-6 col-sm-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title" style="color:#11F966; cursor:pointer;" onclick="show_depenses();">Les Dépenses {!! $date_debut !!} | {!! $date_fin !!} </h3>
				</div>
				<div class="card-header" style="cursor:pointer;" onclick="show_depenses();">
					<h5 class="text-center card-title">Dépences : {!! $depenses_payement_profs + $depense_autre !!} DA</h5>
				</div>

				<div class="card-body">
					<div id="echart2" class="chartsh ">
						
						<h5 style="cursor:pointer;" onclick="show_depenses();"> Payemnt des profs : {!! $depenses_payement_profs ?? '0' !!} DA </h5>

						<h5 style="cursor:pointer;" onclick="show_depenses();"> Autres dépenses : {!! $depense_autre !!}  DA </h5>


						<a type="button" style="color: #ffffff; margin-top: 5%; margin-bottom:1%;" class="btn btn-primary" data-toggle="modal" data-target="#myModal"> <i class="mdi mdi-plus"></i> Ajouter une Dépense </a>

						<div id="myModal" class="modal fade" role="dialog">

						    <div class="modal-dialog modal-lg">

						        <div class="modal-content">

						           	<div class="modal-header">

						                <a type="button" class="close" data-dismiss="modal">&times;</a>

						                <h4 class="modal-title">Nouvelle Dépense</h4>
						          	</div>

						            <div class="modal-body">

						                <form class="form-inline" method="POST" action="/home/caisse/filter/ajout_depense">

						                    {{ csrf_field() }}  

						                    <div class="form-group col-md-6 col-sm-12">

						                        <label for="montant">Montant</label>

						                        <input type="number" autofocus required id="montant" required="true" name="montant" class="form-control">

						                        {{--  --}}
						                    </div>


						                    <div class="form-group col-md-6 col-sm-12">

						                        <label for="commentaire">Commentaire</label>

						                        <input type="text" id="commentaire" required name="commentaire" class="form-control">

						                        {{--  --}}
						                    </div>

						                  	<button type="submit" style="color: #2070F5; margin-top: 5%;" class="btn btn-outline-primary col-md-12 btn_ajouter">Ajouter</button>
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

					</div>
				</div>
			</div>
		</div>


		{{--  --}}
	</div>


	<button style="display:none;" data-toggle="modal" data-target="#myModalsup" class="btn btn-outline-danger col-md-12 show_details" >Voir détails des recettes</button>

    <div id="myModalsup" class="modal fade" role="dialog">

      	<div class="modal-dialog modal-lg">

            <!-- Modal content-->

            <div class="modal-content">

               <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                    <h4 class="modal-title">Détails de la recette</h4>
              	</div>

              	<table class="table table-striped table-bordered text-nowrap w-100">
              		
              		<thead>
              			<tr>
	
	              			<th> date </th>
	              			<th> Type </th>
	              			<th> Eleve </th>
	              			<th> payement </th>
	              			<th> Impression </th>
    						
    						{{--  --}}          				
              			</tr>
              			
              			{{--  --}}
              		</thead>

              		<tbody id="recette_details">
	

              				
              			{{--  --}}
              		</tbody>

                    {{--  --}}
              	</table>

              	<div class="modal-footer">

                    <a class="btn btn-warning" data-dismiss="modal" style="color: #ffffff;">Fermer</a>
              	</div>
            </div>
            {{--  --}}
      	</div>

    </div>  



	<script>
		
		function show_recette()
		{

			var date_debut = $("#date_debut").val();
			var date_fin = $("#date_fin").val();

		    $.ajax({
		        headers: 
		        {
		           'X-CSRF-TOKEN': $('input[name="_token"]').val()
		        },                    
		        type:"POST",
		        url:"/home/caisse/depenses",
		        data:{date_debut:date_debut,date_fin:date_fin},

		        success:function(data) 
		        {

		        	console.log(data);

		        	paragraph = "";
		        	
		        	for (var i = 0; i < data.recettes_groupes.length; i++) 
		        	{

		        		var href = '/home/imprimer_bon/'+data.recettes_groupes[i].id+'/'+data.recettes_groupes[i].id_groupe+'/'+data.recettes_groupes[i].payement

		        		paragraph += "<tr style='font-size:1.5em;' ><td>"+data.recettes_groupes[i].created_at.substr(0,10)+"</td><td> Groupe : #"+ data.recettes_groupes[i].id_groupe +"</td> <td> "+data.recettes_groupes[i].nom+" "+data.recettes_groupes[i].prenom+"</td> <td>"+data.recettes_groupes[i].payement+" DA </td> <td> <a href="+href+" target='_blank' class='btn btn-sm btn-info'>Imprimer Bon</a></td> </tr>"
		        	}

		        	for (var i = 0; i < data.recettes_dawarat.length; i++) 
		        	{

		        		var href = '/home/imprimer_bon_dawra/'+data.recettes_dawarat[i].id+'/'+data.recettes_dawarat[i].id_dawra+'/'+data.recettes_dawarat[i].payement		        		

		        		paragraph += "<tr style='font-size:1.5em;' ><td>"+data.recettes_dawarat[i].created_at.substr(0,10)+"</td><td> Dawra : # "+data.recettes_dawarat[i].id_dawra+" </td><td>"+data.recettes_dawarat[i].nom+" "+data.recettes_dawarat[i].prenom+" </td> <td> "+data.recettes_dawarat[i].payement+" DA </td> <td> <a href="+href+" target='_blank' class='btn btn-sm btn-info'>Imprimer Bon</a></td></tr>"
		        	}

		        	for (var i = 0; i < data.recette_frais.length; i++) 
		        	{

		        		var href = '/home/imprimer_bon_frais/'+data.recette_frais[i].id+'/'+data.recette_frais[i].montant+'/'+data.recette_frais[i].updated_at

		        		paragraph +="<tr style='font-size:1.5em;' ><td>"+data.recette_frais[i].updated_at.substr(0,10)+"</td><td> Frais d'inscriptions  </td><td>" + data.recette_frais[i].nom+" "+data.recette_frais[i].prenom+"</td> <td>"+data.recette_frais[i].montant+" DA</td><td> <a href="+href+" target='_blank' class='btn btn-sm btn-info'>Imprimer Bon</a></td> </tr>"
		        	}

		        	$("#recette_details").html(paragraph);

		        	$(".show_details").click();

		        	//
				}
			})	


			//
		}

		function show_depenses()
		{

			var date_debut = $("#date_debut").val();
			var date_fin = $("#date_fin").val();

		    $.ajax({
		        headers: 
		        {
		           'X-CSRF-TOKEN': $('input[name="_token"]').val()
		        },                    
		        type:"POST",
		        url:"/home/caisse/depenses_2",
		        data:{date_debut:date_debut,date_fin:date_fin},

		        success:function(data) 
		        {


		        	paragraph = "";
		        	
		        	for (var i = 0; i < data.depenses_profs.length; i++) 
		        	{

		        		paragraph += "<li style='font-size:1.5em;' >"+data.depenses_profs[i].nom+" "+data.depenses_profs[i].prenom+" | payement Prof : "+data.depenses_profs[i].payement + "</li>"
		        	}

		        	for (var i = 0; i < data.depenses_autre.length; i++) 
		        	{
		        		paragraph += "<li style='font-size:1.5em;' >"+data.depenses_autre[i].commentaire+" | montant : "+ data.depenses_autre[i].montant +" </li>"
		        	}


		        	$("#recette_details").html(paragraph);

		        	$(".show_details").click();


		        	//
		        }
		    });    
			//
		}

		//
	</script>


	{{--  --}}
@endsection