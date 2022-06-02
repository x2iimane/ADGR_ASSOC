<head>
    <meta charset="utf8"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <img width="100px" src="{{config('app.url')."/storage/logo.jpg"}}">
            </div>
            <div class="col-md-9" align="center">
                <h1>Liste des bénévoles</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>CIN</th>
                            <th>Téléphone</th>
                            <th>Date de naissance</th>
                            <th>Etat</th>
                            <th>Date d'adhésion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Benevole::all() as $benevole)
                            <tr>
                                <td>{{$benevole->nom}}</td>
                                <td>{{$benevole->prenom}}</td>
                                <td>{{$benevole->CIN}}</td>
                                <td>{{$benevole->tele}}</td>
                                <td>{{$benevole->dateNaissance}}</td>
                                <td>
                                    <?php
                                        $etat = "Inactif";
                                        if($benevole->etat == "1"){
                                            $etat = "Actif";
                                        }
                                    ?>
                                    {{$etat}}
                                </td>
                                <td>{{$benevole->dateAdhesion}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>