@extends("layouts.app")
@section("title","Nouvelle Collecte")
@section("content")
    <input type="radio" name="btnCol" class="btnCol" id="fixe" checked> <label for="fixe"> Collecte fixe</label><br>
    <input type="radio" name="btnCol" class="btnCol" id="mobile"> <label for="mobile"> Collecte mobile</label>
    @if(isset($sucess))
        @if($sucess == true)
            <div class="alert alert-success">
                Nouvelle collecte ajoutée avec succès !
            </div>
        @endif
    @endif
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-4" id="formulaireFixe">
                <form action="/collecte/fixe/store" method="post">
                    {{@csrf_field()}}
                    <label for="libCollecte">Libellé collecte</label><input class='form-control' type="text" id="libCollecte"  name="libCollecte"><br>
                    <label for="dateCollecte">Date Collecte</label><input class='form-control' type="date" id="dateCollecte"  name="dateCollecte"><br>
                    <label for="centre">Centre</label>
                    <select name="idCentre" class="form-control">
                            @if(count(App\Centre::all()) > 0)
                                @foreach(App\Centre::all() as $centre)
                                    <option value="{{$centre->id}}">{{$centre->libCentre}}</option>
                                @endforeach
                            @endif
                    </select><br>
                    <label for="nombre_presents">Nombre de présents :</label><input class='form-control' type="number" id="nombre_presents"  name="nombre_presents"><br>
                    <label for="nombre_contre_indiques">Nombre de contre-indiqués :</label><input class='form-control' type="number" id="nombre_contre_indiques"  name="nombre_contre_indiques"><br>
                    <input type="submit" id="ajouterCollecte" class="btn btn-primary" value="Ajouter">
                    <input type='reset' id="annuler" class="btn btn-primary" value="Annuler">
                </form>
            </div>
            <div class="col-md-4" id="formulaireMobile" style='display:none;'>
                    {{@csrf_field()}}
                    <form action="/collecte/mobile/store" method="post">
                        {{csrf_field()}}
                        <label for="libCollecte">Libellé collecte</label><input class='form-control' type="text" id="libCollecte"  name="libCollecte"><br>
                        <label for="dateCollecte">Date Collecte</label><input class='form-control' type="date" id="dateCollecte"  name="dateCollecte"><br>
                        <label for='lieuCollecte'>Lieu</label><input type='text' class='form-control' id='lieuCollecte' name='lieuCollecte'><br>
                        <label for='ville'>Ville</label>
                        <select id="ville" class="form-control">
                            @foreach(App\Ville::All() as $ville)
                                <option class='villes' value={{$ville->id}} > {{$ville->libVille}} </option>
                            @endforeach
                        </select><br>
                        <label for="zone">Zone</label>
                        <div id="listeZones">
                                <select id="zone" class="form-control" name="zone_id">
                                    @if(count(App\Zone::All()) >0)
                                        @foreach(App\Zone::All()->where("ville_id",App\Ville::all()->first()->id) as $zone)
                                            <option class="zones" value={{$zone->id}}> {{$zone->libZone}}</option>
                                        @endforeach
                                    @endif
                                </select>
                        </div><br>
                        <label for="nombre_presents">Nombre de présents :</label><input class='form-control' type="number" id="nombre_presents"  name="nombre_presents"><br>
                        <label for="nombre_contre_indiques">Nombre de contre-indiqués :</label><input class='form-control' type="number" id="nombre_contre_indiques"  name="nombre_contre_indiques"><br>
                        <input type="submit" id="ajouterCollecte" class="btn btn-primary" value="Ajouter">
                        <input type='reset' id="annuler" class="btn btn-primary" value="Annuler">
                    </form>
            </div>
        </div>


    </div>
    <script
            src="/js/jquery.js" ></script>
    <script type="text/javascript">
        $(document).ready(function() {
            let btn = document.getElementsByClassName("btnCol");
            let formulaireFixe = document.getElementById("formulaireFixe");
            let formulaireMobile = document.getElementById("formulaireMobile");
            let divZone = document.getElementById("listeZones");
            btn[0].addEventListener("change", function () {
                $(formulaireMobile).fadeOut();
                $(formulaireFixe).delay(400).fadeIn();
            })
            btn[1].addEventListener('change', function () {
                $(formulaireFixe).fadeOut();
                $(formulaireMobile).delay(400).fadeIn();
                $("#ville").ready(function(){
                        $("#ville").on("change",function(){
                            $.get("/getZones/"+$("#ville").val(), function(data){
                                let zones = JSON.parse(data);
                                let html = "";
                                html += "<select id=\"zone\" class=\"form-control\" name='zone_id'>";
                                for (let i in zones){
                                    html += "<option value='"+zones[i].id+"'>"+zones[i].libZone+"</option>";
                                }
                                html +="</select>";
                                divZone.innerHTML = html;
                            })
                        })
                    });
            })
        })
    </script>
@endsection
