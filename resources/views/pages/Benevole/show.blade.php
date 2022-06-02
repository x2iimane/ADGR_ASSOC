<?php
    if(isset($id)){
        $benevole = \App\Benevole::find($id);
    }
?>
@extends("layouts.app")
@section("title", $benevole->nom." ".$benevole->prenom)
@section("content")
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
        @if(file_exists("/storage/profilePhotos/benevoles/{{$benevole->id}}.jpg"))
            <a href="/storage/profilePhotos/benevoles/{{$benevole->id}}.jpg"><img src="/storage/profilePhotos/benevoles/{{$benevole->id}}.jpg" width="100%"></a>
        @else
                <a href="/storage/logo.jpg"><img src="/storage/logo.jpg" width="100%"></a>
        @endif
        </div>
        <div class="well col-md-9">
            <b>Nom: </b> {{$benevole->nom}}<br>
            <b>Prénom: </b> {{$benevole->prenom}}<br>
            <b>Date de naissance: </b>{{$benevole->dateNaissance}}<br>
            <b>Email: </b> <a href="mailto:{{$benevole->email}}">{{$benevole->email}}</a><br>
            <b>Rôle: </b> {{$benevole->role->libelle}}<br>
            <b>Etat d'activité:</b>
            @if(\Illuminate\Support\Facades\Auth::user()->role_id == 1 | \Illuminate\Support\Facades\Auth::user()->role_id == 2)
                @if($benevole->etat == 1)
                    <label class="switch">
                        <input type="checkbox" id="etatActivite" checked>
                        <span class="slider round"></span>
                    </label>
                @else
                    <label class="switch">
                        <input type="checkbox" id="etatActivite">
                        <span class="slider round"></span>
                    </label>
                @endif
            @else
                @if($benevole->etat == 1)
                    Actif
                @else
                    Inactif
                @endif
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label>Equipes</label>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Responsable</th>
                        <th>Evenement</th>
                        <th>Plus d'infos</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($benevole->benevoleEquipe as $be)
                            <tr>
                                <td>{{$be->equipe->id}}</td>
                                <td><a href="/benevole/show/{{$be->equipe->responsable->id}}">{{$be->equipe->responsable->nom." ".$be->equipe->responsable->prenom}}</a></td>
                                <td>{{$be->equipe->evenement->libelle}}</td>
                                <td><a href="/equipe/show/{{$be->equipe->id}}">Afficher</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <label>Comités</label>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Responsable</th>
                        <th>Evenements</th>
                        <th>Plus d'infos</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($benevole->benevoleComite as $be)
                        <tr>
                            <td>{{$be->comite->id}}</td>
                            <td><a href="/benevole/show/{{$be->comite->responsable->id}}">{{$be->comite->responsable->nom." ".$be->comite->responsable->prenom}}</a></td>
                            <td>
                                @foreach($be->comite->comiteEvenement as $ce)
                                    - {{$ce->evenement->libelle}}
                                @endforeach
                            </td>
                            <td><a href="/comite/show/{{$be->comite->id}}">Afficher</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="{{asset("js/jquery.js")}}"></script>
<script>
    $(function(){
        $("#etatActivite").on("change", function(){
            var idBenevole = "{{$benevole->id}}";
            var nouvelEtat = 0;
            if($("#etatActivite").prop("checked")){
                nouvelEtat = 1;
            }
            $.ajax({
                type: "get",
                url: "/benevole/changeState",
                data:{
                    idBenevole: idBenevole,
                    etat: nouvelEtat,
                },
                success:function(){
                },
                error:function(){
                    alert("error!");
                }
            });
        });
    });
</script>
@endsection