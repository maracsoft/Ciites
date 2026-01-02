<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\HistorialLogeoCollection;
use App\HistorialLogeo;

/**
 * @method static HistorialLogeoBuilder query()
 * @method static HistorialLogeoBuilder where(string $column,string $operator, string $value)
 * @method static HistorialLogeoBuilder where(string $column,string $value)
 * @method static HistorialLogeoBuilder whereNotNull(string $column)
 * @method static HistorialLogeoBuilder whereNull(string $column)
 * @method static HistorialLogeoBuilder whereIn(string $column,array $array)
 * @method static HistorialLogeoBuilder orderBy(string $column,array $sentido)
 * @method static HistorialLogeoBuilder select(array|string $columns)
 * @method static HistorialLogeoBuilder distinct()
 * @method static HistorialLogeoBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static HistorialLogeoBuilder whereBetween(string $column, array $values)
 * @method static HistorialLogeoBuilder whereNotBetween(string $column, array $values)
 * @method static HistorialLogeoBuilder whereNotIn(string $column, array $values)
 * @method static HistorialLogeoBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static HistorialLogeoBuilder whereMonth(string $column, string $operator, int $value)
 * @method static HistorialLogeoBuilder whereYear(string $column, string $operator, int $value)
 * @method static HistorialLogeoBuilder whereColumn(string $first, string $operator, string $second)
 * @method static HistorialLogeoBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static HistorialLogeoBuilder groupBy(string ...$groups)
 * @method static HistorialLogeoBuilder limit(int $value)
 * @method static int count()
 * @method static HistorialLogeoCollection get(array|string $columns = ["*"])
 * @method static HistorialLogeo|null first()
 */
class HistorialLogeoBuilder extends Builder {}
