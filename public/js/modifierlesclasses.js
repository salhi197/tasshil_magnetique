document.getElementById("modif_effectue").style.display = 'none';
document.getElementById("suppression_effectue").style.display = 'none';

function modifierclasse(event,objet) 
{	
		
	event.preventDefault();

	var $id=(($(objet)).attr('id'));

	var id_to_hide = "#classe"+$id;

	var id_nom="#nomclasse"+$id;

	var id_min="#nb_min"+$id;

	var id_max="#nb_max"+$id;
	//---------//---------//
	var $nom=$(id_nom).val();

	var $min=$(id_min).val();

	var $max=$(id_max).val();

    $.ajax({
        headers: 
        {
           'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },                    
        type:"POST",
        url:"/home/classes/modifier/ajax",
        data:{id:$id,nom:$nom,min:$min,max:$max},

        success:function(data) 
        {

        	$("#modif_effectue").show(1000,function()
        	{  

        		setTimeout(function() { $("#modif_effectue").hide(1000);}, 5000);
        		
        	});

        	//
		}
	})	
	// body... 
}

function supprimerclasse (event,objet) 
{

	event.preventDefault();

	$id=(objet.getAttribute('id'));

	$id=($id.substr(3));

	var id_hide="#classe"+$id;

	console.log(id_hide)

    $.ajax({
        headers: 
        {
           'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },                    
        type:"POST",
        url:"/home/classes/supprimer/ajax",
        data:{id:$id},

        success:function(data) 
        {

			$(id_hide).hide(1000);

        	$("#suppression_effectue").show(1000,function()
        	{  

        		setTimeout(function() { $("#suppression_effectue").hide(1000);}, 5000);
        		
        	});

        	//
		}
	});	

	// body... 
}

function ajouterclasse(event,ojbet) 
{

	event.preventDefault();

	var $nom = $("#nomduclasse").val();

	var $min = $("#minduclasse").val();

	var $max = $("#maxduclasse").val();

	var new_id = $(ojbet).attr('id');

	var xx=new_id;

	new_id=(new_id.substr(5));

	new_id = parseInt(new_id)+1;

	console.log(new_id);
	
	var to_append = '<tr class="alert alert-success" id="classe'+new_id+'"><form>{{ csrf_field() }} <td>'+new_id+'</td>'

	to_append+='<td> <input type="text" class="form-control" id="nomclasse'+new_id+'" value="'+$nom+'"> <span style="display: none;"> '+$nom+' </span></td>'

	to_append+='<td> <input type="number" class="form-control" id="nb_min'+new_id+'" value="'+$min+'"> <span style="display: none;"> '+$min+' </span></td>'

	to_append+='<td> <input type="number" class="form-control" id="nb_max'+new_id+'" value="'+$max+'"> <span style="display: none;"> '+$max+' </span></td>'

	to_append+='<td><button style="margin-right:2%;" class="btn btn-primary btn-sm" id="'+new_id+'" onclick="modifierclasse(event,this)"> Enregistrer</button>'

	to_append+='<a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModalsup-'+new_id+'" style="color: #fff;"> supprimer</a><div id="myModalsup-'+new_id+'" class="modal fade" role="dialog">'

	to_append+='<div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Voulez-vous vraiment supprimer ce classe</h4></div>'

	to_append+='<div class="modal-body"><button style="color:#ffffff; margin-right:1%;" class="col-md-5 btn btn-primary" onclick="supprimerclasse(event,this)" data-dismiss="modal" id="mod'+new_id+'">OUI,je supprime</button><a style="color:#ffffff;" data-dismiss="modal" class="col-md-6 btn btn-danger">NON,je ne veux pas supprimer</a></div><div class="modal-footer"><button type="button" class="btn btn-warning" data-dismiss="modal">Fermer</button></div></div></div></div></td></form></tr>'

	to_append=$(to_append)	

	to_append=$(to_append)	

	to_append.hide(0);

	//var newest=new_id+1;

	var newest=new_id;

	console.log('le newest : ');
	
	console.log(newest);

	var xxx = "#"+xx;

	console.log($(xxx));

	newest="ajout"+newest;

	$(xxx).attr('id',newest);

	$("#nomduclasse").val("");
	$("#minduclasse").val("25");
	$("#maxduclasse").val("35");	

    $.ajax({
        headers: 
        {
           'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },                    
        type:"POST",
        url:"/home/classes/ajouter/ajax",
        data:{min:$min,nom:$nom,max:$max},

        success:function(data) 
        {

			$("#all_the_classes").append(to_append).show(1500);

			to_append.show(1500)

			$('html, body').animate({scrollTop:$(document).height()}, 'slow');			

        	//
		}
	});	

	// body... 
}

