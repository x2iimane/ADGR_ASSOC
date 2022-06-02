<?php

namespace App\Http\Controllers;

use App\donneurContreIndication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class donneurContreIndicationController extends Controller
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
    public function store(Request $request, $id)
    {
        $this->validate($request, [
            "contre_indication_id" => "required",
            "dateDebut"=>"required"
        ]);
        $dci = new donneurContreIndication();
        $dci->donneur_id = $id;
        $dci->contre_indication_id = $request->input("contre_indication_id");
        $dci->dateDebut = $request->input("dateDebut");
        $dci->save();
        return Redirect::to("/donneur/show/$id");
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
        $dci = donneurContreIndication::find($id);
        $dci->delete();
        return Redirect::to("/donneur");
    }
}
