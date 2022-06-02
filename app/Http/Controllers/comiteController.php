<?php

namespace App\Http\Controllers;

use App\benevoleComite;
use App\Comite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class comiteController extends Controller
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
        return view("pages.Comite.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("pages.Comite.create");
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
            "membres" => "required",
            "responsable" => "required"
        ]);

        $comite = new Comite();
        $comite->responsable_id = $request->input("responsable");
        $comite->libelle = $request->input("libelle");
        $comite->save();
        $membres = $request->input("membres");
        foreach($membres as $membre){
            $benevoleC = new benevoleComite();
            $benevoleC->benevole_id = $membre;
            $benevoleC->comite_id = $comite->id;
            $benevoleC->save();
        }
        return Redirect::to("/comite");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view("pages.Comite.show")->with("id", $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view("pages.Comite.edit")->with("id", $id);
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
            "membres" => "required",
            "responsable" => "required"
        ]);

        $comite = Comite::find($id);
        $comite->responsable_id = $request->input("responsable");
        $comite->save();
        $membres = $request->input("membres");
        foreach(benevoleComite::all() as $bc){
            $existe = false;
            foreach($membres as $membre){
                if($membre == $bc->benevole->id){
                    $existe = true;
                }
            }
            if(!$existe){
                $bc->delete();
            }
        }
        foreach($membres as $membre){
            if(benevoleComite::all()->where("benevole_id", "=", $membre)->where("comite_id", "=", $comite->id)->count() == 0){
                $benevoleComite = new benevoleComite();
                $benevoleComite->benevole_id = $membre;
                $benevoleComite->comite_id = $comite->id;
                $benevoleComite->save();
            }
        }
        return redirect()->to("/comite");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comite = Comite::find($id);
        $comite->delete();
        return redirect()->to("/comite");
    }

}
