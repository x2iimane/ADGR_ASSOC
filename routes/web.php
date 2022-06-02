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

Route::get('/', "HomeController@index");
//Collecte:
Route::get("/collecte/","collecteController@index");
Route::get("/collecte/create", "collecteController@create");
Route::get("/collecte/printlist","collecteController@export_all_pdf");
Route::get("/collecte/show/{id}","collecteController@show");
Route::get("/collecte/printable/{id}", "collecteController@export_pdf");


//Collecte fixe:
Route::post("/collecte/fixe/store", "collecteFixeController@store");
Route::get("/collecte/fixe/edit/{id}","collecteFixeController@edit");
Route::get("/collecte/fixe/delete/{id}", "collecteFixeController@destroy");
Route::post("/collecte/fixe/update/{id}","collecteFixeController@update");


//Collecte mobile:
Route::post("/collecte/mobile/store", "collecteMobileController@store");
Route::get("/collecte/mobile/store", function(){
    return Redirect::to("/collecte");
});
Route::get("/collecte/mobile/delete/{id}", "collecteMobileController@destroy");
Route::get("/collecte/mobile/edit/{id}", "collecteMobileController@edit");
Route::post("/collecte/mobile/update/{id}", "collecteMobileController@update");

//Ville:
Route::get("/ville","Villecontroller@index");
Route::get("/ville/create","VilleController@create");
Route::post("/ville/store", "VilleController@store");
Route::get("/ville/edit/{id}","VilleController@edit");
Route::post("/ville/update/{id}","VilleController@update");
Route::get("/ville/delete/{id}","VilleController@destroy");

//Zone:
Route::get("/zone/","ZoneController@index");
Route::get("/zone/{idVille}","ZoneController@index");
Route::get("/zone/create/{idVille}","ZoneController@create");
Route::post("/zone/store","ZoneController@store");
Route::get("/zone/edit/{idZone}","ZoneController@edit");
Route::post("/zone/update/{idZone}","ZoneController@update");
Route::get("/zone/delete/{idZone}","ZoneController@destroy");

//Bureau:
Route::get("/bureau","BureauController@index");
Route::get("/bureau/create/","BureauController@create");
Route::get("/bureau/create/{idVille}","BureauController@create");
Route::post("/bureau/store/","BureauController@store");
Route::get("/bureau/delete/{idBureau}","BureauController@destroy");
Route::get("/bureau/edit/{idBureau}","BureauController@edit");
Route::post("/bureau/update/{idBureau}","BureauController@update");


//Centre:
Route::get("/centre","CentreController@index");
Route::get("/centre/create","CentreController@create");
Route::post("/centre/store","CentreController@store");
Route::get("/centre/edit/{idCentre}","CentreController@edit");
Route::post("/centre/update/{idCentre}","CentreController@update");
Route::get("/centre/delete/{idCentre}","CentreController@destroy");



//Cartes:
Route::get("/carte/", "CartesController@index");
Route::get("/carte/create", "CartesController@create");
Route::post("/carte/store","CartesController@store");
Route::get("/carte/show/{id}", "CartesController@show");
Route::get("/carte/edit/{id}", "CartesController@edit");
Route::post("/carte/update/{id}", "CartesController@update");
Route::get("/carte/delete/{id}", "CartesController@destroy");

//Route::group(['middleware' => ['auth:benevole, donneur'] ], function(){
//    Route::get("/donneur/show/{id}", "DonneurController@show");
//});

//Donneurs:
Route::get("/donneur", "DonneurController@index");
Route::get("/donneur/create", "DonneurController@create");
Route::post("/donneur/store", "DonneurController@store");
Route::get("/donneur/show/{id}", "DonneurController@show");
Route::get("/donneur/edit/{id}", "DonneurController@edit");
Route::post("/donneur/update/{id}", "DonneurController@update");
Route::get("/donneur/delete/{id}", "DonneurController@destroy");
Route::get("/donneur/{id}/pdf", "DonneurController@export_pdf");
Route::get("/donneur/printlist", "DonneurController@export_all_pdf");
Route::get("/donneur/listeaptes", "DonneurController@listeAptes");
Route::get("/donneur/printlisteaptes", "DonneurController@printListeAptes");

//Authentification donneur:
Route::get("/donneur/login", "Auth\DonneurLoginController@showLoginForm")->name("donneur.login");
Route::post("/donneur/login","Auth\DonneurLoginController@login")->name("donneur.login.submit");
Route::get("/donneur/logout", "Auth\DonneurLoginController@logout")->name("donneur.logout");



//Dons:
//Route::get("/don/", "DonController@index");
Route::get("/don/create", "DonController@create");
Route::get("/don/{idDonneur}", "DonController@index");
Route::post("/don/store", "DonController@store");


//Dons ADGR:
Route::get("/don/adgr/delete/{id}","DonADGRController@destroy");
Route::get("/don/adgr/edit/{id}","DonADGRController@edit");
Route::post("/don/adgr/update/{id}","DonADGRController@update");
Route::post("/don/adgr/store/","DonADGRController@store");


//Dons externes:
Route::get("/don/externe/delete/{id}","DonExterneController@destroy");
Route::get("/don/externe/edit/{id}","DonExterneController@edit");
Route::post("/don/externe/update/{id}","DonExterneController@update");
Route::post("/don/externe/store/","DonExterneController@store");


//Contre indications:
Route::get("/contreIndication/","ContreIndicationController@index");
Route::get("/contreIndication/create","ContreIndicationController@create");
Route::post("/contreIndication/store","ContreIndicationController@store");
Route::get("/contreIndication/edit/{id}", "ContreIndicationController@edit");
Route::post("/contreIndication/update/{id}", "ContreIndicationController@update");
Route::get("/contreIndication/delete/{id}","ContreIndicationController@destroy");


//donneurContreIndication
Route::post("/donneurContreIndication/store/{id}","donneurContreIndicationController@store");
Route::get("/donneurContreIndication/delete/{id}","donneurContreIndicationController@destroy");



//-------- Gestion fincancière ---------
//Comptes:
Route::get("/compte","ComptesController@index");
Route::get("/compte/delete/{id}", "ComptesController@destroy");
Route::get("/compte/create", "ComptesController@create");
Route::post("/compte/store", "ComptesController@store");
Route::get("/compte/edit/{id}", "ComptesController@edit");
Route::post("/compte/update/{id}", "ComptesController@update");
Route::get("/compte/show/{id}", "ComptesController@show");
Route::post("transfert/store", "TransfertController@store");



//Entrées:
Route::get("/entrees","EntreesController@index");
Route::get("/entrees/create","EntreesController@create");
Route::post("/entrees/store","EntreesController@store");
Route::get("/entrees/edit/{id}","EntreesController@edit");
Route::post("/entrees/update/{id}","EntreesController@update");
Route::get("/entrees/delete/{id}","EntreesController@destroy");



//Dépenses:
Route::get("/depense", "DepensesController@index");
Route::get("/depense/create", "DepensesController@create");
Route::post("/depense/store", "DepensesController@store");
Route::get("/depense/edit/{id}", "DepensesController@edit");
Route::post("/depense/update/{id}", "DepensesController@update");
Route::get("/depense/delete/{id}", "DepensesController@destroy");


//Evenements:
Route::get("/evenement", "EventsController@index");
Route::get("/evenement/create", "EventsController@create");
Route::post("/evenement/store", "EventsController@store");
Route::get("/evenement/edit/{id}","EventsController@edit");
Route::post("/evenement/update/{id}", "EventsController@update");
Route::get("/evenement/delete/{id}", "EventsController@destroy");

//Bénévoles:
Route::get("/benevole", "BenevoleController@index")->name("benevole");
Route::get("/benevole/create", "BenevoleController@create");
Route::post("/benevole/store", "BenevoleController@store");
Route::get("/benevole/edit/{id}", "BenevoleController@edit");
Route::post("/benevole/update/{id}", "BenevoleController@update");
Route::get("/benevole/delete/{id}", "BenevoleController@destroy");
Route::get("/benevole/show/{id}", "BenevoleController@show");
Route::get("/benevole/printlist","BenevoleController@export_all_pdf");
Route::get("/benevole/printable/{id}","BenevoleController@export_pdf");
Route::get("/benevole/showprintlist",function(){
    return view("pages.benevole.printlist");
});

//BenevoleEquipe:
Route::get("/benevoleEquipe/delete/{id}","benevoleEquipeController@destroy");

//Equipes:
Route::get("/equipe", "EquipeController@index");
Route::get("/equipe/create", "EquipeController@create");
Route::post("/equipe/store","EquipeController@store");
Route::get("/equipe/edit/{id}","EquipeController@edit");
Route::post("/equipe/update/{id}","EquipeController@update");
Route::get("/equipe/delete/{id}","EquipeController@destroy");
Route::get("/equipe/show/{id}","EquipeController@show");


//----------- AJAX handlers ---------------
Route::get("/getAllCenters", "ajaxHandlers@getAllCenters");//Tous les centres
Route::get("/getZones/{id}", "ajaxHandlers@getZones");//Toutes les zones d'une ville
Route::get("/getAllCities","ajaxHandlers@getAllCities");//Toutes les villes
Route::post("/cinTest", "ajaxHandlers@CINtest");//Tester l'existence d'un CIN dans "donneurs"
Route::get("/accountLogs/{id}", "ajaxHandlers@accountLogs"); //Les journaux d'un compte
Route::get("/benevole/changeState", "ajaxHandlers@changeState"); //Changer l'etat d'activite d'un bénévole
Route::get("/expensesByCat/{id}", "ajaxHandlers@expensesByCat");
Route::post("/search", "ajaxHandlers@advancedSearch");

//Authentification:
//Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/login',"Auth\BenevoleLoginController@showLoginForm")->name("benevole.login");
Route::post('/login',"Auth\BenevoleLoginController@login")->name("benevole.login.submit");
Route::get("/logout", "Auth\BenevoleLoginController@logout")->name("benevole.logout");


//Comités
Route::get("/comite", "ComiteController@index");
Route::get("/comite/create", "ComiteController@create");
Route::post("/comite/store", "ComiteController@store")->name("comite.store");
Route::get("/comite/edit/{id}", "ComiteController@edit");
Route::post("/comite/update/{id}", "ComiteController@update");
Route::get("/comite/delete/{id}", "ComiteController@destroy");
Route::get("/comite/show/{id}","ComiteController@show");


//ComiteEvenement
Route::post("/comiteEvent/create", "ComiteEvenementController@store")->name("comiteEv.store");
Route::get("/comiteEvent/delete/{id}", "ComiteEvenementController@destroy");



//Appels Telephoniques
Route::get("/appelTelephonique", "appelTelephoniqueController@index");
Route::get("/appelTelephonique/create", "appelTelephoniqueController@create");
Route::post("/appelTelephonique/store", "appelTelephoniqueController@store");
Route::get("/appelTelephonique/edit/{id}", "appelTelephoniqueController@edit");
Route::post("/appelTelephonique/update/{id}", "appelTelephoniqueController@update");
Route::get("/appelTelephonique/delete/{id}", "appelTelephoniqueController@destroy");

//Messages:
Route::get("/message", "MessageController@index");
Route::get("/message/create", "MessageController@create");
Route::post("/message/store", "MessageController@store");
Route::get("/message/delete/{id}", "MessageController@destroy");
Route::get("/message/show/{id}", "MessageController@show");
Route::get("/message/edit/{id}", "MessageController@edit");
Route::post("/message/update/{id}", "MessageController@update");
Route::post("/message/answer/{id}", "MessageController@answer");
Route::get("/message/answer/delete/{id}", "MessageController@deleteAnswer");
Route::get("/message/answer/edit/{id}", "MessageController@editAnswer");

Route::get("/printablecollecte/{id}",function($id){
    return view("pages.collecte.printable")->with("id", $id);
});

Route::post("/donsParGroupeSanguin", "ajaxHandlers@donsParGroupeSanguin");
Route::post("/donsParZone", "ajaxHandlers@donsParZone");

Route::post("/search", "ajaxHandlers@rechercheAvancee");
Route::post("/isapte", "ajaxHandlers@isApte");
Route::post("/nbreDonneursParGroupe", "ajaxHandlers@nbreDonneursParGroupe");
Route::post("/nbreDonneursParAptitude", "ajaxHandlers@nbreDonneursParAptitude");
Route::post("/eventsStats", "ajaxHandlers@eventsStats");