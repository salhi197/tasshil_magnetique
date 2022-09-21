function hide_or_show_tarif(objet) 
{

	var mois = (objet.id.substr(7));

	if($(objet).is(':checked'))
	{
		$("#complement"+mois).hide(1000);
		$("#le_retard"+mois).hide(1000);
		$("#suur"+mois).show(1000);
		
	}
	else
	{
		$("#complement"+mois).show(1000);
		$("#le_retard"+mois).show(1000);
		$("#suur"+mois).hide(1000);			
	}

	//
}

function ajouternumtel() 
{
	
	$('#my_modal').trigger('click');

	//
}

function suur(objet) 
{

	var mois = (objet.id.substr(3));

	if($(objet).is(':checked'))
	{

		var tarif = $(objet).attr("tarif");

		$("#complement"+mois).hide(1000);

		$("#suur"+mois).hide(1000);

		$("#Payement_Complet"+mois).hide(1000);

		var montant_a_paye = $("#mois"+mois).val();

		var montant_payee = tarif-montant_a_paye;

		$("#le_retard"+mois).addClass('text-center').css('color','green').text('Payement Complet '+montant_payee+' DA').show(1000);

		var id_groupe = $(objet).attr("groupe");

		var id_eleve = $(objet).attr("eleve");

		console.log(id_groupe);
		
		console.log(id_eleve)
		
	    $.ajax({
	        headers: 
	        {
	           'X-CSRF-TOKEN': $('input[name="_token"]').val()
	        },                    
	        type:"POST",
	        url:"/home/single_eleve/exoneree/ajax",
	        data:{id_eleve:id_eleve,id_groupe:id_groupe,num_mois:mois},

	        success:function(data) 
	        {

	        	//location.reload();

	        	//
			}
		});	



		//
	}

	//
}

function completer_payement(objet) 
{

	var num_mois = (objet.id.substr(7));

	var max = ($("#mois"+num_mois).attr("max"));
	
	var payement = ($("#mois"+num_mois).val());

	if (parseFloat(payement)>parseFloat(max))
	{	
		$("#mois"+num_mois).addClass("is-invalid state-invalid");

		return false;
	}
	
	else
	{	

		$("#mois"+num_mois).removeClass("is-invalid state-invalid").addClass("is-valid state-valid");

		var current_seance = $(objet).attr("current_seance");

		var id_eleve = $(objet).attr("id_eleve");

		var id_groupe = $(objet).attr("id_groupe");

	    $.ajax({
	        headers: 
	        {
	           'X-CSRF-TOKEN': $('input[name="_token"]').val()
	        },                    
	        type:"POST",
	        url:"/home/single_eleve/completer_payement/ajax",
	        data:{id_eleve:id_eleve,id_groupe:id_groupe,num_mois:num_mois,current_seance:current_seance,payement:payement},

	        success:function(data) 
	        {

	        	window.open('/home/imprimer_bon/'+id_eleve+'/'+id_groupe+'/'+num_mois+'/'+payement,'_blank');

	        	location.reload();

	        	//
			}
		});
	
		//
	}


	//
}

function come_back(objet) 
{

	var id_groupe = (objet.id.substr(6));

	window.location.href='/home/groupes/'+id_groupe;

	//
}

function afficher_suur(objet) 
{

	var le_mois = $(objet).attr('id');
	
	le_mois = le_mois.substr(13)

	var id_to_show = "#payement_prof_effectuee"+le_mois;

	if($(objet).is(':checked'))
	{

		$(id_to_show).show(1000);
	}
	else
	{

		$(id_to_show).hide(1000);

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
	
	console.log(payement);
    
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

        	$("#payement_prof_effectuee"+le_mois).siblings().hide('slow', function() 
        	{
        			
    			$("#payement_prof_effectuee"+le_mois).hide('slow', function() 
    			{
    				
    				$("#payement_prof_effectuee"+le_mois).parent().text(payement+' DA Payement éffectué le : ' +data).css('color','green');

    				//	
    			});

    			//
        	});

        	//
		}
	});	

	// body...
}

function supprimereleve(event,objet) 
{

	event.preventDefault();

	var id_eleve = (objet.id.substr(5));

	var id_groupe = $(objet).attr("id_groupe") ;

    $.ajax({
        headers: 
        {
           'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },                    
        type:"POST",
        url:"/home/single_eleve/supprimer/ajax",
        data:{id_eleve:id_eleve,id_groupe:id_groupe},

        success:function(data) 
        {

        	window.location.href='/home/groupes/'+id_groupe;

        	//
		}
	});	



	// body...
}
