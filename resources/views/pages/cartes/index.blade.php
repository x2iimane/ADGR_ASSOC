@extends("layouts.app")
@section("title","Cartes")
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Dons
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>CIN</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Etat de la carte</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cartes as $carte)
                                    <tr>
                                        <td>{{$carte->donneur->CIN}}</td>
                                        <?php
                                            $donneur = \App\Donneur::find($carte->donneur->id);
                                        ?>
                                        <td>{{$donneur->nom}}</td>
                                        <td>{{$donneur->prenom}}</td>
                                        <td>
                                            @if($carte->etatCarte == 1)
                                                Conçue
                                            @elseif($carte->etatCarte == 2)
                                                Imprimée
                                            @else
                                                Livrée
                                            @endif
                                        </td>
                                        <td>
                                            <a href="/carte/delete/{{$carte->id}}"><span class=" btn btn-warning btn-circle btn-md glyphicon glyphicon-remove removeCollecte"></span></a>
                                            <a href="/carte/edit/{{$carte->id}}"><span class=" btn btn-default btn-circle btn-md glyphicon glyphicon-pencil"></span></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{$cartes->links()}}
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.panel-body -->
                </div>
            </div>
        </div>
    </div>
    <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous">

    </script>
@endsection