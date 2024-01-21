<?php
/**
 * @package   Sistem Pakar Diagnosa Phising <SPK Phising>
 * @author    Afid Arifin <affinbara@gmail.com>
 * @version   v1.0
 * @copyright 02/07/2023
 * @license   /license/
 * @link      https://www.afid.web.id
 */
ini_set('display_errors', 0);
ob_start();

require_once './includes/connect.php';
require_once './includes/classes/Helper.php';

date_default_timezone_set('Asia/Jakarta');

if($helper->is_logged()) {
  $helper->redirect('/admin/');
}
?>
<!DOCTYPE html>
<html>
  <head>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Title -->
    <title>Masuk - SPK Phising</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo $helper->base_url(); ?>/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo $helper->base_url(); ?>/assets/bower_components/font-awesome/css/font-awesome.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo $helper->base_url(); ?>/assets/bower_components/Ionicons/css/ionicons.min.css">

    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo $helper->base_url(); ?>/assets/plugins/iCheck/square/blue.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo $helper->base_url(); ?>/assets/dist/css/AdminLTE.min.css">

    <!-- AdminLTE Skins. Choose a skin from the css/skins
        folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo $helper->base_url(); ?>/assets/dist/css/skins/_all-skins.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <!-- jQuery 3 -->
    <script src="<?php echo $helper->base_url(); ?>/assets/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Additional CSS -->
    <style>
      #add-login-page {
        border-radius: 4px;
        box-shadow: inset 0px 0px 2px 2px #bdbdbd;
      }
      #add-login-text-muted {
        margin-top: -22px;
      }
    </style>
  </head>
  <body class="hold-transition login-page">
    <?php
      if(isset($_POST['submit'])) {
        $email    = $helper->filter(strtolower($_POST['email']), 1);
        $password = $helper->filter($_POST['password'], 1);
        $remember = (!empty($_POST['remember']) ? $helper->filter($_POST['remember'], 1) : '');
        $messages = [];

        if(empty($email) || empty($password)) {
          $messages[] = '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
              &times;
            </button>
            <i class="icon fa fa-warning"></i>
            <b>Oops!</b>
            Silahkan isi email dan kata sandi Anda.
          </div>';
        } elseif(!$helper->is_email($email) || !$helper->check_email($email)) {
          $messages[] = '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
              &times;
            </button>
            <i class="icon fa fa-warning"></i>
            <b>Oops!</b>
            Email Anda tidak terdaftar.
          </div>';
        } else {
          $check_password = [
            1 => $password,
            2 => $helper->data('pakar', 'kata_sandi', $helper->get_pakar_id('email', $email)),
          ];

          if($helper->check_password($check_password)) {
            $_SESSION['is_login'] = $helper->session_login($email);
            $_SESSION['is_role']  = $helper->session_role($email);

            if($remember) {
              if(!isset($_COOKIE['_logged']) && !isset($_COOKIE['_pkr']) && !isset($_COOKIE['_role'])) {
                setcookie('_logged', substr(md5($email), 0, 10), time() + (60 * 60 * 24), '/');
                setcookie('_pkr', $helper->get_pakar_id('email', $email), time() + (60 * 60 * 24), '/');
                setcookie('_role', $helper->data('pakar', 'id', $helper->get_pakar_id('email', $email)), time() + (60 * 60 * 24), '/');
              }
            }

            $helper->redirect('/admin/');
          } else {
            $messages[] = '<div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                &times;
              </button>
              <i class="icon fa fa-warning"></i>
              <b>Oops!</b>
              Kata sandi Anda salah.
            </div>';
          }
        }
      }
    ?>
    <div class="login-box">
      <?php
        if(!empty($messages)) {
          foreach($messages as $message) {
            echo $message;
          }
        }
      ?>
      <div class="login-box-body" id="add-login-page">
        <p class="login-box-msg login-logo">
          MASUK
        </p>
        <p class="text-muted text-center" id="add-login-text-muted">
          Silahkan masuk untuk mengelola sistem pakar diagnosa phising.
        </p>
        <form method="POST" role="form">
          <div class="form-group has-feedback">
            <input id="email" type="email" name="email" class="form-control" placeholder="Email" autocomplete="off" spellcheck="false" required>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input id="password" type="password" name="password" class="form-control" placeholder="Password" autocomplete="off" spellcheck="false" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox" name="remember">
                  Ingat Saya
                </label>
              </div>
            </div>
            <div class="col-xs-4">
              <span id="button">
                <button type="button" class="btn btn-default btn-block btn-rounded">
                  MASUK
                </button>
              </span>
            </div>
          </div>
        </form>
        <div class="social-auth-links text-center">
          <p class="text-muted text-center">
            <strong>
              &copy; 2023
              <a href="https://www.afid.web.id">
                SPK Phising
              </a>
            </strong>
            <br/>
            Dipersembahkan oleh <b>Afid Arifin</b>
          </p>
        </div>
      </div>
    </div>

    <!-- jQuery 3 -->
    <!-- <script src="<?php echo $helper->base_url(); ?>/assets/bower_components/jquery/dist/jquery.min.js"></script> -->

    <!-- Bootstrap 3.3.7 -->
    <script src="<?php echo $helper->base_url(); ?>/assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Login -->
    <script>
      $(document).ready(function() {
        $('#email').keyup(function() {
          var email = $('#email').val();
          var valid = /^\w+([\.]?\w+)*@\w+([\.]?\w+)*(\.\w{2,3})+$/;
          if(email.length > 0) {
            if(valid.test(email)) {
              $('#button').html(`<button type="submit" name="submit" class="btn btn-primary btn-block btn-rounded">Masuk</button>`);
            } else {
              $('#button').html(`<button type="button" class="btn btn-default btn-block btn-rounded">Masuk</button>`);
            }
          }
        });

        $('#password').keyup(function() {
          var password = $('#password').val();
          if(password.length >= 8) {
            $('#button').html(`<button type="submit" name="submit" class="btn btn-primary btn-block btn-rounded">MASUK</button>`);
          } else {
            $('#button').html(`<button type="button" class="btn btn-default btn-block btn-rounded">MASUK</button>`);
          }
        });
      });
    </script>

    <!-- iCheck -->
    <script src="<?php echo $helper->base_url(); ?>/assets/plugins/iCheck/icheck.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%',
        });
      });
    </script>
  </body>
</html>