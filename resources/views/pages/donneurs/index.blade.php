@extends("layouts.app")
@section("title","Donneurs")
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-lg-10">
                <div id="foo" style="cursor: pointer; background-color: #F5F5F5; border: solid 1px #DDDDDD; padding:10px; text-align: center; border-radius: 4px 4px 0 0">Recherche avancée<span class="fa arrow" id="arr"></span></div>
                <div id="bar" style="background-color: #F5F5F5; border:solid 1px #DDDDDD; border-top: none; display:none; text-align:center; border-radius: 0 0 4px 4px; padding:20px;">
                    @if(Auth::user()->role->id == 1)
                        <label for="ville">Ville</label><select id='ville'>
                            <option value="" selected>------</option>
                            @foreach(\App\Ville::all() as $ville)
                                <option value="{{$ville->id}}">{{$ville->libVille}}</option>
                            @endforeach
                        </select><br>
                    @else
                        <input type="hidden" id="ville" value="{{Auth::user()->zone->ville->id}}">
                    @endif
                    <label for="nom">Nom</label><input class="form-inline" type="text" id="nom" placeholder="Nom">
                    <label for="prenom">Prenom</label> <input class="form-inline" type="text" id="prenom" placeholder="Prenom">
                    <label for="cin">CIN</label><input class="form-inline" type="text" id="cin" placeholder="CIN"><br>
                    <label for="groupe">Groupe sanguin</label><select id='groupe'>
                        <option value="" selected>------</option>
                        @foreach(\App\groupeSanguin::all() as $gs)
                            <option value="{{$gs->id}}">{{$gs->libelle.$gs->rhesus}}</option>
                        @endforeach
                    </select><br>
                    <button id="btn" class="btn btn-primary">valider</button>
                </div><br>
            </div>
            <div class="col-lg-10">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-8">
                                Liste des donneurs
                            </div>
                            <div class="col-md-4">
                                    <a href="/donneur/create"><button class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>Ajouter</button></a>
                                <a href="/donneur/printlist"><button class="btn btn-primary"><span class="glyphicon glyphicon-print"></span>Imprimer</button></a>
                                <a href="/donneur/listeaptes"><button class="btn btn-primary"><span class="fa fa-fw fa-check"></span>Aptes</button></a>
                            </div>
                        </div>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body" id="panel">
                        <table width="100%" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>CIN</th>
                                <th>Groupe sanguin</th>
                                <th>Ville</th>
                                <th>Dernier don</th>
                                <th>Prochain don</th>
                                <th>Aptitude</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(Auth::user()->role->id == 1)
                                <?php
                                    $donneurs = \App\Donneur::paginate(5);
                                ?>
                                @foreach($donneurs as $donneur)
                                    <tr id="donneur{{$donneur->id}}">
                                        <td>{{$donneur->nom}}</td>
                                        <td>{{$donneur->prenom}}</td>
                                        <td>{{$donneur->CIN}}</td>
                                        <td>{{$donneur->groupeSanguin->libelle.$donneur->groupeSanguin->rhesus}}</td>
                                        <td>{{$donneur->zone->ville->libVille}}</td>
                                        <td>
                                    @if($donneur->dateDernierDon == null)
                                            ----
                                        @else
                                            <?php
                                        $dernierDon = new DateTime($donneur->dateDernierDon);
                                        ?>
                                                    {{$dernierDon->format("d-m-Y")}}
                                                    @endif
                                        </td>
                                        <td>
                                            @if($donneur->getProchainDon() != null && $donneur->getProchainDon() != new \DateTime("01-01-2000"))
                                                {{$donneur->getProchainDon()->format("d-m-Y")}}
                                            @else
                                                @if($donneur->getProchainDon() == null)
                                                    Prochaine occasion
                                                @else
                                                    Inaptitude définitive
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if($donneur->isApte())
                                                <span class="btn btn-success" data-toggle="modal" data-target="{{"#modalApte".$donneur->id}}">Apte</span>
                                                <div class="modal fade" id="{{"modalApte".$donneur->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                <h4 class="modal-title" id="myModalLabel">Apte</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <b>Ajouter une contre indication</b>
                                                                <form action="/donneurContreIndication/store/{{$donneur->id}}" method="post" id="ajouterContreIndication{{$donneur->id}}">
                                                                    {{csrf_field()}}
                                                                    <label for="contre_indication_id">Contre indication</label>
                                                                    <select id="contre_indication_id" name="contre_indication_id" class="form-control">
                                                                        @foreach(\App\contreIndication::All() as $ci)
                                                                            <option value={{$ci->id}}>{{$ci->nom}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <label for="dateDebut">Date de début</label>
                                                                    <input type="date" name="dateDebut" id="dateDebut" class="form-control">
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                                                <button type="button" class="btn btn-primary" onclick="document.getElementById('ajouterContreIndication{{$donneur->id}}').submit()">Ajouter</button>
                                                            </div>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                            @else
                                                <span class="btn btn-danger" data-toggle="modal" data-target="{{"#modalInapte".$donneur->id}}">Inapte</span>
                                                <div class="modal fade" id="{{"modalInapte".$donneur->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                <h4 class="modal-title" id="myModalLabel">Inapte !</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                @if($donneur->getProchainDon() != null)
                                                                    @if($donneur->getProchainDon() != new DateTime("01-01-2000"))
                                                                        <b>Inaptitude provisoire !</b><br>
                                                                        <b>Cause:</b> {{$donneur->getCauseInaptitude()}}<br>
                                                                        <b>Date du prochain don :</b> {{$donneur->getProchainDon()->format("d-m-Y")}}
                                                                    @else
                                                                        <b>Inaptitude définitive !</b><br>
                                                                        <b>Cause: </b> {{$donneur->getCauseInaptitude()}}
                                                                    @endif
                                                                @endif
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                                            </div>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                            @endif

                                        </td>
                                        <td>
                                            <a href="/donneur/delete/{{$donneur->id}}" class="delete_donneur_btn"><span class=" btn btn-warning btn-circle btn-md glyphicon glyphicon-remove"></span></a>
                                            <a href="/donneur/edit/{{$donneur->id}}"><span class=" btn btn-default btn-circle btn-md glyphicon glyphicon-pencil"></span></a>
                                            <a href="/donneur/show/{{$donneur->id}}"><span class=" btn btn-default btn-circle btn-md glyphicon glyphicon-list"></span></a>
                                            <!-- Modal -->
                                            <span class="btn btn-default btn-circle btn-md glyphicon glyphicon-heart" data-toggle="modal" data-target="{{"#modalDon".$donneur->id}}"></span>
                                            <div class="modal fade" id="{{"modalDon".$donneur->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            <h4 class="modal-title" id="myModalLabel">Apte</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    Dons
                                                                </div>
                                                                <!-- /.panel-heading -->
                                                                <div class="panel-body">
                                                                    <!-- Nav tabs -->
                                                                    <ul class="nav nav-tabs">
                                                                        <li class="active"><a href="#ajouterDon{{$donneur->id}}" data-toggle="tab" aria-expanded="true">Ajouer un don</a></li>
                                                                        <li class=""><a href="#listeDons{{$donneur->id}}" data-toggle="tab" aria-expanded="false">Tous les dons</a></li>
                                                                    </ul>

                                                                    <!-- Tab panes -->
                                                                    <div class="tab-content">
                                                                        <div class="tab-pane fade active in" id="ajouterDon">
                                                                            <h4>Ajouter un don</h4>
                                                                                <input type="radio" name="type" id="donADGR{{$donneur->id}}" class="donADGR" data-donneur="{{$donneur->id}}" checked><label for="donADGR{{$donneur->id}}">Don ADGR</label>
                                                                                <input type="radio" name="type" id="donExt{{$donneur->id}}" class="donExt" data-donneur="{{$donneur->id}}"><label for="donExt{{$donneur->id}}">Don externe</label>
                                                                                <div id="donADGRDiv{{$donneur->id}}">
                                                                                    <form action="/don/adgr/store" method="post" id="ajouterDonADGRForm{{$donneur->id}}">
                                                                                        {{csrf_field()}}
                                                                                        <label for="collecte">Collecte</label>
                                                                                        <select id="collecte" name="collecte" class="form-control">
                                                                                            @foreach(App\collecteFixe::all() as $collecte)
                                                                                                <option value="{{$collecte->id}}">{{$collecte->libCollecte}}</option>
                                                                                            @endforeach
                                                                                        </select><br>
                                                                                        <input type="hidden" name="donneur" value="{{$donneur->id}}">
                                                                                        <input type="hidden" name="typeCollecte" value="0">
                                                                                        <input type="submit" class="btn btn-primary" value="Ajouter">
                                                                                    </form>
                                                                                </div>
                                                                                <div id="donExtDiv{{$donneur->id}}" style="display:none">
                                                                                    <form action="/don/externe/store" method="post" id="ajouterDonExterneForm{{$donneur->id}}">
                                                                                        {{csrf_field()}}
                                                                                        <input type="hidden" name="donneur" value="{{$donneur->id}}">
                                                                                        <input type="hidden" name="typeCollecte" value="1">
                                                                                        <label for="dateDon">Date du don</label>
                                                                                        <input type="date" name="dateDon" class="form-control" id="dateDon"><br>

                                                                                        <label for="raison">Raison du don</label>
                                                                                        <input type="text" name="raison" class="form-control" id="raison"><br>
                                                                                        <input type="submit" class="btn btn-primary" value="Ajouter" id="ajouterDonExterneForm{{$donneur->id}}">
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        <div class="tab-pane fade" id="listeDons{{$donneur->id}}">
                                                                            <h4>Liste des dons</h4>
                                                                            <h3>Dons Externes</h3>
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
                                                                                <h3>Dons ADGR</h3>
                                                                                <table class="table table-striped">
                                                                                    <thead>
                                                                                    <tr>
                                                                                        <th>Date du don</th>
                                                                                        <th>Collecte</th>
                                                                                        <th>Type de collecte</th>
                                                                                        <th>Donneur</th>
                                                                                        <th>Actions</th>
                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                    @foreach($donneur->donsADGR as $don)
                                                                                        <tr>
                                                                                            <td>{{$don->collecte->collecte->date}}</td>
                                                                                            <td>{{$don->collecte->collecte->libCollecte}}</td>
                                                                                            @if($don->typeCollecte == 1)
                                                                                                <td>Fixe</td>
                                                                                            @else
                                                                                                <td>Mobile</td>
                                                                                            @endif
                                                                                            <td>{{$donneur->nom . " " . $donneur->prenom}}</td>
                                                                                            <td>
                                                                                                <a href="/don/adgr/delete/{{$don->id}}"><span class=" btn btn-warning btn-circle btn-md glyphicon glyphicon-remove removeCollecte"></span></a>
                                                                                                <a href="/don/adgr/edit/{{$don->id}}"><span class=" btn btn-default btn-circle btn-md glyphicon glyphicon-pencil"></span></a>
                                                                                            </td>
                                                                                        </tr>
                                                                                    @endforeach
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- /.panel-body -->
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                                        </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                            <a href="/donneur/{{$donneur->id}}/pdf"><span class="btn btn-default btn-circle btn-md glyphicon glyphicon-print"></span></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                @foreach($donneurs as $donneur)
                                    @if($donneur->zone->ville->id == Auth::user()->zone->ville->id)
                                        <tr id="donneur{{$donneur->id}}">
                                            <td>{{$donneur->nom}}</td>
                                            <td>{{$donneur->prenom}}</td>
                                            <td>{{$donneur->CIN}}</td>
                                            <td>{{$donneur->groupeSanguin->libelle.$donneur->groupeSanguin->rhesus}}</td>
                                            <td>{{$donneur->zone->ville->libVille}}</td>
                                            <td>
                                                @if($donneur->dateDernierDon == null)
                                                    ----
                                                @else
                                                    <?php
                                                    $dernierDon = new DateTime($donneur->dateDernierDon);
                                                    ?>
                                                    {{$dernierDon->format("d-m-Y")}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($donneur->getProchainDon() != null && $donneur->getProchainDon() != new \DateTime("01-01-2000"))
                                                    {{$donneur->getProchainDon()->format("d-m-Y")}}
                                                @else
                                                    @if($donneur->getProchainDon() == null)
                                                        Prochaine occasion
                                                    @else
                                                        Inaptitude définitive
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if($donneur->isApte())
                                                    <span class="btn btn-success" data-toggle="modal" data-target="{{"#modalApte".$donneur->id}}">Apte</span>
                                                    <div class="modal fade" id="{{"modalApte".$donneur->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                    <h4 class="modal-title" id="myModalLabel">Apte</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <b>Ajouter une contre indication</b>
                                                                    <form action="/donneurContreIndication/store/{{$donneur->id}}" method="post" id="ajouterContreIndication">
                                                                        {{csrf_field()}}
                                                                        <label for="contre_indication_id">Contre indication</label>
                                                                        <select id="contre_indication_id" name="contre_indication_id" class="form-control">
                                                                            @foreach(\App\contreIndication::All() as $ci)
                                                                                <option value="{{$ci->id}}">{{$ci->nom}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <label for="dateDebut">Date de début</label>
                                                                        <input type="date" name="dateDebut" id="dateDebut" class="form-control">
                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                                                    <button type="button" class="btn btn-primary" onclick="document.getElementById('ajouterContreIndication').submit()">Ajouter</button>
                                                                </div>
                                                            </div>
                                                            <!-- /.modal-content -->
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                    </div>
                                                @else
                                                    <span class="btn btn-danger" data-toggle="modal" data-target="{{"#modalInapte".$donneur->id}}">Inapte</span>
                                                    <div class="modal fade" id="{{"modalInapte".$donneur->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                    <h4 class="modal-title" id="myModalLabel">Inapte !</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    @if($donneur->getProchainDon() != null)
                                                                        @if($donneur->getProchainDon() != new DateTime("01-01-2000"))
                                                                            <b>Inaptitude provisoire !</b><br>
                                                                            <b>Cause:</b> {{$donneur->getCauseInaptitude()}}<br>
                                                                            <b>Date du prochain don :</b> {{$donneur->getProchainDon()->format("d-m-Y")}}
                                                                        @else
                                                                            <b>Inaptitude définitive !</b><br>
                                                                            <b>Cause: </b> {{$donneur->getCauseInaptitude()}}
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                                                </div>
                                                            </div>
                                                            <!-- /.modal-content -->
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                    </div>
                                                @endif

                                            </td>
                                            <td>
                                                <a href="/donneur/delete/{{$donneur->id}}" class="delete_donneur_btn"><span class=" btn btn-warning btn-circle btn-md glyphicon glyphicon-remove"></span></a>
                                                <a href="/donneur/edit/{{$donneur->id}}"><span class=" btn btn-default btn-circle btn-md glyphicon glyphicon-pencil"></span></a>
                                                <a href="/donneur/show/{{$donneur->id}}"><span class=" btn btn-default btn-circle btn-md glyphicon glyphicon-list"></span></a>
                                                <a href="/don/{{$donneur->id}}"><span class=" btn btn-default btn-circle btn-md glyphicon glyphicon-heart"></span></a>
                                                <a href="/donneur/{{$donneur->id}}/pdf"><span class="btn btn-default btn-circle btn-md glyphicon glyphicon-print"></span></a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        {{$donneurs->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset("js/jquery.js")}}"></script>
    <script>
        function deleteDonneur(){
            $(".delete_donneur_btn").click(function(){
                event.preventDefault();
                if(confirm("Voulez-vous vraiment supprimer ce donneur?")){
                    $.ajax({
                        type: "get",
                        url: $(this).attr("href"),
                        success: function(data){
                            $("#donneur"+data).remove();
                        },
                        error: function(){
                            alert("Erreur");
                        },
                    });
                }
            });
        }
        $(function(){
            // $("#btnDonsADGR").on("change", function(){
            //     $("#donsExternes").fadeOut();
            //     $("#donsTOUS").fadeOut();
            //     $("#donsADGR").delay(400).fadeIn();
            // });
            // $("#btnDonsExternes").on("change", function(){
            //     $("#donsADGR").fadeOut();
            //     $("#donsTOUS").fadeOut();
            //     $("#donsExternes").delay(400).fadeIn();
            // });
            // $("#btnDonsTOUS").on("change", function(){
            //     $("#donsADGR").fadeOut();
            //     $("#donsExternes").fadeOut();
            //     $("#donsTOUS").delay(400).fadeIn();
            // });
            //
            // $("#btnSubmit").click(function(){
            //     $("#ajouterDonADGRForm").submit()
            // });

            $(".donADGR").each(function(){
                $(this).on("change",function(){
                    $("#donExtDiv"+$(this).attr("data-donneur")).fadeOut();
                    $("#donADGRDiv"+$(this).attr("data-donneur")).delay(400).fadeIn();
                    $("#btnSubmit").click(function(){
                        $("#ajouterDonADGRForm").submit()
                    });
                });
            });
            $(".donExt").each(function(){
                $(this).on("change",function(){
                    console.log($(this).attr("data-donneur"));
                    $("#donADGRDiv"+$(this).attr("data-donneur")).fadeOut();
                    $("#donExtDiv"+$(this).attr("data-donneur")).delay(400).fadeIn();
                    $("#btnSubmit"+$(this).attr("data-donneur")).click(function(){
                        $("#ajouterDonExterneForm"+this.attr("data-donneur")).submit()
                    });
                });
            });
            deleteDonneur();
            $("#foo").click(function(){
                $("#bar").slideToggle(500, "swing", function(){
                    if($("#bar").css("display") === "none"){
                        $("#foo").css("border-radius", "4px");
                        $("#arr").css({'-webkit-transform' : 'rotate(0deg)',
                            '-moz-transform' : 'rotate(0deg)',
                            '-ms-transform' : 'rotate(0deg)',
                            'transform' : 'rotate(0deg)'});
                    }else{
                        $("#arr").css({'-webkit-transform' : 'rotate(-90deg)',
                            '-moz-transform' : 'rotate(-90deg)',
                            '-ms-transform' : 'rotate(-90deg)',
                            'transform' : 'rotate(-90deg)'});
                        $("#foo").css("border-radius", "4px 4px 0 0");
                    }
                });
                $("#btn").click(function(){
                    let nom = $("#nom").val();
                    let prenom = $("#prenom").val();
                    let ville = $("#ville").val();
                    let cin = $("#cin").val();
                    let groupe = $("#groupe").val();
                    let html = "";
                    $.ajax({
                        type: "post",
                        url: "/search",
                        data:{
                            "nom" : nom,
                            "prenom" : prenom,
                            "ville" : ville,
                            "groupe" : groupe,
                            "cin" : cin,
                            "_token" : "{{csrf_token()}}",
                        },
                        success: function(data){
                            // console.log(JSON.parse(data));
                            let resultat = JSON.parse(data);
                            html = "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\">";
                            html += "<thead>" +
                                "<tr>" +
                                "<th>Nom</th>" +
                                "<th>Prénom</th>" +
                                "<th>CIN</th>" +
                                "<th>Groupe sanguin</th>" +
                                "<th>Ville</th>" +
                                "<th>Dernier don</th>" +
                                "<th>Aptitude</th>" +
                                "<th>Actions</th>" +
                                "</tr>" +
                                "</thead>" +
                                "<thead>";
                            for(let i in resultat){
                                console.log(resultat[i]);
                                html += "<tr  id='donneur"+resultat[i].id+"'>";
                                html += "<td>" + resultat[i].nom + "</td>";
                                html += "<td>" + resultat[i].prenom + "</td>";
                                html += "<td>" + resultat[i].CIN + "</td>";
                                html += "<td>" + resultat[i].libelle +resultat[i].rhesus + "</td>";
                                html += "<td>" + resultat[i].libVille + "</td>";
                                if(resultat[i].dateDernierDon === null){
                                    html += "<td>------</td>";
                                }else{
                                    html += "<td>" + resultat[i].dateDernierDon + "</td>";
                                }
                                $.ajax({
                                    async: false,
                                    type: "post",
                                    url: "/isapte",
                                    data:{
                                        id: resultat[i].id,
                                        _token: "{{csrf_token()}}"
                                    },
                                    success: function(data){
                                        if(data === true){
                                            html += '<td><span class="btn btn-success" data-toggle="modal" data-target="">Apte</span></td>';
                                        }else{
                                            html += '<td><span class="btn btn-danger" data-toggle="modal" data-target="">Inapte</span></td>';
                                        }
                                    },
                                    error: function(){
                                        console.log("error");
                                    },
                                });
                                html += "<td>" +
                                    "<a href=\"/donneur/delete/"+resultat[i].id+"\" class=\"delete_donneur_btn\"><span class=\" btn btn-warning btn-circle btn-md glyphicon glyphicon-remove\"></span></a>" +
                                    "<a href=\"/donneur/edit/"+resultat[i].id+"\"><span class=\" btn btn-default btn-circle btn-md glyphicon glyphicon-pencil\"></span></a>" +
                                    "<a href=\"/donneur/show/"+resultat[i].id+"\"><span class=\" btn btn-default btn-circle btn-md glyphicon glyphicon-list\"></span></a>" +
                                    "<a href=\"/don/"+resultat[i].id+"\"><span class=\" btn btn-default btn-circle btn-md glyphicon glyphicon-heart\"></span></a>" +
                                    "<a href=\"/donneur/"+resultat[i].id+"/pdf\"><span class=\"btn btn-default btn-circle btn-md glyphicon glyphicon-print\"></span></a>" +
                                    "</td>";
                                html += "</tr>";
                            }
                            html += "</tbody>";
                            html += "</table>";
                            $("#panel").html(html);
                            deleteDonneur();
                        },
                        error: function(data){
                            console.log("erreur "+ data);
                        }
                    });
                });
            });
        });
    </script>
@endsection
