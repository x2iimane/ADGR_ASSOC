<?php

namespace App\Http\Controllers;

use App\Benevole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use PDF;

class BenevoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
            $this->middleware("auth:benevole");
    }

    public function index()
    {
        if(Auth::user()->role->id != 1 && Auth::user()->role->id != 2){
            return redirect()->to("/");
        }
        $benevoles = Benevole::paginate(10);
        return view("pages.Benevole.index")->with("benevoles", $benevoles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role->id != 1 && Auth::user()->role->id != 2){
            return redirect()->to("/");
        }
        return view("pages.Benevole.create");
    }


    public function export_pdf($id)
    {
        $benevole = Benevole::find($id); //Chargement des informations depuis la base de données
        $pdf = PDF::loadView('pages.benevole.printable', $benevole ); //Envoi des informations à la vue concernée
        return $pdf->download($benevole ->nom.$benevole ->prenom.time().'.pdf');
    }

    public function export_all_pdf(){
        $pdf = PDF::loadView("pages.benevole.printlist");
        return $pdf->download("ListeBenevoles.pdf");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "nom" => "required",
            "prenom" => "required",
            "CIN" => "required|unique:benevoles",
            "tele" => "required",
            "dateNaissance" => "required",
            "adresse" => "required",
            "email" => "required|email|unique:benevoles",
            "sexe" => "required",
            "dateAdhesion" => "required",
            "username" => "required|unique:benevoles",
            "password" => "required|min:6",
            "etatCivil" => "required",
            ]);
        $benevole = new Benevole();
        $benevole->nom = $request->input("nom");
        $benevole->prenom = $request->input("prenom");
        $benevole->CIN = $request->input("CIN");
        $benevole->tele = $request->input("tele");
        $benevole->teleSec = $request->input("teleSec");
        $benevole->dateNaissance = $request->input("dateNaissance");
        $benevole->adresse = $request->input("adresse");
        $benevole->zone_id = $request->input("zone_id");
        $benevole->x = 0;
        $benevole->y = 0;
        $benevole->email = $request->input("email");
        $benevole->profession = $request->input("profession");
        $benevole->sexe = $request->input("sexe");
        $benevole->dateAdhesion = $request->input("dateAdhesion");
        $benevole->username = $request->input("username");
        $benevole->password = bcrypt($request->input("password"));
        $benevole->etat = true;
        $benevole->etat_civil = $request->input("etatCivil");
        $benevole->droitAcces = false;
        $benevole->role_id = $request->input("role");
        $benevole->save();
        if($request->file("photo")){
            $filename = $benevole->id.".".$request->file("photo")->getClientOriginalExtension();
            $request->file("photo")->storeAs("public/profilePhotos/benevoles",$filename);
        }
        return Redirect::to('/benevole');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->role->id != 1 && Auth::user()->role->id != 2 && Auth::user()->id != $id){
            return redirect()->to("/");
        }
        return view("pages.Benevole.show")->with("id", $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->role->id != 1 && Auth::user()->role->id != 2 && (Auth::user()->id != $id && !Auth::guard("benevole")->check())){
            return redirect()->to("/");
        }
        return view("pages.benevole.edit")->with("id", $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            "nom" => "required",
            "prenom" => "required",
            "CIN" => "required|unique:benevoles",
            "tele" => "required",
            "dateNaissance" => "required",
            "adresse" => "required",
            "email" => "required|email|unique:benevoles",
            "sexe" => "required",
            "dateAdhesion" => "required",
            "username" => "required|unique:benevoles",
            "password" => "required|min:6",
            "etatCivil" => "required",
        ]);

        $benevole = Benevole::find($id);
        $benevole->nom = $request->input("nom");
        $benevole->prenom = $request->input("prenom");
        $benevole->CIN = $request->input("CIN");
        $benevole->tele = $request->input("tele");
        $benevole->teleSec = $request->input("teleSec");
        $benevole->dateNaissance = $request->input("dateNaissance");
        $benevole->adresse = $request->input("adresse");
        $benevole->x = 0;
        $benevole->y = 0;
        $benevole->email = $request->input("email");
        $benevole->profession = $request->input("profession");
        $benevole->sexe = $request->input("sexe");
        $benevole->dateAdhesion = $request->input("dateAdhesion");
        $benevole->username = $request->input("username");
        $benevole->password = $request->input("password");
        $benevole->etat = true;
        $benevole->etat_civil = $request->input("etatCivil");
        $benevole->droitAcces = false;
        $benevole->save();
        if($request->file("photo")){
            $filename = $benevole->id.".".$request->file("photo")->getClientOriginalExtension();
            $request->file("photo")->storeAs("public/profilePhotos/benevoles",$filename);
        }
        return Redirect::to('/benevole');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Benevole::find($id)->delete();
        Storage::delete("public/profilePhotos/benevoles/".$id.".jpg");
        return response($id);
    }
}
