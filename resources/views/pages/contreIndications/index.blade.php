@extends("layouts.app")
@section("title","Contre-indications")
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-9">
                                Contre indications
                            </div>
                            <div class="col-md-2">
                                {{--<a href="/contreIndication/create"><button class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>Ajouter</button></a>--}}
                                <span class="btn btn-primary" data-toggle="modal" data-target="#modalAddCI">Ajouter</span>
                                <div class="modal fade" id="modalAddCI" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title" id="myModalLabel">Ajouter une contre indication</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form action="/contreIndication/store" id="formAddCI" method="post">
                                                    {{csrf_field()}}
                                                    <label for="nom">Nom de la contre-indication</label><input type="text" name="nom" class="form-control" id="nom"><br>
                                                    <input type="radio" name="type" value="provisoire" id="provisoire" checked> <label for="provisoire">Provisoire</label><br>
                                                    <input type="radio" name="type" value="definitive" id="definitive"> <label for="definitive">Définitive</label><br>
                                                    <div id="dureediv">
                                                        <label for="duree">Durée de la contre-indication</label>
                                                        <input type="text" name="duree" class="form-control" id="duree"><br>
                                                        <select name="unite" class="form-control">
                                                            <option value="j">Jours</option>
                                                            <option value="m">Mois</option>
                                                            <option value="a">Années</option>
                                                        </select><br>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                                <button onclick="document.getElementById('formAddCI').submit()" class="btn btn-primary">Ajouter</button>
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
                                    <th>Nom de la contre-indication</th>
                                    <th>Durée</th>
                                    <th>Type</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach(App\ContreIndication::All() as $contre_indication)
                                    <tr id="contreIndication{{$contre_indication->id}}">
                                        <td>{{$contre_indication->nom}}</td>
                                        <?php
                                            if($contre_indication->unite == 'j'){
                                                $unite = "jours";
                                            }elseif($contre_indication->unite == 'm'){
                                                $unite = "mois";
                                            }else{
                                                $unite = "ans";
                                            }
                                        ?>
                                        @if($contre_indication->duree != null)
                                            <td>{{$contre_indication->duree . " " . $unite}}</td>
                                        @else
                                            <td> - </td>
                                        @endif
                                        <td>{{$contre_indication->type}}</td>
                                        <td>
                                            <a href="/contreIndication/delete/{{$contre_indication->id}}" class="delete_contre_indication"><span class=" btn btn-warning btn-circle btn-md glyphicon glyphicon-remove removeCollecte"></span></a>
                                            <a href="/contreIndication/edit/{{$contre_indication->id}}"><span class=" btn btn-default btn-circle btn-md glyphicon glyphicon-pencil"></span></a>
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
    </div>
    <script src="{{"js/jquery.js"}}"></script>
    <script>
        $(document).ready(function(){
            $("#definitive").on("change", function(){
                $("#dureediv").fadeOut();
            });
            $("#provisoire").on("change", function(){
                $("#dureediv").fadeIn();
            });
            $(".delete_contre_indication").click(function(){
                event.preventDefault();
                if(confirm("Voulez-vous vraiment supprimer cette contre indication?")){
                    $.ajax({
                        type: "get",
                        url: $(this).attr("href"),
                        success: function(data){
                            $("#contreIndication"+data).remove();
                        },
                        error: function(){
                            console.log("Erreur !");
                        }
                    })
                }
            })
        });
    </script>
@endsection