<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,AngularJS,Angular,Angular2,jQuery,CSS,HTML,RWD,Dashboard">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Presensi MGE</title>

    <!-- Icons -->
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/simple-line-icons.css" rel="stylesheet">

    <!-- Main styles for this application -->
    <link href="/css/style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/daterangepicker/daterangepicker.css">
    <style type="text/css">
        .breadcrumb-menu.hidden-md-down{
            display: none;
        }
    </style>
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    <header class="app-header navbar">
        <button class="navbar-toggler mobile-sidebar-toggler hidden-lg-up" type="button">☰</button>
        <a class="navbar-brand" href="#"></a>
        <ul class="nav navbar-nav hidden-md-down">
            <li class="nav-item">
                <a class="nav-link navbar-toggler sidebar-toggler" href="#">☰</a>
            </li>
        </ul>
        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <!-- <img src="img/avatars/6.jpg" class="img-avatar" alt="admin@bootstrapmaster.com"> -->
                    <span class="hidden-md-down">{{session('username')}}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">

                    <div class="dropdown-header text-center">
                        <strong>Account</strong>
                    </div>

                    <a class="dropdown-item" href="/setting"><i class="fa fa-gear"></i> Setting</a>
                    <a class="dropdown-item" href="/logout"><i class="fa fa-lock"></i> Logout</a>
                </div>
            </li>
        </ul>
    </header>

    <div class="app-body">
        <div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/"><i class="icon-login"></i> Presensi</a>
                    </li>
                    @if(session('role')=="admin")
                    <li class="nav-item">
                        <a class="nav-link <?php if($TAG=='manajemen') echo 'active'; ?>" href="/manajemen"><i class="icon-layers"></i> Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($TAG=='presensibulanan') echo 'active'; ?>" href="/presensibulanan"><i class="icon-layers"></i> Presensi Bulanan</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link <?php if($TAG=='bookmark') echo 'active'; ?>" href="/bookmark"><i class="icon-notebook"></i> Bookmark</a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main content -->
        <main class="main">
            @yield('content')
        </main>
    </div>

    <footer class="app-footer">
        <a href="http://coreui.io">CoreUI</a> © 2017 creativeLabs.
        <span class="float-right">Powered by <a href="http://coreui.io">CoreUI</a>
        </span>
    </footer>

    <!-- Bootstrap and necessary plugins -->
    <script src="/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/bower_components/tether/dist/js/tether.min.js"></script>
    <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- <script src="/bower_components/pace/pace.min.js"></script> -->


    <!-- Plugins and scripts required by all views -->
    <!-- <script src="/bower_components/chart.js/dist/Chart.min.js"></script> -->


    <!-- GenesisUI main scripts -->

    <!-- <script src="/js/app.js"></script> -->





    <!-- Plugins and scripts required by this views -->

    <!-- Custom scripts required by this view -->
    <!-- <script src="/js/views/main.js"></script> -->
    <script type="text/javascript" src="/daterangepicker/moment.min.js"></script>
    <script type="text/javascript" src="/daterangepicker/daterangepicker.js"></script>
    <script>
        $(".btn-will-disabled").click(function(){
            $(this).text("Sek, ojo di klik maneh, sabar \n ngko lek error lak ketok ;) ");
            $(this).attr('disabled','disabled');
        });

        $('input.singletime').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD HH:mm'
            },
            timePicker24Hour:true,
            timePicker: true,
            timePickerIncrement: 10,
            singleDatePicker: true
        });
    </script>
    @yield('script')
</body>

</html>