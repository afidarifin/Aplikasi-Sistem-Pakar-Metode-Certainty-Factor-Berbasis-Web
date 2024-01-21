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
  $helper->redirect('/admin/pengetahuan/?act=view');
}

if(!$helper->is_logged() || $helper->cookie_role() != 1) {
  $helper->redirect('/');
  exit();
}

$title = 'Ubah Pengetahuan';
require_once '../../includes/header.php';

if(isset($_GET['id']) && !empty($_GET['id'])) {
  $id          = (isset($_GET['id']) ? intval($_GET['id']) : '');
  $pengetahuan = $db->table('pengetahuan')
  ->where('id_pengetahuan', $id)
  ->all();

  if(count($pengetahuan) > 0) {
    //$id = 1;
    foreach($pengetahuan as $data) {
      $id_gejala   = $data->id_gejala;
      $id_gangguan = $data->id_gangguan;
      ?>
        <section class="content">
          <?php
            if(isset($_POST['submit'])) {
              $kode_pengetahuan = $helper->filter($_POST['kode_pengetahuan'], 0);
              $md               = $helper->filter($_POST['md'], 0);
              $mb               = $helper->filter($_POST['mb'], 0);
              $gejala           = $helper->filter($_POST['gejala'], 0);
              $gangguan         = $helper->filter($_POST['gangguan'], 0);
              $messages         = [];

              if(empty($kode_pengetahuan) || empty($md) || empty($mb) || empty($gejala) || empty($gangguan)) {
                $messages[] = '<div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                    &times;
                  </button>
                  <i class="icon fa fa-warning"></i>
                  <b>Oops!</b>
                  Harap isi semua data yang diperlukan.
                </div>';
              } elseif(!is_numeric($md) || !is_numeric($mb)) {
                $messages[] = '<div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                    &times;
                  </button>
                  <i class="icon fa fa-warning"></i>
                  <b>Oops!</b>
                  Nilai MD/MB hanya mendukung angka.
                </div>';
              } else {
                $update_pengetahuan = $db->table('pengetahuan')
                ->where('id_pengetahuan', $id)
                ->update(
                  [
                    'kode_pengetahuan'  => $kode_pengetahuan,
                    'id_gangguan'       => $gangguan,
                    'id_gejala'         => $gejala,
                    'mb'                => $mb,
                    'md'                => $md,
                  ]
                )->exec();
                
                if($update_pengetahuan) {
                  $messages[] = '<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                      &times;
                    </button>
                    <i class="icon fa fa-check"></i>
                    <b>Success!</b>
                    Pengetahuan berhasil diperbarui.
                  </div>';
                } else {
                  $messages[] = '<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                      &times;
                    </button>
                    <i class="icon fa fa-warning"></i>
                    <b>Oops!</b>
                    Pengetahuan gagal diperbarui.
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
                    <i class="icon fa fa-database"></i>
                    Ubah Pengetahuan
                  </h3>
                </div>
                <form method="POST" role="form" class="form-horizontal">
                  <div class="box-body">
                    <div class="row">
                      <div class="col-md-8" style="margin-top: 15px;">
                        <div class="form-group">
                          <label class="col-sm-2 control-label">
                            Kode Pengetahuan
                          </label>
                          <div class="col-sm-10">
                            <input type="text" name="kode_pengetahuan" value="<?php echo $data->kode_pengetahuan; ?>" class="form-control" placeholder="Contoh: P001" autocomplete="off" spellcheck="false" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label">
                            MD
                          </label>
                          <div class="col-sm-10">
                            <input type="text" name="md" value="<?php echo $data->md; ?>" class="form-control" placeholder="Contoh: 0.4" autocomplete="off" spellcheck="false" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label">
                            MB
                          </label>
                          <div class="col-sm-10">
                            <input type="text" name="mb" value="<?php echo $data->mb; ?>" class="form-control" placeholder="Contoh: 0.8" autocomplete="off" spellcheck="false" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label">
                            Gejala
                          </label>
                          <div class="col-sm-10">
                            <select name="gejala" class="form-control select2">
                              <option>--- PILIH ---</option>
                              <?php
                                $gejala = $db->table('gejala')
                                ->orderBy('id_gejala DESC')
                                ->all();

                                if(count($gejala) > 0) {
                                  $id = 1;
                                  foreach($gejala as $data) {
                                    ?>
                                      <option value="<?php echo $data->id_gejala; ?>" <?php echo ($data->id_gejala == $id_gejala ? 'selected' : ''); ?>>
                                        (<?php echo $data->kode_gejala; ?>)
                                        <?php echo $data->nama_gejala; ?>
                                      </option>
                                    <?php
                                    $id++;
                                  }
                                }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label">
                            Gangguan
                          </label>
                          <div class="col-sm-10">
                            <select name="gangguan" class="form-control select2">
                              <option>--- PILIH ---</option>
                              <?php
                                $gangguan = $db->table('gangguan')
                                ->orderBy('id_gangguan DESC')
                                ->all();

                                if(count($gangguan) > 0) {
                                  $id = 1;
                                  foreach($gangguan as $data) {
                                    ?>
                                      <option value="<?php echo $data->id_gangguan; ?>" <?php echo ($data->id_gangguan == $id_gangguan ? 'selected' : ''); ?>>
                                        (<?php echo $data->kode_gangguan; ?>)
                                        <?php echo $data->nama_gangguan; ?>
                                      </option>
                                    <?php
                                    $id++;
                                  }
                                }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="button-group" style="margin-top: 30px;">
                          <button type="submit" name="submit" class="btn btn-success" style="margin-right: 4px;">
                            <i class="icon fa fa-pencil"></i>
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
                              Silahkan pilih gejala yang sesuai dengan gangguan yang ada, dan berikan nilai kepastian (MB & MB) dengan cakupan sebagai berikut:
                              <ul>
                                <li><b>1.0</b> = Sangat Yakin</li>
                                <li><b>0.8</b> = Yakin</li>
                                <li><b>0.6</b> = Cukup Yakin</li>
                                <li><b>0.4</b> = Sedikit Yakin</li>
                                <li><b>0.2</b> = Kurang Yakin</li>
                                <li><b>0.0</b> = Tidak Yakin</li>
                              </ul>
                            </p>
                            <p>
                              <b>CF(Pakar) = MB - MD</b>
                              <br/>
                              <b>MB</b>: Kenaikan kepercayaan (Measure of Increased Belief)
                              <br/>
                              <b>MD</b>: Kenaikan ketidakpercayaan (Measure of Increased Disbelief)
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
      //$id++;
    }
  } else {
    $helper->redirect('/admin/pengetahuan/?act=view');
  }
} else {
  $helper->redirect('/admin/pengetahuan/?act=view');
}

require_once '../../includes/footer.php';
?>