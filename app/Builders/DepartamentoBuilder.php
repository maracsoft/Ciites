<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\DepartamentoCollection;
use App\Departamento;

/**
 * @method static DepartamentoBuilder query()
 * @method static DepartamentoBuilder where(string $column,string $operator, string $value)
 * @method static DepartamentoBuilder where(string $column,string $value)
 * @method static DepartamentoBuilder whereNotNull(string $column)
 * @method static DepartamentoBuilder whereNull(string $column)
 * @method static DepartamentoBuilder whereIn(string $column,array $array)
 * @method static DepartamentoBuilder orderBy(string $column,array $sentido)
 * @method static DepartamentoBuilder select(array|string $columns)
 * @method static DepartamentoBuilder distinct()
 * @method static DepartamentoBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static DepartamentoBuilder whereBetween(string $column, array $values)
 * @method static DepartamentoBuilder whereNotBetween(string $column, array $values)
 * @method static DepartamentoBuilder whereNotIn(string $column, array $values)
 * @method static DepartamentoBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static DepartamentoBuilder whereMonth(string $column, string $operator, int $value)
 * @method static DepartamentoBuilder whereYear(string $column, string $operator, int $value)
 * @method static DepartamentoBuilder whereColumn(string $first, string $operator, string $second)
 * @method static DepartamentoBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static DepartamentoBuilder groupBy(string ...$groups)
 * @method static DepartamentoBuilder limit(int $value)
 * @method static int count()
 * @method static DepartamentoCollection get(array|string $columns = ["*"])
 * @method static Departamento|null first()
 */
class DepartamentoBuilder extends Builder {}
