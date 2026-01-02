<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\DetalleRequerimientoBSCollection;
use App\DetalleRequerimientoBS;

/**
 * @method static DetalleRequerimientoBSBuilder query()
 * @method static DetalleRequerimientoBSBuilder where(string $column,string $operator, string $value)
 * @method static DetalleRequerimientoBSBuilder where(string $column,string $value)
 * @method static DetalleRequerimientoBSBuilder whereNotNull(string $column)
 * @method static DetalleRequerimientoBSBuilder whereNull(string $column)
 * @method static DetalleRequerimientoBSBuilder whereIn(string $column,array $array)
 * @method static DetalleRequerimientoBSBuilder orderBy(string $column,array $sentido)
 * @method static DetalleRequerimientoBSBuilder select(array|string $columns)
 * @method static DetalleRequerimientoBSBuilder distinct()
 * @method static DetalleRequerimientoBSBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static DetalleRequerimientoBSBuilder whereBetween(string $column, array $values)
 * @method static DetalleRequerimientoBSBuilder whereNotBetween(string $column, array $values)
 * @method static DetalleRequerimientoBSBuilder whereNotIn(string $column, array $values)
 * @method static DetalleRequerimientoBSBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static DetalleRequerimientoBSBuilder whereMonth(string $column, string $operator, int $value)
 * @method static DetalleRequerimientoBSBuilder whereYear(string $column, string $operator, int $value)
 * @method static DetalleRequerimientoBSBuilder whereColumn(string $first, string $operator, string $second)
 * @method static DetalleRequerimientoBSBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static DetalleRequerimientoBSBuilder groupBy(string ...$groups)
 * @method static DetalleRequerimientoBSBuilder limit(int $value)
 * @method static int count()
 * @method static DetalleRequerimientoBSCollection get(array|string $columns = ["*"])
 * @method static DetalleRequerimientoBS|null first()
 */
class DetalleRequerimientoBSBuilder extends Builder {}
