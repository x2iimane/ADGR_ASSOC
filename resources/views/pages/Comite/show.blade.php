@extends("layouts.app")
@section("title","Afficher un comité")
@section("content")
    @if(isset($id))
        <?php
            $comite = \App\Comite::find($id);
        ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 well">
                    <b>Evenements: </b>
                        @foreach($comite->comiteEvenement as $comEvent)
                            - {{$comEvent->evenement->libelle}}<br>
                        @endforeach
                    <br><b>Responsable: </b><a href="/benevole/show/{{$comite->responsable->id}}">{{$comite->responsable->nom." " .$comite->responsable->prenom}}</a><br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3>Membres</h3><br>
                    <table width="100%" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <td>Nom</td>
                            <td>Prenom</td>
                            <td>CIN</td>
                            <td>Email</td>
                            <td>Profession</td>
                            <td>Date de naissance</td>
                            <td>Action</td>
                        </tr>
                        </thead>
                        <?php
                            $comites = $comite->benevoleComite()->paginate(10);
                        ?>
                        @foreach($comites as $be)
                            <tr>
                                <td>{{$be->benevole->nom}}</td>
                                <td>{{$be->benevole->prenom}}</td>
                                <td>{{$be->benevole->CIN}}</td>
                                <td>{{$be->benevole->email}}</td>
                                <td>{{$be->benevole->profession}}</td>
                                <td>{{$be->benevole->dateNaissance}}</td>
                                <td>
                                    <a href="/benevole/show/{{$be->benevole->id}}">Afficher</a>

                                    @if($be->comite->responsable->id != $be->benevole->id)
                                        /<a href="/benevoleEquipe/delete/{{$be->id}}">Retirer</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {{$comites->links()}}
                </div>
            </div>
        </div>
    @else

    @endif
@endsection