function imprimer_bon(objet) 
{
	
	$id_eleve = ( $(objet).attr("eleve") );
	$id_groupe = ( $(objet).attr("groupe") );
	$mois = ( $(objet).attr("mois") );

	montant=$("#input_payement"+$id_eleve).val();

    $.ajax({
	        headers: 
	        {
	           'X-CSRF-TOKEN': $('input[name="_token"]').val()
	        },                    
	        type:"POST",
	        url:"/home/single_groupe/imprimer_bon/ajax",
	        data:{id_eleve:$id_eleve,id_groupe:$id_groupe,mois:$mois,montant:montant},

	        success:function(data) 
	        {



	        	//
	        }

	        //
        });

	//
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
        url:"/home/single_groupe/verif_existance/ajax",
        data:{nom:nom,prenom:prenom,id_groupe:id_groupe},

        success:function(data) 
        {

        	if (data!==false) 
        	{

        		$("#nom").removeClass("is-invalid state-invalid").addClass("is-valid state-valid");
        		$("#prenom").removeClass("is-invalid state-invalid").addClass("is-valid state-valid");
        		
        		$("#il_existe_deja").hide('1000', function() 
        		{
        			$("#btn_ajouter").show(1000);
        		});

        		$("#btn_ajouter").show(1000);
        		
        		$("#num_tel").val(data.num_tel);

        		if (data.frais==0 || data.frais===undefined) 
        		{

    				$("#frais").val(data.frais).show(1000);

        			//
        		}
        		else
        		{

        			$("#frais").val(data.frais).hide(1000);
        			//
        		}



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

        		var element = $('<p id="il_existe_deja" style="font-size: 1.2em;" class="invalid-feedback text-center">L\'Elève existe déja</p>');

        		$("#btn_ajouter").after(element);
        		
        		$("#num_tel").val('');

        		$("#frais").hide(1000);

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

function verif_tel(objet) 
{

	if($(objet).val()=="")
	{

		$(objet).val(0)	
	}

	if ($(objet).val().length>10 || !$.isNumeric($(objet).val()) ) 
	{

		$("#num_tel").removeClass("is-valid state-valid").addClass("is-invalid state-invalid");

		$("#btn_ajouter").hide('1000');

		//
	}
	else
	{

		$("#num_tel").removeClass("is-invalid state-invalid").addClass("is-valid state-valid");

		$("#btn_ajouter").show('1000');

		//
	}



	//
}


function valider_tous(objet) 
{

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
        url:"/home/single_groupe/valider_coches/ajax",
        data:{eleves_groupe:eleves_groupe,groupe:groupe,numero_de_la_seance_dans_le_mois:numero_de_la_seance_dans_le_mois,les_coches:les_coches,les_input_payement:les_input_payement,eleves_gratuits:eleves_gratuits},

        success:function(data) 
        {
        	
        	$(objet).parent().hide(500);
        	$("#patientez").show(1000);
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

	window.location.href = '/home/groupes/'+id_groupe+'/eleve/'+id_eleve;
	
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
        url:"/home/groupes/supprimer/ajax",
        data:{id:$id},

        success:function(data) 
        {

        	$("#nnotif").text("Groupe Archivé").attr('class','text-center alert alert-danger')

			window.location.href = '/home/groupes';

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
	
	var id_groupe = $(objet).attr('groupe');

	window.location.href = '/home/groupes/'+id_groupe+'/payer_prof';

	//
}


function fit_tarif(objet) 
{
	
	var niveau = ($(objet).find(":selected").val().substr(0,1));
	
	var cycle = ($(objet).find(":selected").val().substr(2,2));
	
	if (cycle=="AS") 
	{

		if (niveau==1 || niveau==2) 
		{

			$("#tarif").val(1800);

			//
		}
		else
		{

			$("#tarif").val(2500);

			//
		}
		//
	}

	// body...
}


function fit_prof(objet) 
{

	var $matiere = $(objet).find(":selected").val();

	var cycle = $("#niveaudugroupe").find(":selected").val();

	if(cycle.substr(2,2)=='AS')
	{
		var cycle = "Secondaire";
	}

	if(cycle.substr(2,2)=='AM')
	{
		var cycle = "Moyen";
	}

	if(cycle.substr(2,2)=='PS')
	{
		var cycle = "Préscolaire";
	}


	if(cycle.substr(2,2)=='AP')
	{
		var cycle = "Primaire";
	}

	if(cycle.substr(2,2)=='Univ')
	{
		var cycle = "Universitaire";
	}



    $.ajax({
        headers: 
        {
           'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },                    
        type:"POST",
        url:"/home/groupes/get_profs/ajax",
        data:{matiere:$matiere,cycle:cycle},

        success:function(data) 
        {

        	$("#profdugroupe").html("");
			
        	var option = '';
        	
        	for (var i = 0; i < data.length; i++) 
        	{
				
				option += '<option id='+data[i].nom+'-'+data[i].prenom+' value='+data[i].nom+'-'+data[i].prenom+'>'+data[i].nom+'-'+data[i].prenom+' &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</option>'

        		//
        	}

        	$("#profdugroupe").html(option);

        	//
		}
	})	

		

	// body...
}



function fit_salles() 
{	
	var $id_groupe = $("#id_groupe").val();
	var $jour = $("#jourdugroupe").find(":selected").val();
	var $debut = $("#heure_debutdugroupe").val();
	var $fin = $("#heure_findugroupe").val();
	var $salle = $("#salledugroupe").find(":selected").val();

	if ($debut>=$fin) 
	{
		$("#heure_findugroupe").val("");
	}

    $.ajax({
        headers: 
        {
           'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },                    
        type:"POST",
        url:"/home/groupes/fit_salle/modifier/ajax",
        data:{id_groupe:$id_groupe,jour:$jour,debut:$debut,fin:$fin,salle:$salle},

        success:function(data) 
        {

        	if(data !== true)
        	{

				$("#salledugroupe").addClass("is-invalid state-invalid");        		
				$(".invalid-feedback").remove();
				$("#salledugroupe").after($('<div class="invalid-feedback">Il existe un groupe de : '+data.niveau+'<br> Matiere : '+data.matiere+'<br> Prof : '+data.prof+'<br> de : '+data.heure_debut.substr(0,5)+' à '+data.heure_fin.substr(0,5)+'</div>'));
				
        		//
        	}
        	else
        	{

        		$("#salledugroupe").removeClass("is-invalid state-invalid").addClass("is-valid state-valid");
        		$(".invalid-feedback").remove();        		

        		//
        	}

        	//
		}
	})	



	// body...
}



  	
