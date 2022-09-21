document.getElementById("modif_effectue").style.display = 'none';
document.getElementById("suppression_effectue").style.display = 'none';
document.getElementById("in_filiere").style.display = 'none';

function afficher_filiere(objet) 
{

	var conceptName = $(objet).find(":selected").val();	

	var niv = ($('#niveauduniveau').val());

	if((conceptName == "AS" && niv<4 ) || conceptName == "Univ" && niv<4)
	{

		$("#in_niveau").attr('class', 'form-group col-md-4 col-sm-12');

		$(objet).parent().attr('class', 'form-group col-md-4 col-sm-12');

		$("#in_filiere").show('slow');		

		//
	}
	else
	{

		$("#in_niveau").attr('class', 'form-group col-md-6 col-sm-12');

		$(objet).parent().attr('class', 'form-group col-md-6 col-sm-12');

		$("#in_filiere").hide('slow');				

		//
	}

	// body...
}


function afficher_filiere1(objet) 
{
	
	var conceptName = $(objet).val();	

	var cycle = $("#cycleduniveau").find(":selected").val();

	if((conceptName<=3) && (cycle=="AS" || cycle=="Univ") ) 
	{


		$("#in_niveau").attr('class', 'form-group col-md-4 col-sm-12');

		$("#in_cycle").attr('class', 'form-group col-md-4 col-sm-12');

		$("#in_filiere").show('slow');				

		//
	}
	else
	{


		$("#in_niveau").attr('class', 'form-group col-md-6 col-sm-12');

		$("#in_cycle").attr('class', 'form-group col-md-6 col-sm-12');

		$("#in_filiere").hide('slow');						


		//
	}

	//
}



function supprimerniveau (event,objet) 
{

	event.preventDefault();

	$id=(objet.getAttribute('id'));

	$id=($id.substr(3));

	var id_hide="#niveau"+$id;

	console.log(id_hide)

    $.ajax({
        headers: 
        {
           'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },                    
        type:"POST",
        url:"/home/niveaux/supprimer/ajax",
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

function ajouterniveau(event,ojbet) 
{

	event.preventDefault();

	var $niveauduniveau = $("#niveauduniveau").val();

	var $cycleduniveau = $("#cycleduniveau").find(":selected").val();	

	var $filiereduniveau = $("#filiereduniveau").find(":selected").val();	

	var new_id = $(ojbet).attr('id');

	var xx=new_id;

	new_id=(new_id.substr(5));

	new_id = parseInt(new_id)+1;

	console.log(new_id);
	
	var to_append = '<tr class="alert alert-success" id="niveau'+new_id+'"><form>{{ csrf_field() }} <td>'+new_id+'</td>'
	if ($niveauduniveau == 1) 
	{
		to_append+='<td> <span> '+$niveauduniveau+'ere Année  </span> </td>'
	}
	else
	{
		to_append+='<td> <span> '+$niveauduniveau+'éme Année </span> </td>'	
	}

	to_append+='<td> <span> '+$cycleduniveau+' </span></td>'
	
	if($cycleduniveau=="AS"||$cycleduniveau=="Univ") 
	{
		to_append+='<td> <span> '+$filiereduniveau+' </span></td>'
	}
	else
	{
		to_append+='<td> <span> ------ </span></td>'	
	}

	to_append+='<td> <li style="margin: auto; width: 50%; padding: 10px;" class="icons-list-item"><i class="ion-ios7-checkmark-empty" data-toggle="tooltip"></i></li></td></tr>';

/*	to_append+='<td> <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModalsup-'+new_id+'" style="color: #fff;"> supprimer</a><div id="myModalsup-'+new_id+'" class="modal fade" role="dialog">'

	to_append+='<div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Voulez-vous vraiment supprimer ce niveau</h4></div>'

	to_append+='<div class="modal-body"><button style="color:#ffffff; margin-right:1%;" class="col-md-5 btn btn-primary" onclick="supprimerniveau(event,this)" data-dismiss="modal" id="mod'+new_id+'">OUI,je supprime</button><a style="color:#ffffff;" data-dismiss="modal" class="col-md-6 btn btn-danger">NON,je ne veux pas supprimer</a></div><div class="modal-footer"><button type="button" class="btn btn-warning" data-dismiss="modal">Fermer</button></div></div></div></div></td></form></tr>'
*/
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

	$("#niveauduniveau").val("");
	$("#cycleduniveau").val("");
	$("#filiereduniveau").val("");	

    $.ajax({
        headers: 
        {
           'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },                    
        type:"POST",
        url:"/home/niveaux/ajouter/ajax",
        data:{niveauduniveau:$niveauduniveau,cycleduniveau:$cycleduniveau,filiereduniveau:$filiereduniveau},

        success:function(data) 
        {

			$("#all_the_niveaux").append(to_append).show(1500);

			to_append.show(1500)

			$('html, body').animate({scrollTop:$(document).height()}, 'slow');			

        	//
		}
	});	

	// body... 
}

