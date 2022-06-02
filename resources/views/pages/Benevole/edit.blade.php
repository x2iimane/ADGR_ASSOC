@extends("layouts.app")
@section("title", "Modifier un bénévole")
@section("content")
@if(isset($id))
    <?php
        $benevole = \App\Benevole::find($id);
    ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <button id="btnPrecedent" class="btn btn-primary"><< Précédent</button><button id="btnSuivant" class="btn btn-primary">Suivant >></button>
            <form action="/benevole/update/{{$benevole->id}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div id="part1">
                    <h4>Informations générales</h4>
                    <label for="nom">Nom:</label>
                    <input type="text" name="nom" class="form-control" placeholder="Nom" id="nom" value="{{$benevole->nom}}" autofocus><br>
                    <label for="prenom">Prenom:</label>
                    <input type="text" name="prenom" class="form-control" placeholder="Prénom" id="prenom" value="{{$benevole->prenom}}"><br>
                    <label for="sexe">Sexe:</label>
                    <select name="sexe" id="sexe" class="form-control">
                        @if($benevole->sexe == "H")
                            <option value="F">Femme</option>
                            <option value="H" selected>Homme</option>
                        @else
                            <option value="F" selected>Femme</option>
                            <option value="H">Homme</option>
                        @endif
                    </select><br>
                    <label for="CIN">CIN:</label>
                    <input type="text" name="CIN" class="form-control" placeholder="CIN" id="CIN" value="{{$benevole->CIN}}"><br>
                    <label for="profession">Profession:</label>
                    <input type="text" name="profession" class="form-control" placeholder="Profession" id="profession" value="{{$benevole->profession}}"><br>
                    <label for="dateNaissance">Date de naissance:</label>
                    <input type="date" name="dateNaissance" class="form-control" id="dateNaissance" value="{{$benevole->dateNaissance}}"><br>
                    <label for="dateAdhesion">Date d'adhésion:</label>
                    <input type="date" name="dateAdhesion" class="form-control" id="dateAdhesion" value="{{$benevole->dateAdhesion}}"><br>
                    <label for="etatCivil">Etat civil</label>
                    <select id="etatCivil" name="etatCivil" class="form-control">
                        @foreach(App\etatCivil::all() as $etat)
                            @if($benevole->etatCivil->id == $etat->id)
                                <option value="{{$etat->id}}" selected>{{$etat->libelle}}</option>
                            @else
                                <option value="{{$etat->id}}">{{$etat->libelle}}</option>
                            @endif
                        @endforeach
                    </select><br>
                    <label for="photo">Photo de profil</label>
                    <input type="file" name="photo" id="photo">
                </div>
                <div id="part2" style="display:none">
                    <h4>Contact</h4>
                    <label for="tele">Téléphone</label>
                    <input type="text" name="tele" class="form-control" placeholder="Numéro de telephone" id="tele" value="{{$benevole->tele}}"><br>
                    <label for="teleSec">Téléphone secondaire</label>
                    <input type="text" name="teleSec" class="form-control" placeholder="Numero de telephone secondaire" id="teleSec" value="{{$benevole->teleSec}}"><br>
                    <label for="adresse">Adresse</label>
                    <input type="text" name="adresse" class="form-control" placeholder="Adresse" id="adresse" value="{{$benevole->adresse}}"><br>
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Email" id="email" value="{{$benevole->email}}"><br>
                </div>
                <div id="part3" style="display:none">
                    <h4>Informations de connexion</h4>
                    <input type="text" name="login" placeholder="Login" class="form-control" id="login" value="{{$benevole->login}}"><br>
                    <input type="password" name="password" placeholder="Mot de passe" class="form-control" id="password" value="{{$benevole->password}}"><br>
                    <input type="submit" value="Ajouter" class="btn btn-success">
                    <input type="reset" value="Annuler" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>
@endif
<script src="{{asset("js/jquery.js")}}"></script>
<script>
    $(document).ready(function(){
        $("#part1").css("padding","10px");
        $("#part2").css("padding","10px");
        $("#part3").css("padding","10px");
        $("#btnSuivant").click(function(){
            if($("#btnSuivant").attr("class") === "btn btn-primary"){
                $("#btnSuivant").addClass("deuxieme");
                $("#btnPrecedent").addClass("deuxieme");
                $("#part1").slideToggle();
                $("#part2").slideToggle();
            }else if($("#btnSuivant").attr("class") === "btn btn-primary deuxieme"){
                $("#btnSuivant").removeClass("deuxieme").addClass("troisieme");
                $("#btnPrecedent").removeClass("deuxieme").addClass("troisieme");
                $("#part2").slideToggle();
                $("#part3").slideToggle();
            }else{
                $("#btnSuivant").removeClass("troisieme");
                $("#btnPrecedent").removeClass("troisieme");
                $("#part3").slideToggle();
                $("#part1").slideToggle();
            }
        });
        $("#btnPrecedent").click(function(){
            if($("#btnPrecedent").attr("class") === "btn btn-primary"){
                $("#btnPrecedent").addClass("troisieme");
                $("#btnSuivant").addClass("troisieme");
                $("#part3").slideToggle();
                $("#part1").slideToggle();
            }else if($("#btnPrecedent").attr("class") === "btn btn-primary deuxieme"){
                $("#btnPrecedent").removeClass("deuxieme");
                $("#btnSuivant").removeClass("deuxieme");
                $("#part1").slideToggle();
                $("#part2").slideToggle();
            }else{
                $("#btnPrecedent").removeClass("troisieme").addClass("deuxieme");
                $("#btnSuivant").removeClass("troisieme").addClass("deuxieme");
                $("#part3").slideToggle();
                $("#part2").slideToggle();
            }
        });
    });
</script>
@endsection