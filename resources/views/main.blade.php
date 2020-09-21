<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> @yield('title') Monitoring PO - Daisen</title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="{{ asset('style/vendors/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('style/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('style/vendors/themify-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('style/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('style/vendors/selectFX/css/cs-skin-elastic.css') }}">
    <link rel="stylesheet" href="{{ asset('style/assets/css/style.css') }}">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

</head>

<body>


    <script src="{{ asset('style/vendors/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('style/vendors/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('style/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('style/assets/js/main.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>  

    
    


    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <header id="header" class="header">

            <div class="header-menu">

                <div class="col-sm-3">
                    <div class="header-left">
                        <img src="{{ asset('style/images/logo_daisen.png') }}" width="80" alt="">
                        <div class="form-inline">
                            <form class="search-form">
                                <input class="form-control mr-sm-2" type="text" placeholder="Search ..." aria-label="Search">
                                <button class="search-close" type="submit"><i class="fa fa-close"></i></button>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="card-body card-block">
                    </div>
                </div>
                <div class="col-`-5">
                    <div class="card-body card-block">
                    </div>
                </div>
            </div>

        </header><!-- /header -->
        @yield('content')
        <div class="content mt-3">
            <div class="animated fadeIn">
            </div>
        </div> 
    </div>
    <script src="{{ asset('style/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('style/vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('style/vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset('style/vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('style/vendors/jszip/dist/jszip.min.js')}}"></script>
    <script src="{{ asset('style/vendors/pdfmake/build/pdfmake.min.js')}}"></script>
    <script src="{{ asset('style/vendors/pdfmake/build/vfs_fonts.js')}}"></script>
    <script src="{{ asset('style/vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('style/vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{ asset('style/vendors/datatables.net-buttons/js/buttons.colVis.min.js')}}"></script>
    <script src="{{ asset('style/assets/js/init-scripts/data-table/datatables-init.js')}}"></script>
</body>

</html>
