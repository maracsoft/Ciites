<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\TipoOperacionCollection;
use App\TipoOperacion;

/**
 * @method static TipoOperacionBuilder query()
 * @method static TipoOperacionBuilder where(string $column,string $operator, string $value)
 * @method static TipoOperacionBuilder where(string $column,string $value)
 * @method static TipoOperacionBuilder whereNotNull(string $column)
 * @method static TipoOperacionBuilder whereNull(string $column)
 * @method static TipoOperacionBuilder whereIn(string $column,array $array)
 * @method static TipoOperacionBuilder orderBy(string $column,array $sentido)
 * @method static TipoOperacionBuilder select(array|string $columns)
 * @method static TipoOperacionBuilder distinct()
 * @method static TipoOperacionBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static TipoOperacionBuilder whereBetween(string $column, array $values)
 * @method static TipoOperacionBuilder whereNotBetween(string $column, array $values)
 * @method static TipoOperacionBuilder whereNotIn(string $column, array $values)
 * @method static TipoOperacionBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static TipoOperacionBuilder whereMonth(string $column, string $operator, int $value)
 * @method static TipoOperacionBuilder whereYear(string $column, string $operator, int $value)
 * @method static TipoOperacionBuilder whereColumn(string $first, string $operator, string $second)
 * @method static TipoOperacionBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static TipoOperacionBuilder groupBy(string ...$groups)
 * @method static TipoOperacionBuilder limit(int $value)
 * @method static int count()
 * @method static TipoOperacionCollection get(array|string $columns = ["*"])
 * @method static TipoOperacion|null first()
 */
class TipoOperacionBuilder extends Builder {}
