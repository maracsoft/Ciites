<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\ErrorHistorialCollection;
use App\ErrorHistorial;

/**
 * @method static ErrorHistorialBuilder query()
 * @method static ErrorHistorialBuilder where(string $column,string $operator, string $value)
 * @method static ErrorHistorialBuilder where(string $column,string $value)
 * @method static ErrorHistorialBuilder whereNotNull(string $column)
 * @method static ErrorHistorialBuilder whereNull(string $column)
 * @method static ErrorHistorialBuilder whereIn(string $column,array $array)
 * @method static ErrorHistorialBuilder orderBy(string $column,array $sentido)
 * @method static ErrorHistorialBuilder select(array|string $columns)
 * @method static ErrorHistorialBuilder distinct()
 * @method static ErrorHistorialBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static ErrorHistorialBuilder whereBetween(string $column, array $values)
 * @method static ErrorHistorialBuilder whereNotBetween(string $column, array $values)
 * @method static ErrorHistorialBuilder whereNotIn(string $column, array $values)
 * @method static ErrorHistorialBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static ErrorHistorialBuilder whereMonth(string $column, string $operator, int $value)
 * @method static ErrorHistorialBuilder whereYear(string $column, string $operator, int $value)
 * @method static ErrorHistorialBuilder whereColumn(string $first, string $operator, string $second)
 * @method static ErrorHistorialBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static ErrorHistorialBuilder groupBy(string ...$groups)
 * @method static ErrorHistorialBuilder limit(int $value)
 * @method static int count()
 * @method static ErrorHistorialCollection get(array|string $columns = ["*"])
 * @method static ErrorHistorial|null first()
 */
class ErrorHistorialBuilder extends Builder {}
