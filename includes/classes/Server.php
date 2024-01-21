<?php
/**
 * @author    Afid Arifin <affinbara@gmail.com>
 * @version   v1.3
 * @copyright 17/08/2022
 * @license   /license/
 * @link      https://www.afid.web.id
 */
require_once 'QueryBuilder.php';
require_once 'Query.php';

class Server {
  private $pdo;
  
  public function __construct(PDO $pdo) {
    $this->pdo = $pdo;
  }

  public function table(string $table): QueryBuilder {
    return new QueryBuilder($this->pdo, $table);
  }

  public function query(string $query): Query {
    return (new Query($this->pdo))->query($query);
  }
}
?>