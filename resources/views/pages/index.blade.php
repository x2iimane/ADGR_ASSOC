@extends("layouts.app")
@section("title","Accueil")
@section("content")
    <head>
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
    </head>
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-tint fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{count(\App\collecteFixe::all()) + count(\App\collecteMobile::all())}}</div>
                            <div>Collectes !</div>
                        </div>
                    </div>
                </div>
                <a href="/collecte">
                    <div class="panel-footer">
                        <span class="pull-left">Afficher les détails</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-medkit fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{count(\App\Centre::all())}}</div>
                            <div>Centres !</div>
                        </div>
                    </div>
                </div>
                <a href="/centre">
                    <div class="panel-footer">
                        <span class="pull-left">Voir les détails</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-users fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{count(\App\Donneur::all())}}</div>
                            <div>Adhérents !</div>
                        </div>
                    </div>
                </div>
                <a href="/donneur">
                    <div class="panel-footer">
                        <span class="pull-left">Voir les détails</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-building fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{count(\App\Bureau::all())}}</div>
                            <div>Bureaux !</div>
                        </div>
                    </div>
                </div>
                <a href="/bureau">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <input type="hidden" id="ville" value="{{Auth::user()->zone->ville->id}}">
    @if(Auth::user()->role->id == 1)
    <div class="row">
        <div class="col-lg-10">
            <div id="foo" style="cursor: pointer; background-color: #F5F5F5; border: solid 1px #DDDDDD; padding:10px; text-align: center; border-radius: 4px 4px 0 0">Recherche avancée <span class="fa arrow" id="arr"></span></div>
            <div id="bar" style="background-color: #F5F5F5; border:solid 1px #DDDDDD; border-top: none; display:none; text-align:center; border-radius: 0 0 4px 4px; padding:20px;">
                @if(Auth::user()->role->id == 1)
                    <label for="ville">Ville</label><select id='ville'>
                        <option value="" selected>------</option>
                        @foreach(\App\Ville::all() as $ville)
                            <option value="{{$ville->id}}">{{$ville->libVille}}</option>
                        @endforeach
                    </select>
                @else
                    <input type="hidden" id="ville" value="{{Auth::user()->zone->ville->id}}">
                @endif
                {{--<label for="groupe">Groupe sanguin</label>--}}
                    {{--<select id='groupe'>--}}
                    {{--<option value="" selected>------</option>--}}
                        {{--@foreach(\App\groupeSanguin::all() as $gs)--}}
                            {{--<option value="{{$gs->id}}">{{$gs->libelle.$gs->rhesus}}</option>--}}
                        {{--@endforeach--}}
                    {{--</select><br>--}}
                <button id="btn" class="btn btn-primary">valider</button>
            </div><br>
        </div>
        <div class="col-md-3">
            Nombre de donneurs par groupe sanguin
        </div>
    </div>
    @else
        <div class="row">
            <div class="col-md-12">
                <h3>Distribution des donneurs par Groupe/aptitude</h3>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-3">
            <div id="chart">
                <apexchart type=pie width=300 :options="chartOptions" :series="series" />
            </div>
        </div>
        <div class="col-md-1">

        </div>
        <div class="col-md-3">
            <div id="chart2">
                <apexchart type=pie width=300 :options="chartOptions" :series="series" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10">
            <div id="chart3">
                <apexchart type=bar height=350 :options="chartOptions" :series="series" />
            </div>
        </div>
    </div>
    <script src="{{asset("/js/vue.js")}}"></script>
    <script src="{{asset("/js/apexchartslatest.js")}}"></script>
    <script src="{{asset("/js/jsapexcharts.js")}}"></script>
    <script src="{{asset("/js/jquery.js")}}"></script>
    <script>
        $(function(){
                let ville = $("#ville").val();
                $.ajax({
                    type: "post",
                    url: "/nbreDonneursParGroupe",
                    data: {
                        "ville": ville,
                        "_token": "{{csrf_token()}}",
                    },
                    success: function (data) {
                        let reponse = JSON.parse(data);
                        let groupesSanguins = [];
                        let nombres = [];
                        for (let i in reponse) {
                            if (reponse[i].nombre > 0) {
                                groupesSanguins.push(reponse[i]["libelleGroupe"]);
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
                        });
                    },
                    error: function () {
                    }
                });
            $.ajax({
                type: "post",
                url: "/nbreDonneursParAptitude",
                data: {
                    "ville": ville,
                    "_token": "{{csrf_token()}}",
                },
                success: function (data) {
                    let reponse = JSON.parse(data);
                    let aptitude = ["Apte", "Inapte"];
                    let nombres = [];
                        nombres.push(reponse[0].Aptes);
                        nombres.push(reponse[0].Inaptes);
                    new Vue({
                        el: '#chart2',
                        components: {
                            apexchart: VueApexCharts,
                        },
                        data: {
                            series: nombres,
                            chartOptions: {
                                labels: aptitude,
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
                    });
                },
                error: function () {
                    console.log("error");
                }
            });

            $.ajax({
                type: "post",
                url: '/eventsStats',
                data: {
                    _token: "{{csrf_token()}}",
                    ville: ville,
                },
                success: function(data){
                    let reponse = JSON.parse(data);
                    console.log(data);
                    let appels = [];
                    let presence = [];
                    let dons = [];
                    let dates = [];
                    for(let i in reponse){
                        appels.push(reponse[i].appelsTelephoniques);
                        presence.push(reponse[i].presence);
                        dons.push(reponse[i].dons);
                        dates.push(reponse[i].date);
                    }
                    new Vue({
                        el: '#chart3',
                        components: {
                            apexchart: VueApexCharts,
                        },
                        data: {
                            series: [{
                                name: 'Appels telephoniques',
                                data: appels
                            }, {
                                name: 'Présence',
                                data: presence
                            }, {
                                name: 'Dons',
                                data: dons
                            }],
                            chartOptions: {
                                plotOptions: {
                                    bar: {
                                        horizontal: false,
                                        columnWidth: '10%',
                                        endingShape: 'rounded'
                                    },
                                },
                                dataLabels: {
                                    enabled: false
                                },
                                stroke: {
                                    show: true,
                                    width: 2,
                                    colors: ['transparent']
                                },

                                xaxis: {
                                    categories: dates,
                                },
                                yaxis: {
                                    title: {
                                        text: '(Nombre de personnes)'
                                    }
                                },
                                fill: {
                                    opacity: 1

                                },
                                tooltip: {
                                    y: {
                                        formatter: function (val) {
                                            return val + " personnes"
                                        }
                                    }
                                }
                            }
                        }
                    })
                },
                error: function(){
                    console.log("error");
                }
            });



            $("#foo").click(function () {
                $("#bar").slideToggle(500, "swing", function () {
                    if ($("#bar").css("display") === "none") {
                        $("#foo").css("border-radius", "4px");
                        $("#arr").css({
                            '-webkit-transform': 'rotate(0deg)',
                            '-moz-transform': 'rotate(0deg)',
                            '-ms-transform': 'rotate(0deg)',
                            'transform': 'rotate(0deg)'
                        });
                    } else {
                        $("#arr").css({
                            '-webkit-transform': 'rotate(-90deg)',
                            '-moz-transform': 'rotate(-90deg)',
                            '-ms-transform': 'rotate(-90deg)',
                            'transform': 'rotate(-90deg)'
                        });
                        $("#foo").css("border-radius", "4px 4px 0 0");
                    }
                });
                $("#btn").click(function () {
                    $("#chart").html("<apexchart type=pie width=300 :options=\"chartOptions\" :series=\"series\" />");
                    $("#chart2").html("<apexchart type=pie width=300 :options=\"chartOptions\" :series=\"series\" />");
                    let ville = $("#ville").val();
                    $.ajax({
                        type: "post",
                        url: "/nbreDonneursParGroupe",
                        data: {
                            "ville": ville,
                            "_token": "{{csrf_token()}}",
                        },
                        success: function (data) {
                            let reponse = JSON.parse(data);
                            let groupesSanguins = [];
                            let nombres = [];
                            for (let i in reponse) {
                                if (reponse[i].nombre > 0) {
                                    groupesSanguins.push(reponse[i]["libelleGroupe"]);
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
                            });
                        },
                        error: function () {
                            console.log("error");
                        }
                    });
                    $.ajax({
                        type: "post",
                        url: "/nbreDonneursParAptitude",
                        data: {
                            "ville": ville,
                            "_token": "{{csrf_token()}}",
                        },
                        success: function (data) {
                            let reponse = JSON.parse(data);
                            let aptitude = ["Apte", "Inapte"];
                            let nombres = [];
                            nombres.push(reponse[0].Aptes);
                            nombres.push(reponse[0].Inaptes);
                            new Vue({
                                el: '#chart2',
                                components: {
                                    apexchart: VueApexCharts,
                                },
                                data: {
                                    series: nombres,
                                    chartOptions: {
                                        labels: aptitude,
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
                            });
                        },
                        error: function () {
                            console.log("error");
                        }
                    });
                });
            });

        });
    </script>
@endsection