<?php

namespace App\Http\Controllers;

use App\donExterne;
use App\Donneur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DonExterneController extends Controller
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
        //
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
                "donneur"=>"required",
                "dateDon" => "required",
                "raison" => "required"
            ]
        );
        $donneur = Donneur::find($request->donneur);
        if($donneur->isApte()) {
            $don = new donExterne();
            $don->date = $request->input("dateDon");
            $don->donneur_id = $request->input("donneur");
            $don->raison = $request->input("raison");
            $donneur = Donneur::find($don->donneur_id);
            $donneur->dateDernierDon = $don->date;
            $donneur->save();
            $don->save();
            return Redirect::to("/donneur/show/" . $don->donneur_id)->with("success", "Don externe ajouté !");
        }
        return Redirect::to("/donneur/show/" . $request->donneur)->with("error", "Donneur inapte !");
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
        $don = donExterne::find($id);
        $donneur = Donneur::find($don->donneur_id);
        $don->delete();
        return Redirect::to("/donneur/show/".$donneur->id);
    }
}
