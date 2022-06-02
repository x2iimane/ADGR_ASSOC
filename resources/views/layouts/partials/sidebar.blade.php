    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li class="sidebar-search">
                    <div class="input-group custom-search-form">
                        <input type="text" id="montext" class="form-control" placeholder="Search...">
                        <span class="input-group-btn" id="btnSearch">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                        </span>
                    </div>
                    <!-- /input-group -->
                </li>
                <li>
                <span id="searchResults" style="display:none;">
                    <!-- Search results -->
                </span>
                </li>
                <li>
                    <a href="/"><i class="fa fa-dashboard fa-fw"></i> Accueil</a>
                </li>
                @if(Auth::guard("benevole")->check())
                @if(Auth::user()->role->id == 1 || Auth::user()->role->id == 2)
                <li>
                    <a href="#"><i class="fa fa-medkit fa-fw"></i> Gestion des dons <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="/collecte"><i class="fa fa-tint fa-fw"></i>Collectes</a>
                            <a href="/donneur"><i class="fa fa-users fa-fw"></i> Donneurs</a>
                            <a href="/contreIndication"><i class="fa fa-remove fa-fw"></i> Contre indications</a>
                            <a href="/centre"> <i class="fa fa-building fa-fw"></i> Centres</a>
                            @if(Auth::user()->role->id == 1)
                                <a href="/ville"><i class="fa fa-home fa-fw"></i> Villes</a>
                            @endif
                            <a href="/zone"><i class="fa fa-map-marker fa-fw"></i> Zones</a>
                            <a href="/bureau"><i class="fa fa-desktop fa-fw"></i> Bureaux</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                @elseif (Auth::user()->role->id == 4)
                    <li>
                        <a href="/contreIndication"><i class="fa fa-remove fa-fw"></i> Contre indications</a>
                    </li>
                @endif
                @if(Auth::user()->role->id == 3 || Auth::user()->role->id == 1)
                <li>
                    <a href="#"><i class="fa fa-dollar fa-fw"></i> Gestion financière<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="/compte"><i class="fa fa-briefcase fa-fw"></i> Comptes</a>
                            <a href="/entrees"><i class="fa fa-plus fa-fw"></i> Entrées</a>
                            <a href="/depense"><i class="fa fa-minus fa-fw"></i> Dépenses</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                @endif
            @if(Auth::user()->role->id == 1 || Auth::user()->role->id == 2)
                <li>
                    <a href="#"><i class="fa fa-heart fa-fw"></i> Gestion des événements <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="/evenement"><i class="fa fa-heart fa-fw"></i> Evenement </a>
                            <a href="/equipe"><i class="fa fa-users fa-fw"></i> Equipes</a>
                            <a href="/comite"><i class="fa fa-users fa-fw"></i> Comités</a>
                            <a href="/benevole"><i class="fa fa-user fa-fw"></i> Benevoles</a>
                            <a href="/appelTelephonique"><i class="fa fa-phone fa-fw"></i> Appels téléphoniques</a>
                        </li>
                    </ul>
                </li>
            @endif
            @endif
                <li>
                    <a href="/message"><i class="fa fa-comments fa-fw"></i> Support </a>
                </li>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <script src="{{asset("js/jquery.js")}}"></script>
    <script>
        function recherche(){
            let motCle = "";
            let recherche = "";
            let option = "";
            $("#montext").keyup(function(){
                if($(this).val()[0] === "@"){
                    // texte = $(this).val().substr(1).split(" ");
                    // if(event.keyCode === 13){
                        let myVar = $(this).val().substr(1).split(" ");
                        motCle = "";
                        recherche = "";
                        option = "";
                        motCle = myVar[0];
                        for(let i = 1; i < myVar.length ; i++){
                            if(myVar[i][0]+myVar[i][1] !== "--"){
                                recherche += myVar[i];
                            }else{
                                option = myVar[i];
                            }
                            if(i < myVar.length - 1){
                                recherche += " ";
                            }
                        }
                        motCle = motCle.toLowerCase();
                        recherche = recherche.toLowerCase();
                        option = option.substr(2).toLowerCase();
                        $.ajax({
                            url: "/search",
                            type: 'post',
                            data: {
                                _token:"{{csrf_token()}}",
                                motCle : motCle,
                                recherche: recherche,
                                option : option,
                            },
                            success: function(data){
                                let html = "";
                                let reponse = JSON.parse(data);
                                if(data !== ""){
                                    for(let i in reponse){
                                        html += "<a href='/"+motCle+"/show/"+reponse[i]['id']+"'>"+reponse[i]["nom"]+" "+ reponse[i]["prenom"]+"</a><br>";
                                    }
                                    $("#searchResults").html(html).slideDown();
                                }else{
                                    $("#searchResults").html(html).up();
                                }
                            },
                            error: function(){

                            }
                        });
                    }
                // }
            });
        }
        $(document).ready(recherche());
    </script>