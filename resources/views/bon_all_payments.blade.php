<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body style="color: black; text-align: center; margin-top:-2%;">


	<?php $eleve = $data['eleve']; ?>

	<h1>Ecole</h1>

	<h1>The English Gate</h1>

	<h3>Elève : {!! $eleve->nom !!} {!! $eleve->prenom !!}</h3>

	<img style="margin-top:1%;" src="logo_english_gate.jpg" width="300" height="120" alt="English Gate">
	<h5 style="">Imprimé le : {!! Date('d/m/Y H:i:s') !!} </h5>
    <table style="float:left; margin-top:2%; width: 100%; text-align: center;" width="100%" border="0.1" class="text-center table">
        
        <thead>
            <tr>
                
                <th>Date </th>
                <th>Montant</th>
                <th>Motif</th>

            </tr>

        </thead>

        <tbody id="payements_eleve">
			
        	@foreach ($data['payements_groupes'] as $p_groupe)

		    	<tr>		    		

		    		<td>{!! date_format(date_create($p_groupe->created_at),'d/m/Y') !!}</td>
		    		<td>{!! $p_groupe->payement !!} DA</td>
		    		<td>G#{!! $p_groupe->id_groupe !!} | {!! $p_groupe->matiere !!}</td>

		    	</tr>

        	@endforeach

        	@foreach ($data['payements_dawarat'] as $p_dawarat)

		    	<tr>		    		

		    		<td>{!! date_format(date_create($p_dawarat->created_at),'d/m/Y') !!}</td>
		    		<td>{!! $p_dawarat->montant !!} DA</td>
		    		<td>D#{!! $p_dawarat->id_dawra !!} | {!! $p_dawarat->matiere !!}</td>

		    	</tr>

        	@endforeach

        	@foreach ($data['frais'] as $p_frais)

		    	<tr>		    		

		    		<td>{!! date_format(date_create($p_frais->updated_at),'d/m/Y') !!}</td>
		    		<td>{!! $p_frais->frais !!} DA</td>
		    		<td>Frais insc</td>

		    	</tr>

        	@endforeach


        </tbody>

    </table>

</body>
</html>