@extends("layouts.app")
@section("title","Centre")
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-lg-10" id="collectesFixes">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-10">
                                Liste des centres
                            </div>
                            <div class="col-md-2">
                                <span class="btn btn-primary" data-toggle="modal" data-target="#modalAddCentre">Ajouter</span>
                                <div class="modal fade" id="modalAddCentre" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title" id="myModalLabel">Ajouter un centre</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form action="/centre/store" id="formAddCentre" method="post">
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
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                                <button onclick="document.getElementById('formAddCentre').submit()" class="btn btn-primary">Ajouter</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Libellé centre</th>
                                <th>Adresse</th>
                                <th>Ville</th>
                                <th>Zone</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($centres as $centre)
                                @if(Auth::user()->role->id != 1)
                                    @if($centre->zone->ville->id == Auth::user()->zone->ville->id)
                                        <tr id="centre{{$centre->id}}">
                                            <td>{{$centre->libCentre}}</td>
                                            <td>{{$centre->adresse}}</td>
                                            <td>{{$centre->zone->ville->libVille}}</td>
                                            <td>{{$centre->zone->libZone}}</td>
                                            <td>
                                                <a href="/centre/delete/{{$centre->id}}" class="btn_delete_centre"><span class=" btn btn-warning btn-circle btn-md glyphicon glyphicon-remove removeCollecte"></span></a>
                                                <a href="/centre/edit/{{$centre->id}}"><span class=" btn btn-default btn-circle btn-md glyphicon glyphicon-pencil"></span></a>
                                            </td>
                                        </tr>
                                    @endif
                                @else
                                    <tr id="centre{{$centre->id}}">
                                        <td>{{$centre->libCentre}}</td>
                                        <td>{{$centre->adresse}}</td>
                                        <td>{{$centre->zone->ville->libVille}}</td>
                                        <td>{{$centre->zone->libZone}}</td>
                                        <td>
                                            <a href="/centre/delete/{{$centre->id}}" class="btn_delete_centre"><span class=" btn btn-warning btn-circle btn-md glyphicon glyphicon-remove removeCollecte"></span></a>
                                            <a href="/centre/edit/{{$centre->id}}"><span class=" btn btn-default btn-circle btn-md glyphicon glyphicon-pencil"></span></a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                        {{$centres->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{"js/jquery.js"}}"></script>
    <script>
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

        $(".btn_delete_centre").click(function(){
            event.preventDefault();
            if(confirm("Voulez-vous vraiment supprimer ce centre?")){
                $.ajax({
                    type: 'get',
                    url: $(this).attr("href"),
                    success: function(data){
                        $("#centre"+data).remove();
                        console.log("Succès !")
                    },
                    error: function(){
                        console.log("Erreur !");
                    }
                })
            }
        });

        });
    </script>
@endsection