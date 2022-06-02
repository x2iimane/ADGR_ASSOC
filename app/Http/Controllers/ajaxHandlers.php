<?php

namespace App\Http\Controllers;

use App\Benevole;
use App\categorieDepense;
use App\Centre;
use App\collecte;
use App\collecteFixe;
use App\Compte;
use App\Donneur;
use App\Evenement;
use App\groupeSanguin;
use App\Ville;
use App\Zone;
use Doctrine\DBAL\Schema\Schema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ajaxHandlers extends Controller
{
    public function CINTest(Request $request){
        return count(\App\Donneur::all()->where("CIN",$request->CIN));
    }
    public function getAllCities(){
        return json_encode(Ville::all());
    }
    public function getZones($id){
        return json_encode(Ville::find($id)->zone);
    }
    public function getAllCenters(){
        return json_encode(Centre::all());
    }
    public function accountLogs($id){
        $compte = Compte::find($id);
        return json_encode($compte->logs);
    }
    public function changeState(Request $request){
        $benevole = Benevole::find($request->idBenevole);
        $benevole->etat = $request->etat;
        $benevole->save();
    }
    public function expensesByCat($id){
        $compte = Compte::find($id);
        $expensesByCat = array();
        foreach(categorieDepense::all() as $cat){
            $myobj = ["cat_id"=>$cat->libelle, "cat_amount"=> count($compte->depenses()->get()->where("categorie_depense_id", "=", $cat->id))];
            array_push($expensesByCat, $myobj);
        }
        return json_encode($expensesByCat);
    }
    public function advancedSearch(Request $request){
        if($request->recherche != "") {
            if ($request->motCle == "donneur"){
                if($request->option == "") {
                    $donneurq = Donneur::where("nom", "like", "%" . $request->recherche . "%")
                        ->orWhere("prenom", "like", "%" . $request->recherche . "%")
                        ->orWhere("dateNaissance", "like", "%" . $request->recherche . "%")
                        ->orWhere("email", "like", "%" . $request->recherche . "%")
                        ->orWhere("username", "like", "%" . $request->recherche . "%")
                        ->orWhere("CIN", "like", "%" . $request->recherche . "%")->get();
                }else{
                    $donneurq = Donneur::where($request->option, "like", "%" . $request->recherche . "%")->get();
                }
                return response(json_encode($donneurq));
            } elseif ($request->motCle == "benevole") {
                if($request->option == ""){
                    $benevoles = Benevole::where("nom", "like", "%" . $request->recherche . "%")
                        ->orWhere("prenom", "like", "%" . $request->recherche . "%")
                        ->orWhere("dateNaissance", "like", "%" . $request->recherche . "%")
                        ->orWhere("email", "like", "%" . $request->recherche . "%")
                        ->orWhere("username", "like", "%" . $request->recherche . "%")
                        ->orWhere("CIN", "like", "%" . $request->recherche . "%")->get();
                }else{
                    $benevoles = Benevole::where($request->option, "like", "%" . $request->recherche . "%")->get();
                }
                return response(json_encode($benevoles));
            }
        }
    }
    public function isApte(Request $request){
        $donneur = Donneur::find($request->id);
        $aptitude = $donneur->isApte()?"true":"false";
        return response()->json($donneur->isApte());
    }
    public function getProchainDon(Request $request){
        $donneur = Donneur::find($request->id);
        return response($donneur->getProchainDon()->format("d-m-Y"));
    }
    public function donsParGroupeSanguin(Request $request){
        $collecte = collecte::find($request->collecte_id);
        $dons = $collecte->dons()->get();
        $groupesSanguins = groupeSanguin::all();
        $reponse = array();
        foreach($groupesSanguins as $gs){
            $c = 0;
            foreach($dons as $don){
                if($don->donneur->groupeSanguin->id == $gs->id){
                    $c++;
                }
            }
            array_push($reponse, [
                "libelle" => $gs->libelle.$gs->rhesus,
                "nombre" => $c,
            ]);
        }
        return json_encode($reponse);

    }
    public function donsParZone(Request $request){
        $collecte = collecte::find($request->collecte_id);
        $dons = $collecte->dons()->get();
//        return $collecte->collecte->centre->zone->ville->id;
        $zones = $collecte->typeCollecte==1?Zone::where("ville_id", "=", $collecte->collecte->centre->zone->ville->id)->get():Zone::where("ville_id", "=", $collecte->collecte->zone->ville->id)->get();
        $reponse = array();
        foreach($zones as $zone){
            $c = 0;
            foreach($dons as $don){
                if($don->donneur->zone->id == $zone->id){
                    $c++;
                }
            }
            array_push($reponse, [
                "zone" => $zone->libZone,
                "nombre" => $c,
            ]);
        }
        return json_encode($reponse);

    }
    public function rechercheAvancee(Request $request){
        $donneur = Donneur::where("donneurs.id","!=","0")
            ->join("zones","donneurs.zone_id", "=", "zones.id")
            ->join("villes", "zones.ville_id", "=", "villes.id")
            ->join("groupe_sanguins", "donneurs.groupe_sanguin_id", "=", "groupe_sanguins.id")
            ->select("groupe_sanguins.*", "zones.*", "villes.*","donneurs.*");
        if($request->nom != ""){
            $donneur = $donneur->where("nom","like","%" . $request->nom . "%");
        }
        if($request->prenom != ""){
            $donneur = $donneur->where("prenom", "like", "%".$request->prenom."%");
        }
        if($request->cin != ""){
            $donneur = $donneur->where("CIN", "like", "%".$request->cin."%");
        }
        if($request->groupe != ""){
            $donneur = $donneur->where("groupe_sanguin_id", "=", $request->groupe);
        }
        if($request->ville != ""){
            $donneur = $donneur->where("villes.id", "=", $request->ville);
        }
        return response(json_encode($donneur->get()));
    }
    public function nbreDonneursParGroupe(Request $request){
        $reponse = array();
        foreach(groupeSanguin::all() as $gs){
            $c = 0;
            if($request->ville != ""){
                foreach ($gs->donneur as $d){
                    if($d->zone->ville->id == $request->ville)$c++;
                }
                array_push($reponse, [
                    "libelleGroupe" => $gs->libelle.$gs->rhesus,
                    "nombre" => $c,
                ]);
            }else{
                array_push($reponse, [
                    "libelleGroupe" => $gs->libelle.$gs->rhesus,
                    "nombre" => $gs->donneur()->count(),
                ]);
            }
        }
        return response(json_encode($reponse));
    }
    public function nbreDonneursParAptitude(Request $request){
        if($request->ville == ""){
            $reponse = array();
            $nbreAptes = 0;
            $nbreInaptes = 0;
            foreach(Donneur::all() as $donneur){
                if($donneur->isApte())$nbreAptes++;
                else $nbreInaptes++;
            }
            array_push($reponse, [
                "Aptes" => $nbreAptes,
                "Inaptes" => $nbreInaptes,
            ]);
            return response(json_encode($reponse));
        }else{
            $reponse = array();
            $nbreAptes = 0;
            $nbreInaptes = 0;
            foreach(Donneur::all() as $donneur){
                if($donneur->zone->ville->id == $request->ville){
                    if($donneur->isApte())$nbreAptes++;
                    else $nbreInaptes++;
                }
            }
            array_push($reponse, [
                "Aptes" => $nbreAptes,
                "Inaptes" => $nbreInaptes,
            ]);
            return response(json_encode($reponse));
        }
    }
    public function eventsStats(){
        $reponse = array();
        $evenements = Evenement::all();
        foreach ($evenements as $ev) {
            foreach (collecte::all()->sortBy("date") as $collecte) {
                if ($collecte->evenement->id == $ev->id) {
                    array_push($reponse, [
                        "date" => $collecte->collecte->date,
                        "dons" => $collecte->dons()->count(),
                        "appelsTelephoniques" => $ev->appelTelephonique()->count(),
                        "presence" => $collecte->collecte->nombre_presents,
                    ]);
                }
            }
        }
        return response(json_encode($reponse));
    }
}
