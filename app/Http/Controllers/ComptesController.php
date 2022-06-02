<?php

namespace App\Http\Controllers;

use App\accountLog;
use App\Compte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ComptesController extends Controller
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
        return view("pages.GestionFinanciere.Comptes.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("pages.GestionFinanciere.Comptes.create");
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
            "libelle" => "required",
            "type" => "required"
        ]);
        $compte = new Compte();
        $compte->libelle = $request->input("libelle");
        $compte->type = $request->input("type");
        if($request->input("solde") != ""){
            $compte->solde = $request->input("solde");
        }else{
            $compte->solde = 0;
        }
        $compte->save();
        $log = new accountLog();
        $log->compte_id = $compte->id;
        $log->date = date("Y-m-d");
        $log->solde = $compte->solde;
        $log->save();
        return Redirect::to("/compte");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view("pages.GestionFinanciere.Comptes.show")->with("id", $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view("pages.GestionFinanciere.Comptes.edit")->with("idCompte", $id);
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
        $compte = \App\Compte::find($id);
        $compte->libelle = $request->input("libelle");
        $compte->type = $request->input("type");
        $compte->save();
        return Redirect::to("/compte");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $compte = \App\Compte::find($id);
        $compte->delete();
        return Redirect::to("/compte");
    }


    public function transfert(Request $request){
        $id_cpt1 = $request->input("compte1");
        $id_cpt2 = $request->input("compte2");
        $montant = $request->input("montant");
        $compte1 = Compte::find($id_cpt1);
        $compte2 = Compte::find($id_cpt2);
        if($montant > 0 && $montant <= $compte1->solde){
            $compte1->retrait($montant);
            $compte2->depos($montant);
            $compte1->save();
            $log = new accountLog();
            $log->compte_id = $compte1->id;
            $log->date = date("Y-m-d");
            $log->solde = $compte1->solde;
            $log->save();
            $compte2->save();
            $log = new accountLog();
            $log->compte_id = $compte2->id;
            $log->date = date("Y-m-d");
            $log->solde = $compte2->solde;
            $log->save();
        }
        return Redirect::to("/compte/show/".$compte1->id);
    }

}
