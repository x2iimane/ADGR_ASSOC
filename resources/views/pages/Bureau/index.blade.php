@extends("layouts.app")
@section("title","Bureaux")
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                @if(count(App\Bureau::all())> 0)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Bureau
                            <span class="btn btn-primary" data-toggle="modal" data-target="#modalAddBureau">Ajouter</span>
                            <div class="modal fade" id="modalAddBureau" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title" id="myModalLabel">Ajouter un bureau</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form action="/bureau/store" id="formAddBureau" method="post">
                                                {{csrf_field()}}
                                                <label for="dateCreation">Date de création</label>
                                                <input type="date" name="dateCreation" id="dateCreation" class="form-control"><br>
                                                <label for="responsable">Responsable</label><br>
                                                <select name="responsable" class="form-control" id="responsable">
                                                    @foreach(\App\Benevole::all() as $benevole)
                                                        @if(Auth::user()->role->id != 1)
                                                            @if($benevole->zone->ville->id == Auth::user()->zone->ville->id)
                                                                <option value="{{$benevole->id}}">{{$benevole->nom." ".$benevole->prenom}}</option>
                                                            @endif
                                                        @else
                                                            <option value="{{$benevole->id}}">{{$benevole->nom." ".$benevole->prenom}}</option>
                                                        @endif
                                                    @endforeach
                                                </select><br>
                                                @if(Auth::user()->role->id != 1)
                                                    Ville:<br>
                                                    <label for="villes">{{Auth::user()->zone->ville->libVille}}</label>
                                                    <input id="villes" type="checkbox" name="villes[]" value="{{Auth::user()->zone->ville->id}}" checked>
                                                @else
                                                    <label for="villes">Villes</label><br>
                                                    @foreach(\App\Ville::all() as $ville)
                                                        <label for="ville{{$ville->id}}">{{$ville->libVille}}</label>
                                                        <input type="checkbox" name="villes[]" value="{{$ville->id}}" id="ville{{$ville->id}}"><br>
                                                    @endforeach
                                                @endif
                                                <br>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                            <button onclick="document.getElementById('formAddBureau').submit()" class="btn btn-primary">Ajouter</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Villes</th>
                                        <th>Responsable</th>
                                        <th>Créé le</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($bureaux as $bureau)
                                        @if(Auth::user()->role->id != 1)
                                            @if(Auth::user()->zone->ville->id == $bureau->responsable->zone->ville->id)
                                                <tr id="bureau{{$bureau->id}}">
                                                    <td>{{$bureau->id}}</td>
                                                    <td>
                                                        <?php $flag = false; ?>
                                                        @foreach($bureau->bureauVille as $bv)
                                                            <b>-</b> {{$bv->ville->libVille}}<br>
                                                            <?php $flag = true; ?>
                                                        @endforeach
                                                        @if(!$flag)
                                                            <span style="color:red;">Aucune ville</span>
                                                        @endif
                                                    </td>
                                                    <td><a href="/benevole/show/{{$bureau->responsable->id}}">{{$bureau->responsable->nom." ".$bureau->responsable->prenom}}</a></td>
                                                    <td>{{$bureau->dateCreation}}</td>
                                                    <td>
                                                        <a href="/bureau/delete/{{$bureau->id}}"><span class=" btn btn-warning btn-circle btn-md glyphicon glyphicon-remove removeCollecte"></span></a>
                                                        <a href="/bureau/edit/{{$bureau->id}}"><span class=" btn btn-default btn-circle btn-md glyphicon glyphicon-pencil"></span></a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @else
                                            <tr id="bureau{{$bureau->id}}">
                                                <td>{{$bureau->id}}</td>
                                                <td>
                                                    <?php $flag = false; ?>
                                                    @foreach($bureau->bureauVille as $bv)
                                                        <b>-</b> {{$bv->ville->libVille}}<br>
                                                        <?php $flag = true; ?>
                                                    @endforeach
                                                    @if(!$flag)
                                                        <span style="color:red;">Aucune ville</span>
                                                    @endif
                                                </td>
                                                <td><a href="/benevole/show/{{$bureau->responsable->id}}">{{$bureau->responsable->nom." ".$bureau->responsable->prenom}}</a></td>
                                                <td>{{$bureau->dateCreation}}</td>
                                                <td>
                                                    <a href="/bureau/delete/{{$bureau->id}}" class="btn_delete_bureau"><span class=" btn btn-warning btn-circle btn-md glyphicon glyphicon-remove removeCollecte"></span></a>
                                                    <a href="/bureau/edit/{{$bureau->id}}"><span class=" btn btn-default btn-circle btn-md glyphicon glyphicon-pencil"></span></a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                                {{$bureaux->links()}}
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                @else
                    <div class="well">
                        Vous n'avez aucun bureau !
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script src="{{asset("js/jquery.js")}}"></script>
    <script>
        $(function(){
            $(".btn_delete_bureau").click(function(){
                event.preventDefault();
                if(confirm("Voulez-vous vraiment supprimer ce bureau?")){
                    $.ajax({
                        type: "get",
                        url : $(this).attr("href"),
                        success: function(data){
                            $("#bureau"+data).remove();
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