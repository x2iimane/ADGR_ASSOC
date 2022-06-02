@extends("layouts.app")
@section("title","Nouveau donneur")
@section("content")

    <div class="container">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-4">
                <form action="/donneur/store" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <label for="nom">Nom</label>
                    <input type="text" name="nom" id="nom" class="form-control" placeholder="Nom"><br>

                    <label for="prenom">Prenom</label>
                    <input type="text" name="prenom" id="prenom" class="form-control" placeholder="Prenom"><br>

                    <label for="cin">CIN</label><span id="cinMsg" style="color:red"></span>
                    <input type="text" name="cin" id="cin" class="form-control" placeholder="CIN"><br>

                    <label for="numeroTelephone">Numéro de téléphone</label>
                    <input type="tel" name="numeroTelephone" id="numeroTelephone" class="form-control" placeholder="Numéro de telephone"><br>

                    <label for="numeroTelephoneSecondaire">Numéro de téléphone secondaire</label>
                    <input type="tel" name="numeroTelephoneSecondaire" id="numeroTelephoneSecondaire" class="form-control" placeholder="Numéro de telephone secondaire"><br>

                    <label for="dateNaissance">Date de naissance</label>
                    <input type="date" name="dateNaissance" id="dateNaissance" class="form-control"> <br>

                    <label for="adresse">Adresse</label>
                    <input type="text" name="adresse" id="adresse" class="form-control" placeholder="Adresse"><br>

                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email"><br>

                    <label for="profession">Profession</label>
                    <input type="text" name="profession" id="profession" class="form-control" placeholder="Profession"><br>

                    <label for="sexe">Sexe</label>
                    <select id="sexe" name="sexe" class="form-control">
                        <option value="Femme">Femme</option>
                        <option value="Homme">Homme</option>
                        {{--<option value="Autre">Autre</option>--}}
                    </select><br>

                    <label for="moyen">Moyen d'adhésion</label>
                    <select id="moyen" name="moyen" class="form-control">
                        <option value="Rencontre ADGR">Une rencontre organisée par l'ADGR</option>
                        <option value="conseil d'un ami">Conseil d'un ami</option>
                    </select><br>

                    <label for="etat">Etat d'activité</label>
                    <select id="etat" name="etat" class="form-control">
                        <option value="1">Actif</option>
                        <option value="0">Inactif</option>
                    </select><br>

                    <label for="groupe">Groupe sanguin</label>
                    <select id="groupe" name="groupe" class="form-control">
                        @foreach(App\groupeSanguin::all() as $groupe)
                            @if($groupe->rhesus == '-')
                                <?php $rhesus = 'négatif' ?>
                            @else
                                <?php $rhesus = 'positif' ?>
                            @endif
                            <option value="{{$groupe->id}}">{{$groupe->libelle." ".$rhesus}}</option>
                        @endforeach
                    </select><br>

                    <label for="photo">Charger une photo de profil</label>
                    <input type="file" name="photo" id="photo" class="form-control"><br>


                    <label for="dateDernierDon">Date du dernier don</label>
                    <input type="date" name="dateDernierDon" id="dateDernierDon" class="form-control" > <br>

                    <label for="etatCivil">Etat civil</label>
                    <select id="etatCivil" name="etatCivil" class="form-control">
                        @foreach(App\etatCivil::all() as $etat)
                            <option value="{{$etat->id}}">{{$etat->libelle}}</option>
                        @endforeach
                    </select><br>

                    <label for="nombreEnfants">Nombre d'enfants</label>
                    <input type="text" name="nombreEnfants" id="nombreEnfants" class="form-control" placeholder="Nombre d'enfants"><br>

                    <label for="ville">Ville</label>
                    <select id="ville" name="ville" class="form-control">
                        @foreach(App\Ville::all() as $ville)
                            <option value="{{$ville->id}}">{{$ville->libVille}}</option>
                        @endforeach
                    </select><br>

                    <label for="zone">Zone</label>
                    <div id="listeZones">
                        <select id="zone" name="zone_id" class="form-control">
                            @foreach(App\Zone::all()->where("ville_id", App\Ville::all()->first()->id) as $zone)
                                <option value="{{$zone->id}}">{{$zone->libZone}}</option>
                            @endforeach
                        </select><br>
                    </div>

                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" name="username" class="form-control" placeholder="Nom d'utilisateur"><br>

                    <span id="mdpmsg"></span>
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Mot de passe"><br>
                    <label for="passwordVerification">Resaisissez le mot de passe</label>
                    <input type="password" id="passwordVerification" class="form-control" placeholder="Resaisissez le mot de passe"><br>

                    <label for="remarque">Remarque(s)</label>
                    <input type="textarea" name="remarque" id="remarque" class="form-control" placeholder="Remarque(s)"><br>
                    <div class="form-check">
                        <input class="form-check-input" name="type" type="checkbox" value="1" id="type">
                        <label class="form-check-label" for="type">
                            Donneur confidentiel
                        </label>
                    </div>

                    <input type="submit" value="Ajouter" id='ajouter' class="btn btn-primary">
                    <input type="reset" value="Annuler" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
    <script src="{{asset("js/jquery.js")}}"></script>
    <script type="text/javascript">
        let divZone = document.getElementById("listeZones");
        $(document).ready(function() {
            $("#ville").ready(function(){
                $("#ville").on("change",function(){
                    $.get("/getZones/"+$("#ville").val(), function(data){
                        let zones = JSON.parse(data);
                        let html = "";
                        html += "<select id=\"zone\" class=\"form-control\" name='zone_id'>";
                        for (let i in zones){
                            html += "<option value='"+zones[i].id+"'>"+zones[i].libZone+"</option>";
                        }
                        html +="</select><br>";
                        divZone.innerHTML = html;
                    })
                })
            });
            $("#cin").on("keyup", function(){
                let cin = $("#cin").val();
                $.ajax({
                    type: 'POST',
                    url: '/cinTest',
                    data: {
                        "_token": "<?php echo csrf_token() ?>",
                        "CIN": cin
                    },
                    success:function(data){
                        if(data == 1){
                            $("#cin").css("background-color", "#FF5050");
                            $("#cin").css("color", "#FFFFFF");
                            $("#cinMsg").html(" <b>déjà utilisé</b>");
                            $("#ajouter").className += " disabled";
                        }else{
                            $("#cin").css("background-color","");
                            $("#cin").css("color", "");
                            $("#cinMsg").text("");
                            $("#ajouter").className -= " disabled";
                        }
                    },
                    error: function(reject){
                        console.log(reject);
                    }
                });
            });
            $("#passwordVerification").on("keyup", function(){
                if($(this).val() !== $("#password").val()){
                    $("#mdpmsg").text("Les mots de passe ne sont pas identiques :(");
                    $("#mdpmsg").css("color", "red");
                    $(this).css("background-color", "#FF5050");
                    $(this).css("color", "#FFFFFF");
                    $("#password").css("background-color", "#FF5050");
                    $("#password").css("color", "#FFFFFF");
                }else{
                    $("#mdpmsg").text("");
                    $(this).css("background-color","");
                    $(this).css("color", "");
                    $("#password").css("background-color", "");
                    $("#password").css("color", "");
                }
            });
            $("#password").on("keyup", function(){
                if($(this).val() !== $("#passwordVerification").val()){
                    $("#mdpmsg").text("Les mots de passe ne sont pas identiques :(");
                    $("#mdpmsg").css("color", "red");
                    $(this).css("background-color", "#FF5050");
                    $(this).css("color", "#FFFFFF");
                    $("#passwordVerification").css("background-color", "#FF5050");
                    $("#passwordVerification").css("color", "#FFFFFF");
                }else{
                    $("#mdpmsg").text("");
                    $(this).css("background-color","");
                    $(this).css("color", "");
                    $("#passwordVerification").css("background-color", "");
                    $("#passwordVerification").css("color", "");
                }
            });
        });
    </script>
@endsection
