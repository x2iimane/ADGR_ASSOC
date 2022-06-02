<?php

namespace App\Http\Controllers;

use App\Bureau;
use App\BureauVille;
use App\Ville;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class VilleController extends Controller
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
        if(Auth::user()->role->id != 1)return redirect("/");
        return view("pages.ville.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role->id != 1)return redirect("/");
        return view("pages.ville.nouvelleVille");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->role->id != 1)return redirect("/");
        $this->validate($request, [
            'libVille' => "required|unique:villes",
            'bureau' => 'required'
        ]);
        $ville = new Ville();
        $ville->libVille = $request->input("libVille");
        $ville->save();
        $bureauville = new BureauVille();
        $bureauville->bureau_id = $request->bureau;
        $bureauville->ville_id = $ville->id;
        $bureauville->save();
        return redirect("/ville");
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
        if(Auth::user()->role->id != 1)return redirect("/");
        return view("pages.ville.modifierVille")->with("idVille", $id);
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
        if(Auth::user()->role->id != 1)return redirect("/");
        $ville = Ville::find($id);
        $ville->libVille = $request->input("libVille");
        $ville->save();
        foreach(BureauVille::All()->where("ville_id", "=", $id) as $bureau){
            $bureau->delete();
        }
        $bv = new BureauVille();
        $bv->bureau_id = $request->bureau;
        $bv->ville_id = $ville->id;
        $bv->save();
        return Redirect::to("/ville");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->role->id != 1)return redirect("/");
        Ville::find($id)->delete();
        return response($id);
    }
}
