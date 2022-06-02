<!doctype html>
<html lang="fr">
<head>
@section("title", "Collecte")
@include("layouts.partials.head")
<link rel="stylesheet" type="text/css" href="{{asset("/css/styles.css")}}">
<style>
    #chart {
        max-width: 380px;
        margin: 35px auto;
    }
    #chart2{
        max-width: 380px;
        margin: 35px auto;
    }
</style>
<script src="{{asset("/js/vue.js")}}"></script>
<script src="{{asset("/js/apexchartslatest.js")}}"></script>
<script src="{{asset("/js/jsapexcharts.js")}}"></script>
<style>
    body{
        background-color: white;
    }
</style>
</head>
<body>
    @if(isset($id))
        <?php
            $collecte = \App\collecte::find($id);
        ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <img src="{{asset("/storage/logo.jpg")}}" width="200px">
                </div>
                <div class="col-md-6" style="text-align:center;">
                    <h1>Collecte: {{$collecte->collecte->libCollecte}}</h1>
                    <div class="well" style="text-align:left;">
                        <b>Date de la collecte:</b> {{$collecte->collecte->date}}<br>
                        <b>Nombre de présents:</b> {{$collecte->collecte->nombre_presents}}<br>
                        <b>Nombre de contre indiqués:</b> {{$collecte->collecte->nombre_contre_indiques}}<br>
                        <b>Nombre de dons:</b> {{count(\App\donAdgr::where("collecte_id","=", $collecte->id)->get())}}<br>
                        <b>Ville:</b>
                        @if($collecte->typeCollecte == 1)
                            {{$collecte->collecte->centre->zone->ville->libVille}}<br>
                            <b>Centre: </b> {{$collecte->collecte->centre->libCentre}}<br>
                        @else
                            {{$collecte->collecte->zone->ville->libVille}}<br>
                            <b>Zone: </b>{{$collecte->collecte->zone->libZone}}
                        @endif

                    </div>
                </div>
                <div class="col-md-3">
                    {{date("d-m-Y H:i:s")}}
                </div>
            </div>
            <div class="row">
                <div class="col-md-11">
                    <h3>Liste des donneurs:</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-responsive table-hover table-striped">
                        <thead>
                        <tr>
                            <th>CIN</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Groupe sanguin</th>
                            <th>Age</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($collecte->dons as $don)
                                <tr>
                                    <td>{{$don->donneur->CIN}}</td>
                                    <td>{{$don->donneur->nom}}</td>
                                    <td>{{$don->donneur->prenom}}</td>
                                    <td>{{$don->donneur->groupeSanguin->libelle." ".$collecte->dons()->first()->donneur->groupeSanguin->rhesus}}</td>
                                    <td>{{$don->donneur->getAge()}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-11">
                    <h3>Statistiques:</h3>
                </div>
            </div>
            <div class="row" style="text-align: center;">
                <div class="col-md-4">
                    <strong>Distribution des dons par groupe sanguin</strong>
                    <div id="chart">
                        <apexchart type=pie width=380 :options="chartOptions" :series="series" />
                    </div>
                </div>
                <div class="col-md-4" >
                    <strong>Distribution des donneurs par zone</strong>
                    <div id="chart2">
                        <apexchart type=pie width=380 :options="chartOptions" :series="series" />
                    </div>
                </div>
                <div class="col-md-4">

                </div>
            </div>
        </div>
    @endif
    <script src="/js/jquery.js"></script>
    <script>
        $(function(){
            $.ajax({
                type: "post",
                url: "/donsParGroupeSanguin",
                data: {
                    collecte_id : "{{$collecte->id}}",
                    _token : "{{csrf_token()}}",
                },
                success: function(data){
                    reponse = JSON.parse(data);
                    let groupesSanguins = [];
                    let nombres = [];
                    for(let i in reponse){
                        if(reponse[i]["nombre"] > 0){
                            groupesSanguins.push(reponse[i]["libelle"]);
                            nombres.push(reponse[i]["nombre"]);
                        }
                    }
                    new Vue({
                        el: '#chart',
                        components: {
                            apexchart: VueApexCharts,
                        },
                        data: {
                            series: nombres,
                            chartOptions: {
                                labels: groupesSanguins,
                                responsive: [{
                                    breakpoint: 480,
                                    options: {
                                        chart: {
                                            width: 200
                                        },
                                        legend: {
                                            position: 'bottom'
                                        }
                                    }
                                }]
                            }
                        },

                    })
                },
                error: function(){
                    alert("Une erreur s'est produite");
                }
            });
            $.ajax({
                type: "post",
                url: "/donsParZone",
                data:{
                    collecte_id : "{{$collecte->id}}",
                    _token: "{{csrf_token()}}",
                },
                success: function(data){
                    reponse = JSON.parse(data);
                    let zones = [];
                    let nombres = [];
                    for(let i in reponse){
                        if(reponse[i]["nombre"] > 0){
                            zones.push(reponse[i]["zone"]);
                            nombres.push(reponse[i]["nombre"]);
                        }
                    }
                    console.log(zones);
                    new Vue({
                        el: '#chart2',
                        components: {
                            apexchart: VueApexCharts,
                        },
                        data: {
                            series: nombres,
                            chartOptions: {
                                labels: zones,
                                responsive: [{
                                    breakpoint: 480,
                                    options: {
                                        chart: {
                                            width: 200
                                        },
                                        legend: {
                                            position: 'bottom'
                                        }
                                    }
                                }]
                            }
                        },

                    })
                },
                error: function(){
                    alert("Une erreur s'est produite");
                }
            });
        });
    </script>
</body>
</html>