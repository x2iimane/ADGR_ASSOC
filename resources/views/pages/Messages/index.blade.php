@extends("layouts.app")
@if(Auth::guard("donneur")->check())
    @section("title","Mes messages")
@else
    @section("title","Messages")
@endif
@section("content")
    @if(Auth::guard("donneur")->check())
        <a href="/message/create"><button class="btn btn-primary">Nouveau message</button></a>
    @endif
    <table class="table table-responsive table-striped table-hover">
        <thead>
            <tr>
                @if(Auth::guard("benevole")->check())
                    @if(Auth::user()->role->id == 1 || Auth::user()->role->id == 2)
                        <th>Donneur</th>
                    @endif
                @endif
                <th>Objet</th>
                <th>Contenu</th>
                <th>Statut</th>
                <th>Actions </th>
            </tr>
        </thead>
        <tbody>
        @if(Auth::guard("donneur")->check())
            @foreach(\App\Message::all()->where("donneur_id", "=", Auth::user()->id) as $message)
                <?php
                    $statut = $message->status == 1?"Envoyé":"Clos";
                ?>
                <tr>
                    <td>{{$message->objet}}</td>
                    <td>{!!  str_limit($message->contenu, 35) !!}</td>
                    <td>{{$statut}}</td>
                    <td>
                        <a href="/message/delete/{{$message->id}}">Supprimer</a>
                        <a href="/message/show/{{$message->id}}">Afficher</a>
                    </td>
                </tr>
            @endforeach
        @else
            @if(Auth::user()->role->id == 1)
                @foreach(\App\Message::all() as $message)
                    <?php
                        $statut = $message->status == 1?"Envoyé":"Clos";
                    ?>
                    <tr>
                        @if(Auth::guard("benevole")->check())
                            @if(Auth::user()->role->id == 1 || Auth::user()->role->id == 2)
                                <td><a href="/donneur/show/{{$message->donneur->id}}">{{$message->donneur->nom." ".$message->donneur->prenom}}</a></td>
                            @endif
                        @endif
                        <td>{{$message->objet}}</td>
                        <td>{!!  str_limit($message->contenu, 35) !!}</td>
                        <td>{{$statut}}</td>
                        <td>
                            <a href="/message/delete/{{$message->id}}">Supprimer</a>
                            <a href="/message/show/{{$message->id}}">Afficher</a>
                        </td>
                    </tr>
                @endforeach
            @elseif(Auth::user()->role->id == 2)
                @foreach(\App\Message::all() as $message)
                    <?php
                        $statut = $message->status == 1?"Envoyé":"Clos";
                    ?>
                    @if($message->donneur->zone->ville->id == Auth::user()->zone->ville->id)
                        <tr>
                            @if(Auth::guard("benevole")->check())
                                @if(Auth::user()->role->id == 1 || Auth::user()->role->id == 2)
                                    <td><a href="/donneur/show/{{$message->donneur->id}}">{{$message->donneur->nom." ".$message->donneur->prenom}}</a></td>
                                @endif
                            @endif
                            <td>{{$message->objet}}</td>
                            <td>{!! str_limit($message->contenu,35) !!}</td>
                            <td>{{$status}}</td>
                            <td>
                                <a href="/message/delete/{{$message->id}}">Supprimer</a>
                                <a href="/message/answer/{{$message->id}}">Afficher</a>
                            </td>
                        </tr>
                    @endif
                @endforeach
            @endif
        @endif
        </tbody>
    </table>
@endsection