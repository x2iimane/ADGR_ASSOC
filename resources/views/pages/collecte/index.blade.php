@extends("layouts.app")
@section("title","Collectes")
@section("content")
    <div class="container">
        {{--<input type="radio" class="btn btn" name="typeCol" id='fixe' checked> <label for="fixe">Collectes fixes</label>--}}
        {{--<input type="radio" name="typeCol" id="mobile"> <label for="mobile">Collectes mobiles</label>--}}
        <div class="row">
            <div class="col-md-8">
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-primary">
                        <input type="radio" name="btnCol" class="btnCol" id="fixe" checked> <label for="fixe"> Collecte fixe</label><br>
                    </label>
                    <label class="btn btn-primary">
                        <input type="radio" name="btnCol" class="btnCol" id="mobile"> <label for="mobile"> Collecte mobile</label>
                    </label>
                </div>
            </div>
            <div class="col-md-3">
                <a href="/evenement/create"><button class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Ajouter</button></a>
                <a href="/collecte/printlist"><button class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Imprimer tout</button></a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10" id="collectesFixes">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Liste des collectes fixes
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                            <tr>
                                <th>Libellé Collecte</th>
                                <th>Centre</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(App\collecteFixe::all() as $collecte)
                                @if(Auth::user()->role->id == 1)
                                    <tr>
                                        <td>{{$collecte->libCollecte}}</td>
                                        <td>{{$collecte->centre->libCentre}}</td>
                                        <td>{{$collecte->date}}</td>
                                        <td>Fixe</td>
                                        <td>
                                            <a href="/collecte/show/{{$collecte->collecte->id}}"><span class=" btn btn-default btn-circle btn-md glyphicon glyphicon-list"></span></a>
                                            <a href="/collecte/fixe/edit/{{$collecte->id}}"><span class=" btn btn-default btn-circle btn-md glyphicon glyphicon-pencil"></span></a>
                                            <a href="/collecte/fixe/delete/{{$collecte->id}}"><span class=" btn btn-warning btn-circle btn-md glyphicon glyphicon-remove removeCollecte"></span></a>
                                        </td>
                                    </tr>
                                @elseif(Auth::user()->role->id == 2)
                                    @if($collecte->centre->zone->ville->id == Auth::user()->zone->ville->id)
                                        <tr>
                                            <td>{{$collecte->libCollecte}}</td>
                                            <td>{{$collecte->centre->libCentre}}</td>
                                            <td>{{$collecte->date}}</td>
                                            <td>Fixe</td>
                                            <td>
                                                <a href="/collecte/show/{{$collecte->collecte->id}}"><span class=" btn btn-default btn-circle btn-md glyphicon glyphicon-list"></span></a>
                                                <a href="/collecte/fixe/edit/{{$collecte->id}}"><span class=" btn btn-default btn-circle btn-md glyphicon glyphicon-pencil"></span></a>
                                                <a href="/collecte/fixe/delete/{{$collecte->id}}"><span class=" btn btn-warning btn-circle btn-md glyphicon glyphicon-remove removeCollecte"></span></a>
                                            </td>
                                        </tr>
                                    @endif
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <div class="row">
            <div class="col-lg-10" id="collectesMobiles" style="display:none">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Liste des collectes mobiles
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                <tr>
                                    <th>Libellé Collecte</th>
                                    <th>Date</th>
                                    <th>Ville</th>
                                    <th>Zone</th>
                                    <th>Lieu</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach(App\collecteMobile::all() as $collecte)
                                    @if(Auth::user()->role->id == 1)
                                        <tr>
                                            <td>{{$collecte->libCollecte}}</td>
                                            <td>{{$collecte->date}}</td>
                                            <td>{{$collecte->zone->ville->libVille}}</td>
                                            <td>{{$collecte->zone->libZone}}</td>
                                            <td>{{$collecte->lieu}}</td>
                                            <td>
                                                <a href="/collecte/show/{{$collecte->collecte->id}}"><span class=" btn btn-default btn-circle btn-md glyphicon glyphicon-list"></span></a>
                                                <a href="/collecte/fixe/edit/{{$collecte->id}}"><span class=" btn btn-default btn-circle btn-md glyphicon glyphicon-pencil"></span></a>
                                                <a href="/collecte/fixe/delete/{{$collecte->id}}"><span class=" btn btn-warning btn-circle btn-md glyphicon glyphicon-remove removeCollecte"></span></a>
                                            </td>
                                        </tr>
                                    @elseif (Auth::user()->role->id == 2)
                                        @if(Auth::user()->zone->ville->id == $collecte->zone->ville->id)
                                            <tr>
                                                <td>{{$collecte->libCollecte}}</td>
                                                <td>{{$collecte->date}}</td>
                                                <td>{{$collecte->zone->ville->libVille}}</td>
                                                <td>{{$collecte->zone->libZone}}</td>
                                                <td>{{$collecte->lieu}}</td>
                                                <td>
                                                    <a href="/collecte/show/{{$collecte->collecte->id}}"><span class=" btn btn-default btn-circle btn-md glyphicon glyphicon-list"></span></a>
                                                    <a href="/collecte/fixe/edit/{{$collecte->id}}"><span class=" btn btn-default btn-circle btn-md glyphicon glyphicon-pencil"></span></a>
                                                    <a href="/collecte/fixe/delete/{{$collecte->id}}"><span class=" btn btn-warning btn-circle btn-md glyphicon glyphicon-remove removeCollecte"></span></a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="{{asset("js/jquery.js")}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#fixe").on("change",function(){
                $("#collectesMobiles").fadeOut();
                $("#collectesFixes").delay(400).fadeIn();
            });
            $("#mobile").on("change",function(){
                $("#collectesFixes").fadeOut();
                $("#collectesMobiles").delay(400).fadeIn();
            });
        });
    </script>
@endsection