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

require_once '../../includes/connect.php';
require_once '../../includes/classes/Helper.php';

if(!$_SERVER['QUERY_STRING']) {
  $helper->redirect('/admin/gejala/?act=view');
}
?>
<section class="content">
  <?php
    if(isset($_POST['submit'])) {
      $kode_gejala = $helper->filter($_POST['kode_gejala'], 0);
      $nama_gejala = $helper->filter($_POST['nama_gejala'], 0);
      $messages    = [];

      if(empty($kode_gejala) || empty($nama_gejala)) {
        $messages[] = '<div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
            &times;
          </button>
          <i class="icon fa fa-warning"></i>
          <b>Oops!</b>
          Harap isi semua data yang diperlukan.
        </div>';
      } else {
        $insert_gejala = $db->table('gejala')
        ->insert(
          [
            'kode_gejala' => $kode_gejala,
            'nama_gejala' => $nama_gejala,
          ])
        ->lastId();

        if($insert_gejala) {
          $messages[] = '<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
              &times;
            </button>
            <i class="icon fa fa-check"></i>
            <b>Success!</b>
            Gejala berhasil ditambahkan.
          </div>';
        } else {
          $messages[] = '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
              &times;
            </button>
            <i class="icon fa fa-warning"></i>
            <b>Oops!</b>
            Gejala gagal ditambahkan.
          </div>';
        }
      }
    }

    if(!empty($messages)) {
      foreach($messages as $message) {
        ?>
          <div class="row">
            <div class="col-md-12">
              <?php echo $message; ?>
            </div>
          </div>
        <?php
      }
    }
  ?>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">
            <i class="icon fa fa-heartbeat"></i>
            Tambah gejala
          </h3>
        </div>
        <form method="POST" role="form" class="form-horizontal">
          <div class="box-body">
            <div class="row">
              <div class="col-md-8" style="margin-top: 15px;">
                <div class="form-group">
                  <label class="col-sm-2 control-label">
                    Kode gejala
                  </label>
                  <div class="col-sm-10">
                    <input type="text" name="kode_gejala" value="" class="form-control" placeholder="Contoh: K001" autocomplete="off" spellcheck="false" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">
                    Nama gejala
                  </label>
                  <div class="col-sm-10">
                    <input type="text" name="nama_gejala" value="" class="form-control" placeholder="Contoh: Fake Login" autocomplete="off" spellcheck="false" required>
                  </div>
                </div>
                <div class="button-group" style="margin-top: 30px;">
                  <button type="submit" name="submit" class="btn btn-success" style="margin-right: 4px;">
                    <i class="icon fa fa-plus"></i>
                    Tambah
                  </button>
                  <button type="reset" class="btn btn-danger">
                    <i class="icon fa fa-trash"></i>
                    Clear
                  </button>
                </div>
              </div>
              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-12">
                    <h4>
                      <i class="icon fa fa-info-circle"></i>
                      Petunjuk Pengisian
                    </h4>
                    <p>
                      Silahkan masukkan kode gejala, dan nama gejala. Data ini akan digunakan untuk proses diagnosa yang terjadi.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>