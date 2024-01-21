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

$title = 'Beranda';
require_once 'includes/header.php';
?>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-body">
          <!-- Banner -->
          <div  class="carousel">
            <div class="carousel-inner">
              <div class="item active">
                <img src="<?php echo $helper->base_url(); ?>/assets/images/banner_1.png" alt="Banner 1">
              </div>
            </div>
          </div>

          <!-- Teks Sambutan -->
          <div class="row">
            <div class="col-md-4">
              <div class="single-service text-center">
                <h2>
                  <i class="icon fa fa-desktop text-muted" style="font-size: 50px;"></i>
                </h2>
                <p class="text-muted">
                  Aplikasi sistem pakar ini dapat menyesuaikan ukuran perangkat Anda. Jadi, walupun diakses melalui perangkat mobile tetap nyaman juga.
                </p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="single-service text-center">
                <h2>
                  <i class="icon fa fa-thumbs-o-up text-muted" style="font-size: 50px;"></i>
                </h2>
                <p class="text-muted">
                  Aplikasi sistem pakar ini dapat menjadi sahabat aman Anda untuk menjelajah dunia internet.
                </p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="single-service text-center">
                <h2>
                  <i class="icon fa fa-globe text-muted" style="font-size: 50px;"></i>
                </h2>
                <p class="text-muted">
                  Sistem pakar ini akan terus diperbarui, agar tingkat akurasi dalam mendeteksi serangan phising menjadi lebih baik lagi di masa depan.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php
require_once 'includes/footer.php';
?>