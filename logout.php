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

require_once './includes/connect.php';
require_once './includes/classes/Helper.php';

if($helper->is_logged()) {
  if(session_destroy()) {
    setcookie('_logged', null, -(60 * 60 * 24), '/');
    setcookie('_pkr', null, -(60 * 60 * 24), '/');
    setcookie('_role', null, -(60 * 60 * 24), '/');
    $helper->redirect('/?');
    exit();
  }
} else {
  $helper->redirect('/?');
}
?>