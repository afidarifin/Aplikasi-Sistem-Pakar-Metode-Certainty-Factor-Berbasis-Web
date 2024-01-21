<?php
/**
 * @author    Afid Arifin <affinbara@gmail.com>
 * @version   v1.3
 * @copyright 17/08/2022
 * @license   /license/
 * @link      https://www.afid.web.id
 */
Trait Alias {
  public function andWhere($field, $operatorValue = null, $value = null): self {
    return $this->where($field, $operatorValue, $value);
  }

  public function and($field, $operatorValue = null, $value = null): self {
    return $this->where($field, $operatorValue, $value);
  }
  
  public function or($field, $operatorValue = null, $value = null): self {
    return $this->orWhere($field, $operatorValue, $value);
  }

  public function whereIsNull(string $field): self {
    return $this->whereNull($field);
  }

  public function andWhereIsNull(string $field): self {
    return $this->whereNull($field);
  }

  public function andWhereNull(string $field): self {
    return $this->whereNull($field);
  }

  public function andIsNull(string $field): self {
    return $this->whereNull($field);
  }

  public function andNull(string $field): self {
    return $this->whereNull($field);
  }

  public function orIsNull(string $field): self {
    return $this->orWhereNull($field);
  }

  public function orWhereIsNull(string $field): self {
    return $this->orWhereNull($field);
  }

  public function orNull(string $field): self {
    return $this->orWhereNull($field);
  }

  public function whereIsNotNull(string $field): self {
    return $this->whereNotNull($field);
  }

  public function andWhereIsNotNull(string $field): self {
    return $this->whereNotNull($field);
  }

  public function andWhereNotNull(string $field): self {
    return $this->whereNotNull($field);
  }

  public function andIsNotNull(string $field): self {
    return $this->whereNotNull($field);
  }

  public function andNotNull(string $field): self {
    return $this->whereNotNull($field);
  }

  public function orIsNotNull($field): self {
    return $this->orWhereNotNull($field);
  }

  public function orNotNull($field): self {
    return $this->orWhereNotNull($field);
  }

  public function orWhereIsNotNull($field): self {
    return $this->orWhereNotNull($field);
  }

  public function andWhereIn(string $field, array $values): self {
    return $this->whereIn($field, $values);
  }

  public function andIn(string $field, array $values): self {
    return $this->whereIn($field, $values);
  }

  public function orIn(string $field, array $values): self {
    return $this->orWhereIn($field, $values);
  }

  public function andNotIn(string $field, array $values): self {
    return $this->whereNotIn($field, $values);
  }

  public function andWhereNotIn(string $field, array $values): self {
    return $this->whereNotIn($field, $values);
  }

  public function orNotIn(string $field, array $values): self {
    return $this->orWhereNotIn($field, $values);
  }

  public function andWhereBetween(string $field, array $values): self {
    return $this->whereBetween($field, $values);
  }

  public function andBetween(string $field, array $values): self {
    return $this->whereBetween($field, $values);
  }

  public function orBetween(string $field, array $values): self {
    return $this->orWhereBetween($field, $values);
  }

  public function andWhereNotBetween(string $field, array $values): self {
    return $this->whereNotBetween($field, $values);
  }

  public function andNotBetween(string $field, array $values): self {
    return $this->whereNotBetween($field, $values);
  }

  public function orNotBetween(string $field, array $values): self {
    return $this->orWhereNotBetween($field, $values);
  }
}
?>