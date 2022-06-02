@extends("layouts.app")
@section("title","Dons")
@section("content")
    <div class="container">
        <div class="row" id="maDiv">
            @if($idDonneur != -1)
                    <div class="col-md-6">
                        @if(count(\App\Donneur::all()) > 0)
                            <input type="radio" id="btnDonsADGR" checked name="typeDon"><label for="btnDonsADGR">Dons ADGR</label>
                            <input type="radio" id="btnDonsExternes" name="typeDon"><label for="btnDonsExternes">Dons Externes</label>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Dons
                                </div>
                            <?php
                                $donneur = \App\Donneur::find($idDonneur);
                            ?>
                            <!-- /.panel-heading -->
                                <div class="panel-body" id="donsADGR">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>Date du don</th>
                                                <th>Collecte</th>
                                                <th>Donneur</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($donneur->donsADGR as $don)
                                                <tr>
                                                    <td>{{$don->collecte->collecte->date}}</td>
                                                    <td>{{$don->collecte->libCollecte}}</td>
                                                    <td><a href="/donneur/show/{{$donneur->id}}">{{$donneur->nom . " " . $donneur->prenom}}</a></td>
                                                    <td>
                                                        <a href="/don/adgr/delete/{{$don->id}}"><span class=" btn btn-warning btn-circle btn-md glyphicon glyphicon-remove removeCollecte"></span></a>
                                                        <a href="/don/adgr/edit/{{$don->id}}"><span class=" btn btn-default btn-circle btn-md glyphicon glyphicon-pencil"></span></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.panel-body -->
                                <div class="panel-body" id="donsExternes" style="display:none;">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>Date du don</th>
                                                <th>Raison</th>
                                                <th>Donneur</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($donneur->donsExternes as $don)
                                                <tr>
                                                    <td>{{$don->date}}</td>
                                                    <td>{{$don->raison}}</td>
                                                    <td>{{$donneur->nom . " " . $donneur->prenom}}</td>
                                                    <td>
                                                        <a href="/don/externe/delete/{{$don->id}}"><span class=" btn btn-warning btn-circle btn-md glyphicon glyphicon-remove removeCollecte"></span></a>
                                                        <a href="/don/externe/edit/{{$don->id}}"><span class=" btn btn-default btn-circle btn-md glyphicon glyphicon-pencil"></span></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                            </div>
                    </div>
                @else
                    <div class="well">
                        Il n'y a aucun donneur dans la base de données
                    </div>
                @endif
            @else
                    <div class="col-md-6">
                        @if(count(\App\Donneur::all()) > 0)
                            <select name="donneurs" id="donneurs" class="form-control">
                                @foreach(App\Donneur::all() as $donneur)
                                    <option value="{{$donneur->id}}">{{$donneur->nom . " " . $donneur->prenom."(".$donneur->CIN.")"}}</option>
                                @endforeach
                            </select><br>
                            <input type="radio" id="btnDonsADGR" checked name="typeDon"><label for="btnDonsADGR">Dons ADGR</label>
                            <input type="radio" id="btnDonsExternes" name="typeDon"><label for="btnDonsExternes">Dons Externes</label>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Dons
                                </div>
                            <?php
                                $donneur = \App\Donneur::All()->first();
                            ?>
                            <!-- /.panel-heading -->
                                <div class="panel-body" id="donsADGR">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>Date du don</th>
                                                <th>Collecte</th>
                                                <th>Donneur</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($donneur->donsADGR as $don)
                                                <tr>
                                                    <td>{{$don->collecte->collecte->date}}</td>
                                                    <td>{{$don->collecte->libCollecte}}</td>
                                                    <td><a href="/donneur/show/{{$donneur->id}}">{{$donneur->nom . " " . $donneur->prenom}}</a></td>
                                                    <td>
                                                        <a href="/don/adgr/delete/{{$don->id}}"><span class=" btn btn-warning btn-circle btn-md glyphicon glyphicon-remove removeCollecte"></span></a>
                                                        <a href="/don/adgr/edit/{{$don->id}}"><span class=" btn btn-default btn-circle btn-md glyphicon glyphicon-pencil"></span></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.panel-body -->
                                <div class="panel-body" id="donsExternes" style="display:none;">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>Date du don</th>
                                                <th>Raison</th>
                                                <th>Donneur</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($donneur->donsExternes as $don)
                                                <tr>
                                                    <td>{{$don->date}}</td>
                                                    <td>{{$don->raison}}</td>
                                                    <td>{{$donneur->nom . " " . $donneur->prenom}}</td>
                                                    <td>
                                                        <a href="/don/externe/delete/{{$don->id}}"><span class=" btn btn-warning btn-circle btn-md glyphicon glyphicon-remove removeCollecte"></span></a>
                                                        <a href="/don/externe/edit/{{$don->id}}"><span class=" btn btn-default btn-circle btn-md glyphicon glyphicon-pencil"></span></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                            </div>
                    </div>
                    @else
                        <div class="well">
                            Il n'y a aucun donneur dans la base de données
                        </div>
                    @endif
            @endif
        </div>
    </div>
    <script
            src="/js/jquery.js">
    </script>
    <script>
        $(document).ready(function(){
            $("#btnDonsADGR").on("change", function(){
                $("#donsExternes").fadeOut();
                $("#donsADGR").delay(400).fadeIn();
            });
            $("#btnDonsExternes").on("change", function(){
                $("#donsADGR").fadeOut();
                $("#donsExternes").delay(400).fadeIn();
            });

            $("#donneurs").on("change", function(){
                alert($(this).attr("value"));
            });
        })
    </script>
@endsection