<?php

namespace App\Http\Controllers;

use App\Benevole;
use App\benevoleEquipe;
use App\Equipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class EquipeController extends Controller
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
        return view("pages.Equipe.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("pages.Equipe.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $this->validate($request, [
            "evenement" => "required",
            "membres" => "required",
            "responsable" => "required"
        ]);

        $equipe = new Equipe();
        $equipe->responsable_id = $request->input("responsable");
        $equipe->evenement_id = $request->input("evenement");
        $equipe->save();
        $membres = $request->input("membres");
        foreach($membres as $membre){
            $benevoleEquipe = new benevoleEquipe();
            $benevoleEquipe->benevole_id = $membre;
            $benevoleEquipe->equipe_id = $equipe->id;
            $benevoleEquipe->save();
        }
        return Redirect::to("/equipe");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view("pages.Equipe.show")->with("id",$id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view("pages.Equipe.edit")->with("id",$id);
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
            "evenement" => "required",
            "membres" => "required",
            "responsable" => "required"
        ]);

        $equipe = Equipe::find($id);
        $equipe->responsable_id = $request->input("responsable");
        $equipe->evenement_id = $request->input("evenement");
        $equipe->save();
        $membres = $request->input("membres");
        foreach(benevoleEquipe::all()->where("equipe_id", $equipe->id) as $be){
            $existe = false;
            foreach($membres as $membre){
                if($membre == $be->benevole->id){
                    $existe = true;
                }
            }
            if(!$existe){
                $be->delete();
            }
        }
        foreach($membres as $membre){
            if(benevoleEquipe::all()->where("benevole_id", "=", $membre)->where("equipe_id", "=", $equipe->id)->count() == 0){
                $benevoleEquipe = new benevoleEquipe();
                $benevoleEquipe->benevole_id = $membre;
                $benevoleEquipe->equipe_id = $equipe->id;
                $benevoleEquipe->save();
            }
        }
        return Redirect::to("/equipe");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Equipe::find($id)->delete();

        return Redirect::to("/equipe");
    }
}
