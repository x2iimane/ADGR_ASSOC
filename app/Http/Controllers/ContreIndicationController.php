<?php

namespace App\Http\Controllers;

use App\contreIndication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ContreIndicationController extends Controller
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
        return view("pages.contreIndications.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role->id != 1 && Auth::user()->role->id != 2 && Auth::user()->role->id != 4){
            return redirect()->to("/");
        }
        return view("pages.contreIndications.create");
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
            'nom' => 'required',
        ]);

        $ci = new ContreIndication;
        $ci->nom = $request->input('nom');
        if($request->input("duree") != null) $ci->duree = $request->input('duree');
        $ci->type = $request->input("type");
        $ci->unite = $request->input("unite");
        $ci->save();
        return Redirect::to("/contreIndication");
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
        if(Auth::user()->role->id != 1 && Auth::user()->role->id != 2 && Auth::user()->role->id != 4){
            return redirect()->to("/");
        }
        return view("pages.contreIndications.edit")->with("id", $id);
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
            'nom' => 'required',
        ]);

        $ci = ContreIndication::find($id);
        $ci->nom = $request->input('nom');
        $ci->type = $request->input("type");
        if($ci->type == 'definitive'){
            $ci->duree = null;
            $ci->unite = null;
        }else{
            $ci->duree = $request->input('duree');
            $ci->unite = $request->input('unite');
        }
        $ci->save();

        return redirect('/contreIndication')->with('success', 'Contre-indication mise à jour');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->role->id == 1 || Auth::user()->role->id == 2 || Auth::user()->role->id == 4){
            contreIndication::find($id)->delete();
        }
        return response($id);
    }
}
