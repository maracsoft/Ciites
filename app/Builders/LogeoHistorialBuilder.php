<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\LogeoHistorialCollection;
use App\LogeoHistorial;

/**
 * @method static LogeoHistorialBuilder query()
 * @method static LogeoHistorialBuilder where(string $column,string $operator, string $value)
 * @method static LogeoHistorialBuilder where(string $column,string $value)
 * @method static LogeoHistorialBuilder whereNotNull(string $column)
 * @method static LogeoHistorialBuilder whereNull(string $column)
 * @method static LogeoHistorialBuilder whereIn(string $column,array $array)
 * @method static LogeoHistorialBuilder orderBy(string $column,array $sentido)
 * @method static LogeoHistorialBuilder select(array|string $columns)
 * @method static LogeoHistorialBuilder distinct()
 * @method static LogeoHistorialBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static LogeoHistorialBuilder whereBetween(string $column, array $values)
 * @method static LogeoHistorialBuilder whereNotBetween(string $column, array $values)
 * @method static LogeoHistorialBuilder whereNotIn(string $column, array $values)
 * @method static LogeoHistorialBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static LogeoHistorialBuilder whereMonth(string $column, string $operator, int $value)
 * @method static LogeoHistorialBuilder whereYear(string $column, string $operator, int $value)
 * @method static LogeoHistorialBuilder whereColumn(string $first, string $operator, string $second)
 * @method static LogeoHistorialBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static LogeoHistorialBuilder groupBy(string ...$groups)
 * @method static LogeoHistorialBuilder limit(int $value)
 * @method static int count()
 * @method static LogeoHistorialCollection get(array|string $columns = ["*"])
 * @method static LogeoHistorial|null first()
 */
class LogeoHistorialBuilder extends Builder {}
