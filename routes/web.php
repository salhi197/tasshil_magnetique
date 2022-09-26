<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->middleware('lang');

Auth::routes();
Route::group(['middleware' => 'auth'], function () {
Route::get('/home', 'HomeController@index')->name('home');

//classes :
Route::get('/home/classes', 'ClasseController@classes');
Route::post('/home/classes/modifier/ajax','ClasseController@modifier');
Route::post('/home/classes/supprimer/ajax','ClasseController@supprimer');
Route::post('/home/classes/ajouter/ajax','ClasseController@ajouter');

//niveaux :
Route::get('/home/niveaux', 'NiveauController@niveaux');
Route::post('/home/niveaux/modifier/ajax','NiveauController@modifier');
Route::post('/home/niveaux/supprimer/ajax','NiveauController@supprimer');
Route::post('/home/niveaux/ajouter/ajax','NiveauController@ajouter');


//matiéres :
Route::get('/home/matiéres', 'MatiereController@matieres');
Route::post('/home/matieres/modifier/ajax','MatiereController@modifier');
Route::post('/home/matieres/supprimer/ajax','MatiereController@supprimer');
Route::post('/home/matieres/ajouter/ajax','MatiereController@ajouter');


//Profs :
Route::get('/home/Enseignants', 'ProfController@profs');
Route::post('/home/profs/modifier/ajax','ProfController@modifier');
Route::post('/home/profs/supprimer/ajax','ProfController@supprimer');
Route::post('/home/profs/ajouter/ajax','ProfController@ajouter');


//Groupes :
Route::get('/home/groupes','GroupeController@groupes');
Route::get('/home/groupes/{id}','GroupeController@afficher_groupe');
Route::post('/home/groupes/{id}/ajouter','GroupeController@ajouter_eleve');
Route::post('/home/single_groupe/valider_coches/ajax','SingleGroupeController@valider_coches');
Route::get('/home/groupes/{id}/tout','SingleGroupeController@toutes_seances');

Route::get('/home/scann/{matricule}','SingleGroupeController@scanner');
Route::get('/home/seance/annuler/{matricule}/{seance}','SingleGroupeController@annuler')->name('annuler');;
Route::get('/home/cloturer/{id_groupe}','SingleGroupeController@cloturer')->name('cloturer');

Route::post('/home/groupes/modifier/ajax','GroupeController@modifier');
Route::post('/home/groupes/supprimer/ajax','GroupeController@supprimer');
Route::post('/home/groupes/ajouter/ajax','GroupeController@ajouter');
Route::post('/home/groupes/get_profs/ajax','GroupeController@get_profs');
Route::post('/home/groupes/fit_salle/ajax','GroupeController@fit_salles');
Route::post('/home/single_groupe/verif_existance/ajax','GroupeController@verif_existance');


//payement :

Route::get('/home/groupes/{id_groupe}/eleve/{id_eleve}','SingleGroupeController@historique_payement');
Route::post('/home/single_eleve/exoneree/ajax','SingleGroupeController@exonerer');
Route::post('/home/single_eleve/completer_payement/ajax','SingleGroupeController@completer_payement');

Route::post('/home/groupes/{id_groupe}/eleve/{id_eleve}/completer_frais','SingleGroupeController@completer_frais');


Route::post('/home/single_groupe/payer_prof/ajax','SingleGroupeController@payer_prof');

// dawarat :
Route::get('/home/dawarat','DawraController@dawrat');
Route::get('/home/groupes_special','SpecialGroupeController@index');
Route::post('/home/dawra/ajouter','DawraController@ajouter');
Route::get('/home/dawra/{id}','DawraController@afficher_dawra');
Route::post('/home/dawra/{id}/ajouter','DawraController@ajouter_eleve');
Route::post('/home/single_dawra/valider_coches','DawraController@valider_coches')->name('dawra_valider_coches');
Route::post('/home/single_dawra/verif_existance/ajax','DawraController@verif_existance');
Route::get('/home/dawra/{id_dawra}/eleve/{id_eleve}','DawraController@historique_payement');










Route::get('/lang/{lang}', 'LangController@setLang');

Route::get('/home/inscription', 'InscriptionController@index');
Route::post('/home/inscriptions/ajouter','InscriptionController@ajouter');





















//Goupes Spéciaux : 

Route::post('/home/groupes_special/ajouter/ajax','SpecialGroupeController@ajouter');
Route::get('/home/groupes_special/{id}','SpecialGroupeController@afficher_groupe');
Route::post('/home/groupes_special/{id}/ajouter','SpecialGroupeController@ajouter_eleve');
Route::post('/home/single_groupe_special/valider_coches/ajax','SpecialGroupeController@valider_coches');
Route::post('/home/single_groupe_speciale/fit_prof/ajax','SpecialGroupeController@get_profs');
Route::post('/home/single_groupe_speciale/fit_matiere/ajax','SpecialGroupeController@get_matiere');

Route::get('/home/groupes_special/{id_groupe}/eleve/{id_eleve}','SpecialGroupeController@historique_payement');

Route::post('/home/single_groupe_special/verif_existance/ajax','SpecialGroupeController@verif_existance');

Route::post('/home/single_eleve_special/exoneree/ajax','SpecialGroupeController@exonerer');

Route::post('/home/single_eleve_special/completer_payement/ajax','SpecialGroupeController@completer_payement');

Route::post('/home/groupes_special/supprimer/ajax','SpecialGroupeController@supprimer');



//matiéres :
Route::get('/home/caisse', 'CaisseController@index');

Route::post('/home/saisir_frais', 'HomeController@saisir_frais');
Route::post('/change/password', 'HomeController@ChangePassword');

     
});


Route::view('/sync', 'Home.sync');
Route::post('/sync', 'HomeController@getDB');
