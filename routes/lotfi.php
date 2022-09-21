<?php

Route::group(['middleware' => 'auth'], function () 
{

	Route::get('/home/calendrier','CalendrierController@index');

	Route::get('/home/inscriptions','GroupeController@inscription');

	Route::get('/home/groupes/{id}/payer_prof','SingleGroupeController@payer_prof1');

	Route::get('/home/groupes_special/{id}/payement_prof','SpecialGroupeController@payement_prof');

	Route::post('/home/groupes/modifier','SingleGroupeController@modifier_groupe');

	Route::post('/home/groupes/fit_salle/modifier/ajax','SingleGroupeController@fit_salles');

	Route::post('/home/single_eleve/supprimer/ajax','SingleGroupeController@supprimer_eleve');

	Route::get('/home/particuliers','ParticulierController@index');

	Route::post('/home/Enseignants/verif_existance/ajax','ProfController@verif_existance');

	Route::post('/home/groupes/{id_groupe}/eleve/{id_eleve}/modif_num','SingleGroupeController@modifier_eleve');

	Route::post('/home/caisse/filter/ajout_depense','CaisseController@ajout_depense');

	Route::post('/home/caisse/depenses','CaisseController@get_recettes');

	Route::post('/home/caisse/depenses_2','CaisseController@get_depenses');

	Route::post('/imprimer_bon','ParticulierController@bon');

	Route::get('/home/imprimer_bon/{id_eleve}/{id_groupe}/{montant}','ParticulierController@bon');

	Route::get('/home/imprimer_bon/{id_eleve}/{id_groupe}/{mois}/{montant}','ParticulierController@bon');

	Route::post('/home/caisse/filter','CaisseController@filter');

	Route::get('/home/imprimer_bon_dawra/{id_eleve}/{id_dawra}/{montant}','ParticulierController@bon_dawra');
	
	Route::get('/home/imprimer_bon_frais/{id_eleve}/{montant}/{updated_at}','ParticulierController@bon_frais');

	Route::post('/home/get_payment/ajax','HomeController@get_all_payement_eleve');

	Route::post('/home/imprimer_bon/eleve/all','HomeController@imprimer_bon_payement_eleve');

	Route::post('/home/edit_eleve','HomeController@edit_eleve');

	//
});	