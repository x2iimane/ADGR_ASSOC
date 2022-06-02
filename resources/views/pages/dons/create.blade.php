@extends("layouts.app")
@section("title","Nouveau don")
@section("content")
    <div class="container">
        <input type="radio" name="type" id="donADGR" checked><label for="donADGR">Don ADGR</label>
        <input type="radio" name="type" id="donExt"><label for="donExt">Don externe</label>
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-4">
                <div id="donADGRDiv">
                    <form action="/don/adgr/store" method="post">
                        {{csrf_field()}}
                        <label for="collecte">Collecte</label>
                        <select id="collecte" name="collecte" class="form-control">
                            @foreach(App\collecteFixe::all() as $collecte)
                                <option value="{{$collecte->id}}">{{$collecte->libCollecte}}</option>
                            @endforeach
                            {{--@foreach(App\collecteMobile::all() as $collecte)--}}
                                {{--<option value="{{$collecte->id}}">{{$collecte->libCollecte}}</option>--}}
                            {{--@endforeach--}}
                        </select><br>
                        <label for="donneur">CIN du donneur</label>
                        <select name="donneur" id="donneur" class="form-control">
                            @foreach(\App\Donneur::all() as $donneur)
                                <option value="{{$donneur->id}}">{{$donneur->nom . " " . $donneur->prenom . "(".$donneur->CIN.")"}}</option>
                            @endforeach
                        </select><br>
                        <input type="hidden" name="typeCollecte" value="0">
                        <input type="submit" value="Ajouter" class="btn btn-primary">
                        <input type="reset" value="Annuler" class="btn btn-primary">
                    </form>
                </div>
                <div id="donExtDiv" style="display:none">
                    <form action="/don/externe/store" method="post">
                        {{csrf_field()}}
                        <label for="donneur">Donneur</label>
                        <select name="donneur" id="donneur" class="form-control">
                            @foreach(\App\Donneur::all() as $donneur)
                                <option value="{{$donneur->id}}">{{$donneur->nom . " " . $donneur->prenom . "(".$donneur->CIN.")"}}</option>
                            @endforeach
                        </select><br>
                        <input type="hidden" name="typeCollecte" value="1">

                        <label for="raison">Raison du don</label>
                        <input type="text" name="raison" class="form-control" id="raison"><br>

                        <input type="submit" value="Ajouter" class="btn btn-primary">
                        <input type="reset" value="Annuler" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script
            src="/js/jquery.js">
    </script>
    <script>
        $(document).ready(function () {
            $("#donADGR").on("change",function(){
                $("#donExtDiv").fadeOut();
                $("#donADGRDiv").delay(400).fadeIn();
            });
            $("#donExt").on("change",function(){
                $("#donADGRDiv").fadeOut();
                $("#donExtDiv").delay(400).fadeIn();
            });
        })
    </script>
@endsection
