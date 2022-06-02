<?php

namespace App\Http\Controllers;

use App\accountLog;
use App\Compte;
use App\Entree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EntreesController extends Controller
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
        return view("pages.GestionFinanciere.Entrees.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("pages.GestionFinanciere.Entrees.create");
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
//            "compte" => "required",
//            "montant" => "required",
//            "source" => "required",
//        ]);

        $entree=  new Entree();
        $entree->compte_id = $request->input("compte");
        $compte = Compte::find($entree->compte_id);
        $entree->source = $request->input("source");
        $entree->montant = $request->input("montant");
        $entree->remarque= $request->input("remarque");
        $log = new accountLog();
        $compte->depos($entree->montant);
        $compte->save();
        $entree->save();
        return Redirect::to("/compte/show/".$compte->id);
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
        return view("pages.GestionFinanciere.Entrees.edit")->with("id",$id);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $entree = Entree::find($id);
        $entree->delete();
        return Redirect::to("/entrees");
    }
}
