<?php

namespace App\Http\Controllers;

//use Barryvdh\DomPDF\PDF;
use App\collecte;
use Illuminate\Http\Request;
use PDF;

class collecteController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:benevole");
    }
    public function index(){
        return view("pages.collecte.index");
    }

    public function export_all_pdf(){
        $pdf = PDF::loadView("pages.collecte.printlist");
        return $pdf->download("ListeDonneurs.pdf");
    }

    public function export_pdf($id){
        $collecte = collecte::find($id);
        $pdf = PDF::loadView("pages.collecte.printable", $collecte);
        return $pdf->download("Collecte.pdf");
    }

    public function show($id)
    {
        return view("pages.collecte.printable")->with("id", $id);
    }
    public function create(){
//        $centres = \App\Centre::all();
        return view("pages.collecte.nouvelleCollecte");
    }
}
