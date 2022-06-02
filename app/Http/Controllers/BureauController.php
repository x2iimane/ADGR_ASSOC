<?php

namespace App\Http\Controllers;

use App\Bureau;
use App\BureauVille;
use App\Ville;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class BureauController extends Controller
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
        $bureaux = Bureau::paginate(5);
        return view("pages.bureau.index")->with("bureaux", $bureaux);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=-1)
    {
        if(Auth::user()->role->id != 1 && Auth::user()->role->id != 2) return redirect()->to("/");
        return view("pages.bureau.nouveauBureau")->with("idVille", $id);
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
            "responsable"=>"required",
            "villes" => "required",
            "dateCreation"=>"required",
        ]);
        $bureau = new Bureau();
        $bureau->responsable_id = $request->input("responsable");
        $bureau->dateCreation = $request->input("dateCreation");
        $bureau->save();
        foreach($request->villes as $ville){
            $BV = new BureauVille();
            $BV->ville_id = $ville;
            $BV->bureau_id = $bureau->id;
            $BV->save();
        }
        return Redirect::to("/bureau");
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
        return view("pages.bureau.modifierBureau")->with("idBureau", $id);
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
        $this->validate($request,[
            "villes"=>"required",
            "dateCreation"=>"required"
        ]);
        $bureau = Bureau::find($id);
        $bureau->dateCreation = $request->input("dateCreation");
        $bureau->save();
        $villes = $request->input("villes");
        foreach($villes as $ville){
            $BV = new BureauVille();
            $BV->ville_id = $ville;
            $BV->bureau_id = $bureau->id;
            $BV->save();
        }
        return Redirect::to("/bureau");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bureau = Bureau::find($id);
        $bureau->delete();
        return response($id);
    }
}
