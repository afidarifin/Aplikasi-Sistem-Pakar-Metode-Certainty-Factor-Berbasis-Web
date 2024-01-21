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

require_once '../includes/connect.php';
require_once '../includes/classes/Helper.php';

if(!$helper->is_logged() || $helper->cookie_role() != 1) {
  $helper->redirect('/');
  exit();
}

$title = 'Beranda';
require_once '../includes/header.php';
?>
<section class="content">
  <div class="row">
    <!-- Pengetahuan -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-red">
        <div class="inner">
          <h3>
            <?php echo $helper->total_pengetahuan(); ?>
          </h3>
          <p>PENGETAHUAN</p>
        </div>
        <div class="icon">
          <i class="fa fa-database"></i>
        </div>
      </div>
    </div>

    <!-- Gangguan -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-green">
        <div class="inner">
          <h3>
            <?php echo $helper->total_gangguan(); ?>
          </h3>
          <p>GANGGUAN</p>
        </div>
        <div class="icon">
          <i class="fa fa-stethoscope"></i>
        </div>
      </div>
    </div>

    <!-- Gangguan -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-orange">
        <div class="inner">
          <h3>
            <?php echo $helper->total_gejala(); ?>
          </h3>
          <p>GEJALA</p>
        </div>
        <div class="icon">
          <i class="fa fa-heartbeat"></i>
        </div>
      </div>
    </div>

    <!-- Pakar -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-blue">
        <div class="inner">
          <h3>
            1
          </h3>
          <p>PAKAR</p>
        </div>
        <div class="icon">
          <i class="fa fa-user"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Selamat Datang -->
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
        </div>
      </div>
    </div>
  </div>
</section>

<?php
require_once '../includes/footer.php';
?>