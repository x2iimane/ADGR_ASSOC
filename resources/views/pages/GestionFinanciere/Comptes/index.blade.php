@extends("layouts.app")
@section("title", "Comptes")
@section("content")
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-9">
                        Comptes
                    </div>
                    <div class="col-md-3">
                        <a href="/compte/create"><button class="btn btn-primary"> <span class="glyphicon glyphicon-plus"></span> Ajouter un compte</button></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <table width="100%" class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Libelle</th>
                    <th>Solde</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                        $comptes = App\Compte::paginate(10);
                    ?>
                    @foreach($comptes as $compte)
                        <tr>
                            <?php
                                $type = $compte->type==0?"Secondaire":"Principal";
                            ?>
                            <td>{{$compte->libelle}}</td>
                            <td>{{$compte->solde}} DH</td>
                            <td>{{$type}}</td>
                                <td>
                                    <a href="compte/delete/{{$compte->id}}"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>
                                    <a href="compte/edit/{{$compte->id}}"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>
                                    <a href="compte/show/{{$compte->id}}"><span class="glyphicon glyphicon-list"></span> Afficher</a>
                                </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{$comptes->links()}}
        </div>
    </div>
@endsection