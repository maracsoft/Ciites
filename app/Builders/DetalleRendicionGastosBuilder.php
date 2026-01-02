<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\DetalleRendicionGastosCollection;
use App\DetalleRendicionGastos;

/**
 * @method static DetalleRendicionGastosBuilder query()
 * @method static DetalleRendicionGastosBuilder where(string $column,string $operator, string $value)
 * @method static DetalleRendicionGastosBuilder where(string $column,string $value)
 * @method static DetalleRendicionGastosBuilder whereNotNull(string $column)
 * @method static DetalleRendicionGastosBuilder whereNull(string $column)
 * @method static DetalleRendicionGastosBuilder whereIn(string $column,array $array)
 * @method static DetalleRendicionGastosBuilder orderBy(string $column,array $sentido)
 * @method static DetalleRendicionGastosBuilder select(array|string $columns)
 * @method static DetalleRendicionGastosBuilder distinct()
 * @method static DetalleRendicionGastosBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static DetalleRendicionGastosBuilder whereBetween(string $column, array $values)
 * @method static DetalleRendicionGastosBuilder whereNotBetween(string $column, array $values)
 * @method static DetalleRendicionGastosBuilder whereNotIn(string $column, array $values)
 * @method static DetalleRendicionGastosBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static DetalleRendicionGastosBuilder whereMonth(string $column, string $operator, int $value)
 * @method static DetalleRendicionGastosBuilder whereYear(string $column, string $operator, int $value)
 * @method static DetalleRendicionGastosBuilder whereColumn(string $first, string $operator, string $second)
 * @method static DetalleRendicionGastosBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static DetalleRendicionGastosBuilder groupBy(string ...$groups)
 * @method static DetalleRendicionGastosBuilder limit(int $value)
 * @method static int count()
 * @method static DetalleRendicionGastosCollection get(array|string $columns = ["*"])
 * @method static DetalleRendicionGastos|null first()
 */
class DetalleRendicionGastosBuilder extends Builder {}
