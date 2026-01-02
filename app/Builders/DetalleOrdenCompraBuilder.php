<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\DetalleOrdenCompraCollection;
use App\DetalleOrdenCompra;

/**
 * @method static DetalleOrdenCompraBuilder query()
 * @method static DetalleOrdenCompraBuilder where(string $column,string $operator, string $value)
 * @method static DetalleOrdenCompraBuilder where(string $column,string $value)
 * @method static DetalleOrdenCompraBuilder whereNotNull(string $column)
 * @method static DetalleOrdenCompraBuilder whereNull(string $column)
 * @method static DetalleOrdenCompraBuilder whereIn(string $column,array $array)
 * @method static DetalleOrdenCompraBuilder orderBy(string $column,array $sentido)
 * @method static DetalleOrdenCompraBuilder select(array|string $columns)
 * @method static DetalleOrdenCompraBuilder distinct()
 * @method static DetalleOrdenCompraBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static DetalleOrdenCompraBuilder whereBetween(string $column, array $values)
 * @method static DetalleOrdenCompraBuilder whereNotBetween(string $column, array $values)
 * @method static DetalleOrdenCompraBuilder whereNotIn(string $column, array $values)
 * @method static DetalleOrdenCompraBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static DetalleOrdenCompraBuilder whereMonth(string $column, string $operator, int $value)
 * @method static DetalleOrdenCompraBuilder whereYear(string $column, string $operator, int $value)
 * @method static DetalleOrdenCompraBuilder whereColumn(string $first, string $operator, string $second)
 * @method static DetalleOrdenCompraBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static DetalleOrdenCompraBuilder groupBy(string ...$groups)
 * @method static DetalleOrdenCompraBuilder limit(int $value)
 * @method static int count()
 * @method static DetalleOrdenCompraCollection get(array|string $columns = ["*"])
 * @method static DetalleOrdenCompra|null first()
 */
class DetalleOrdenCompraBuilder extends Builder {}
