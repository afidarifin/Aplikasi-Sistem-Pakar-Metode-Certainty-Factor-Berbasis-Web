<?php
/**
 * @author    Afid Arifin <affinbara@gmail.com>
 * @version   v1.3
 * @copyright 17/08/2022
 * @license   /license/
 * @link      https://www.afid.web.id
 */
class Database {
  private $connect = [];
  private $database;

  private $db_set_driver;
  private $db_set_host;
  private $db_set_user;
  private $db_set_pass;
  private $db_set_name;
  private $db_set_port;
  private $db_set_charset;
  private $db_set_mode;
  private $db_set_dsn;

  public function __construct(array $database) {
    $this->database = $database;
  }

  public function connect(string $server = 'local'): Server {
    if(!isset($this->database[$server])) {
      throw new InvalidArgumentException('Database '.$server.' doesn\'t exists.');
    }

    try {
      $this->database       = isset($this->database[$server]) ? $this->database[$server] : 'local';
      $this->db_set_driver  = isset($this->database['driver']) ? $this->database['driver'] : 'mysql';
      $this->db_set_host    = isset($this->database['host']) ? $this->database['host'] : 'localhost';
      $this->db_set_user    = isset($this->database['user']) ? $this->database['user'] : 'root';
      $this->db_set_pass    = isset($this->database['pass']) ? $this->database['pass'] : '';
      $this->db_set_name    = isset($this->database['name']) ? $this->database['name'] : '';
      $this->db_set_port    = isset($this->database['port']) ? $this->database['port'] : '';
      $this->db_set_charset = isset($this->database['charset']) ? $this->database['charset'] : 'utf8mb4';
      $this->db_set_mode    = isset($this->database['mode']) ? $this->database['mode'] : '';

      $this->db_set_dsn     = $this->db_set_driver.":host=".str_replace(':'.$this->db_set_port, '', $this->db_set_host).($this->db_set_port != '' ? ';port='.$this->db_set_port : '').";dbname=".$this->db_set_name.";charset=".$this->db_set_charset;

      if(array_key_exists($server, $this->connect)) {
        return $this->connect[$server];
      }

      $pdo      = new PDO($this->db_set_dsn, $this->db_set_user, $this->db_set_pass, $this->db_set_mode);
      $connect  = new Server($pdo);
      $this->connect[$server] = $connect;

      return $connect;
    } catch(PDOException $e) {
      throw new PDOException($e->getMessage());
    }
  }
}
?>