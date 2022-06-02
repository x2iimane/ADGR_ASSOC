<?php

namespace App\Http\Controllers;

use App\collecte;
use App\collecteFixe;
use App\collecteMobile;
use App\Evenement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EventsController extends Controller
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
        return view("pages.Evenements.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("pages.Evenements.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $event = new Evenement();
        $event->libelle = $request->input("libelle");
        $event->type_event_id = $request->input("typeEvent");
        $event->date_debut = $request->input("dateDebut");
        $event->date_fin =  $request->input("dateFin");
        $event->save();
        if($event->type_event_id == "1"){
            if($request->input("typeCollecte") == 'f'){
                $collecte = new collecteFixe();
                $collecte->libCollecte = $request->input("libCollecte");
                $collecte->date = $event->date_debut;
                $collecte->centre_id = $request->input("centre");
                $collecte->save();
                $collecte2 = new collecte();
                $collecte2->collecte_id = $collecte->id;
                $collecte2->typeCollecte = 1;
                $collecte2->Evenement_id = $event->id;
                $collecte2->save();
            }else{
                $collecte = new collecteMobile();
                $collecte->libCollecte = $request->input("libCollecte");
                $collecte->date = $event->date_debut;
                $collecte->x = 0;
                $collecte->y = 0;
                $collecte->lieu = $request->input("lieuCollecte");
                $collecte->zone_id = $request->input("zone");
                $collecte->save();
                $collecte2 = new collecte();
                $collecte2->collecte_id = $collecte->id;
                $collecte2->typeCollecte = 0;
                $collecte2->Evenement_id = $event->id;
                $collecte2->save();
            }
        }
        return Redirect::to("/evenement");
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
        return view("pages.Evenements.edit")->with("id", $id);
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
        $event = Evenement::find($id);
        $event->libelle = $request->input("libelle");
        $event->type_event_id = $request->input("typeEvent");
        $event->date_debut = $request->input("dateDebut");
        $event->date_fin =  $request->input("dateFin");
        $event->save();
        return \redirect("/evenement");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Evenement::find($id)->delete();
        return view("pages.Evenements.index");
    }
}
