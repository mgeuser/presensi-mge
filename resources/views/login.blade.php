<!--
 * CoreUI - Open Source Bootstrap Admin Template
 * @version v1.0.0-alpha.4
 * @link http://coreui.io
 * Copyright (c) 2017 creativeLabs Łukasz Holeczek
 * @license MIT
 -->
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="CoreUI Bootstrap 4 Admin Template">
    <meta name="author" content="Lukasz Holeczek">
    <meta name="keyword" content="CoreUI Bootstrap 4 Admin Template">
    <!-- <link rel="shortcut icon" href="assets/ico/favicon.png"> -->

    <title>Presensi MGE</title>

    <!-- Icons -->
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/simple-line-icons.css" rel="stylesheet">

    <!-- Main styles for this application -->
    <link href="/css/style.css" rel="stylesheet">

</head>

<body class="app flex-row align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card-group mb-0">
                    <div class="card p-2">
                        <form id="form-login" class="card-block" method="post">
                            {{csrf_field()}}
                            <h1>Login</h1>
                            <p class="text-muted">Sign In to your account</p>
                            <div class="input-group mb-1">
                                <span class="input-group-addon"><i class="icon-user"></i>
                                </span>
                                <input required autocomplete="false" type="text" class="form-control" placeholder="Username" name="username">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-addon"><i class="icon-lock"></i>
                                </span>
                                <input required autocomplete="false" type="password" class="form-control" placeholder="Password" name="password">
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary px-2">Login</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap and necessary plugins -->
    <script src="/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/bower_components/tether/dist/js/tether.min.js"></script>
    <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    @if(session()->has('error'))
        <script type="text/javascript">
            alert("{{session()->pull('error')}}");
        </script>
    @endif


</body>

</html>