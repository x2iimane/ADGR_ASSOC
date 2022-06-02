<!doctype html>
<html lang="fr">
<head>
    @section("title", "Collecte")
    @include("layouts.partials.head")
</head>
<body>
    <h1 style="text-align:center;">Liste des donneurs aptes</h1>
    <a href="/donneur/printlisteaptes"><button class="btn btn-primary"><i class="fa fa-fw fa-print"></i>Imprimer</button></a>
    <table class="table table-striped table-responsive table-hover">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prenom</th>
                <th>CIN</th>
                <th>Groupe sanguin</th>
                <th>Age</th>
                <th>Tele</th>
                <th>Tele(2)</th>
            </tr>
        </thead>
        <tbody>
        @if(Auth::user()->role->id == 1)
            @foreach(\App\Donneur::all() as $donneur)
                    @if($donneur->isApte())
                        <tr>
                            <td>{{$donneur->nom}}</td>
                            <td>{{$donneur->prenom}}</td>
                            <td>{{$donneur->CIN}}</td>
                            <td>{{$donneur->groupeSanguin->libelle.$donneur->groupeSanguin->rhesus}}</td>
                            <td>{{$donneur->getAge()}}</td>
                            <td>{{$donneur->numeroTelephone}}</td>
                            <td>{{$donneur->numeroTelephoneSecondaire}}</td>
                        </tr>
                    @endif
            @endforeach
        @else
            @foreach(\App\Donneur::all() as $donneur)
                @if($donneur->isApte())
                    @if($donneur->zone->ville->id == Auth::user()->zone->ville->id)
                        <tr>
                            <td>{{$donneur->nom}}</td>
                            <td>{{$donneur->prenom}}</td>
                            <td>{{$donneur->CIN}}</td>
                            <td>{{$donneur->groupeSanguin->libelle.$donneur->groupeSanguin->rhesus}}</td>
                            <td>{{$donneur->getAge()}}</td>
                            <td>{{$donneur->numeroTelephone}}</td>
                            <td>{{$donneur->numeroTelephoneSecondaire}}</td>
                        </tr>
                    @endif
                @endif
            @endforeach
        @endif
        </tbody>
    </table>
</body>