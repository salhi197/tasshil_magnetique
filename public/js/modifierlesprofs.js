document.getElementById("modif_effectue").style.display = 'none';
document.getElementById("suppression_effectue").style.display = 'none';

function modifierprof(event,objet) 
{	
		
	event.preventDefault();

	var $id=(($(objet)).attr('id'));

	var id_to_hide = "#prof"+$id;

	var id_tel="#telprof"+$id;

	//---------//---------//

	var $tel=$(id_tel).val();

    $.ajax({
        headers: 
        {
           'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },                    
        type:"POST",
        url:"/home/profs/modifier/ajax",
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

function verif_prof() 
{
	
 	var nom = $("#nomduprof").val();

 	var prenom = $("#prenomduprof").val();

 	if (nom.includes("-") || nom.includes("1")|| nom.includes("2")|| nom.includes("3")|| nom.includes("4")|| nom.includes("5")|| nom.includes("6")|| nom.includes("7")|| nom.includes("8")|| nom.includes("9")|| nom.includes("0")) 
 	{
 		$("#nomduprof").removeClass("is-valid state-valid").addClass("is-invalid state-invalid");
 		$(".btn_ajouter").hide('1000');
 		return false;
 	}
 	else
 	{
		$("#nomduprof").removeClass("is-invalid state-invalid").addClass("is-valid state-valid"); 		
		$(".btn_ajouter").show('1000');		
 	}

 	if (prenom.includes("-") || nom.includes("1")|| nom.includes("2")|| nom.includes("3")|| nom.includes("4")|| nom.includes("5")|| nom.includes("6")|| nom.includes("7")|| nom.includes("8")|| nom.includes("9")|| nom.includes("0")) 
 	{
 		$("#prenomduprof").removeClass("is-valid state-valid").addClass("is-invalid state-invalid");
 		$(".btn_ajouter").hide('1000');
 		return false; 		
 	}
 	else
 	{
		$("#prenomduprof").removeClass("is-invalid state-invalid").addClass("is-valid state-valid"); 		
		$(".btn_ajouter").show('1000');		
 	}



    $.ajax({
        headers: 
        {
           'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },                    
        type:"POST",
        url:"/home/Enseignants/verif_existance/ajax",
        data:{nom:nom,prenom:prenom},

        success:function(data) 
        {

        	if (data==true) 
        	{

        		$("#nomduprof").removeClass("is-invalid state-invalid").addClass("is-valid state-valid");
        		$("#prenomduprof").removeClass("is-invalid state-invalid").addClass("is-valid state-valid");
        		
        		$("#il_existe_deja").hide('1000', function() 
        		{
        			$(".btn_ajouter").show(1000);
        		});

        		$(".btn_ajouter").show(1000);

        		//
        	}
        	else
        	{

        		$("#nomduprof").removeClass("is-valid state-valid").addClass("is-invalid state-invalid");
        		$("#prenomduprof").removeClass("is-valid state-valid").addClass("is-invalid state-invalid");
        		
        		$(".btn_ajouter").hide('1000', function() 
        		{
        			$("#il_existe_deja").show('1000');
        		});

        		var element = $('<p id="il_existe_deja" style="font-size: 1.2em;" class="invalid-feedback text-center">Le Prof existe déja</p>');

        		$(".btn_ajouter").after(element);
        		

        		//	
        	}

        	//
		}
	});	



	//
}

function supprimerprof (event,objet) 
{

	event.preventDefault();

	$id=(objet.getAttribute('id'));

	$id=($id.substr(3));

	var id_hide="#prof"+$id;

	console.log(id_hide)

    $.ajax({
        headers: 
        {
           'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },                    
        type:"POST",
        url:"/home/profs/supprimer/ajax",
        data:{id:$id},

        success:function(data) 
        {

        	if(data!==false)
        	{
	
				$(id_hide).hide(1000);

	        	$("#suppression_effectue").show(1000,function()
	        	{  

	        		setTimeout(function() { $("#suppression_effectue").hide(1000);}, 5000);
	        		
	        	});

        	}
        	else
        	{

				swal("Suppression Impossible", "Vous Pouvez pas supprimer, ce prof a un groupe", "error");

        		//	
        	}	


        	//
		}
	});	

	// body... 
}

function verif_tel(objet) 
{

	if($(objet).val()=="")
	{

		$(objet).val(0)	
	}

	if ($(objet).val().length>10 || !$.isNumeric($(objet).val()) ) 
	{

		$("#telduprof").removeClass("is-valid state-valid").addClass("is-invalid state-invalid");

		$(".btn_ajouter").hide('1000');

		//
	}
	else
	{

		$("#telduprof").removeClass("is-invalid state-invalid").addClass("is-valid state-valid");

		$(".btn_ajouter").show('1000');

		//
	}



	//
}


function ajouterprof(event,ojbet) 
{

	event.preventDefault();

	var selected=[];
	var selecteds="";

	$('#cycleduprof :selected').each(function()
	{
	    selected[$(this).val()]=$(this).text();
	    selecteds += $(this).text()+","
	});
	
	console.log(selecteds);

	var $nom = $("#nomduprof").val();

	var $prenom = $("#prenomduprof").val();

	var $tel = $("#telduprof").val();

	if ($nom == "" || $nom.includes("-")) 
	{
		$("#nomduprof").removeClass("is-valid state-valid").addClass("is-invalid state-invalid");

		return false;
		//
	}
	else
	{
		$("#nomduprof").removeClass("is-invalid state-invalid").addClass("is-valid state-valid");
		//
	}


	if ($prenom == "" || $prenom.includes("-")) 
	{
		$("#prenomduprof").removeClass("is-valid state-valid").addClass("is-invalid state-invalid");

		return false;
		//
	}
	else
	{
		$("#prenomduprof").removeClass("is-invalid state-invalid").addClass("is-valid state-valid");
		//
	}


	if ($tel == "") 
	{
		$("#telduprof").removeClass("is-valid state-valid").addClass("is-invalid state-invalid");

		return false;
		//
	}
	else
	{
		$("#telduprof").removeClass("is-invalid state-invalid").addClass("is-valid state-valid");
		//
	}


	var $cycle = $("#cycleduprof").val();

	var $matiere = $("#matiereduprof").val();

	var new_id = $(ojbet).attr('id');

	var xx=new_id;

	new_id=(new_id.substr(5));

	new_id = parseInt(new_id)+1;

	console.log(new_id);
	
	var currentdate = new Date(); 
	
	var datetime =  currentdate.getDate() + "/"
	                + (currentdate.getMonth()+1)  + "/" 
	                + currentdate.getFullYear() + " "  
	                + currentdate.getHours() + ":"  
	                + currentdate.getMinutes() + ":" 
	                + currentdate.getSeconds();

	var to_append = '<tr class="alert alert-success" id="prof'+new_id+'"><form>{{ csrf_field() }} <td>'+new_id+'</td>'

	to_append+='<td> <span> '+$nom+' </span></td>'

	to_append+='<td> <span> '+$prenom+' </span></td>'

	to_append+='<td> <input type="text" id="telprof'+new_id+'" class="form-control" value="'+$tel+'">  <span style="display: none;">'+$tel+'</span></td>'

	to_append+='<td> <span> '+$cycle+' </span></td>'

	to_append+='<td> <span> '+$matiere+' </span></td>'

	to_append+='<td> <span> '+datetime+' </span></td>'

	to_append+='<td><button style="margin-right:2%;" class="btn btn-primary btn-sm" id="'+new_id+'" onclick="modifierprof(event,this)"> Enregistrer</button>'

	to_append+='<a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModalsup-'+new_id+'" style="color: #fff;"> supprimer</a><div id="myModalsup-'+new_id+'" class="modal fade" role="dialog">'

	to_append+='<div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Voulez-vous vraiment supprimer ce prof</h4></div>'

	to_append+='<div class="modal-body"><button style="color:#ffffff; margin-right:1%;" class="col-md-5 btn btn-primary" onclick="supprimerprof(event,this)" data-dismiss="modal" id="mod'+new_id+'">OUI,je supprime</button><a style="color:#ffffff;" data-dismiss="modal" class="col-md-6 btn btn-danger">NON,je ne veux pas supprimer</a></div><div class="modal-footer"><button type="button" class="btn btn-warning" data-dismiss="modal">Fermer</button></div></div></div></div></td></form></tr>'

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

	$("#nomduprof").val("");
	
    $.ajax({
        headers: 
        {
           'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },                    
        type:"POST",
        url:"/home/profs/ajouter/ajax",
        data:{nom:$nom,prenom:$prenom,tel:$tel,cycle:$cycle,matiere:$matiere},

        success:function(data) 
        {

			$("#all_the_profs").append(to_append).show(1500);

			to_append.show(1500)

			$('html, body').animate({scrollTop:$(document).height()}, 'slow');			

        	//
		}
	});	

	// body... 
}

