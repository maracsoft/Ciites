<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\DetalleRevisionCollection;
use App\DetalleRevision;

/**
 * @method static DetalleRevisionBuilder query()
 * @method static DetalleRevisionBuilder where(string $column,string $operator, string $value)
 * @method static DetalleRevisionBuilder where(string $column,string $value)
 * @method static DetalleRevisionBuilder whereNotNull(string $column)
 * @method static DetalleRevisionBuilder whereNull(string $column)
 * @method static DetalleRevisionBuilder whereIn(string $column,array $array)
 * @method static DetalleRevisionBuilder orderBy(string $column,array $sentido)
 * @method static DetalleRevisionBuilder select(array|string $columns)
 * @method static DetalleRevisionBuilder distinct()
 * @method static DetalleRevisionBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static DetalleRevisionBuilder whereBetween(string $column, array $values)
 * @method static DetalleRevisionBuilder whereNotBetween(string $column, array $values)
 * @method static DetalleRevisionBuilder whereNotIn(string $column, array $values)
 * @method static DetalleRevisionBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static DetalleRevisionBuilder whereMonth(string $column, string $operator, int $value)
 * @method static DetalleRevisionBuilder whereYear(string $column, string $operator, int $value)
 * @method static DetalleRevisionBuilder whereColumn(string $first, string $operator, string $second)
 * @method static DetalleRevisionBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static DetalleRevisionBuilder groupBy(string ...$groups)
 * @method static DetalleRevisionBuilder limit(int $value)
 * @method static int count()
 * @method static DetalleRevisionCollection get(array|string $columns = ["*"])
 * @method static DetalleRevision|null first()
 */
class DetalleRevisionBuilder extends Builder {}
