<?php
    if(isset($id)){
        $compte = \App\Compte::find($id);
    }
?>
@extends("layouts.app")

@section("title", "Compte")

@section("content")
    <div class="container-fluid">
        <div class="row">
                <div class="col-md-6">
                    <div class="well">
                        <b>ID compte: </b> {{$compte->id}}<br>
                        <b>Libelle: </b> {{$compte->libelle}}<br>
                        <b>Type: </b> <?php $type = $compte->type==0?"Secondaire":"Principal"; ?> {{$type}} <br>
                        <b>Solde: </b> {{$compte->solde}}
                    </div>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-success" data-toggle="modal" data-target="#ajouterEntree">Nouvelle entrée</button><br><br>
                    <div class="modal fade" id="ajouterEntree" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title" id="myModalLabel">Nouvelle entrée</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="/entrees/store" method="post" id="nouvelleEntree">
                                        {{csrf_field()}}
                                        <input type="hidden" value="{{$compte->id}}" name="compte">
                                        <label for="montant">Montant</label>
                                        <input id="montant" name="montant" type="number" min="0" placeholder="montant" class="form-control"><br>
                                        <label for="source">Source</label>
                                        <input type="text" name="source" id="source" class="form-control"><br>
                                        <label for="remarque">Remarque</label>
                                        <input type="text" name="remarque" id="remarque" class="form-control"><br>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                    <button type="button" class="btn btn-primary" onclick="document.getElementById('nouvelleEntree').submit()">Ajouter</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#ajouterDepense">Nouvelle dépense</button><br>
                    <div class="modal fade" id="ajouterDepense" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title" id="myModalLabel">Nouvelle dépense</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="/depense/store" method="post" id="nouvelleDepense">
                                        {{csrf_field()}}
                                        <input type="hidden" value="{{$compte->id}}" name="compte">
                                        <label for="event">Evènement</label>
                                        <select name="event" id="event" class="form-control">
                                            @foreach(\App\Evenement::all() as $evenement)
                                                <option value="{{$evenement->id}}">{{$evenement->libelle}}</option>
                                            @endforeach
                                        </select><br>

                                        <label for="montant">Montant</label>
                                        <input type="number" name="montant" min="0" id="montant" class="form-control"><br>

                                        <label for="motif">Motif</label>
                                        <input type="text" name="motif" id="motif" class="form-control"><br>

                                        <label for="remarque">Remarque</label>
                                        <input type="text" name="remarque" id="remarque" class="form-control"><br>

                                        <label for="categorie">Catégorie</label>
                                        <select name="categorie" id="categorie" class="form-control">
                                            @foreach(\App\categorieDepense::all() as $categorie)
                                                <option value="{{$categorie->id}}">{{$categorie->libelle}}</option>
                                            @endforeach
                                        </select><br>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                    <button type="button" class="btn btn-primary" onclick="document.getElementById('nouvelleDepense').submit()">Ajouter</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <br><button class="btn btn-info" data-toggle="modal" data-target="#transfertArgent">Transfert d'argent</button><br>
                    <div class="modal fade" id="transfertArgent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title" id="myModalLabel">Transfert</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="/transfert/store" method="post" id="nouveauTransfert">
                                        {{csrf_field()}}
                                        <input type="hidden" name="compte1" value="{{$compte->id}}">
                                        <label>Compte: </label> {{$compte->libelle}}
                                        <input type="text" name="montant" class="form-control" placeholder="montant"><br>
                                        <select name="compte2" class="form-control">
                                            @foreach(\App\Compte::all()->where("id","!=",$compte->id) as $cpt)
                                                <option value="{{$cpt->id}}">{{$cpt->libelle}}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                    <button type="button" class="btn btn-primary" onclick="document.getElementById('nouveauTransfert').submit()">Transférer</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3>Journaux</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Basic Tabs
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#graphic" data-toggle="tab" aria-expanded="true">Représentation graphique</a>
                            </li>
                            <li class=""><a href="#list" data-toggle="tab" aria-expanded="false">Liste</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="graphic">
                                <h4>Représentation graphique</h4>
                                <div id="journaux-compte">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="list">
                                <h4>Liste</h4>
                                    <div class="panel-body">
                                        <div class="panel-group" id="accordion">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" class="collapsed">Entrées</a>
                                                    </h4>
                                                </div>
                                                <div id="collapseOne" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                                    <div class="panel-body">
                                                        <table width="100%" class="table table-striped table-bordered table-hover dataTables-example">
                                                            <thead>
                                                                <tr>
                                                                    <th>Source</th>
                                                                    <th>Montant</th>
                                                                    <th>Remarque</th>
                                                                    <th>Date</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                    @foreach($compte->entrees as $entree)
                                                                        <tr>
                                                                            <td>{{$entree->source}}</td>
                                                                            <td>{{$entree->montant}} DH</td>
                                                                            <td>{{$entree->remarque}}</td>
                                                                            <td>{{$entree->created_at}}</td>
                                                                        </tr>
                                                                    @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed" aria-expanded="false">Dépenses</a>
                                                    </h4>
                                                </div>
                                                <div id="collapseTwo" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                                    <div class="panel-body">
                                                        <table width="100%" class="table table-striped table-bordered table-hover dataTables-example">
                                                            <thead>
                                                            <tr>
                                                                <th>Evenement</th>
                                                                <th>Montant</th>
                                                                <th>Categorie</th>
                                                                <th>Date</th>
                                                                <th>Motif</th>
                                                                <th>Remarque</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($compte->depenses as $depense)
                                                                    <tr>
                                                                        <td>{{$depense->evenement->libelle}}</td>
                                                                        <td>{{$depense->montant}} DH</td>
                                                                        <td>{{$depense->categorie->libelle}}</td>
                                                                        <td>{{$depense->created_at}}</td>
                                                                        <td>{{$depense->motif}}</td>
                                                                        <td>{{$depense->remarque}}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="collapsed" aria-expanded="false">Transferts</a>
                                                    </h4>
                                                </div>
                                                <div id="collapseThree" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                                    <div class="panel-body">
                                                        <b>Entrants:</b>
                                                        <table width="100%" class="table table-striped table-bordered table-hover dataTables-example">
                                                            <thead>
                                                            <tr>
                                                                <th>De</th>
                                                                <th>Montant</th>
                                                                <th>Date</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($compte->transfertsEntrants as $transfert)
                                                                <tr>
                                                                    <td><a href="/compte/show/{{$transfert->source->id}}">{{$transfert->source->libelle}}</a></td>
                                                                    <td>{{$transfert->montant}} DH</td>
                                                                    <td>{{$transfert->created_at}}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table><br>
                                                        <b>Sortants</b>
                                                        <table width="100%" class="table table-striped table-bordered table-hover dataTables-example">
                                                            <thead>
                                                            <tr>
                                                                <th>Vers</th>
                                                                <th>Montant</th>
                                                                <th>Date</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($compte->transfertsSortants as $transfert)
                                                                <tr>
                                                                    <td><a href="/compte/show/{{$transfert->destination->id}}">{{$transfert->destination->libelle}}</a></td>
                                                                    <td>{{$transfert->montant}} DH</td>
                                                                    <td>{{$transfert->created_at}}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
        </div>
    </div>
    <script src="{{asset("js/jquery.js")}}"></script>
    <script>
        $(document).ready(function(){
            $.ajax({
                url:"/accountLogs/{{$compte->id}}",
                success:function(data){
                    let j = JSON.parse(data);
                    let myObj = [];
                    for(let i in j){
                        // alert(j[i]["solde"]);
                        myObj.push({
                            date: j[i]["created_at"],
                            solde: j[i]["solde"],
                        });
                    }
                    console.log(myObj);
                    Morris.Area({
                        element: 'journaux-compte',
                        data: myObj,
                        xkey: 'date',
                        ykeys: ['solde'],
                        labels: ['solde'],
                        pointSize: 2,
                        hideHover: 'auto',
                        resize: true,
                        smooth: false
                    });
                },
                error:function(){
                    console.log("error");
                }
            });
        });
    </script>
@endsection
