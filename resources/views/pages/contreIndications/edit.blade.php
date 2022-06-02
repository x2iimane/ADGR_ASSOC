@extends("layouts.app")
@section("title","Modifier la contre-indication")
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-2">
            </div>
            <?php
                $contreIndication  = \App\contreIndication::find($id);
            ?>
            <div class="col-md-4">
                <form action="/contreIndication/update/{{$id}}" method="post">
                    {{csrf_field()}}
                    <label for="nom">Nom de la contre-indication</label><input type="text" name="nom" class="form-control" value="{{$contreIndication->nom}}" id="nom"><br>
                    @if($contreIndication->type == 'provisoire')
                        <input type="radio" name="type" value="provisoire" id="provisoire" checked> <label for="provisoire">Provisoire</label><br>
                        <input type="radio" name="type" value="definitive" id="definitive"> <label for="definitive">Définitive</label><br>
                        <div id="dureediv">
                            <label for="duree">Durée de la contre-indication</label>
                            <input type="text" name="duree" class="form-control" id="duree" value="{{$contreIndication->duree}}"><br>
                            <select name="unite" class="form-control">
                                @if($contreIndication->unite == 'j')
                                    <option value="j" selected>Jours</option>
                                    <option value="m">Mois</option>
                                    <option value="a">Années</option>
                                @elseif($contreIndication->unite == 'm')
                                    <option value="j">Jours</option>
                                    <option value="m" selected>Mois</option>
                                    <option value="a">Années</option>
                                @else
                                    <option value="j">Jours</option>
                                    <option value="m">Mois</option>
                                    <option value="a" selected>Années</option>
                                @endif
                            </select><br>
                        </div>
                    @else
                        <input type="radio" name="type" value="provisoire" id="provisoire"> <label for="provisoire">Provisoire</label><br>
                        <input type="radio" name="type" value="definitive" id="definitive" checked> <label for="definitive">Définitive</label><br>
                        <div id="dureediv" style="display:none;">
                            <label for="duree">Durée de la contre-indication</label>
                            <input type="text" name="duree" class="form-control" id="duree" value="{{$contreIndication->duree}}"><br>
                            <select name="unite" class="form-control">
                                @if($contreIndication->unite == 'j')
                                    <option value="j" selected>Jours</option>
                                    <option value="m">Mois</option>
                                    <option value="a">Années</option>
                                @elseif($contreIndication->unite == 'm')
                                    <option value="j">Jours</option>
                                    <option value="m" selected>Mois</option>
                                    <option value="a">Années</option>
                                @else
                                    <option value="j">Jours</option>
                                    <option value="m">Mois</option>
                                    <option value="a" selected>Années</option>
                                @endif
                            </select><br>
                        </div>
                    @endif
                    <input type="submit" value="Ajouter" class="btn btn-primary">
                    <input type="reset" value="Annuler" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
    <script src="{{asset("js/jquery.js")}}"></script>

    <script>
        $(document).ready(function(){
            $("#definitive").on("change", function(){
                $("#dureediv").fadeOut();
            })
            $("#provisoire").on("change", function(){
                $("#dureediv").fadeIn();
            })
        });
    </script>
@endsection
