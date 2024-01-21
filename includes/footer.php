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
?>
</div>

<footer class="main-footer">
  <div class="pull-right hidden-xs">
    <b>v1.0</b>
  </div>
  <strong>
    &copy; 2023 - 
    <a href="https://www.afid.web.id">
      SPK Phising
    </a> by Afid Arifin
  </strong>
</footer>
</div>

<!-- jQuery 3 -->
<!-- <script src="<?php echo $helper->base_url(); ?>/assets/bower_components/jquery/dist/jquery.min.js"></script> -->

<!-- jQuery UI 1.11.4 -->
<script src="<?php echo $helper->base_url(); ?>/assets/bower_components/jquery-ui/jquery-ui.min.js"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button);
</script>

<!-- Bootstrap 3.3.7 -->
<script src="<?php echo $helper->base_url(); ?>/assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Select2 -->
<script src="<?php echo $helper->base_url(); ?>/assets/bower_components/select2/dist/js/select2.full.min.js"></script>

<!-- DataTables -->
<script src="<?php echo $helper->base_url(); ?>/assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $helper->base_url(); ?>/assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<!-- SlimScroll -->
<script src="<?php echo $helper->base_url(); ?>/assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>

<!-- FastClick -->
<script src="<?php echo $helper->base_url(); ?>/assets/bower_components/fastclick/lib/fastclick.js"></script>

<!-- AdminLTE App -->
<script src="<?php echo $helper->base_url(); ?>/assets/dist/js/adminlte.min.js"></script>

<script>
$(document).ready(function () {
  $('.sidebar-menu').tree();
  $('.select2').select2();
});
</script>

<script>
$(function () {
  $('#example1').DataTable()
  $('#example2').DataTable({
    'paging'      : true,
    'lengthChange': false,
    'searching'   : false,
    'ordering'    : true,
    'info'        : true,
    'autoWidth'   : false
  })
});
</script>
</body>
</html>
<?php ob_end_flush(); ?>