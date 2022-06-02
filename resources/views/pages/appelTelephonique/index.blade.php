@extends("layouts.app")
@section("title","Appels téléphoniques")
@section("content")
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <table class="table-hover table table-striped">
                <thead>
                    <tr>
                        <th>Téléphone</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Réponse</th>
                        <th>Bénévole appelant</th>
                        <th>Evénement</th>
                        <th>Date</th>
                        <th>Actions</th>
                        <th><a href="/appelTelephonique/create"><button class="btn btn-primary">Nouvel appel</button></a></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appels as $appel)
                        <?php
                            $reponse =  $appel->reponse == "1"? "Favorable":($appel->reponse == "2"?"Défavorable":($appel->reponse == "3"?"Pas de réponse":"A rappeler"));
                        ?>
                        <tr>
                            <td><a href="tel:{{$appel->donneur->numeroTelephone}}">{{$appel->donneur->numeroTelephone}}</a></td>
                            <td>{{$appel->donneur->nom}}</td>
                            <td>{{$appel->donneur->prenom}}</td>
                            <td>{{$reponse}}</td>
                            <td><a href="/benevole/show/{{$appel->Benevole->id}}">{{$appel->Benevole->nom. " ". $appel->Benevole->prenom}}</a></td>
                            <td>{{$appel->evenement->libelle}}</td>
                            <td>{{$appel->created_at}}</td>
                            <td colspan="2">
                                <a href="/appelTelephonique/edit/{{$appel->id}}">Modifier</a>
                                <a href="/appelTelephonique/delete/{{$appel->id}}">Supprimer</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{$appels->links()}}
        </div>
    </div>
</div>


@endsection