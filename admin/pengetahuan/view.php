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
?>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="callout callout-info">
        <p>
          <i class="icon fa fa-bullhorn"></i>
          Perkaya kemampuan sistem pakar Anda dengan menambahkan basis pengetahuan baru secara rutin.
        </p>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">
            <i class="icon fa fa-database"></i>
            Pengetahuan
          </h3>
          <a href="<?php echo $helper->base_url(); ?>/admin/pengetahuan/?page=add" class="btn btn-success btn-sm pull-right" title="Tambahkan">
            <i class="icon fa fa-plus"></i>
            Tambahkan
          </a>
        </div>
        <div class="box-body table-responsive">
          <table id="example1" class="table table-hover table-bordered table-striped">
            <thead>
              <tr>
                <th class="text-center" width="5">NO</th>
                <th class="text-center" width="120">Kode Pengetahuan</th>
                <th class="text-center">Gangguan</th>
                <th class="text-center">Gejala</th>
                <th class="text-center" width="5">MB</th>
                <th class="text-center" width="5">MD</th>
                <th class="text-center" width="100">Tindakan</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $pengetahuan = $db->table('pengetahuan')
                ->orderBy('id_pengetahuan ASC')
                ->all();

                if(count($pengetahuan) > 0) {
                  $id = 1;
                  foreach($pengetahuan as $data) {
                    ?>
                      <tr>
                        <td class="text-center"><?php echo $id; ?></td>
                        <td class="text-center"><?php echo $data->kode_pengetahuan; ?></td>
                        <td><?php echo $helper->get_gangguan($data->id_gangguan); ?></td>
                        <td><?php echo $helper->get_gejala($data->id_gejala); ?></td>
                        <td class="text-center"><?php echo $data->mb; ?></td>
                        <td class="text-center"><?php echo $data->md; ?></td>
                        <td>
                          <center>
                            <button id="edit-<?php echo $data->id_pengetahuan; ?>" class="btn btn-primary btn-xs" title="Ubah">
                              <i class="icon fa fa-edit"></i>
                              Ubah
                            </button>
                            <button id="hapus-<?php echo $data->id_pengetahuan; ?>" class="btn btn-danger btn-xs" title="Hapus">
                              <i class="icon fa fa-trash"></i>
                              Hapus
                            </button>
                          </center>
                        </td>
                      </tr>
                      <script>
                        $(document).ready(function() {
                          $('#edit-<?php echo $data->id_pengetahuan; ?>').on('click', function() {
                            window.location = '<?php echo $helper->base_url(); ?>/admin/pengetahuan/edit.php?id=<?php echo $data->id_pengetahuan; ?>';
                          });

                          $('#hapus-<?php echo $data->id_pengetahuan; ?>').on('click', function() {
                            window.location = '<?php echo $helper->base_url(); ?>/admin/pengetahuan/delete.php?id=<?php echo $data->id_pengetahuan; ?>';
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