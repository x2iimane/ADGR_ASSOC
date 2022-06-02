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
            <h1>Liste des collectes fixes</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date de la collecte</th>
                        <th>Libellé de la collecte</th>
                        <th>Centre</th>
                        <th>Ville</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(\App\collecteFixe::all() as $collecte)
                        <tr>
                            <td>{{$collecte->date}}</td>
                            <td>{{$collecte->libCollecte}}</td>
                            <td>{{$collecte->centre->libCentre}}</td>
                            <td>{{$collecte->centre->zone->ville->libVille}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <img width="100px" src="{{config('app.url')."/storage/logo.jpg"}}">
        </div>
        <div class="col-md-9" align="center">
            <h1>Liste des collectes mobiles</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                <tr>
                    <th>Date de la collecte</th>
                    <th>Libellé de la collecte</th>
                    <th>Lieu</th>
                    <th>Zone</th>
                    <th>Ville</th>
                </tr>
                </thead>
                <tbody>
                @foreach(\App\collecteMobile::all() as $collecte)
                    <tr>
                        <td>{{$collecte->date}}</td>
                        <td>{{$collecte->libCollecte}}</td>
                        <td>{{$collecte->lieu}}</td>
                        <td>{{$collecte->zone->libZone}}</td>
                        <td>{{$collecte->zone->ville->libVille}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>