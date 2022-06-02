@extends("layouts.app")
@section("title","Ajouter un appel téléphonique")
@section("content")
    <div class="container-fluid">
        {{--<div class="col-md-3"></div>--}}
        <div class="col-md-12">
            <form action="/appelTelephonique/store" method="post">
                {{csrf_field()}}
                <label for="event">Evénement</label>
                <select id="event" name="evenement" class="form-control" style="width:20%">
                    @foreach (\App\Evenement::all() as $evenement)
                        <option value="{{$evenement->id}}">{{$evenement->libelle}}</option>
                    @endforeach
                </select><br>
                <table class="table table-striped table-responsive table-bordered">
                    <thead>
                        <tr>
                            <td>Nom</td>
                            <td>Prenom</td>
                            <td>Numero de téléphone</td>
                            <td>Numero de téléphone secondaire</td>
                            <td>Appelé?</td>
                            <td>Réponse</td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $donneurs = \App\Donneur::paginate(10);
                    ?>
                        @foreach($donneurs as $donneur)
                            @if(Auth::user()->role->id != 1)
                                @if($donneur->zone->ville->id == Auth::user()->zone->ville->id)
                                    @if($donneur->isApte())
                                        <tr>
                                            <td>{{$donneur->nom}}</td>
                                            <td>{{$donneur->prenom}}</td>
                                            <td>{{$donneur->numeroTelephone}}</td>
                                            <td>{{$donneur->numeroTelephoneSecondaire}}</td>
                                            <td>
                                                <input type="checkbox" class="checkboxes" data-target="select{{$donneur->id}}" name="donneursAppeles[]" value="{{$donneur->id}}">
                                            </td>
                                            <td>
                                                <select name="reponses[]" class="form-control" id="select{{$donneur->id}}" disabled>
                                                    <option value="1">Favorable</option>
                                                    <option value="2">Défavorable</option>
                                                    <option value="3">Pas de réponse</option>
                                                    <option value="4">A rappeler</option>
                                                </select>
                                            </td>
                                        </tr>
                                    @endif
                                @endif
                            @else
                                @if($donneur->isApte())
                                    <tr>
                                        <td>{{$donneur->nom}}</td>
                                        <td>{{$donneur->prenom}}</td>
                                        <td>{{$donneur->numeroTelephone}}</td>
                                        <td>{{$donneur->numeroTelephoneSecondaire}}</td>
                                        <td>
                                            <input type="checkbox" data-target="select{{$donneur->id}}" name="donneursAppeles[]" value="{{$donneur->id}}">
                                        </td>
                                        <td>
                                            <select class="form-control"  id="select{{$donneur->id}}" name="reponses[]" disabled>
                                                <option value="1">Favorable</option>
                                                <option value="2">Défavorable</option>
                                                <option value="3">Pas de réponse</option>
                                                <option value="4">A rappeler</option>
                                            </select>
                                        </td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                    </tbody>
                </table>
                {!! $donneurs->links() !!}
                <input type="hidden" value="{{auth()->user()->id}}" name="benevole">
                <input type="submit" class="btn btn-primary" value="Enregistrer">
                <input type="reset" class="btn btn-danger" value="Annuler">
            </form>
        </div>
    </div>
    <script src="/js/jquery.js"></script>
    <script>
        $(function(){
                $("input[type=checkbox]").each(function(){
                    $(this).on("change", function(){
                        if($(this).prop("checked")){
                            $("#"+$(this).attr("data-target")).prop("disabled", false);
                        }else{
                            $("#"+$(this).attr("data-target")).prop("disabled", true);
                        }
                    });
                });
        });
    </script>
@endsection