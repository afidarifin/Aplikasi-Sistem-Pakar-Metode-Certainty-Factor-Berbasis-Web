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

class Helper {
  private $gangguan, $get_gangguan;
  public function get_gangguan(string $id): string {
    global $db;

    $this->get_gangguan = $id;

    $this->gangguan = $db->table('gangguan')
    ->where('id_gangguan', $this->get_gangguan)
    ->all();

    if(count($this->gangguan) > 0) {
      foreach($this->gangguan as $data) {
        return $data->nama_gangguan;
      }
    } else {
      return 'Tidak ada data';
    }
  }

  private $gejala, $get_gejala;
  public function get_gejala(string $id): string {
    global $db;

    $this->get_gejala = $id;

    $this->gejala = $db->table('gejala')
    ->where('id_gejala', $this->get_gejala)
    ->all();

    if(count($this->gejala) > 0) {
      foreach($this->gejala as $data) {
        return $data->nama_gejala;
      }
    } else {
      return 'Tidak ada data';
    }
  }
  
  private $total_pengetahuan;
  public function total_pengetahuan(): string {
    global $db;
    $this->total_pengetahuan = $db->table('pengetahuan')->all();
    return number_format((count($this->total_pengetahuan)), 0, ',', '.');
  }

  private $total_gejala;
  public function total_gejala(): string {
    global $db;
    $this->total_gejala = $db->table('gejala')->all();
    return number_format((count($this->total_gejala)), 0, ',', '.');
  }

  private $total_gangguan;
  public function total_gangguan(): string {
    global $db;
    $this->total_gangguan = $db->table('gangguan')->all();
    return number_format((count($this->total_gangguan)), 0, ',', '.');
  }

  private $cek_gangguan;
  public function cek_gangguan(): bool {
    global $db;

    $this->cek_gangguan = $db->table('gangguan')
    ->orderBy('id DESC')
    ->all();

    if(count($this->cek_gangguan) > 0) {
      return true;
    } else {
      return false;
    }
  }

  public $get_id, $get_pakar_id_field, $get_pakar_id_value;
  public function get_pakar_id(string $field, string $value): int {
    global $db;

    $this->get_pakar_id_field = $field;
    $this->get_pakar_id_value = $value;

    $this->get_id = $db->table('pakar')
    ->where($this->get_pakar_id_field, $this->get_pakar_id_value)
    ->select('id')
    ->get();

    $result = (array) $this->get_id;
    return $result['id'];
  }

  private $check_password;
  public function check_password(array $value): bool {
    $this->check_password = $value;

    if(password_verify($this->check_password[1], $this->check_password[2])) {
      return true;
    } else {
      return false;
    }
  }

  private $check_email, $check_email_value;
  public function check_email(string $value): bool {
    global $db;

    $this->check_email_value = $value;
    $this->check_email = $db->table('pakar')
    ->where('email', $this->check_email_value)
    ->select('email')
    ->get();
      
    if(empty($this->check_email)) {
      return false;
    } else {
      return true;
    }
  }

  private $session_login;
  public function session_login(string $value): string {
    $this->session_login = $value;

    return ($this->data('pakar', 'id', ($this->get_pakar_id('email', $this->session_login))));
  }

  private $session_role;
  public function session_role(string $value): string {
    $this->session_role = $value;
    return ($this->data('pakar', 'id', ($this->get_pakar_id('email', $this->session_role))));
  }

  public function is_login(): string {
    if(isset($_SESSION['is_login'])) {
      return $_SESSION['is_login'];
    }
  }

  public function is_role() {
    if(isset($_SESSION['is_role'])) {
      return $_SESSION['is_role'];
    }
  }
  
  public function is_logged(): bool {
    if(isset($_COOKIE['_logged']) && isset($_COOKIE['_pkr']) && isset($_COOKIE['_role']) || isset($_SESSION['is_login']) && isset($_SESSION['is_role'])) {
      return true;
    } else {
      return false;
    }
  }

  private $cookie_role;
  public function cookie_role(): int {
    $this->cookie_role = isset($_COOKIE['_role']);

    if($this->cookie_role) {
      return $_COOKIE['_role'];
    } else {
      return $this->is_role();
    }
  }

  private $redirect_url;
  public function redirect(string $url): void {
    $this->redirect_url = $url;
    header('location: '.$this->redirect_url);
  }

  private $filter_string, $filter_mode, $filter_html;
  public function filter(string $string, int $mode = 0, bool $html = false): string {
    $this->filter_string = $string;
    $this->filter_mode   = $mode;
    $this->filter_html   = $html;

    if($this->filter_mode == 0) {
      return trim(addslashes($this->filter_string));
    } else {
      return trim(htmlspecialchars(stripslashes($this->filter_string)));
    }

    if($this->filter_mode == 1) {
      if($this->filter_html) {
        return trim(stripslashes($this->filter_string));
      } else {
        return trim(htmlspecialchars(stripslashes($this->filter_string)));
      }
    }
  }

  private $is_email;
  public function is_email(string $email): bool {
    $this->is_email = $email;

    if(strlen($this->is_email) == 0) {
      return false;
    }

    if(!preg_match('/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix', $this->is_email)) {
      return false;
    } else {
      return true;
    }
  }

  private $data, $data_table, $data_field, $data_id, $data_result;
  public function data(string $table, string $field, int $id): string {
    global $db;

    $this->data_table = $table;
    $this->data_field = $field;
    $this->data_id    = $id;

    $this->data = $db->table($this->data_table)
    ->where('id', $this->data_id)
    ->select($this->data_field)
    ->get();

    $this->data_result = (array) $this->data;
    return $this->data_result[$this->data_field];
  }

  public function base_url() : string {
    return ($_SERVER['REQUEST_SCHEME'] == 'https' ? 'https://'.$_SERVER['HTTP_HOST'] : 'http://'.$_SERVER['HTTP_HOST']);
  }
}

$helper = new Helper();
?>