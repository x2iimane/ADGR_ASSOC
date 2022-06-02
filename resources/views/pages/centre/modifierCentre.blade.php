@extends("layouts.app")
@section("title","Centre")
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-2">
            </div>
            <?php
                $centre = \App\Centre::find($idCentre);
            ?>
            <div class="col-md-4">
                <form action="/centre/update/{{$centre->id}}" method="post">
                    {{csrf_field()}}
                    <label for="libCentre">Libellé centre</label>
                    <input type="text" id="libCentre" name="libCentre" class="form-control" value={{$centre->libCentre}}><br>
                    <label for='adresse'>Adresse</label>
                    <input type="text" id="adresse" name="adresse" class="form-control" value={{$centre->adresse}}><br>
                    <label for='ville'>Ville</label>
                    <select id="ville" class="form-control">
                        @foreach(App\Ville::All() as $ville)
                            @if($centre->zone->ville_id == $ville->id)
                                <option class='villes' value="{{$ville->id}}" selected> {{$ville->libVille}} </option>
                            @else
                                <option class='villes' value={{$ville->id}} > {{$ville->libVille}} </option>
                            @endif
                        @endforeach
                    </select><br>
                    <label for="zone">Zone</label>
                    <div id="listeZones">
                        <select id="zone" class="form-control" name="zone_id">
                            @foreach(App\Zone::All()->where("id",$centre->zone->id) as $zone)
                                <option class="zones" value={{$zone->id}}> {{$zone->libZone}}</option>
                            @endforeach
                        </select>
                    </div><br>
                    <input type="submit" value="Ajouter" class="btn btn-primary">
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
                        html +="</select>";
                        divZone.innerHTML = html;
                    })
                })
            });
        });
    </script>
@endsection