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

if(!$helper->is_logged() || $helper->cookie_role() != 1) {
  $helper->redirect('/');
  exit();
}

$page = isset($_GET['page']) ? trim($_GET['page']) : '';
switch($page) {
  case 'add':
    $title = 'Tambah Pengetahuan';
    require_once '../../includes/header.php';
    require_once '../../admin/pengetahuan/add.php';
    require_once '../../includes/footer.php';
  break;
  case 'view':
    $title = 'Pengetahuan';
    require_once '../../includes/header.php';
    require_once '../../admin/pengetahuan/view.php';
    require_once '../../includes/footer.php';
  break;
  default:
    $helper->redirect('/admin/pengetahuan/?page=view');
  break;
}
?>