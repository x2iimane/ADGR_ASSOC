@extends("layouts.app")
@section("title","Modifier donneur")
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-2">
            </div>
            <?php
            $donneur = App\Donneur::find($id);
            ?>
            <div class="col-md-4">
                <form action="/donneur/update/{{$donneur->id}}" method="post">
                    {{csrf_field()}}
                    <label for="nom">Nom</label>
                    <input type="text" name="nom" id="nom" class="form-control" value={{$donneur->nom}}><br>

                    <label for="prenom">Prenom</label>
                    <input type="text" name="prenom" id="prenom" class="form-control" value={{$donneur->prenom}}><br>

                    <label for="cin">CIN</label>
                    <input type="text" name="cin" id="cin" class="form-control" value={{$donneur->CIN}}><br>

                    <label for="numeroTelephone">Numéro de téléphone</label>
                    <input type="tel" name="numeroTelephone" id="numeroTelephone" class="form-control" value={{$donneur->numeroTelephone}}><br>

                    <label for="numeroTelephoneSecondaire">Numéro de téléphone secondaire</label>
                    <input type="tel" name="numeroTelephoneSecondaire" id="numeroTelephoneSecondaire" class="form-control" value={{$donneur->numeroTelephoneSecondaire}}><br>

                    <label for="dateNaissance">Date de naissance</label>
                    <input type="date" name="dateNaissance" id="dateNaissance" class="form-control" value={{$donneur->dateNaissance}}> <br>

                    <label for="adresse">Adresse</label>
                    <input type="text" name="adresse" id="adresse" class="form-control" value={{$donneur->adresse}}><br>

                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" class="form-control" value={{$donneur->email}}><br>

                    <label for="profession">Profession</label>
                    <input type="text" name="profession" id="profession" class="form-control" value={{$donneur->profession}}><br>

                    <label for="sexe">Sexe</label>
                    <select id="sexe" name="sexe" class="form-control" value={{$donneur->sexe}}>
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
                    <select id="etat" name="etat" class="form-control" value={{$donneur->etat}}>
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

                    <label for="dateDernierDon">Date du dernier don</label>
                    <input type="date" name="dateDernierDon" id="dateDernierDon" class="form-control" value={{$donneur->dateDernierDon}}> <br>

                    <label for="etatCivil">Etat civil</label>
                    <select id="etatCivil" name="etatCivil" class="form-control">
                        @foreach(App\etatCivil::all() as $etat)
                            <option value="{{$etat->id}}">{{$etat->libelle}}</option>
                        @endforeach
                    </select><br>

                    <label for="nombreEnfants">Nombre d'enfants</label>
                    <input type="text" name="nombreEnfants" id="nombreEnfants" class="form-control" value={{$donneur->nombreEnfants}}><br>

                    <label for="ville">Ville</label>
                    <select id="ville" name="ville" class="form-control">
                        @foreach(App\Ville::all() as $ville)
                            @if($ville->id == $donneur->zone->ville->id)
                                <option value="{{$ville->id}}" selected>{{$ville->libVille}}</option>
                            @else
                                <option value="{{$ville->id}}">{{$ville->libVille}}</option>
                            @endif
                        @endforeach
                    </select><br>

                    <label for="zone">Zone</label>
                    <div id="listeZones">
                        <select id="zone" name="zone_id" class="form-control">
                            @foreach(App\Zone::all()->where("ville_id", $donneur->zone->ville->id) as $zone)
                                @if($zone->id == $donneur->zone->id)
                                    <option value="{{$zone->id}}" selected>{{$zone->libZone}}</option>
                                @else
                                    <option value="{{$zone->id}}">{{$zone->libZone}}</option>
                                @endif
                            @endforeach
                        </select><br>
                    </div>


                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" name="username" class="form-control" placeholder="Nom d'utilisateur" value={{$donneur->username}}><br>

                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" class="form-control" placeholder="Mot de passe"><br>


                    <label for="remarque">Remarque(s)</label>
                    <input type="textarea" name="remarque" id="remarque" class="form-control" value={{$donneur->remarque}}><br>

                    <div class="form-check">
                        @if($donneur->type == 0)
                            <input class="form-check-input" name="type" type="checkbox" value="1" id="type">
                        @else
                            <input class="form-check-input" name="type" type="checkbox" value="1" id="type" checked>
                        @endif
                        <label class="form-check-label" for="type">
                            Donneur confidentiel
                        </label>
                    </div>

                    <input type="submit" value="Modifier" class="btn btn-primary">
                    <input type="reset" value="Annuler" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
    <script src="/js/jquery.js"></script>
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
        });
    </script>
@endsection