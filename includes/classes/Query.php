<?php
/**
 * @author    Afid Arifin <affinbara@gmail.com>
 * @version   v1.3
 * @copyright 17/08/2022
 * @license   /license/
 * @link      https://www.afid.web.id
 */
require_once 'QueryBuilder.php';
require_once 'Alias.php';
require_once 'Compose.php';

class Query {
  private $pdo;
  private $query;
  private $stmt;
  private $values = [];
  private $execute;
  private $lastInsertId;

  public function __construct(PDO $pdo) {
    $this->pdo = $pdo;
  }

  public function query(string $query): self {
    $this->query  = $query;
    $this->stmt   = $this->pdo->prepare($query);
    return $this;
  }

  public function values(array $values): self {
    $this->values = $values;
    foreach($values as $key => $value) {
      if(!is_array($value)) {
        $this->stmt->bindValue(":$key", $value);
      } else {
        foreach($value as $k => $v) {
          $this->stmt->bindValue(":$k", $v);
        }
      }
    }
    return $this;
  }

  public function execute() {
    try {
      $this->execute      = $this->stmt->execute();
      $this->lastInsertId = (int) $this->pdo->lastInsertId();
    } catch(PDOException $e) {
      throw new PDOException($e->getMessage());
    }
  }

  public function exec(): bool {
    $this->execute();
    return $this->execute;
  }

  public function lastId(): int {
    $this->execute();
    return $this->lastInsertId;
  }

  public function count(): int {
    $this->execute();
    return (int) $this->stmt->rowCount();
  }

  public function get() {
    $this->execute();
    if($this->stmt->rowCount() > 1) {
      return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }
    return $this->stmt->fetch(PDO::FETCH_OBJ);
  }

  public function all(): array {
    $this->execute();
    $data = $this->stmt->fetchAll(PDO::FETCH_OBJ);
    return $data ? : [];
  }

  public function debug(): string {
    ob_start();
    $this->stmt->debugDumpParams();
    $output = ob_get_contents() ? : '';
    ob_end_clean();
    return '<pre>'.htmlspecialchars($output).'</pre>';
  }

  public function __toString(): string {
    return $this->query;
  }
}
?>