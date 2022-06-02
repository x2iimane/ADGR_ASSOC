<head>
    <meta charset="utf8"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<?php
$donneur = null;
if(isset($id)){
    $donneur = \App\Donneur::find($id);
}
?>
@if($donneur != null)
    {{date("d-m-Y")}}
    <div align="center">
        <table>
            <tr>
                <td>
                    @if(file_exists(config('app.url')."/storage/profilePhotos/donneurs/".$id.".jpg"))
                        <img width="200px" src="{{config('app.url')."/storage/profilePhotos/donneurs/".$id.".jpg"}}">
                    @else
                        <img width="200px" src="{{config('app.url')."/storage/logo.jpg"}}">
                    @endif
                </td>
                <td align="center">
                    <h1>{{$donneur->nom." ".$donneur->prenom}}</h1>
                </td>
            </tr>
        </table>
        <table class="table table-striped">
            <tr>
                <td>
                    Date de naissance :
                </td>
                <td>
                    {{$donneur->dateNaissance}}
                </td>
            </tr>

            <tr>
                <td>
                    Sexe :
                </td>
                <td>
                    {{$donneur->sexe}}
                </td>
            </tr>
            <tr>
                <td>
                    Groupe sanguin :
                </td>
                <td>
                    {{$donneur->groupeSanguin->libelle.$donneur->groupeSanguin->rhesus}}
                </td>
            </tr>
            <tr>
                <td>
                    Date du dernier don :
                </td>
                <td>
                    {{$donneur->dateDernierDon}}
                </td>
            </tr>
            <tr>
                <td>
                    CIN :
                </td>
                <td>
                    {{$donneur->CIN}}
                </td>
            </tr>
            <tr>
                <td>
                    Etat civil :
                </td>
                <td>
                    {{$donneur->etatCivil->libelle}}
                </td>
            </tr>
            <tr>
                <td>
                    Nombre d'enfants :
                </td>
                <td>
                    {{$donneur->nombreEnfants}}
                </td>
            </tr>
            <tr>
                <td>
                    Profession :
                </td>
                <td>
                    {{$donneur->profession}}
                </td>
            </tr>
            <tr>
                <td>
                    Moyen d'adhésion :
                </td>
                <td>
                    {{$donneur->moyenAdhesion}}
                </td>
            </tr>
            <tr>
                <td>
                    Numéro de téléphone :
                </td>
                <td>
                    {{$donneur->numeroTelephone}}
                </td>
            </tr>
            <tr>
                <td>
                    Adresse e-mail :
                </td>
                <td>
                    {{$donneur->email}}
                </td>
            </tr>
            <tr>
                <td>
                    Adresse :
                </td>
                <td>
                    {{$donneur->adresse}}
                </td>
            </tr>
            <tr>
                <td>
                    Ville :
                </td>
                <td>
                    {{$donneur->zone->ville->libVille}}
                </td>
            </tr>
            <tr>
                <td>
                    Zone :
                </td>
                <td>
                    {{$donneur->zone->libZone}}
                </td>
            </tr>
            <tr>
                <td>
                    Date du prochain don :
                </td>
                <td>
                    @if(!is_string($donneur->getProchainDon()))
                        @if($donneur->getProchainDon() == null)
                            Prochaine occasion
                        @else
                            {{$donneur->getProchainDon()->format("d-m-Y")}}
                        @endif
                    @else
                        Inaptitude définitive
                    @endif

                </td>
            </tr>
        </table>
        <br><br><br>
        <h1> Dons : </h1>
        @if(count(App\donAdgr::all()->where("donneur_id",$donneur->id)) > 0)
            <table class="table table-striped" width="100%">
                <thead>
                <tr>
                    <th>Date </th>
                    <th>Collecte</th>
                    <th>Type collecte</th>
                </tr>
                </thead>
                <tbody>

                @foreach(App\donAdgr::all()->where("donneur_id",$donneur->id) as $don)
                    <tr>
                        <td>{{$don->dateDon}}</td>
                        <td>{{$don->collecte->libCollecte}}</td>
                        @if($don->collecte->typeCollecte == 0)
                            <td>Collecte fixe</td>
                        @else
                            <td>Collecte mobile</td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            Pas de dons ADGR
        @endif

        @if(count(App\donExterne::all()->where("donneur_id",$donneur->id)) > 0)
            <h3> Dons externes : </h3>
            <table class="table table-striped" width="100%">
                <thead>
                <tr>
                    <th>Date </th>
                    <th>Raison</th>
                </tr>
                </thead>
                <tbody>
                @foreach(App\donExterne::all()->where("donneur_id",$donneur->id) as $don)
                    <tr>
                        <td>{{$don->date}}</td>
                        <td>{{$don->raison}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            Pas de dons externes
        @endif

        @if(count(App\donneurContreIndication::all()->where("donneur_id", $donneur->id)) > 0)
            <h1>Contre indications</h1>
            <table class="table table-striped" width="100%">
                <thead>
                <tr>
                    <th>Libelle</th>
                    <th>Duree</th>
                    <th>Date début</th>
                    <th>Date fin</th>
                    <th>Type</th>
                </tr>
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
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            Pas de contre indications !
        @endif
    </div>
@else
    HELLO !
@endif