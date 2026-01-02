<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\OrdenCompraCollection;
use App\OrdenCompra;

/**
 * @method static OrdenCompraBuilder query()
 * @method static OrdenCompraBuilder where(string $column,string $operator, string $value)
 * @method static OrdenCompraBuilder where(string $column,string $value)
 * @method static OrdenCompraBuilder whereNotNull(string $column)
 * @method static OrdenCompraBuilder whereNull(string $column)
 * @method static OrdenCompraBuilder whereIn(string $column,array $array)
 * @method static OrdenCompraBuilder orderBy(string $column,array $sentido)
 * @method static OrdenCompraBuilder select(array|string $columns)
 * @method static OrdenCompraBuilder distinct()
 * @method static OrdenCompraBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static OrdenCompraBuilder whereBetween(string $column, array $values)
 * @method static OrdenCompraBuilder whereNotBetween(string $column, array $values)
 * @method static OrdenCompraBuilder whereNotIn(string $column, array $values)
 * @method static OrdenCompraBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static OrdenCompraBuilder whereMonth(string $column, string $operator, int $value)
 * @method static OrdenCompraBuilder whereYear(string $column, string $operator, int $value)
 * @method static OrdenCompraBuilder whereColumn(string $first, string $operator, string $second)
 * @method static OrdenCompraBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static OrdenCompraBuilder groupBy(string ...$groups)
 * @method static OrdenCompraBuilder limit(int $value)
 * @method static int count()
 * @method static OrdenCompraCollection get(array|string $columns = ["*"])
 * @method static OrdenCompra|null first()
 */
class OrdenCompraBuilder extends Builder {}
