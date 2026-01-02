<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\LugarEjecucionCollection;
use App\LugarEjecucion;

/**
 * @method static LugarEjecucionBuilder query()
 * @method static LugarEjecucionBuilder where(string $column,string $operator, string $value)
 * @method static LugarEjecucionBuilder where(string $column,string $value)
 * @method static LugarEjecucionBuilder whereNotNull(string $column)
 * @method static LugarEjecucionBuilder whereNull(string $column)
 * @method static LugarEjecucionBuilder whereIn(string $column,array $array)
 * @method static LugarEjecucionBuilder orderBy(string $column,array $sentido)
 * @method static LugarEjecucionBuilder select(array|string $columns)
 * @method static LugarEjecucionBuilder distinct()
 * @method static LugarEjecucionBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static LugarEjecucionBuilder whereBetween(string $column, array $values)
 * @method static LugarEjecucionBuilder whereNotBetween(string $column, array $values)
 * @method static LugarEjecucionBuilder whereNotIn(string $column, array $values)
 * @method static LugarEjecucionBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static LugarEjecucionBuilder whereMonth(string $column, string $operator, int $value)
 * @method static LugarEjecucionBuilder whereYear(string $column, string $operator, int $value)
 * @method static LugarEjecucionBuilder whereColumn(string $first, string $operator, string $second)
 * @method static LugarEjecucionBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static LugarEjecucionBuilder groupBy(string ...$groups)
 * @method static LugarEjecucionBuilder limit(int $value)
 * @method static int count()
 * @method static LugarEjecucionCollection get(array|string $columns = ["*"])
 * @method static LugarEjecucion|null first()
 */
class LugarEjecucionBuilder extends Builder {}
