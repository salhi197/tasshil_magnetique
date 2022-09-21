function fit_prof() 
{

	var matiere = $("#matiere").find(":selected").val();

    $.ajax({
        headers: 
        {
           'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },                    
        type:"POST",
        url:"/home/single_groupe_speciale/fit_prof/ajax",
        data:{matiere:matiere},

        success:function(data) 
        {

        	$("#prof").html("");
			
        	var option = '';
        	
        	for (var i = 0; i < data.length; i++) 
        	{
				
				option += '<option id='+data[i].nom+'-'+data[i].prenom+' value='+data[i].nom+'-'+data[i].prenom+'>'+data[i].nom+'-'+data[i].prenom+' &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</option>'

        		//
        	}

        	$("#prof").html(option);

        	//
		}
	});	


	// body...
}


function fit_matiere() 
{

	var prof = $("#prof").find(":selected").val();

    $.ajax({
        headers: 
        {
           'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },                    
        type:"POST",
        url:"/home/single_groupe_speciale/fit_matiere/ajax",
        data:{prof:prof},

        success:function(data) 
        {

        	$("#matiere").html("");
			
        	var option = '';
        	
        	for (var i = 0; i < data.length; i++) 
        	{
				
				option += '<option value='+data[i].matiere+'>'+data[i].matiere+' </option>'

        		//
        	}

        	$("#matiere").html(option);

        	//
		}
	});	


	// body...
}


function verif_existance() 
{
 	
 	var nom = $("#nom").val();

 	var prenom = $("#prenom").val();

 	var id_groupe = $("#nom").attr('groupe');

    $.ajax({
        headers: 
        {
           'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },                    
        type:"POST",
        url:"/home/single_groupe_special/verif_existance/ajax",
        data:{nom:nom,prenom:prenom,id_groupe:id_groupe},

        success:function(data) 
        {

        	//alert(data);

        	if (data!==false) 
        	{

        		$("#nom").removeClass("is-invalid state-invalid").addClass("is-valid state-valid");
        		$("#prenom").removeClass("is-invalid state-invalid").addClass("is-valid state-valid");
        		
        		$("#il_existe_deja").hide('1000', function() 
        		{
        			$("#btn_ajouter").show(1000);
        		});

        		$("#num_tel").val(data);

        		//
        	}
        	else
        	{

        		$("#nom").removeClass("is-valid state-valid").addClass("is-invalid state-invalid");
        		$("#prenom").removeClass("is-valid state-valid").addClass("is-invalid state-invalid");
        		
        		$("#btn_ajouter").hide('1000', function() 
        		{
        			$("#il_existe_deja").show('1000');
        		});

        		$("#num_tel").val('');

        		//
        	}

        	//
		}
	});	



 	//
} 

function valider_coches(objet) 
{

	$(objet).hide(500, function() 
	{

		$("#valider").show(500);

		$("#ne_pas_valider").show(500);
		
	});

	// body...
}

function retour(objet) 
{
	$("#valider").hide('500');

	$(objet).hide('1000', function() 
	{	
		
		$("#valider_les_coches").show(500)	
		
	});

	//
}


function valider_tous(objet) 
{

	var la_matiere = $("#matiere").find(":selected").val();
	var le_prof = $("#prof").find(":selected").val();
	
	if (la_matiere=="--" || le_prof=="--") 
	{
		
		$("#matiere").removeClass("is-valid state-valid").addClass("is-invalid state-invalid");
		$("#prof").removeClass("is-valid state-valid").addClass("is-invalid state-invalid");
		
		return false;
		//
	}
	else
	{

		$("#matiere").removeClass("is-invalid state-invalid").addClass("is-valid state-valid");
		$("#prof").removeClass("is-invalid state-invalid").addClass("is-valid state-valid");

		//
	}


	var eleves_groupe = JSON.parse($(objet).attr('value'));

	var groupe = JSON.parse($(objet).attr('groupe'));

	var seances_eleves = JSON.parse($(objet).attr('seances_eleves'));

	var numero_de_la_seance_dans_le_mois = JSON.parse($(objet).attr('numero_de_la_seance_dans_le_mois'));	

	var eleves_gratuits = JSON.parse($(objet).attr('eleves_gratuits'));
	
	var les_coches = [];

	var les_input_payement = [];	

	var max = [];

	var compteur_faux = 0;

	for (var i = 0; i < eleves_groupe.length; i++) 
	{

		if($("#mois1-"+eleves_groupe[i].id+"-"+numero_de_la_seance_dans_le_mois).is(":checked")) 
		{
			les_coches[i]=1;
			//
		}
		else
		{
			les_coches[i]=0;
			//
		}

		les_input_payement[i] = parseFloat($("#input_payement"+eleves_groupe[i].id).val());

		max[i] = parseFloat($("#input_payement"+eleves_groupe[i].id).attr('max'));

		if(les_input_payement[i] > max[i]) 
		{

			compteur_faux = compteur_faux+1;

			$("#input_payement"+eleves_groupe[i].id).removeClass("is-valid state-valid").addClass("is-invalid state-invalid");
			
			var scroll_to = $("#l_eleve"+eleves_groupe[i].id).position();

			/*$("#valid_"+eleves_groupe[i].id).hide('1000');
			
			$("#invalid_"+eleves_groupe[i].id).show(1000);*/
				
			

			
			//
		}
		else
		{

			$("#input_payement"+eleves_groupe[i].id).removeClass("is-invalid state-invalid").addClass("is-valid state-valid");
		
			/*$("#invalid_"+eleves_groupe[i].id).hide('1000');
			$("#valid_"+eleves_groupe[i].id).show(1000);*/
				

			//			
		}


		//
	}

	console.log(seances_eleves);
	console.log(les_coches);

	var nb_coches = les_coches.reduce((a, b) => a + b, 0)

	if (nb_coches<(eleves_groupe.length)/5) 
	{

		//alert("Verifiez Que vous avez bien coché les élèves Vou avez coché "+nb_coches+" élèves seulement!!");

		swal("Cochez les présences", "Vous avez coché que "+nb_coches+" élèves parmis : "+eleves_groupe.length, "error");

		return false;

		//
	}
	
	if (compteur_faux>0) 
	{

		$("html, body").animate({ scrollTop: scroll_to.top }, "slow");

		return false;
	}

    $.ajax({
        headers: 
        {
           'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },                    
        type:"POST",
        url:"/home/single_groupe_special/valider_coches/ajax",
        data:{la_matiere:la_matiere,le_prof:le_prof,eleves_groupe:eleves_groupe,groupe:groupe,numero_de_la_seance_dans_le_mois:numero_de_la_seance_dans_le_mois,les_coches:les_coches,les_input_payement:les_input_payement,eleves_gratuits:eleves_gratuits},

        success:function(data) 
        {        	

        	$("html, body").animate({ scrollTop: 140 }, "slow");
        	
        	location.reload();

        	//
		}
	});	




	// body...
}


function goto_the_link(objet) 
{

	var id_eleve = (objet.id.substr(5));

	var id_groupe = $(objet).attr("groupe")

	window.location.href = '/home/groupes_special/'+id_groupe+'/eleve/'+id_eleve;
	
	// body...
}

function supprimergroupe (event,objet) 
{

	event.preventDefault();

	$id=(objet.getAttribute('id'));

	$id=($id.substr(3));

	var id_hide="#groupe"+$id;

	console.log(id_hide)

    $.ajax({
        headers: 
        {
           'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },                    
        type:"POST",
        url:"/home/groupes_special/supprimer/ajax",
        data:{id:$id},

        success:function(data) 
        {

        	$("#nnotif").text("Groupe Archivé").attr('class','text-center alert alert-danger')

			window.location.href = '/home/groupes_special';

        	//
		}
	});	

	// body... 
}

function hide_payement(objet) 
{	

	if($(objet).is(":checked"))
	{

		$("#payement .form-control").val(0);

		$("#payement").show('1000', function() 
		{
			
			$(".custom-switch-description").text("L'élève paye ses cotisations");

			//	
		});

		//
	}
	else
	{

		$("#payement").hide('1000', function() 
		{
			
			$(".custom-switch-description").text("L'élève ne paye pas");

			//	
		});


		//
	}

	//
}

function verif_prix_tarif(objet,tarif) 
{

	var max = $(objet).attr('max');

	tarif = max;

	tarif = parseFloat(tarif);

	if ($(objet).val()>tarif) 
	{

		$(objet).removeClass("is-valid state-valid").addClass("is-invalid state-invalid");

		//
	}
	else
	{

		$(objet).removeClass("is-invalid state-invalid").addClass("is-valid state-valid");
		//
	}
	

	// body...
}


function afficher_payement_prof_1(objet,le_mois) 
{
	
	if($(objet).attr('class')!=="col-md-5 alert alert-success")
	{

		$("#payement_prof_effectuee"+le_mois).parent().show(1000);

		//
	}


	//
}

function afficher_payement_prof_2(objet,le_mois) 
{

	var num_mois = le_mois;
	
	var num_seance = $(objet).attr('seance');

	var id_groupe = $(objet).attr('groupe');

	var nom_prenom_prof = $(objet).attr('prof');

	var payement = $("#le_payement_du_mois"+le_mois).val();

    $.ajax({
        headers: 
        {
           'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },                    
        type:"POST",
        url:"/home/single_groupe/payer_prof/ajax",
        data:{num_mois:num_mois,num_seance:num_seance,id_groupe:id_groupe,nom_prenom_prof:nom_prenom_prof,payement:payement},

        success:function(data) 
        {

        	$("#payement_prof_effectuee"+le_mois).parent().hide('slow', function() 
        	{
        		$("#payement_prof_mois"+le_mois).removeClass("alert alert-warning").hide('slow/400/fast', function() 
        		{
        			
        			$("#payement_prof_mois"+le_mois).addClass("alert alert-success").show('slow');

        			//
        		});
        	});

        	//
		}
	});	


	

	// body...
}

  	
