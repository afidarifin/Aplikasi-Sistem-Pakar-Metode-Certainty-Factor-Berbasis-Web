<?php
/**
 * @author    Afid Arifin <affinbara@gmail.com>
 * @version   v1.3
 * @copyright 17/08/2022
 * @license   /license/
 * @link      https://www.afid.web.id
 */
ini_set('display_errors', 0);
ob_start();
session_start();

if(version_compare(phpversion(), '7.0', '<=')) {
  echo '<b>Oops!</b> Your PHP version must be equal or higher than 7.3.0 to use the script.';
  exit();
}

if(ob_start() == false) {
  echo '<b>Oops!</b> Your output buffering inactive.';
  exit();
}

if(file_exists('includes/classes/Server.php')) {
  require_once 'includes/classes/Server.php';
} else {
  if(file_exists('../includes/classes/Server.php')) {
    require_once '../includes/classes/Server.php';
  } else {
    require_once '../../includes/classes/Server.php';
  }
}

if(file_exists('includes/classes/Database.php')) {
  require_once 'includes/classes/Database.php';
} else {
  if(file_exists('../includes/classes/Database.php')) {
    require_once '../includes/classes/Database.php';
  } else {
    require_once '../../includes/classes/Database.php';
  }
}

$database = new Database([
  'local' => [
    'driver'  => 'mysql',
    'host'    => '127.0.0.1',
    'user'    => 'root',
    'pass'    => '',
    'name'    => 'spk_phising',
    'port'    => 3306,
    'charset' => 'utf8mb4',
    'mode'    => [
      PDO::ATTR_ERRMODE             => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE  => PDO::FETCH_OBJ,
      PDO::ATTR_EMULATE_PREPARES    => false,
    ],
  ],
]);
                    
$db = $database->connect('local');
?>