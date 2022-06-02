@extends("layouts.app")
<?php
    if(isset($id)){
        $donneur = \App\Donneur::find($id);
    }
?>
@section("title", $donneur->nom. " ". $donneur->prenom)
@section("content")
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                @if(file_exists("/storage/profilePhotos/donneurs/{{$donneur->id}}.jpg"))
                    <a href="/storage/profilePhotos/donneurs/{{$donneur->id}}.jpg"><img src="/storage/profilePhotos/donneurs/{{$donneur->id}}.jpg" width="100%"></a>
                @else
                    @if($donneur->sexe == "Homme")
                        <a href="/storage/profilePhotos/man.jpg"><img src="/storage/profilePhotos/man.jpg" width="80%"></a>
                    @else
                        <a href="/storage/profilePhotos/woman.jpg"><img src="/storage/profilePhotos/woman.jpg" width="100%"></a>
                    @endif
                @endif
            </div>
            <div class="col-md-9">
                <div class="well">
                    <b>Nom et prénom:</b> {{$donneur->nom}} {{$donneur->prenom}}
                    @if($donneur->isApte())

                        <span class="btn btn-success">Apte</span>
                    @else
                        <span class="btn btn-danger" data-toggle="modal" data-target="#inaptitude">Inapte</span>
                        <div class="modal fade" id="inaptitude" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h4 class="modal-title" id="myModalLabel">Inapte !</h4>
                                    </div>
                                    <div class="modal-body">
                                        @if($donneur->getProchainDon() != null)
                                            @if($donneur->getProchainDon() != new DateTime("01-01-2000"))
                                                <b>Inaptitude provisoire !</b><br>
                                                <?php
                                                    $idContreI = 0;
                                                    $prochain2 = new \DateTime(Date("01-01-2000"));
                                                    $donneurContreIndications = $donneur->donneurContreIndications()->get();
                                                    foreach ($donneurContreIndications as $dci) {
                                                        if($dci->contreIndication->type != "definitive"){
                                                            $dateFin = new \DateTime($dci->dateFin()->format("d-m-Y"));
                                                            if ($dateFin > $prochain2) {
                                                                $idContreI = $dci->contreIndication->id;
                                                                $prochain2 = $dateFin;
                                                            }
                                                        }

                                                    }
                                                    if($idContreI != 0){
                                                        echo "<b>Contre indication : </b>".\App\contreIndication::find($idContreI)->nom."<br>";
                                                    }else{
                                                        echo "<b>Cause: </b> Dérnier don<br>";
                                                    }
                                                ?>
                                                <b>Date du prochain don :</b> {{$donneur->getProchainDon()->format("d-m-Y")}}
                                            @else
                                                <b>Inaptitude définitive !</b><br>
                                                <b>Cause: </b>
                                                @if($donneur->getAge() >= 63)
                                                    Age
                                                @else
                                                    <?php
                                                        $donneurContreIndications = $donneur->donneurContreIndications()->get();
                                                        foreach($donneurContreIndications as $dci){
                                                            if($dci->contreIndication->type == "definitive"){
                                                                echo $dci->contreIndication->nom."<br>";
                                                            }
                                                        }
                                                    ?>
                                                @endif
                                            @endif
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                    @endif
                    <br>
                    <b>Email: </b> {{$donneur->email}}<br>
                    <b>Date de naissance:</b> {{$donneur->dateNaissance}}<br>
                    <b>Groupe sanguin:</b> {{$donneur->groupeSanguin->libelle.$donneur->groupeSanguin->rhesus}}<br>
                    <b>Dernier don: </b>{{$donneur->dateDernierDon}}<br>
                    @if(isset($donneur->carte))
                        <b>Etat de la carte: </b>
                        @if($donneur->carte->etatCarte == 1)
                            <div>
                                <p>
                                    <strong>Conçue</strong>
                                    <span class="pull-right text-muted">33% Complete</span>
                                </p>
                                <div class="progress progress-striped active">
                                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" style="width: 33%">
                                        <span class="sr-only">33% Complete</span>
                                    </div>
                                </div>
                            </div>

                        @elseif($donneur->carte->etatCarte == 2)
                            <div>
                                <p>
                                    <strong>Imprimée</strong>
                                    <span class="pull-right text-muted">66% Complete</span>
                                </p>
                                <div class="progress progress-striped active">
                                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100" style="width: 66%">
                                        <span class="sr-only">66% Complete</span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div>
                                <p>
                                    <strong>Livrée</strong>
                                    <span class="pull-right text-muted">100% Complete</span>
                                </p>
                                <div class="progress progress-striped active">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                        <span class="sr-only">100% Complete</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(Auth::guard("benevole")->check())
                            @if(Auth::user()->role->id == 1 || Auth::user()->role->id == 2)
                                <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    Modifier l'état de la carte
                                </button>
                            @endif
                        @endif
                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h4 class="modal-title" id="myModalLabel">Modifier l'état de la carte</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="/carte/update/{{$donneur->carte->id}}" method="post" id="modifierCarte">
                                            {{csrf_field()}}
                                            <label for="etatCarte">Etat de la carte</label>
                                            <select id="etatCarte" name="etatCarte" class="form-control">
                                                <option value="1">Conçue</option>
                                                <option value="2">Imprimée</option>
                                                <option value="3">Livrée</option>
                                            </select><br>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                        <button type="button" class="btn btn-primary" onclick="document.getElementById('modifierCarte').submit()">Modifier</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                    @else
                        Aucune carte <br>
                        @if(Auth::guard("benevole")->check())
                            @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                                <form  action="/carte/store" method="post">
                                    {{csrf_field()}}
                                    <input type="hidden" name="donneur_id" value={{$donneur->id}}>
                                    <input type="submit" class="btn btn-primary" value="Créer une carte">
                                </form>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Basic Tabs
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#home" data-toggle="tab" aria-expanded="true">Détails</a>
                            </li>
                            <li class=""><a href="#profile" data-toggle="tab" aria-expanded="false">Dons</a>
                            </li>
                            <li class=""><a href="#messages" data-toggle="tab" aria-expanded="false">Contre indications</a>
                            </li>
                            <li class=""><a href="#contact" data-toggle="tab" aria-expanded="false">Contact</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="home">
                                <h4>Détails des informations</h4>
                                <table class="table-striped table-bordered" width="50%">
                                    <tr>
                                        <td>CIN</td>
                                        <td>{{$donneur->CIN}}</td>
                                    </tr>
                                    <tr>
                                        <td>Date de naissance</td>
                                        <td> {{$donneur->dateNaissance}}</td>
                                    </tr>
                                    <tr>
                                        <td>Sexe</td>
                                        <td>{{$donneur->sexe}}</td>
                                    </tr>
                                    <tr>
                                        <td>Profession</td>
                                        <td>{{$donneur->profession}}</td>
                                    </tr>
                                    <tr>
                                        <td>Adresse</td>
                                        <td>{{$donneur->adresse}}</td>
                                    </tr>
                                    <tr>
                                        <td>Etat civil</td>
                                        <td>
                                            {{$donneur->etatCivil->libelle}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nombre d'enfants</td>
                                        <td>{{$donneur->nombreEnfants}}</td>
                                    </tr>
                                    <tr>
                                        <td>email</td>
                                        <td>{{$donneur->email}}</td>
                                    </tr>
                                    <tr>
                                        <td>Moyen d'adhesion</td>
                                        <td> {{$donneur->moyenAdhesion}}</td>
                                    </tr>
                                    <tr>
                                        <td>Remarque(s)</td>
                                        <td>{{$donneur->remarque}}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="profile">
                                <h4>Dons</h4>
                                <input type="radio" id="btnDonsTOUS" name="typeDon" checked><label for="btnDonsTOUS">Tous les dons</label>
                                <input type="radio" id="btnDonsADGR" checked name="typeDon"><label for="btnDonsADGR">Dons ADGR</label>
                                <input type="radio" id="btnDonsExternes" name="typeDon"><label for="btnDonsExternes">Dons Externes</label>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Dons
                                        @if(\Illuminate\Support\Facades\Auth::guard("benevole")->check())
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#ajouterDon">
                                            <i class="glyphicon glyphicon-plus"></i>Ajouter un don
                                        </button>
                                        <div class="modal fade" id="ajouterDon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h4 class="modal-title" id="ajouterDonLabel"><i class="glyphicon glyphicon-plus"></i> Ajouter un don</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                            <input type="radio" name="type" id="donADGR" checked><label for="donADGR">Don ADGR</label>
                                                            <input type="radio" name="type" id="donExt"><label for="donExt">Don externe</label>
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div id="donADGRDiv">
                                                                        <form action="/don/adgr/store" method="post" id="ajouterDonADGRForm">
                                                                            {{csrf_field()}}
                                                                            <label for="collecte">Collecte</label>
                                                                            <select id="collecte" name="collecte" class="form-control">
                                                                                @foreach(App\collecteFixe::all() as $collecte)
                                                                                    <option value="{{$collecte->id}}">{{$collecte->libCollecte}}</option>
                                                                                @endforeach
                                                                            </select><br>
                                                                            <input type="hidden" name="donneur" value="{{$donneur->id}}">
                                                                            <input type="hidden" name="typeCollecte" value="0">
                                                                        </form>
                                                                    </div>
                                                                    <div id="donExtDiv" style="display:none">
                                                                        <form action="/don/externe/store" method="post" id="ajouterDonExterneForm">
                                                                            {{csrf_field()}}
                                                                            <input type="hidden" name="donneur" value="{{$donneur->id}}">
                                                                            <input type="hidden" name="typeCollecte" value="1">
                                                                            <label for="dateDon">Date du don</label>
                                                                            <input type="date" name="dateDon" class="form-control" id="dateDon"><br>

                                                                            <label for="raison">Raison du don</label>
                                                                            <input type="text" name="raison" class="form-control" id="raison"><br>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                                        <button type="button" class="btn btn-primary" id="btnSubmit">Ajouter</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            @endif
                                    </div>
                                <!-- /.panel-heading -->
                                    <div class="panel-body" id="donsADGR">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Date du don</th>
                                                    <th>Collecte</th>
                                                    <th>Type de collecte</th>
                                                    <th>Donneur</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($donneur->donsADGR as $don)
                                                    <tr>
                                                        <td>{{$don->collecte->collecte->date}}</td>
                                                        <td>{{$don->collecte->collecte->libCollecte}}</td>
                                                        @if($don->typeCollecte == 1)
                                                            <td>Fixe</td>
                                                        @else
                                                            <td>Mobile</td>
                                                        @endif
                                                        <td>{{$donneur->nom . " " . $donneur->prenom}}</td>
                                                        <td>
                                                            <a href="/don/adgr/delete/{{$don->id}}"><span class=" btn btn-warning btn-circle btn-md glyphicon glyphicon-remove removeCollecte"></span></a>
                                                            <a href="/don/adgr/edit/{{$don->id}}"><span class=" btn btn-default btn-circle btn-md glyphicon glyphicon-pencil"></span></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.table-responsive -->
                                    </div>
                                    <!-- /.panel-body -->
                                    <div class="panel-body" id="donsExternes" style="display:none;">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Date du don</th>
                                                        <th>Raison</th>
                                                        <th>Donneur</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($donneur->donsExternes as $don)
                                                        <tr>
                                                            <td>{{$don->date}}</td>
                                                            <td>{{$don->raison}}</td>
                                                            <td>{{$donneur->nom . " " . $donneur->prenom}}</td>
                                                            <td>
                                                                <a href="/don/externe/delete/{{$don->id}}"><span class=" btn btn-warning btn-circle btn-md glyphicon glyphicon-remove removeCollecte"></span></a>
                                                                <a href="/don/externe/edit/{{$don->id}}"><span class=" btn btn-default btn-circle btn-md glyphicon glyphicon-pencil"></span></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.table-responsive -->
                                    </div>
                                    <div class="panel-body" id="donsTOUS" style="display:none;">
                                        <h3>Dons Externes</h3>
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Date du don</th>
                                                    <th>Raison</th>
                                                    <th>Donneur</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($donneur->donsExternes as $don)
                                                    <tr>
                                                        <td>{{$don->date}}</td>
                                                        <td>{{$don->raison}}</td>
                                                        <td>{{$donneur->nom . " " . $donneur->prenom}}</td>
                                                        <td>
                                                            <a href="/don/externe/delete/{{$don->id}}"><span class=" btn btn-warning btn-circle btn-md glyphicon glyphicon-remove removeCollecte"></span></a>
                                                            <a href="/don/externe/edit/{{$don->id}}"><span class=" btn btn-default btn-circle btn-md glyphicon glyphicon-pencil"></span></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <h3>Dons ADGR</h3>
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Date du don</th>
                                                    <th>Collecte</th>
                                                    <th>Type de collecte</th>
                                                    <th>Donneur</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($donneur->donsADGR as $don)
                                                    <tr>
                                                        <td>{{$don->collecte->collecte->date}}</td>
                                                        <td>{{$don->collecte->collecte->libCollecte}}</td>
                                                        @if($don->typeCollecte == 1)
                                                            <td>Fixe</td>
                                                        @else
                                                            <td>Mobile</td>
                                                        @endif
                                                        <td>{{$donneur->nom . " " . $donneur->prenom}}</td>
                                                        <td>
                                                            <a href="/don/adgr/delete/{{$don->id}}"><span class=" btn btn-warning btn-circle btn-md glyphicon glyphicon-remove removeCollecte"></span></a>
                                                            <a href="/don/adgr/edit/{{$don->id}}"><span class=" btn btn-default btn-circle btn-md glyphicon glyphicon-pencil"></span></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.table-responsive -->
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="messages">
                                <h4>Contre indications</h4>
                                <!-- Modal -->
                                <div class="modal fade" id="contreIndication" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title" id="myModalLabel">Ajouter une contre indication</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form action="/donneurContreIndication/store/{{$donneur->id}}" method="post" id="ajouterContreIndication">
                                                    {{csrf_field()}}
                                                    <label for="contre_indication_id">Contre indication</label>
                                                    <select id="contre_indication_id" name="contre_indication_id" class="form-control">
                                                        @foreach(\App\contreIndication::All() as $ci)
                                                            <option value={{$ci->id}}>{{$ci->nom}}</option>
                                                        @endforeach
                                                    </select>
                                                    <label for="dateDebut">Date de début</label>
                                                    <input type="date" name="dateDebut" id="dateDebut" class="form-control">
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary" onclick="document.getElementById('ajouterContreIndication').submit()">Ajouter</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div><br>
                                @if(count(App\donneurContreIndication::all()->where("donneur_id", $donneur->id))>0)
                                    <table width="100%" class="table-striped table-hover">
                                        <thead>
                                            <th>Libelle</th>
                                            <th>Duree</th>
                                            <th>Date debut</th>
                                            <th>Date fin</th>
                                            <th>type</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            @foreach(App\donneurContreIndication::all()->where("donneur_id", $donneur->id) as $dci)
                                                <tr>
                                                    <td>{{$dci->contreIndication->nom}}</td>
                                                    <?php
                                                        $unite = "jours";
                                                        if($dci->contreIndication->unite == "j"){
                                                            $unite = "jours";
                                                        }elseif($dci->contreIndication->unite == "m"){
                                                            $unite = "mois";
                                                        }elseif($dci->contreIndication->unite == "a"){
                                                            $unite = "ans";
                                                        }else{
                                                            $unite = "-";
                                                        }
                                                        $duree = $dci->contreIndication->duree!=null?$dci->contreIndication->duree:"-";
                                                    ?>
                                                    <td>{{$duree. " " . $unite}}</td>
                                                    <td>{{$dci->dateDebut}}</td>
                                                    @if(!(is_string($dci->dateFin())))
                                                        <td>{{$dci->dateFin()->format("Y-m-d")}}</td>
                                                    @else
                                                        <td>-------</td>
                                                    @endif
                                                    @if($dci->contreIndication->type == "definitive")
                                                        <td>Définitive</td>
                                                    @else
                                                        <td>Provisoire</td>
                                                    @endif
                                                    <td><a href="/donneurContreIndication/delete/{{$dci->id}}">Supprimer</a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="alert alert-success">
                                        Pas de contre indications !
                                    </div>
                                @endif
                                @if(Auth::guard("benevole")->check())
                                    @if(Auth::user()->role->id == 1 || Auth::user()->id == 2 || Auth::user()->role->id == 4)
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#contreIndication">
                                            Ajouter
                                        </button>
                                    @endif
                                @endif
                            </div>
                            <div class="tab-pane fade" id="contact">
                                <h4>Moyens de contact : </h4>
                                <table class="table-striped table-bordered" width="50%">
                                    <tr>
                                        <td><label>Numéro de téléphone :</label></td>
                                        <td>{{$donneur->numeroTelephone}}</td>
                                    </tr>
                                    <tr>
                                        <td><label>Numéro de téléphone secondaire :</label></td>
                                        <td>{{$donneur->numeroTelephoneSecondaire}}</td>
                                    </tr>
                                    <tr>
                                        <td><label>Adresse e-mail :</label></td>
                                        <td>{{$donneur->email}}</td>
                                    </tr>
                                    <tr>
                                        <td><label>Adresse :</label></td>
                                        <td>{{$donneur->adresse}}</td>
                                    </tr>
                                    <tr>
                                        <td><label>Ville :</label></td>
                                        <td>{{$donneur->zone->ville->libVille}}</td>
                                    </tr>
                                    <tr>
                                        <td><label>Zone :</label></td>
                                        <td>{{$donneur->zone->libZone}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset("/js/jquery.js")}}">
    </script>
    <script>
        $(document).ready(function(){
           $("#btnDonsADGR").on("change", function(){
                $("#donsExternes").fadeOut();
                $("#donsTOUS").fadeOut();
                $("#donsADGR").delay(400).fadeIn();
            });
            $("#btnDonsExternes").on("change", function(){
                $("#donsADGR").fadeOut();
                $("#donsTOUS").fadeOut();
                $("#donsExternes").delay(400).fadeIn();
            });
            $("#btnDonsTOUS").on("change", function(){
                $("#donsADGR").fadeOut();
                $("#donsExternes").fadeOut();
                $("#donsTOUS").delay(400).fadeIn();
            });

            $("#btnSubmit").click(function(){
                $("#ajouterDonADGRForm").submit()
            });

            $("#donADGR").on("change",function(){
                $("#donExtDiv").fadeOut();
                $("#donADGRDiv").delay(400).fadeIn();
                $("#btnSubmit").click(function(){
                    $("#ajouterDonADGRForm").submit()
                });
            });
            $("#donExt").on("change",function(){
                $("#donADGRDiv").fadeOut();
                $("#donExtDiv").delay(400).fadeIn();
                $("#btnSubmit").click(function(){
                    $("#ajouterDonExterneForm").submit()
                });
            });
        })
    </script>
@endsection
