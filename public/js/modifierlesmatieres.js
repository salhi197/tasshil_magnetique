document.getElementById("modif_effectue").style.display = 'none';
document.getElementById("suppression_effectue").style.display = 'none';

function modifiermatiere(event,objet) 
{	
		
	event.preventDefault();

	var $id=(($(objet)).attr('id'));

	var id_to_hide = "#matiere"+$id;

	var id_tel="#telmatiere"+$id;

	//---------//---------//

	var $tel=$(id_tel).val();

    $.ajax({
        headers: 
        {
           'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },                    
        type:"POST",
        url:"/home/matieres/modifier/ajax",
        data:{id:$id,tel:$tel},

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

function supprimermatiere (event,objet) 
{

	event.preventDefault();

	$id=(objet.getAttribute('id'));

	$id=($id.substr(3));

	var id_hide="#matiere"+$id;

	console.log(id_hide)

    $.ajax({
        headers: 
        {
           'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },                    
        type:"POST",
        url:"/home/matieres/supprimer/ajax",
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

function ajoutermatiere(event,ojbet) 
{

	event.preventDefault();

	var selected=[];
	var selecteds="";

	$('#cycledumatiere :selected').each(function()
	{
	    selected[$(this).val()]=$(this).text();
	    selecteds += $(this).text()+","
	});
	
	console.log(selecteds);

	var $nom = $("#nomdumatiere").val();

	var new_id = $(ojbet).attr('id');

	var xx=new_id;

	new_id=(new_id.substr(5));

	new_id = parseInt(new_id)+1;

	console.log(new_id);
	
	var to_append = '<tr class="alert alert-success" id="matiere'+new_id+'"><form>{{ csrf_field() }} <td>'+new_id+'</td>'

	to_append+='<td> <span> '+$nom+' </span></td>'

	if (new_id>20) 
	{
		to_append+='<td><a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModalsup-'+new_id+'" style="color: #fff;"> supprimer</a><div id="myModalsup-'+new_id+'" class="modal fade" role="dialog">'

		to_append+='<div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Voulez-vous vraiment supprimer ce matiere</h4></div>'

		to_append+='<div class="modal-body"><button style="color:#ffffff; margin-right:1%;" class="col-md-5 btn btn-primary" onclick="supprimermatiere(event,this)" data-dismiss="modal" id="mod'+new_id+'">OUI,je supprime</button><a style="color:#ffffff;" data-dismiss="modal" class="col-md-6 btn btn-danger">NON,je ne veux pas supprimer</a></div><div class="modal-footer"><button type="button" class="btn btn-warning" data-dismiss="modal">Fermer</button></div></div></div></div></td>'		
	}
	else
	{
		to_append+='<td> <li style="margin: auto; width: 50%; padding: 10px;" class="icons-list-item"><i class="ion-ios7-checkmark-empty" data-toggle="tooltip" title="ion-ios7-checkmark-empty"></i></li></td>'		
	}


	to_append+='</form></tr>'

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

	$("#nomdumatiere").val("");
	
    $.ajax({
        headers: 
        {
           'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },                    
        type:"POST",
        url:"/home/matieres/ajouter/ajax",
        data:{nom:$nom},

        success:function(data) 
        {

			$("#all_the_matieres").append(to_append).show(1500);

			to_append.show(1500)

			$('html, body').animate({scrollTop:$(document).height()}, 'slow');			

        	//
		}
	});	

	// body... 
}

