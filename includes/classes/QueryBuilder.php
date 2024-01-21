<?php
/**
 * @author    Afid Arifin <affinbara@gmail.com>
 * @version   v1.3
 * @copyright 17/08/2022
 * @license   /license/
 * @link      https://www.afid.web.id
 */
require_once 'Query.php';
require_once 'Alias.php';
require_once 'Compose.php';

class QueryBuilder {
  use Alias;
  use Compose;
  
  private $pdo;

  private $table;
  private $insert   = [];
  private $update   = [];
  private $select   = '';
  private $delete   = false;
  private $truncate = false;
  private $join     = [];
  private $where    = [];
  private $groupBy  = '';
  private $orderBy  = '';
  private $limit    = '';
  private $offset   = false;

  private $whereOperators = [
    '=', '>', '>=', '<', '<=', '!=', '<>', 'LIKE','NOT LIKE', 'IS NULL','IS NOT NULL', 'IN', 'NOT IN', 'BETWEEN', 'NOT BETWEEN', 'REGEXP',
  ];

  private $startParentheses = false;
  private $endParentheses   = false;

  public function __construct(PDO $pdo, string $table) {
    $this->pdo    = $pdo;
    $this->table  = $table;
  }

  public function insert(array $data): Query {
    $this->insert = $data;
    $query        = $this->execute();
    return $query;
  }

  public function update(array $data): Query {
    $this->update = $data;
    $query        = $this->execute();
    return $query;
  }

  public function delete(): Query {
    $this->delete = true;
    $query        = $this->execute();
    return $query;
  }

  public function truncate(): Query {
    $this->truncate = true;
    $query          = $this->execute();
    return $query;
  }

  public function select(...$field): Query {
    $this->select = (!empty($field)) ? join(', ', $field) : '*';
    $query        = $this->execute();
    return $query;
  }

  public function get() {
    $this->select = '*';
    $query        = $this->execute();
    return $query->get();
  }

  public function all() {
    $this->select = '*';
    $query        = $this->execute();
    return $query->all();
  }

  public function debug(): string {
    $this->select = '*';
    $query        = $this->execute();
    return $query->debug();
  }

  public function count(): int {
    $this->select = '*';
    $query        = $this->execute();
    return $query->count();
  }

  public function max(string $field) {
    $max          = 'MAX('.$field.')';
    $this->select = $max;
    $query        = $this->execute();
    return $query->get()->{$max};
  }

  public function min(string $field) {
    $min          = 'MIN('.$field.')';
    $this->select = $min;
    $query        = $this->execute();
    return $query->get()->{$min};
  }

  public function avg(string $field) {
    $avg          = 'AVG('.$field.')';
    $this->select = $avg;
    $query        = $this->execute();
    return $query->get()->{$avg};
  }

  public function sum(string $field) {
    $sum          = 'SUM('.$field.')';
    $this->select = $sum;
    $query        = $this->execute();
    return $query->get()->{$sum};
  }

  public function leftJoin(string $join): self {
    $this->join[] = [
      'type' => 'LEFT',
      'sql'  => trim($join)
    ];
    return $this;
  }

  public function rightJoin(string $join): self {
    $this->join[] = [
      'type' => 'RIGHT',
      'sql'  => trim($join)
    ];
    return $this;
  }

  public function crossJoin(string $join): self {
    $this->join[] = [
      'type' => 'CROSS',
      'sql'  => trim($join)
    ];
    return $this;
  }

  public function innerJoin(string $join): self {
    $this->join[] = [
      'type' => 'INNER',
      'sql'  => trim($join)
    ];
    return $this;
  }

  public function rawJoin(string $join): self {
    $this->join[] = [
      'type' => '',
      'sql'  => trim($join)
    ];
    return $this;
  }

  public function where($field, $operatorValue = null, $value = null): self {
    return $this->addWhere('AND', $field, $operatorValue, $value);
  }

  public function orWhere($field, $operatorValue, $value = null): self {
    return $this->addWhere('OR', $field, $operatorValue, $value);
  }

  public function whereNull(string $field): self {
    return $this->addWhere('AND', $field, 'IS NULL');
  }

  public function orWhereNull(string $field): self {
    return $this->addWhere('OR', $field, 'IS NULL');
  }

  public function whereNotNull(string $field): self {
    return $this->addWhere('AND', $field, 'IS NOT NULL');
  }

  public function orWhereNotNull(string $field): self {
    return $this->addWhere('OR', $field, 'IS NOT NULL');
  }

  public function whereIn(string $field, array $values): self {
    return $this->addWhere('AND', $field, 'IN', $values);
  }

  public function orWhereIn(string $field, array $values): self {
    return $this->addWhere('OR', $field, 'IN', $values);
  }

  public function whereNotIn(string $field, array $values): self {
    return $this->addWhere('AND', $field, 'NOT IN', $values);
  }

  public function orWhereNotIn(string $field, array $values): self {
    return $this->addWhere('OR', $field, 'NOT IN', $values);
  }

  public function whereBetween(string $field, array $values): self {
    if(count($values) !== 2) {
      throw new InvalidArgumentException('Between condition must have two values');
    }
    return $this->addWhere('AND', $field, 'BETWEEN', $values);
  }

  public function orWhereBetween(string $field, array $values): self {
    if(count($values) !== 2) {
      throw new InvalidArgumentException('Between condition must have two values');
    }
    return $this->addWhere('OR', $field, 'BETWEEN', $values);
  }

  public function whereNotBetween(string $field, array $values): self {
    if(count($values) !== 2) {
      throw new InvalidArgumentException('Between condition must have two values');
    }
    return $this->addWhere('AND', $field, 'NOT BETWEEN', $values);
  }

  public function orWhereNotBetween(string $field, array $values): self {
    if(count($values) !== 2) {
      throw new InvalidArgumentException('Between condition must have two values');
    }
    return $this->addWhere('OR', $field, 'NOT BETWEEN', $values);
  }

  public function rawWhere(string $where, array $values = []): self {
    return $this->addWhere('', $where, null, $values);
  }

  private function addWhere($clause, $field, $operatorValue = null, $value = null): self {
    if(!is_string($field) && !is_callable($field)) {
      throw new InvalidArgumentException('First parameter must be a string or callable');
    }

    if(is_callable($field)) {
      $this->startParentheses = true;  
      call_user_func($field, $this);
      $last = (count($this->where)) - 1;
      $this->where[$last]['endParentheses'] = true;
    } else {
      $operator = ($operatorValue !== 0 && in_array($operatorValue, $this->whereOperators)) ? $operatorValue : '=';
      $this->where[] = [
        'clause'            => $clause,
        'field'             => trim($field),
        'operator'          => trim($operator),
        'value'             => ($value) ? $value : $operatorValue,
        'startParentheses'  => $this->startParentheses,
        'endParentheses'    => $this->endParentheses
      ];
    }
    $this->startParentheses = false;
    return $this;
  }

  public function groupBy(string $groupBy): self {
    $this->groupBy = trim($groupBy);
    return $this;
  }

  public function orderBy(string $orderBy): self {
    $this->orderBy = trim($orderBy);
    return $this;
  }

  public function limit(string $limit): self {
    $this->limit = trim($limit);
    return $this;
  }

  public function offset(int $offset): self {
    $this->offset = $offset;
    return $this;
  }

  private function execute(): Query {
    $query  = $this->composeStatement()['query'];
    $query .= $this->composeJoins();
    $query .= $this->composeWhereConditions()['query'];          
    $query .= $this->composeGroupBy();
    $query .= $this->composeOrderBy();
    $query .= $this->composeLimit();
    $query .= $this->composeOffset();
    $values = array_merge($this->composeStatement()['values'], $this->composeWhereConditions()['values']);
    
    return (new Query($this->pdo))->query($query)->values($values);
  }
}
?>