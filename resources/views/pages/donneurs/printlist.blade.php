<head>
    <meta charset="utf8"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <img width="100px" src="{{config('app.url')."/storage/logo.jpg"}}">
        </div>
        <div class="col-md-9" align="center">
            <h1>Liste des donneurs</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php
                $donneurs = \App\Donneur::all();
            ?>
            @if(count($donneurs) > 0)
                    <table class="table">
                        <tr>
                            <td>
                                Nom
                            </td>
                            <td>
                                Prénom
                            </td>
                            <td>
                                CIN
                            </td>
                            <td>
                                Groupe sanguin
                            </td>
                            <td>
                                Dernier don
                            </td>
                            <td>
                                Prochain don
                            </td>
                            <td>
                                Aptitude
                            </td>
                            <td>
                                Age
                            </td>
                        </tr>
                        <tbody>
                            @foreach($donneurs as $donneur)
                                <tr>
                                    <td>{{$donneur->nom}}</td>
                                    <td>{{$donneur->prenom}}</td>
                                    <td>{{$donneur->CIN}}</td>
                                    <td>{{$donneur->groupeSanguin->libelle.$donneur->groupeSanguin->rhesus}}</td>
                                    <td>{{$donneur->dateDernierDon}}</td>
                                    <td>
                                        @if($donneur->getProchainDon() != null && $donneur->getProchainDon() != "01-01-2000")
                                            {{$donneur->getProchainDon()->format("d-m-Y")}}
                                        @else
                                            @if($donneur->getProchainDon() == null)
                                                Prochaine occasion
                                            @else
                                                Inaptitude définitive
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if($donneur->isApte())
                                            <span class="btn btn-success">Apte</span>
                                        @else
                                            <span class="btn btn-danger">Inapte</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{$donneur->getAge()."ans"}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            @else
                <div class="well">
                    Pas de donneurs
                </div>
            @endif
        </div>
    </div>
</div>