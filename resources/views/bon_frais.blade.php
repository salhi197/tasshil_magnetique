<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body style="color: black; text-align: center; margin-top:-15%;">


	<?php use App\Eleve; ?>

	<?php $eleve = Eleve::find($data['id_eleve']); ?>

	<h1>Ecole</h1>

	<h1>The English Gate</h1>

	<img style="margin-top:3%;" src="logo_english_gate.jpg" width="300" height="120" alt="English Gate">

	<h3>Eleve : {!! ucfirst($eleve->nom) !!} {!! ucfirst($eleve->prenom) !!}</h3>
	
	<h3 style="border:solid black 1px;">Montant payé : {!! $data['montant'] !!} DA</h3>
	
	<h3>Payé le : {!! $data['updated_at'] !!} </h3> 
	
	<h3> Frais d'inscriptions </h3>

	<?php date_default_timezone_set("Africa/Algiers"); ?>

	<h5>Bon delivré le : {!! date("d/m/Y h:i:sa") !!}</h5> 

</body>
</html>