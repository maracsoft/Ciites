<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\NumeracionCollection;
use App\Numeracion;

/**
 * @method static NumeracionBuilder query()
 * @method static NumeracionBuilder where(string $column,string $operator, string $value)
 * @method static NumeracionBuilder where(string $column,string $value)
 * @method static NumeracionBuilder whereNotNull(string $column)
 * @method static NumeracionBuilder whereNull(string $column)
 * @method static NumeracionBuilder whereIn(string $column,array $array)
 * @method static NumeracionBuilder orderBy(string $column,array $sentido)
 * @method static NumeracionBuilder select(array|string $columns)
 * @method static NumeracionBuilder distinct()
 * @method static NumeracionBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static NumeracionBuilder whereBetween(string $column, array $values)
 * @method static NumeracionBuilder whereNotBetween(string $column, array $values)
 * @method static NumeracionBuilder whereNotIn(string $column, array $values)
 * @method static NumeracionBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static NumeracionBuilder whereMonth(string $column, string $operator, int $value)
 * @method static NumeracionBuilder whereYear(string $column, string $operator, int $value)
 * @method static NumeracionBuilder whereColumn(string $first, string $operator, string $second)
 * @method static NumeracionBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static NumeracionBuilder groupBy(string ...$groups)
 * @method static NumeracionBuilder limit(int $value)
 * @method static int count()
 * @method static NumeracionCollection get(array|string $columns = ["*"])
 * @method static Numeracion|null first()
 */
class NumeracionBuilder extends Builder {}
