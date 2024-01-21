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
  $helper->redirect('/admin/pengetahuan/?page=view');
}

if(!$helper->is_logged() || $helper->cookie_role() != 1) {
  $helper->redirect('/');
  exit();
}

if(isset($_GET['id']) && !empty($_GET['id'])) {
  $id          = (isset($_GET['id']) ? intval($_GET['id']) : '');
  $pengetahuan = $db->table('pengetahuan')
  ->where('id_pengetahuan', $id)
  ->all();

  if(count($pengetahuan) > 0) {
    $delete = $db->table('pengetahuan')
    ->where('id_pengetahuan', $id)
    ->delete()
    ->exec();

    if($delete) {
      $helper->redirect('/admin/pengetahuan/?page=view');
    } else {
      $helper->redirect('/admin/pengetahuan/?page=view');
    }
  } else {
    $helper->redirect('/admin/pengetahuan/?page=view');
  }
} else {
  $helper->redirect('/admin/pengetahuan/?page=view');
}
?>