@extends("layouts.app")
@section("title","Modifier un comité")
@section("content")
    <?php
    if(isset($id)){
        $comite = \App\Comite::find($id);
        }
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form action="/comite/update/{{$comite->id}}" method="post">
                    {{csrf_field()}}
                    <fieldset>
                        <legend>Membres</legend>
                        @foreach(\App\Benevole::all() as $benevole)
                            @if(count($benevole->benevoleComite) > 0)
                                <?php
                                $flag = false;
                                ?>
                                @foreach ($benevole->benevoleComite as $be)
                                    @if($be->comite->id == $comite->id)
                                        <?php
                                        $flag = true;
                                        ?>
                                    @endif
                                    @if($flag)
                                        <input type="checkbox" class="membres" data-nom="{{$benevole->nom." ". $benevole->prenom}}" name="membres[]" value="{{$benevole->id}}" id="benevole{{$benevole->id}}" checked> <label for="benevole{{$benevole->id}}">{{$benevole->nom." ". $benevole->prenom}}</label>
                                        <a href="/benevole/show/{{$benevole->id}}">Afficher...</a><br>
                                    @else
                                        <input type="checkbox" class="membres" data-nom="{{$benevole->nom." ". $benevole->prenom}}" name="membres[]" value="{{$benevole->id}}" id="benevole{{$benevole->id}}"> <label for="benevole{{$benevole->id}}">{{$benevole->nom." ". $benevole->prenom}}</label>
                                        <a href="/benevole/show/{{$benevole->id}}">Afficher...</a><br>
                                    @endif
                                @endforeach
                            @else
                                <input type="checkbox" class="membres" data-nom="{{$benevole->nom." ". $benevole->prenom}}" name="membres[]" value="{{$benevole->id}}" id="benevole{{$benevole->id}}"> <label for="benevole{{$benevole->id}}">{{$benevole->nom." ". $benevole->prenom}}</label>
                                <a href="/benevole/show/{{$benevole->id}}">Afficher...</a><br>
                            @endif
                        @endforeach
                    </fieldset><br>
                    <div id="selectRespo">
                        <label for="responsable">Responsable</label>
                        <div class="well">Choisissez un membre !</div>
                    </div>
                    <input type="submit" value="Créer" class="btn btn-primary">
                    <input type="reset" value="Annuler" class="btn btn-danger">
                </form>
            </div>
        </div>
    </div>
    <script src="/js/jquery.js"></script>
    <script>
        $(document).ready(function(){
            $(".membres").on("change", function(){
                let html = "<label for=\"responsable\">Responsable</label>" +
                    "<select name='responsable' id='responsable' class='form-control'>";
                let flag = false;
                $(".membres").each(function(){
                    if($(this).prop("checked") === true){
                        html += "<option value='"+$(this).attr("value")+"'>"+$(this).attr("data-nom")+"</option>"
                        flag = true;
                    }
                });
                html +="</select><br>";
                if(!flag) html="<div class=\"well\">Choisissez un membre !</div>";
                $("#selectRespo").html(html);
            });
        });
    </script>
@endsection