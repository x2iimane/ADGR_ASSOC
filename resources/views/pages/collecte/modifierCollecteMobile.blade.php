@extends("layouts.app")
@section("title","Modifier une collecte")
@section("content")
    @if(isset($sucess))
        @if($sucess == true)
            <div class="alert alert-success">
                Collecte modifiée avec succès
            </div>
        @endif
    @endif
    @if(isset($idCollecte))
        <?php
        $collecte = \App\collecteMobile::find($idCollecte);
        ?>
    @endif
    <div class="container">
        <div class="row">
            <div class="col-md-3"><b>Collecte Mobile:</b></div>
            <div class="col-md-4" id="formulaireMobile" >
                {{@csrf_field()}}
                <form action="/collecte/mobile/update/{{$idCollecte}}" method="post">
                    {{csrf_field()}}
                    <label for="libCollecte">Libellé collecte</label><input class='form-control' type="text" id="libCollecte"  name="libCollecte" value={{$collecte->libCollecte}}><br>
                    <label for="dateCollecte">Date Collecte</label><input class='form-control' type="date" id="dateCollecte"  name="dateCollecte" value={{$collecte->date}}><br>
                    <label for='lieuCollecte'>Lieu</label><input type='text' class='form-control' id='lieuCollecte' name='lieuCollecte' value={{$collecte->lieu}}><br>
                    <label for='ville'>Ville</label>
                    <select id="ville" class="form-control">
                        @foreach(App\Ville::All() as $ville)
                            @if($collecte->zone->ville->id == $ville->id)
                                <option class='villes' value={{$ville->id}} selected> {{$ville->libVille}} </option>
                            @else
                                <option class='villes' value={{$ville->id}} > {{$ville->libVille}} </option>
                            @endif
                        @endforeach
                    </select><br>
                    <label for="zone">Zone</label>
                    <div id="listeZones">
                        <select id="zone" class="form-control" name="zone_id">
                            @foreach(App\Zone::All()->where("ville_id",$collecte->zone->ville->id) as $zone)
                                @if($zone->id == $collecte->zone->id)
                                    <option class="zones" value={{$zone->id}} selected> {{$zone->libZone}}</option>
                                @else
                                    <option class="zones" value={{$zone->id}}> {{$zone->libZone}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div><br>
                    <label for="nombre_presents">Nombre de présents :</label><input class='form-control' type="number" id="nombre_presents"  name="nombre_presents" value={{$collecte->nombre_presents}}><br>
                    <label for="nombre_contre_indiques">Nombre de contre-indiqués :</label><input class='form-control' type="number" id="nombre_contre_indiques"  name="nombre_contre_indiques" value={{$collecte->nombre_contre_indiques}}><br>
                    <input type="submit" id="ajouterCollecte" class="btn btn-primary" value="Ajouter">
                    <input type='reset' id="annuler" class="btn btn-primary" value="Annuler">
                </form>
            </div>
        </div>
    </div>
    <script src="{{asset("js/jquery.js")}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            let btn = document.getElementsByClassName("btnCol");
            let formulaireFixe = document.getElementById("formulaireFixe");
            let formulaireMobile = document.getElementById("formulaireMobile");
            let divZone = document.getElementById("listeZones");
            $("#ville").ready(function () {
                $("#ville").on("change", function () {
                    $.get("/getZones/" + $("#ville").val(), function (data) {
                        let zones = JSON.parse(data);
                        let html = "";
                        html += "<select id=\"zone\" class=\"form-control\" name='zone_id'>";
                        for (let i in zones) {
                            html += "<option value='" + zones[i].id + "'>" + zones[i].libZone + "</option>";
                        }
                        html += "</select>";
                        divZone.innerHTML = html;
                    })
                });
            });
        });
    </script>
@endsection
