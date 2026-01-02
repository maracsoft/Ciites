<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\UnidadMedidaCollection;
use App\UnidadMedida;

/**
 * @method static UnidadMedidaBuilder query()
 * @method static UnidadMedidaBuilder where(string $column,string $operator, string $value)
 * @method static UnidadMedidaBuilder where(string $column,string $value)
 * @method static UnidadMedidaBuilder whereNotNull(string $column)
 * @method static UnidadMedidaBuilder whereNull(string $column)
 * @method static UnidadMedidaBuilder whereIn(string $column,array $array)
 * @method static UnidadMedidaBuilder orderBy(string $column,array $sentido)
 * @method static UnidadMedidaBuilder select(array|string $columns)
 * @method static UnidadMedidaBuilder distinct()
 * @method static UnidadMedidaBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static UnidadMedidaBuilder whereBetween(string $column, array $values)
 * @method static UnidadMedidaBuilder whereNotBetween(string $column, array $values)
 * @method static UnidadMedidaBuilder whereNotIn(string $column, array $values)
 * @method static UnidadMedidaBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static UnidadMedidaBuilder whereMonth(string $column, string $operator, int $value)
 * @method static UnidadMedidaBuilder whereYear(string $column, string $operator, int $value)
 * @method static UnidadMedidaBuilder whereColumn(string $first, string $operator, string $second)
 * @method static UnidadMedidaBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static UnidadMedidaBuilder groupBy(string ...$groups)
 * @method static UnidadMedidaBuilder limit(int $value)
 * @method static int count()
 * @method static UnidadMedidaCollection get(array|string $columns = ["*"])
 * @method static UnidadMedida|null first()
 */
class UnidadMedidaBuilder extends Builder {}
