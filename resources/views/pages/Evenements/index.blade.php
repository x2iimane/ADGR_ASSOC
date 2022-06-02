@extends("layouts.app")
@section("title", "Evénements")
@section("content")
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-9">
                        Comptes
                    </div>
                    <div class="col-md-3">
                        <a href="/evenement/create"><button class="btn btn-primary"> <span class="glyphicon glyphicon-plus"></span> Ajouter un événement</button></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <table width="100%" class="table table-striped">
                <thead>
                <tr>
                    <th>Libelle</th>
                    <th>Type</th>
                    <th>Date début</th>
                    <th>Date fin</th>
                    <th>Responsable</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    $evenements = App\Evenement::paginate(10);
                ?>
                @foreach($evenements as $evenement)
                    <tr>

                        <td>{{$evenement->libelle}}</td>
                        <td>
                            <?php
                                $type = \App\TypeEvent::find($evenement->type_event_id)->libelle;
                                echo $type;
                            ?>
                        </td>
                        <td>{{$evenement->date_debut}}</td>
                        <td>{{$evenement->date_fin}}</td>
                        <td>
                            @if($evenement->equipe)
                                <a href="/benevole/show/{{$evenement->equipe->responsable->id}}">{{$evenement->equipe->responsable->nom ." ". $evenement->equipe->responsable->prenom}}</a>
                            @elseif($evenement->comiteEvenement)
                                <a href="/benevole/show/{{$evenement->comiteEvenement->comite->responsable->id}}">{{$evenement->comiteEvenement->comite->responsable->nom ." ". $evenement->comiteEvenement->comite->responsable->prenom}}</a> ({{$evenement->comiteEvenement->comite->libelle}}) <a href="/comiteEvent/delete/{{$evenement->comiteEvenement->id}}">Retirer</a>
                            @else
                                <a href="/equipe/create">
                                    <button class="btn btn-danger">
                                        Créer une équipe
                                    </button>
                                </a><br>
                                <button class="btn btn-danger" data-toggle="modal" data-target="#myModal">
                                    Choisir un comité
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title" id="myModalLabel">Choisir un comite</h4>
                                                <a href="/comite/create">
                                                    <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                                        Nouveau comité
                                                    </button>
                                                </a>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{route("comiteEv.store")}}" method="post" id="choisirComite">
                                                        <table class="table table-bordered table-responsive" >
                                                            {{csrf_field()}}
                                                            <input type="hidden" name="evenement" value="{{$evenement->id}}">
                                                            <thead>
                                                                <tr>
                                                                    <th>Libelle</th>
                                                                    <th>Responsable</th>
                                                                    <th>Date de création</th>
                                                                    <th>Choisir</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach(\App\Comite::all() as $com)
                                                                    <tr>
                                                                        <td>{{$com->libelle}}</td>
                                                                        <td><a href="/benevole/show/{{$com->responsable->id}}">{{$com->responsable->nom." ".$com->responsable->prenom}}</a></td>
                                                                        <td>{{$com->created_at}}</td>
                                                                        <td>
                                                                            <input type="radio" name="comite" value="{{$com->id}}">
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                                <button type="button" class="btn btn-primary" onclick="document.getElementById('choisirComite').submit()">Enregistrer</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                            @endif
                        </td>
                        <td>
                            <a href="evenement/delete/{{$evenement->id}}"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>
                            <a href="evenement/edit/{{$evenement->id}}"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$evenements->links()}}
        </div>
    </div>
@endsection