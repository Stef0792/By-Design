<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Privacy | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo URL::to('/'); ?>/AdminLTE/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo URL::to('/'); ?>/AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo URL::to('/'); ?>/AdminLTE/dist/css/adminlte.min.css">

  <style>
      .holdLogo{
          margin: 30px 0px 0px 20px;
      }

      .inputNoBorder{
        border: 2px solid #CDD !important;
        border-top: 0px !important;
        border-left: 0px !important;
        border-right: 0px !important;
      }

      .iconLeft{
        margin-left: -30px;
        z-index: 99999;
      }

      .iconNoBorder{
          border: 0px !important;
      }
  </style>
</head>
<body class="hold-transition login-page">

<div class="col-md-12" style="margin-top: 100px;">
    <div class="col-md-3" style="min-width: 16.666667%; height: 1px; float: left; padding-right: 0px;"> </div>
    <div class="col-md-4" style="float: left; padding-right: 0px;" >
        <div class="">            
            <!-- /.login-logo -->
            <div class="card">
                <div class="row">
                    <div class="col-md-12">
                        <div class="holdLogo">
                            <img src="<?php echo URL::to('/'); ?>/logoBY_design.jpeg" style="max-width: 220px;" />
                        </div>
                    </div>
                </div>
                <div class="card-body login-card-body" style="height: 360px;">

                    <h3> Entrar </h3>
                    <p class="">Insira seus dados para acessar o sistema.</p>

                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control inputNoBorder" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text iconNoBorder">
                            <span class="fas fa-envelope iconLeft"></span>
                            </div>
                        </div>
                        </div>
                        <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control inputNoBorder" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text iconNoBorder">
                            <span class="fas fa-lock iconLeft"></span>
                            </div>
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                
                            </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block" style="width: 95%; margin-top: 3%; background-color: #2DD6E0;">Entrar</button>
                        </div>
                        <!-- /.col -->
                        </div>
                    </form>                   
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
    </div>
    <div class="col-md-5" style="float: left; padding: 0px;">
        <img src="<?php echo URL::to('/'); ?>/By_Design_fundo.jpeg" style="max-width: 360px; height: 433px;" />
    </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?php echo URL::to('/'); ?>/AdminLTE/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo URL::to('/'); ?>/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo URL::to('/'); ?>/AdminLTE/dist/js/adminlte.min.js"></script>
</body>
</html>
