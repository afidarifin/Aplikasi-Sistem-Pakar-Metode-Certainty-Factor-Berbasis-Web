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

if(file_exists('includes/connect.php')) {
  require_once 'includes/connect.php';
} else {
  if(file_exists('../includes/connect.php')) {
    require_once '../includes/connect.php';
  } else {
    require_once '../../includes/connect.php';
  }
}

if(file_exists('includes/classes/Helper.php')) {
  require_once 'includes/classes/Helper.php';
} else {
  if(file_exists('../includes/classes/Helper.php')) {
    require_once '../includes/classes/Helper.php';
  } else {
    require_once '../../includes/classes/Helper.php';
  }
}

date_default_timezone_set('Asia/Jakarta');
?>
<!DOCTYPE html>
<html>
  <head>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Title -->
    <title><?php echo (!empty($title) ? $title : 'Beranda') ?> - SPK Phising</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo $helper->base_url(); ?>/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo $helper->base_url(); ?>/assets/bower_components/font-awesome/css/font-awesome.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo $helper->base_url(); ?>/assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo $helper->base_url(); ?>/assets/bower_components/select2/dist/css/select2.min.css">

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
  </head>
  <body class="hold-transition skin-green fixed sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo $helper->base_url(); ?>" class="logo">
          <span class="logo-mini">
            <b>S</b> P
          </span>
          <span class="logo-lg">
            <b>SPK</b> Phising
          </span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
          <!-- Sidebar toggle button -->
          <a href="javascript: void(0);" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">
              Toggle navigation
            </span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
        </nav>
      </header>

      <!-- Left side column. contains the sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?php echo $helper->base_url(); ?>/assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p>Afid Arifin</p>
              <a href="javascript: void(0);">
                <i class="fa fa-circle text-success"></i>
                Online
              </a>
            </div>
          </div>

          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu" data-widget="tree">
            <?php
              if($helper->is_logged()) {
                if($helper->cookie_role() == 1 || $helper->is_role() == 1) {
                  ?>
                    <li class="header">
                      MAIN NAVIGATION
                    </li>
                    <li <?php echo ($_SERVER['SCRIPT_NAME'] == '/admin/index.php' ? 'class="active"' : ''); ?>>
                      <a href="<?php echo $helper->base_url(); ?>/">
                        <i class="icon fa fa-home"></i>
                        <span>
                          Beranda
                        </span>
                      </a>
                    </li>
                    <li <?php echo ($_SERVER['REQUEST_URI'] == '/admin/gangguan/?page=view' ? 'class="active"' : ($_SERVER['REQUEST_URI'] == '/admin/gangguan/?page=add' ? 'class="active"' : ($_SERVER['SCRIPT_NAME'] == '/admin/gangguan/edit.php' ? 'class="active"' : ''))); ?>>
                      <a href="<?php echo $helper->base_url(); ?>/admin/gangguan/?page=view">
                        <i class="icon fa fa-stethoscope"></i>
                        <span>
                          Gangguan
                        </span>
                      </a>
                    </li>
                    <li <?php echo ($_SERVER['REQUEST_URI'] == '/admin/gejala/?page=view' ? 'class="active"' : ($_SERVER['REQUEST_URI'] == '/admin/gejala/?page=add' ? 'class="active"' : ($_SERVER['SCRIPT_NAME'] == '/admin/gejala/edit.php' ? 'class="active"' : ''))); ?>>
                      <a href="<?php echo $helper->base_url(); ?>/admin/gejala/?page=view">
                        <i class="icon fa fa-heartbeat"></i>
                        <span>
                          Gejala
                        </span>
                      </a>
                    </li>
                    <li <?php echo ($_SERVER['REQUEST_URI'] == '/admin/pengetahuan/?page=view' ? 'class="active"' : ($_SERVER['REQUEST_URI'] == '/admin/pengetahuan/?page=add' ? 'class="active"' : ($_SERVER['SCRIPT_NAME'] == '/admin/pengetahuan/edit.php' ? 'class="active"' : ''))); ?>>
                      <a href="<?php echo $helper->base_url(); ?>/admin/pengetahuan/?page=view">
                        <i class="icon fa fa-database"></i>
                        <span>
                          Pengetahuan
                        </span>
                      </a>
                    </li>
                    <li>
                      <a href="<?php echo $helper->base_url(); ?>/logout.php">
                        <i class="icon fa fa-sign-out"></i>
                        <span>
                          Keluar
                        </span>
                      </a>
                    </li>
                  <?php
                }
              } else {
                ?>
                  <li class="header">
                    MAIN NAVIGATION
                  </li>
                  <li <?php echo ($_SERVER['SCRIPT_NAME'] == '/index.php' ? 'class="active"' : ''); ?>>
                    <a href="<?php echo $helper->base_url(); ?>/">
                      <i class="icon fa fa-home"></i>
                      <span>
                        Beranda
                      </span>
                    </a>
                  </li>
                  <li <?php echo ($_SERVER['SCRIPT_NAME'] == '/diagnosa.php' ? 'class="active"' : ''); ?>>
                    <a href="<?php echo $helper->base_url(); ?>/diagnosa.php">
                      <i class="icon fa fa-stethoscope"></i>
                      <span>
                        Diagnosa
                      </span>
                    </a>
                  </li>
                  <li <?php echo ($_SERVER['QUERY_STRING'] == 'p=help' ? 'class="active"' : ''); ?>>
                    <a href="<?php echo $helper->base_url(); ?>/about.php?p=help">
                      <i class="icon fa fa-question-circle"></i>
                      <span>
                        Bantuan
                      </span>
                    </a>
                  </li>
                  <li <?php echo ($_SERVER['QUERY_STRING'] == 'p=overview' ? 'class="active"' : ''); ?>>
                    <a href="<?php echo $helper->base_url(); ?>/about.php?p=overview">
                      <i class="icon fa fa-info-circle"></i>
                      <span>
                        Tentang Kami
                      </span>
                    </a>
                  </li>
                <?php
              }
            ?>
          </ul>
        </section>
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

      