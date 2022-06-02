@extends("layouts.app")
@section("title", "Dépenses")
@section("content")
    <div class="container-fluid">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-9">
                                Dépenses
                            </div>
                            <div class="col-md-3">
                                <a href="/depense/create"><button class="btn btn-primary"> <span class="glyphicon glyphicon-plus"></span> Ajouter une dépense</button></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped">
                        <thead>
                        <tr>
                            <th>Compte</th>
                            <th>Evenement</th>
                            <th>Montant</th>
                            <th>Categorie</th>
                            <th>Motif</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $depenses = \App\depense::paginate(10);
                        ?>
                        @foreach($depenses as $depense)
                            <tr>
                                <td>{{$depense->compte->libelle}}</td>
                                <td>{{$depense->evenement->libelle}}</td>
                                <td>{{$depense->montant}}</td>
                                <td>
                                    <?php
                                        $catDep = App\categorieDepense::find($depense->categorie_depense_id);
                                    ?>
                                    {{$catDep->libelle}}
                                </td>
                                <td>{{$depense->motif}}</td>
                                <td>
                                    <a href="/depense/delete/{{$depense->id}}"><span class=" btn btn-warning btn-circle btn-md glyphicon glyphicon-remove removeCollecte"></span></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$depenses->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
