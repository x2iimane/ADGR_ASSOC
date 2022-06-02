@extends("layouts.app")
@section("title","Villes")
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-9">
                                Villes
                            </div>
                            <div class="col-md-3">
                                <span class="btn btn-primary" data-toggle="modal" data-target="#modalAddCity">Ajouter</span>
                                <div class="modal fade" id="modalAddCity" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title" id="myModalLabel">Ajouter un centre</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form action="/ville/store" id='formAddCity' method="post">
                                                    {{csrf_field()}}
                                                    <label for="libVille">Libellé ville</label><input type="text" name="libVille" class="form-control" id="libVille"><br>
                                                    <label for="bureau">Bureau</label><br>
                                                    <select name="bureau" id="bureau" class="form-control">
                                                        @foreach(\App\Bureau::all() as $bureau)
                                                            <option value="{{$bureau->id}}">{{"Bureau : ".$bureau->id}}</option>
                                                        @endforeach
                                                    </select><br>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                                <button onclick="document.getElementById('formAddCity').submit()" class="btn btn-primary">Ajouter</button>
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
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Libellé ville</th>
                                    <th># Bureau</th>
                                    <th>Nombre de zones</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $villes = App\Ville::paginate(5);
                                ?>
                                @foreach($villes as $ville)
                                    <tr id="ville{{$ville->id}}">
                                        <td>{{$ville->libVille}}</td>
                                        <td>
                                            @foreach($ville->bureauVille as $bv)
                                                - Bureau {{$bv->bureau->id}}<br>
                                            @endforeach
                                        </td>
                                        <td>{{count($ville->zone)}}
                                            @if(count($ville->zone))<a href="/zone/{{$ville->id}}"> Afficher tout</a>@endif
                                        </td>
                                        <td>
                                            <a href="/ville/delete/{{$ville->id}}" class="btn_delete_ville"><span class=" btn btn-warning btn-circle btn-md glyphicon glyphicon-remove removeCollecte"></span></a>
                                            <a href="/ville/edit/{{$ville->id}}"><span class=" btn btn-default btn-circle btn-md glyphicon glyphicon-pencil"></span></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            {!! $villes->links() !!}
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.panel-body -->
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset("js/jquery.js")}}"></script>
    <script>
        $(function(){
            $(".btn_delete_ville").click(function(){
                event.preventDefault();
                if(confirm("Voulez-vous vraiment supprimer cette ville?")){
                    $.ajax({
                        type: "get",
                        url: $(this).attr("href"),
                        success: function(data){
                            $("#ville"+data).remove();
                        },
                        error: function(){
                            console.log("Erreur !");
                        }
                    });
                }
            });
        });
    </script>
@endsection