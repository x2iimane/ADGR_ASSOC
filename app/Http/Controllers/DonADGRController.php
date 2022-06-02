<?php

namespace App\Http\Controllers;

use App\donAdgr;
use App\Donneur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DonADGRController extends Controller
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

    public function index($id)
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("pages.dons.create");
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
//            'collecte' => 'required',
//            'typeCollecte' => 'required',
//            'donneur_id' => 'required',
//            'dateDon' => 'required',
//        ]);

        $donneur = Donneur::find($request->donneur);
        if($donneur->isApte()) {
            $don = new donAdgr();
            $don->collecte_id = $request->input('collecte');
            $don->donneur_id = $request->input('donneur');
//            $don->dateDon = $request->input('dateDon');
            $don->save();
            $donneur = Donneur::find($don->donneur_id);
            $donneur->dateDernierDon = $don->collecte->collecte->date;
            $donneur->save();
            return Redirect::to("/donneur/show/".$request->donneur)->with("success", "Don ADGR ajouté !");
        }
        return Redirect::to("/donneur/show/".$request->donneur)->with("error", "Donneur inapte !");
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
        return view("pages.dons.edit")->with("typeDon","ADGR")->with("id", $id);
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $don = donAdgr::find($id);
        $donneur = Donneur::find($don->donneur_id);
        $don->delete();
        return Redirect::to("/donneur/show/".$donneur->id);
    }
}
