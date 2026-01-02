<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\ArchivoOrdenCompraCollection;
use App\ArchivoOrdenCompra;

/**
 * @method static ArchivoOrdenCompraBuilder query()
 * @method static ArchivoOrdenCompraBuilder where(string $column,string $operator, string $value)
 * @method static ArchivoOrdenCompraBuilder where(string $column,string $value)
 * @method static ArchivoOrdenCompraBuilder whereNotNull(string $column)
 * @method static ArchivoOrdenCompraBuilder whereNull(string $column)
 * @method static ArchivoOrdenCompraBuilder whereIn(string $column,array $array)
 * @method static ArchivoOrdenCompraBuilder orderBy(string $column,array $sentido)
 * @method static ArchivoOrdenCompraBuilder select(array|string $columns)
 * @method static ArchivoOrdenCompraBuilder distinct()
 * @method static ArchivoOrdenCompraBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static ArchivoOrdenCompraBuilder whereBetween(string $column, array $values)
 * @method static ArchivoOrdenCompraBuilder whereNotBetween(string $column, array $values)
 * @method static ArchivoOrdenCompraBuilder whereNotIn(string $column, array $values)
 * @method static ArchivoOrdenCompraBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static ArchivoOrdenCompraBuilder whereMonth(string $column, string $operator, int $value)
 * @method static ArchivoOrdenCompraBuilder whereYear(string $column, string $operator, int $value)
 * @method static ArchivoOrdenCompraBuilder whereColumn(string $first, string $operator, string $second)
 * @method static ArchivoOrdenCompraBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static ArchivoOrdenCompraBuilder groupBy(string ...$groups)
 * @method static ArchivoOrdenCompraBuilder limit(int $value)
 * @method static int count()
 * @method static ArchivoOrdenCompraCollection get(array|string $columns = ["*"])
 * @method static ArchivoOrdenCompra|null first()
 */
class ArchivoOrdenCompraBuilder extends Builder {}
