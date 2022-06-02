@section("title", "Connexion")
        <!DOCTYPE html>
<html lang="en">

@include("layouts.partials.head")
<body>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Veuillez vous Connecter <strong>(Donneur)</strong></h3>
                </div>
                <div class="panel-body">
                    <form role="form" action="{{route("donneur.login.submit")}}" method="post" >
                        {{csrf_field()}}
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Nom d'utilisateur" name="username" type="text" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Mot de passe" name="password" type="password" value="">
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                </label>
                            </div>
                            <input type='submit' class="btn btn-lg btn-success btn-block" value="Se connecter">

                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>
