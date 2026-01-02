<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\DetalleReposicionGastosCollection;
use App\DetalleReposicionGastos;

/**
 * @method static DetalleReposicionGastosBuilder query()
 * @method static DetalleReposicionGastosBuilder where(string $column,string $operator, string $value)
 * @method static DetalleReposicionGastosBuilder where(string $column,string $value)
 * @method static DetalleReposicionGastosBuilder whereNotNull(string $column)
 * @method static DetalleReposicionGastosBuilder whereNull(string $column)
 * @method static DetalleReposicionGastosBuilder whereIn(string $column,array $array)
 * @method static DetalleReposicionGastosBuilder orderBy(string $column,array $sentido)
 * @method static DetalleReposicionGastosBuilder select(array|string $columns)
 * @method static DetalleReposicionGastosBuilder distinct()
 * @method static DetalleReposicionGastosBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static DetalleReposicionGastosBuilder whereBetween(string $column, array $values)
 * @method static DetalleReposicionGastosBuilder whereNotBetween(string $column, array $values)
 * @method static DetalleReposicionGastosBuilder whereNotIn(string $column, array $values)
 * @method static DetalleReposicionGastosBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static DetalleReposicionGastosBuilder whereMonth(string $column, string $operator, int $value)
 * @method static DetalleReposicionGastosBuilder whereYear(string $column, string $operator, int $value)
 * @method static DetalleReposicionGastosBuilder whereColumn(string $first, string $operator, string $second)
 * @method static DetalleReposicionGastosBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static DetalleReposicionGastosBuilder groupBy(string ...$groups)
 * @method static DetalleReposicionGastosBuilder limit(int $value)
 * @method static int count()
 * @method static DetalleReposicionGastosCollection get(array|string $columns = ["*"])
 * @method static DetalleReposicionGastos|null first()
 */
class DetalleReposicionGastosBuilder extends Builder {}
