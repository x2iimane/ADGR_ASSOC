<?php

namespace App\Http\Controllers;

use App\accountLog;
use App\depense;
use App\Compte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DepensesController extends Controller
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
        return view("pages.GestionFinanciere.Depenses.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("pages.GestionFinanciere.Depenses.create");
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
            'compte' => "required",
            'event' => "required",
            'montant' => 'required',
            "motif" => "required",
        ]);

        $depense = new depense();
        $depense->compte_id = $request->input("compte");
        $compte = Compte::find($depense->compte_id);
        $depense->Evenement_id = $request->input("event");
        $depense->montant = $request->input("montant");
        $depense->categorie_depense_id = $request->input("categorie");
        $depense->motif = $request->input("motif");
        $depense->remarque = $request->input("remarque");
        $compte->retrait($depense->montant);
        $compte->save();
        $depense->save();
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
        //
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
        $depense = depense::find($id);
        $depense->delete();
        return Redirect::to("/depense");
    }
}
