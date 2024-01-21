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
?>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="callout callout-info">
        <p>
          <i class="icon fa fa-bullhorn"></i>
          Perkaya kemampuan sistem pakar Anda dengan menambahkan gangguan baru secara rutin.
        </p>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">
            <i class="icon fa fa-stethoscope"></i>
            Gangguan
          </h3>
          <a href="<?php echo $helper->base_url(); ?>/admin/gangguan/?page=add" class="btn btn-success btn-sm pull-right" title="Tambahkan">
            <i class="icon fa fa-plus"></i>
            Tambahkan
          </a>
        </div>
        <div class="box-body table-responsive">
          <table id="example1" class="table table-hover table-bordered table-striped">
            <thead>
              <tr>
                <th class="text-center" width="5">NO</th>
                <th class="text-center" width="100">Kode Gangguan</th>
                <th class="text-center" width="110">Nama Gangguan</th>
                <th class="text-center">Saran Masukan</th>
                <th class="text-center" width="100">Tindakan</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $gangguan = $db->table('gangguan')
                ->orderBy('id_gangguan ASC')
                ->all();

                if(count($gangguan) > 0) {
                  $id = 1;
                  foreach($gangguan as $data) {
                    ?>
                      <tr>
                        <td class="text-center"><?php echo $id; ?></td>
                        <td class="text-center"><?php echo $data->kode_gangguan; ?></td>
                        <td><?php echo $data->nama_gangguan; ?></td>
                        <td><?php echo $data->saran_gangguan; ?></td>
                        <td>
                          <center>
                            <button id="edit-<?php echo $data->id_gangguan; ?>" class="btn btn-primary btn-xs" title="Ubah">
                              <i class="icon fa fa-edit"></i>
                              Ubah
                            </button>
                            <button id="hapus-<?php echo $data->id_gangguan; ?>" class="btn btn-danger btn-xs" title="Hapus">
                              <i class="icon fa fa-trash"></i>
                              Hapus
                            </button>
                          </center>
                        </td>
                      </tr>
                      <script>
                        $(document).ready(function() {
                          $('#edit-<?php echo $data->id_gangguan; ?>').on('click', function() {
                            window.location = '<?php echo $helper->base_url(); ?>/admin/gangguan/edit.php?id=<?php echo $data->id_gangguan; ?>';
                          });

                          $('#hapus-<?php echo $data->id_gangguan; ?>').on('click', function() {
                            window.location = '<?php echo $helper->base_url(); ?>/admin/gangguan/delete.php?id=<?php echo $data->id_gangguan; ?>';
                          });
                        });
                      </script>
                    <?php
                    $id++;
                  }
                }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>