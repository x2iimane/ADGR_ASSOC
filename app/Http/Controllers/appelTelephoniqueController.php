<?php

namespace App\Http\Controllers;

use App\appelTelephonique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class appelTelephoniqueController extends Controller
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
        $appels = appelTelephonique::paginate(10);
        return view("pages.appelTelephonique.index")->with("appels", $appels);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("pages.appelTelephonique.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $this->validate($request, [
//            "nom" => "required",
//            "prenom" => "required",
//            "tele" => "required",
//            "reponse" => "required",
//            "benevole" => "required",
//        ]);
        $reponses = $request->reponses;
        $donneurs = $request->donneursAppeles;
        $i = 0;
        $appels = array();
        foreach($donneurs as $donneur){
            array_push($appels, ["Donneur" => $donneur, "Reponse" => $reponses[$i++]]);
        }
        foreach($appels as $appel){
            $nvlAppel = new appelTelephonique();
            $nvlAppel->reponse = $appel["Reponse"];
            $nvlAppel->donneur_id = $appel["Donneur"];
            $nvlAppel->benevole_id = Auth::user()->id;
            $nvlAppel->evenement_id = $request->evenement;
            $nvlAppel->save();
        }
        return redirect()->to("/appelTelephonique");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view("pages.appelTelephonique.edit")->with("id", $id);
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
            "tele" => "required",
            "reponse" => "required",
            "benevole" => "required",
        ]);
        $appel = appelTelephonique::find($id);
        $appel->nom = $request->input("nom");
        $appel->prenom = $request->input("prenom");
        $appel->tele = $request->input("tele");
        $appel->reponse = $request->input("reponse");
        $appel->benevole_id = $request->input("benevole");
        $appel->save();
        return redirect()->to("/appelTelephonique");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        appelTelephonique::find($id)->delete();
        return redirect()->to("/appelTelephonique");
    }
}
