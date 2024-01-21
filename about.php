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

require_once 'includes/connect.php';
require_once 'includes/classes/Helper.php';

if($helper->is_logged()) {
  if($helper->cookie_role() == 1) {
    $helper->redirect('/admin/');
  }
}

$page = isset($_GET['p']) ? trim($_GET['p']) : '';
switch($page) {
  case 'help':
    $title = 'Bantuan';
    require_once 'includes/header.php';
    ?>
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title">
                  <i class="icon fa fa-question-circle"></i>
                  Bantuan
                </h3>
              </div>
              <div class="box-body">
                <p class="text-muted">
                  Selamat datang di Sistem Pakar Diagnosa Phising Berbasis Web, berikut adalah panduan singkat untuk memulai diagnosa serangan phising.
                </p>
                <p class="text-muted">
                  <ul style="list-style: none;margin-left: -22px;">
                    <li>
                      <i class="icon fa fa-check-square-o text-green"></i>
                      Pilih Menu <b>Diagnosa</b>.
                    </li>
                    <li>
                      <i class="icon fa fa-check-square-o text-green"></i>
                      Pilih <b>Gejala</b>.
                    </li>
                    <li>
                      <i class="icon fa fa-check-square-o text-green"></i>
                      Lalu pilih <b>Kondisi</b> yang sesuai keadaan.
                    </li>
                    <li>
                      <i class="icon fa fa-check-square-o text-green"></i>
                      Klik tombol <b>Proses</b>, tunggu beberapa saat.
                    </li>
                    <li>
                      <i class="icon fa fa-check-square-o text-green"></i>
                      Selesai.
                    </li>
                  </ul>
                </p>
                <p class="text-muted">
                  <b>Catatan!</b>
                  <br/>
                  Pada halaman hasil diagnosa, Anda dapat melihat hasil berupa jenis gejala hingga detail tiap gejala serangan phising yang muncul.
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>
    <?php
    require_once 'includes/footer.php';
  break;
  case 'overview':
    $title = 'Tentang Kami';
    require_once 'includes/header.php';
    ?>
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box box-default">
              <div class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" src="<?php $helper->base_url(); ?>/assets/dist/img/user4-128x128.jpg" alt="Afid Arifin" style="margin-top: 12px;">
                <p class="text-center" style="margin-top: 8px;margin-bottom: 8px;font-size: 20px;">
                  <i class="icon fa fa-facebook-square" style="color: blue;"></i>
                  <i class="icon fa fa-instagram" style="color: magenta;"></i>
                  <i class="icon fa fa-twitter" style="color: skyblue;"></i>
                  <i class="icon fa fa-linkedin-square" style="color: darkblue;"></i>
                  <i class="icon fa fa-whatsapp" style="color:green;"></i>
                </p>
                <h3 class="profile-username text-center text-muted" style="font-family: serif;">
                  Sistem Pakar Diagnosa Phising
                </h3>
                <p class="text-muted text-center">
                  Sistem pakar yang mampu mendeteksi serangan phising<br/>berdasarkan pengetahuan yang diberikan langsung dari pakar/ahlinya dan melalui studi literatur.
                  <br/>
                  Sistem pakar ini dirancang oleh Afid Arifin dalam rangka untuk memenuhi tugas akhir atau skripsi di Kampus Tunas Bangsa Banjarnegara.
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>
    <?php
    require_once 'includes/footer.php';
  break;
  default:
    $helper->redirect('/');
  break;
}
?>