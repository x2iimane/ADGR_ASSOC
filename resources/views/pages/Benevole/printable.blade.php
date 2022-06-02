<head>
    <meta charset="utf8"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<?php
$benevole = null;
if(isset($id)){
    $benevole = \App\Benevole::find($id);
}
?>
@if($benevole != null)
    {{date("d-m-Y")}}
    <div align="center">
        <table>
            <tr>
                <td>
                    <img width="200px" src="{{config('app.url')."/storage/profilePhotos/benevoles/".$id.".jpg"}}">
                </td>
                <td align="center">
                    <h1>{{$benevole->nom." ".$benevole->prenom}}</h1>
                </td>
            </tr>
        </table>
        <table class="table table-striped">
            <tr>
                <td>
                    Date de naissance :
                </td>
                <td>
                    {{$benevole->dateNaissance}}
                </td>
            </tr>

            <tr>
                <td>
                    Sexe :
                </td>
                <td>
                    {{$benevole->sexe}}
                </td>
            </tr>
            <tr>
                <td>
                    Profession :
                </td>
                <td>
                    {{$benevole->profession}}
                </td>
            </tr>
            <tr>
                <td>
                    CIN :
                </td>
                <td>
                    {{$benevole->CIN}}
                </td>
            </tr>
            <tr>
                <td>
                    Numéro de téléphone :
                </td>
                <td>
                    {{$benevole->tele}}
                </td>
            </tr>
            <tr>
                <td>
                    Etat civil :
                </td>
                <td>
                    {{$benevole->etatCivil->libelle}}
                </td>
            </tr>
            <tr>
                <td>
                    Adresse :
                </td>
                <td>
                    {{$benevole->adresse}}
                </td>
            </tr>
        </table>
@else
    HELLO !
@endif