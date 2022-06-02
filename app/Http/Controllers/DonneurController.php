<?php

namespace App\Http\Controllers;

use App\Carte;
use App\Donneur;
use FontLib\EOT\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PDF;


class DonneurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware("auth:donneur,benevole");
    }

    public function export_pdf($id)
    {
        $donneur = Donneur::find($id); //Chargement des informations depuis la base de données
        $pdf = PDF::loadView('pages.donneurs.printable', $donneur); //Envoi des informations à la vue concernée
        return $pdf->download($donneur->nom.$donneur->prenom.time().'.pdf');
    }

    public function export_all_pdf(){
        $pdf = PDF::loadView("pages.donneurs.printlist");
        return $pdf->download("ListeDonneurs.pdf");
    }
    public function index()
    {
        if(!Auth::guard("benevole")->check())return redirect()->to("/");
        $donneurs = Donneur::paginate(10);
        return view("pages.donneurs.index")->with("donneurs", $donneurs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function listeAptes(){
        if(Auth::guard("benevole")->check()){
            if(Auth::user()->role->id == 1 || Auth::user()->role->id == 2){
                return view("pages.donneurs.listeAptes");
            }
        }
        return redirect("/");
    }

    public function printListeAptes(){
        $pdf = PDF::loadView("pages.donneurs.printlistaptes");
        return $pdf->download("listeAptes.pdf");
    }


    public function create()
    {
        if(!Auth::guard("benevole")->check()){
            return redirect()->to("/");
        }else{
            if(Auth::user()->role->id != 1 && Auth::user()->role->id != 2){
                return redirect()->to("/");
            }
        }
        return view("pages.donneurs.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file("photo");
        $this->validate($request, [
            'nom' => 'required',
            'prenom' => 'required',
            'cin' => 'required|unique:donneurs',
            'numeroTelephone' => 'required',
            'groupe' => 'required',
            'username' => 'required|unique:benevoles',
            "password" => "required",
        ]);
        $donneur = new Donneur();
        $donneur->nom = $request->input('nom');
        $donneur->prenom = $request->input('prenom');
        $donneur->CIN = $request->input('cin');
        $donneur->numeroTelephone = $request->input('numeroTelephone');
        $donneur->numeroTelephoneSecondaire = $request->input('numeroTelephoneSecondaire');
        $donneur->dateNaissance = $request->input('dateNaissance');
        $donneur->adresse = $request->input('adresse');
        $donneur->email = $request->input('email');
        $donneur->profession = $request->input('profession');
        $donneur->sexe = $request->input('sexe');
        $donneur->etat = $request->input('etat');
        $donneur->groupe_sanguin_id = $request->input('groupe');
        $donneur->dateDernierDon = $request->input('dateDernierDon');
        $donneur->etat_civil_id = $request->input('etatCivil');
        $donneur->nombreEnfants = $request->input('nombreEnfants');
        if ($request->type) {
            $donneur->type = 1;
        } else {
            $donneur->type = 0;
        }
        $donneur->x = 0;
        $donneur->y = 0;
        $donneur->username = $request->input("username");
        $donneur->password = bcrypt($request->input("password"));
        $donneur->remarque = $request->input('remarque');
        $donneur->zone_id = $request->input('zone_id');
        $donneur->moyenAdhesion = $request->input("moyen");
        $donneur->save();
        if($request->file("photo")){
            $filename = $donneur->id. "." .$file->getClientOriginalExtension();
            $file->storeAs("public/profilePhotos/donneurs/", $filename);
        }
        return redirect('/donneur')->with('success', 'Donneur ajouté');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $donneur = Donneur::find($id);
        if(!Auth::guard("benevole")->check()){
            if(Auth::user()->id != $id){
                return redirect()->to("/");
            }
        }else{
            if(Auth::user()->role->id != 1 && Auth::user()->role->id != 2 && Auth::user()->role->id != 4){

                return redirect()->to("/");
            }else{
                if(Auth::user()->role->id != 1){
                    if(Auth::user()->zone->ville->id != $donneur->zone->ville->id){
                        return redirect()->to("/");
                    }
                }
            }
        }
        return view("pages.donneurs.show")->with("id", $id);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::guard("benevole")->check()){
            return redirect()->to("/");
        }else{
            if(Auth::user()->role->id != 1 && Auth::user()->role->id != 2){
                return redirect()->to("/");
            }
        }
        return view("pages.donneurs.edit")->with("id", $id);
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
            'nom' => 'required',
            'prenom' => 'required',
            'numeroTelephone' => 'required',
            'groupe' => 'required',
        ]);

        $donneur = Donneur::find($id);
        $donneur->nom = $request->input('nom');
        $donneur->prenom = $request->input('prenom');
        $donneur->CIN = $request->input('cin');
        $donneur->numeroTelephone = $request->input('numeroTelephone');
        $donneur->numeroTelephoneSecondaire = $request->input('numeroTelephoneSecondaire');
        $donneur->dateNaissance = $request->input('dateNaissance');
        $donneur->adresse = $request->input('adresse');
        $donneur->email = $request->input('email');
        $donneur->profession = $request->input('profession');
        $donneur->sexe = $request->input('sexe');
        $donneur->etat = $request->input('etat');
        $donneur->groupe_sanguin_id = $request->input('groupe');
        $donneur->dateDernierDon = $request->input('dateDernierDon');
        $donneur->etat_civil_id = $request->input('etatCivil');
        $donneur->nombreEnfants = $request->input('nombreEnfants');
        if($request->type){
            $donneur->type = 1;
        }else{
            $donneur->type = 0;
        }
        $donneur->x = 0;
        $donneur->y = 0;
        $donneur->username = $request->input("username");
        if($request->password != ""){
            $donneur->password = bcrypt($request->input("password"));
        }
        $donneur->remarque = $request->input('remarque');
        $donneur->zone_id = $request->input('zone_id');
        $donneur->save();
        return redirect('/donneur')->with('success', 'Donneur ajouté');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Auth::guard("benevole")->check()){
            return redirect()->to("/");
        }else{
            if(Auth::user()->role->id != 1 && Auth::user()->role->id != 2){
                return redirect()->to("/");
            }
        }

        $donneur = Donneur::find($id);
        Storage::delete("public/profilePhotos/donneurs/".$donneur->id.".jpg");
        $donneur->delete();
        return response($id);
    }
}
