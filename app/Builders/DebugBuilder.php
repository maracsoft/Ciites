<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\DebugCollection;
use App\Debug;

/**
 * @method static DebugBuilder query()
 * @method static DebugBuilder where(string $column,string $operator, string $value)
 * @method static DebugBuilder where(string $column,string $value)
 * @method static DebugBuilder whereNotNull(string $column)
 * @method static DebugBuilder whereNull(string $column)
 * @method static DebugBuilder whereIn(string $column,array $array)
 * @method static DebugBuilder orderBy(string $column,array $sentido)
 * @method static DebugBuilder select(array|string $columns)
 * @method static DebugBuilder distinct()
 * @method static DebugBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static DebugBuilder whereBetween(string $column, array $values)
 * @method static DebugBuilder whereNotBetween(string $column, array $values)
 * @method static DebugBuilder whereNotIn(string $column, array $values)
 * @method static DebugBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static DebugBuilder whereMonth(string $column, string $operator, int $value)
 * @method static DebugBuilder whereYear(string $column, string $operator, int $value)
 * @method static DebugBuilder whereColumn(string $first, string $operator, string $second)
 * @method static DebugBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static DebugBuilder groupBy(string ...$groups)
 * @method static DebugBuilder limit(int $value)
 * @method static int count()
 * @method static DebugCollection get(array|string $columns = ["*"])
 * @method static Debug|null first()
 */
class DebugBuilder extends Builder {}
