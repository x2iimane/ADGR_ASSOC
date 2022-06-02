<?php

namespace App\Http\Controllers;

use App\Centre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CentreController extends Controller
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
        $centres = Centre::paginate(10);
        return view("pages.centre.index")->with("centres", $centres);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("pages.centre.nouveauCentre");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            "adresse" => "required",
            ]);
        $centre = new Centre();
        $centre->adresse = $request->input("adresse");
        $centre->x = 0;
        $centre->y = 0;
        $centre->libCentre = $request->input("libCentre");
        $centre->zone_id = $request->input("zone_id");
        $centre->save();

        return Redirect::to("/centre");
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
        return view("pages.centre.modifierCentre")->with("idCentre", $id);
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
        $centre = Centre::find($id);
        $centre->adresse = $request->input("adresse");
        $centre->libCentre = $request->input("libCentre");
        $centre->zone_id = $request->input("zone_id");
        $centre->save();
        return Redirect::to("/centre");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Centre::find($id)->delete();
        return response($id);
    }
}
