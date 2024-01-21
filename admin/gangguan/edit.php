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
  $helper->redirect('/admin/gangguan/?act=view');
}

if(!$helper->is_logged() || $helper->cookie_role() != 1) {
  $helper->redirect('/');
  exit();
}

$title = 'Ubah Gangguan';
require_once '../../includes/header.php';

if(isset($_GET['id']) && !empty($_GET['id'])) {
  $id       = (isset($_GET['id']) ? intval($_GET['id']) : '');
  $gangguan = $db->table('gangguan')
  ->where('id_gangguan', $id)
  ->all();

  if(count($gangguan) > 0) {
    // $id = 1;
    foreach($gangguan as $data) {
      ?>
        <section class="content">
          <?php
            if(isset($_POST['submit'])) {
              $kode_gangguan = $helper->filter($_POST['kode_gangguan'], 0);
              $nama_gangguan = $helper->filter($_POST['nama_gangguan'], 0);
              $saran_masukan = $helper->filter($_POST['saran_masukan'], 0);
              $messages      = [];

              if(empty($kode_gangguan) || empty($nama_gangguan) || empty($saran_masukan)) {
                $messages[] = '<div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                    &times;
                  </button>
                  <i class="icon fa fa-warning"></i>
                  <b>Oops!</b>
                  Harap isi semua data yang diperlukan.
                </div>';
              } else {
                $update_gangguan = $db->table('gangguan')
                ->where('id_gangguan', $id)
                ->update(
                  [
                    'kode_gangguan'   => $kode_gangguan,
                    'nama_gangguan'   => $nama_gangguan,
                    'saran_gangguan'  => $saran_masukan,
                  ]
                )->exec();
                
                if($update_gangguan) {
                  $messages[] = '<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                      &times;
                    </button>
                    <i class="icon fa fa-check"></i>
                    <b>Success!</b>
                    Gangguan berhasil diperbarui.
                  </div>';
                } else {
                  $messages[] = '<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                      &times;
                    </button>
                    <i class="icon fa fa-warning"></i>
                    <b>Oops!</b>
                    Gangguan gagal diperbarui.
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
                    <i class="icon fa fa-stethoscope"></i>
                    Ubah Gangguan
                  </h3>
                </div>
                <form method="POST" role="form" class="form-horizontal">
                  <div class="box-body">
                    <div class="row">
                      <div class="col-md-8" style="margin-top: 15px;">
                        <div class="form-group">
                          <label class="col-sm-2 control-label">
                            Kode Gangguan
                          </label>
                          <div class="col-sm-10">
                            <input type="text" name="kode_gangguan" value="<?php echo $data->kode_gangguan; ?>" class="form-control" placeholder="Contoh: G001" autocomplete="off" spellcheck="false" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label">
                            Nama Gangguan
                          </label>
                          <div class="col-sm-10">
                            <input type="text" name="nama_gangguan" value="<?php echo $data->nama_gangguan; ?>" class="form-control" placeholder="Contoh: Fake Login" autocomplete="off" spellcheck="false" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label">
                            Saran Masukan
                          </label>
                          <div class="col-sm-10">
                            <textarea name="saran_masukan" class="form-control" placeholder="Contoh: Hindari memasukkan data pribadi" autocomplete="off" spellcheck="false" style="resize: none;height: 75px;" required><?php echo $data->saran_gangguan; ?></textarea>
                          </div>
                        </div>
                        <div class="button-group" style="margin-top: 30px;">
                          <button type="submit" name="submit" class="btn btn-success" style="margin-right: 4px;">
                            <i class="icon fa fa-plus"></i>
                            Ubah
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
                              Silahkan masukkan kode gangguan, nama gangguan dan saran masukkan. Data ini akan digunakan untuk proses diagnosa yang terjadi.
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
      <?php
      // $id++;
    }
  } else {
    $helper->redirect('/admin/gangguan/?act=view');
  }
} else {
  $helper->redirect('/admin/gangguan/?act=view');
}

require_once '../../includes/footer.php';
?>