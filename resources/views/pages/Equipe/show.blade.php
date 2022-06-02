@extends("layouts.app")
@section("title","Afficher une équipe")
@section("content")
    @if(isset($id))
        <?php
            $equipe = \App\Equipe::find($id);
        ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 well">
                    <b>Evenement: </b>{{$equipe->evenement->libelle}}<br>
                    <b>Responsable: </b><a href="/benevole/show/{{$equipe->responsable->id}}">{{$equipe->responsable->nom." " .$equipe->responsable->prenom}}</a><br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3>Membres</h3><br>
                    <table width="100%" class="table table-striped table-responsive table-bordered">
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
                            $benevoles = $equipe->benevoleEquipe()->paginate(10);
                        ?>
                        @foreach($benevoles as $be)
                            <tr>
                                <td>{{$be->benevole->nom}}</td>
                                <td>{{$be->benevole->prenom}}</td>
                                <td>{{$be->benevole->CIN}}</td>
                                <td>{{$be->benevole->email}}</td>
                                <td>{{$be->benevole->profession}}</td>
                                <td>{{$be->benevole->dateNaissance}}</td>
                                <td>
                                    <a href="/benevole/show/{{$be->benevole->id}}">Afficher</a>

                                    @if($be->equipe->responsable->id != $be->benevole->id)
                                        /<a href="/benevoleEquipe/delete/{{$be->id}}">Retirer</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {{$benevoles->links()}}
                </div>
            </div>
        </div>
    @else

    @endif
@endsection