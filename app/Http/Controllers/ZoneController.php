<?php

namespace App\Http\Controllers;

use App\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ZoneController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:benevole");
    }

    public function index($idVille=-1)
    {
        if (Auth::user()->role->id != 1){
            if(Auth::user()->role->id == 2) {
                    return view("pages.Zone.index")->with("idVille", Auth::user()->zone->ville->id);
            }else{
                return \redirect("/");
            }
        }
        return view("pages.Zone.index")->with("idVille", $idVille);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($idVille)
    {
        return view("pages.Zone.nouvelleZone")->with("idVille",$idVille);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $this->validate($request,[
//            "libZone"=>"required",
//            "codePostal" =>'required',
//            "ville_id"=>'required'
//        ]);
        $zone = new Zone();
        $zone->libZone = $request->input("libZone");
        $zone->codePostal = $request->input("codePostal");
        $zone->ville_id = $request->input("ville_id");
        $zone->save();
        return Redirect::to("/ville");
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
        return view("pages.zone.modifierZone")->with("idZone", $id);
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
        $zone = Zone::find($id);
        $zone->libZone = $request->input("libZone");
        $zone->ville_id = $request->input("ville_id");
        $zone->codePostal = $request->input("codePostal");
        $zone->save();
        return Redirect::to("/zone/". $zone->ville_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $zone = Zone::find($id);
        $ville = $zone->ville->id;
        $zone->delete();
        return Redirect::to("/zone/". $ville);
    }
}
