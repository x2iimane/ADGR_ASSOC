<?php

namespace App\Http\Controllers;

use App\collecte;
use App\collecteMobile;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;

class collecteMobileController extends Controller
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

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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

        $this->validate($request,
            [
                "libCollecte"=>"required",
                "dateCollecte"=>"required",
                "lieuCollecte"=>"required",
                "zone_id"=>"required",
            ]);
        $collecte = new collecteMobile();
        $collecte->libCollecte = $request->input("libCollecte");
        $collecte->date = $request->input("dateCollecte");
        $collecte->x = 0;
        $collecte->y = 0;
        $collecte->lieu = $request->input("lieuCollecte");
        $collecte->zone_id = $request->input("zone_id");
        $collecte->nombre_presents = $request->input("nombre_presents");
        $collecte->nombre_contre_indiques = $request->input("nombre_contre_indiques");
        $collecte->save();
        $collecte2 = new collecte();
        $collecte2->collecte_id = $collecte->id;
        $collecte2->typeCollecte = 0;
        $collecte2->save();
        return view("pages.collecte.nouvelleCollecte")->with(["sucess"=>true]);
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
        return view("pages.collecte.modifierCollecteMobile")->with("idCollecte",$id);
    }
    public function update(Request $request, $id)
    {
        $collecte = collecteMobile::find($id);
        $collecte->libCollecte = $request->input("libCollecte");
        $collecte->date = $request->input("dateCollecte");
        $collecte->lieu= $request->input("lieuCollecte");
        $collecte->zone_id= $request->input("zone_id");
        $collecte->nombre_presents = $request->input("nombre_presents");
        $collecte->nombre_contre_indiques = $request->input("nombre_contre_indiques");
        $collecte->save();
        return Redirect::to("/collecte");

    }

    public function destroy($id)
    {
        collecteMobile::find($id)->delete();
        return Redirect::to("/collecte");
    }
}
