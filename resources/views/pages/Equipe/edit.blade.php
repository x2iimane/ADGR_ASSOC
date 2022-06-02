@extends("layouts.app")
@section("title","Modifier une équipe")
@section("content")
    <?php
    if(isset($id)){
        $equipe = \App\Equipe::find($id);
    }

    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form action="/equipe/update/{{$equipe->id}}" method="post">
                    {{csrf_field()}}
                    <label for="evenement">Evénement</label>
                    <select name="evenement" id="evenement" class="form-control">
                                <option value="{{$equipe->evenement->id}}">{{$equipe->evenement->libelle}}</option>
                        @foreach(\App\Evenement::all() as $event)
                            @if(! $event->equipe)
                                <option value="{{$event->id}}">{{$event->libelle}}</option>
                            @endif
                        @endforeach
                    </select><br>
                    <fieldset>
                        <legend>Membres</legend>
                            @foreach(\App\Benevole::all() as $benevole)
                                <?php
                                    $flag1 = false;
                                ?>
                                    @foreach ($benevole->benevoleEquipe as $be)
                                        <?php
                                            $flag2 = false;
                                        ?>
                                        @if($be->equipe->id == $equipe->id)
                                            <?php
                                                $flag1 = true;
                                                $flag2 = true;
                                            ?>
                                        @endif
                                        @if($flag2)

                                                <input type="checkbox" class="membres" data-nom="{{$benevole->nom." ". $benevole->prenom}}" name="membres[]" value="{{$benevole->id}}" id="benevole{{$benevole->id}}" checked> <label for="benevole{{$benevole->id}}">{{$benevole->nom." ". $benevole->prenom}}</label>
                                                <a href="/benevole/show/{{$benevole->id}}">Afficher...</a><br>
                                        @endif
                                    @endforeach
                                @if(!$flag1)
                                        <input type="checkbox" class="membres" data-nom="{{$benevole->nom." ". $benevole->prenom}}" name="membres[]" value="{{$benevole->id}}" id="benevole{{$benevole->id}}"> <label for="benevole{{$benevole->id}}">{{$benevole->nom." ". $benevole->prenom}}</label>
                                        <a href="/benevole/show/{{$benevole->id}}">Afficher...</a><br>
                                @endif
                            @endforeach
                    </fieldset><br>
                    <div id="selectRespo">
                        <label for="responsable">Responsable</label>
                        <div class="well">Choisissez un membre !</div>
                    </div>
                    <input type="submit" value="Modifier" class="btn btn-primary">
                    <input type="reset" value="Annuler" class="btn btn-danger">
                </form>
            </div>
        </div>
    </div>
    <script src="{{asset("js/jquery.js")}}"></script>
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