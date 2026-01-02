<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\MetaEjecutadaCollection;
use App\MetaEjecutada;

/**
 * @method static MetaEjecutadaBuilder query()
 * @method static MetaEjecutadaBuilder where(string $column,string $operator, string $value)
 * @method static MetaEjecutadaBuilder where(string $column,string $value)
 * @method static MetaEjecutadaBuilder whereNotNull(string $column)
 * @method static MetaEjecutadaBuilder whereNull(string $column)
 * @method static MetaEjecutadaBuilder whereIn(string $column,array $array)
 * @method static MetaEjecutadaBuilder orderBy(string $column,array $sentido)
 * @method static MetaEjecutadaBuilder select(array|string $columns)
 * @method static MetaEjecutadaBuilder distinct()
 * @method static MetaEjecutadaBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static MetaEjecutadaBuilder whereBetween(string $column, array $values)
 * @method static MetaEjecutadaBuilder whereNotBetween(string $column, array $values)
 * @method static MetaEjecutadaBuilder whereNotIn(string $column, array $values)
 * @method static MetaEjecutadaBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static MetaEjecutadaBuilder whereMonth(string $column, string $operator, int $value)
 * @method static MetaEjecutadaBuilder whereYear(string $column, string $operator, int $value)
 * @method static MetaEjecutadaBuilder whereColumn(string $first, string $operator, string $second)
 * @method static MetaEjecutadaBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static MetaEjecutadaBuilder groupBy(string ...$groups)
 * @method static MetaEjecutadaBuilder limit(int $value)
 * @method static int count()
 * @method static MetaEjecutadaCollection get(array|string $columns = ["*"])
 * @method static MetaEjecutada|null first()
 */
class MetaEjecutadaBuilder extends Builder {}
