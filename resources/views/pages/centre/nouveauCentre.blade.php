@extends("layouts.app")
@section("title","Centre")
@section("content")
   <div class="container">
       <div class="row">
           <div class="col-md-12">
               @if(count(\App\Ville::all())==0)
                   <div class="alert alert-warning">
                       Vous devez ajouter une ville d'abord !
                   </div>
               @endif
           </div>
       </div>
       <div class="row">
           <div class="col-md-2">
           </div>
           <div class="col-md-4">
               <form action="/centre/store" method="post">
                   {{csrf_field()}}
                   <label for="libCentre">Libellé centre</label>
                   <input type="text" id="libCentre" name="libCentre" class="form-control"><br>
                   <label for='adresse'>Adresse</label>
                   <input type="text" id="adresse" name="adresse" class="form-control"><br>
                   <label for='ville'>Ville</label>
                   <select id="ville" class="form-control">
                       @if(count(App\Ville::All()) >0)
                           @foreach(App\Ville::All() as $ville)
                               <option class='villes' value={{$ville->id}} > {{$ville->libVille}} </option>
                           @endforeach
                       @endif
                   </select><br>
                   <label for="zone">Zone</label>
                   <div id="listeZones">
                       <select id="zone" class="form-control" name="zone_id">
                           @if(count(App\Zone::All()) > 0)
                               @foreach(App\Zone::All()->where("ville_id",App\Ville::all()->first()->id) as $zone)
                                   <option class="zones" value={{$zone->id}}> {{$zone->libZone}}</option>
                               @endforeach
                           @endif
                       </select>
                   </div><br>
                   @if(count(\App\Ville::all()) > 0)
                       <input type="submit" value="Ajouter" class="btn btn-primary">
                       <input type="reset" value="Annuler" class="btn btn-primary">
                   @else
                       <input type="submit" value="Ajouter" class="btn btn-primary" disabled>
                       <input type="reset" value="Annuler" class="btn btn-primary">
                   @endif
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