function verif_existance() 
{
 	
 	var nom = $("#nom").val();

 	var prenom = $("#prenom").val();

 	var id_dawra = $("#nom").attr('dawra');

    $.ajax({
        headers: {
           'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },                    
        type:"POST",
        url:"/home/single_dawra/verif_existance/ajax",
        data:{nom:nom,prenom:prenom,id_dawra:id_dawra},
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
	$("#valider").hide();	
    var checked = [];
    var payments = [];
    var dawra = $('#dawra_id').val();
    $(".checkboxes:checkbox:checked").each(function() {
        checked.push({
            "eleve":$(this).attr("eleve"),
            "num_seance":$(this).attr("seance"),
//			"montant":parseFloat($("#payment_eleve_"+$(this).attr("eleve")).val()),
        }
        )
    });
	var liste_eleves = JSON.parse($('#liste_eleves').val());
    console.log(liste_eleves);

	var payment_inputs = []
	for(var i=0;i<liste_eleves.length;i++){
		payment_inputs.push({
            "eleve":liste_eleves[i].id,
			"montant":parseFloat($("#payment_eleve_"+liste_eleves[i].id).val())
		}
		)
	}
	console.log(payment_inputs)
	
	$.ajax({   
		type: "POST",
		data : {
			dawra:dawra,
			data:JSON.stringify(checked),
			payments:JSON.stringify(payment_inputs),
			
		},//$(this).serialize(),
		url: "/home/single_dawra/valider_coches",   
		success: function(data){
			console.log('sasa');
			$("#results").html(data);                       
        	location.reload();

		},
		error:function(err){
			console.log(err	);
		}
	});      

	



	// body...
}


function goto_the_link(objet) 
{

	var id_eleve = (objet.id.substr(5));

	var id_dawra = $(objet).attr("dawra")

	window.location.href = '/home/dawra/'+id_dawra+'/eleve/'+id_eleve;
	
	// body...
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






  	
