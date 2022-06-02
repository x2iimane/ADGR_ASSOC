<?php

namespace App\Http\Controllers;

use App\Compte;
use App\Transfert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TransfertController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
//            "compte1" => "required",
//            "compte2" => "required",
//            "montant" => "required"
//        ]);
        $source = Compte::find($request->input("compte1"));
        $destination = Compte::find($request->input("compte2"));
        $montant = $request->input("montant");
        if($montant > 0){
            $source->retrait($montant);
            $destination->depos($montant);
            $source->save();
            $destination->save();
            $transfert = new Transfert();
            $transfert->compte1_id = $source->id;
            $transfert->compte2_id = $destination->id;
            $transfert->montant = $montant;
            $transfert->save();
        }
        return Redirect::to("/compte/show/".$transfert->source->id);
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
        //
    }
}
