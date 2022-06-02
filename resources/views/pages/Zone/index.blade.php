@extends("layouts.app")
@section("title","Zones")
@section("content")
    <div class="container">
        @if(count(\App\Ville::all()) > 0)
            @if($idVille == -1)
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-4">
                        <label for="id_ville">Ville</label>
                        <select id="id_ville" class="form-control">
                            @foreach(App\Ville::all() as $ville)
                                <option value={{$ville->id}}>{{$ville->libVille}}</option>
                            @endforeach
                        </select><br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <div class="panel panel-default" id="maDiv">
                            <div class="panel-heading" >
                                <?php
                                $ville = App\Ville ::all()->first()->libVille;
                                $idVille = App\Ville ::all()->first()->id;
                                ?>
                                <div class="row">
                                    <div class="col-md-9">
                                        Zones
                                    </div>
                                    <div class="col-md-3">
                                        <a href='/zone/create/{{$idVille}}' class='btn btn-default'><span class=' glyphicon glyphicon-plus'></span> Ajouter </a>
                                    </div>
                                </div>
                            </div>

                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Libellé Zone</th>
                                            <th>Code postal</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach(App\Ville::find($idVille)->zone as $zone)
                                            <tr>
                                                <td>{{$zone->libZone}}</td>
                                                <td>{{$zone->codePostal}}</td>
                                                <td>
                                                    <a href="/zone/delete/{{$zone->id}}"><span class=" btn btn-warning btn-circle btn-md glyphicon glyphicon-remove"></span></a>
                                                    <a href="/zone/edit/{{$zone->id}}"><span class=" btn btn-default btn-circle btn-md glyphicon glyphicon-pencil"></span></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <?php
                                echo "Zones de la ville de ". App\Ville::find($idVille)->libVille. " <a href='/zone/create/".$idVille."' class='btn btn-default'><span class=' glyphicon glyphicon-plus'></span> Ajouter </a>";
                                ?>
                            </div>

                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Libellé Zone</th>
                                            <th>Code postal</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach(App\Ville::find($idVille)->zone as $zone)
                                            <tr>
                                                <td>{{$zone->libZone}}</td>
                                                <td>{{$zone->codePostal}}</td>
                                                <td>
                                                    <a href="/zone/delete/{{$zone->id}}"><span class=" btn btn-warning btn-circle btn-md glyphicon glyphicon-remove removeCollecte"></span></a>
                                                    <a href="/zone/edit/{{$zone->id}}"><span class=" btn btn-default btn-circle btn-md glyphicon glyphicon-pencil"></span></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                    </div>
                </div>
            @endif
        @else
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-warning">
                        Vous devez ajouter une ville d'abord !
                    </div>
                </div>
            </div>
        @endif
    </div>
    <script src="{{asset("js/jquery.js")}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#id_ville").ready(function(){
                $(this).on("change",function(){
                    $.get("/getZones/"+$("#id_ville").val(),function(data){
                        let zones = JSON.parse(data);
                        let maDiv = document.getElementById("maDiv");
                            let html = "<div class=\"panel-heading\" ><div class='row'><div class='col-md-9'> Zones:</div><div class='col-md-3'> <a href='/zone/create/"+$("#id_ville").val()+"' class='btn btn-default'><span class=' glyphicon glyphicon-plus'></span> Ajouter </a></div></div></div>" +
                                "<div class='panel-body'>" +
                                "                        <div class=\"table-responsive\">" +
                                "                            <table class=\"table table-striped\">" +
                                "                                <thead>" +
                                "                                <tr>" +
                                "                                    <th>Libellé Zone</th>" +
                                "                                    <th>Code postal</th>" +
                                "                                    <th>Actions</th>" +
                                "                                </tr>" +
                                "                                </thead>" +
                                "                                <tbody>";
                                for(let i in zones){
                                    html += "<tr>" +
                                        "<td>" +
                                            zones[i].libZone +
                                        "</td>" +
                                        "<td>" +
                                            zones[i].codePostal +
                                        "</td>" +
                                        "<td>" +
                                            "<a href='/zone/delete/"+zones[i].id+"'><span class='btn btn-warning btn-circle btn-md glyphicon glyphicon-remove '></span></a>"+
                                            "<a href='/zone/edit/"+zones[i].id+"'><span class='btn btn-default btn-circle btn-md glyphicon glyphicon-pencil '></span></a>"+
                                        "</td>" +
                                        "</tr>"
                                }
                                html += "                                </tbody>" +
                                "                            </table>" +
                                "                        </div>" +
                                "                    </div>"
                        maDiv.innerHTML = html;
                    })
                })
            });
        });
    </script>
@endsection