<!DOCTYPE html>
<html lang="en">
    @include("layouts.partials.head")
    <body>
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            @include("layouts.partials.navbar")
            @include("layouts.partials.sidebar")
        </nav>
        <div id="wrapper">
            <div id="page-wrapper">
                <div class="row">
                    @include("layouts.partials.pageHeader")
                </div>
                @yield("content")
            </div>
            <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->

        <!-- jQuery -->
        <script src="{{asset("vendor/jquery/jquery.min.js")}}"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="{{asset("vendor/bootstrap/js/bootstrap.min.js")}}"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="{{asset("vendor/metisMenu/metisMenu.min.js")}}"></script>

        <!-- Morris Charts JavaScript -->
        <script src="{{asset("vendor/raphael/raphael.min.js")}}"></script>
        <script src="{{asset("vendor/morrisjs/morris.min.js")}}"></script>
        <script src="{{asset("data/morris-data.js")}}"></script>

        <!-- DataTables JavaScript -->
        <script src="{{asset("vendor/datatables/js/jquery.dataTables.min.js")}}"></script>
        <script src="{{asset("vendor/datatables-plugins/dataTables.bootstrap.min.js")}}"></script>
        <script src="{{asset("vendor/datatables-responsive/dataTables.responsive.js")}}"></script>
        <script>
            $(document).ready(function() {
                $('.dataTables-example').DataTable({
                    responsive: true
                });
            });
        </script>

        <!-- Custom Theme JavaScript -->
        <script src="{{asset("dist/js/sb-admin-2.js")}}"></script>
    </body>
</html>
