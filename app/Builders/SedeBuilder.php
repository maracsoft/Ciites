<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\SedeCollection;
use App\Sede;

/**
 * @method static SedeBuilder query()
 * @method static SedeBuilder where(string $column,string $operator, string $value)
 * @method static SedeBuilder where(string $column,string $value)
 * @method static SedeBuilder whereNotNull(string $column)
 * @method static SedeBuilder whereNull(string $column)
 * @method static SedeBuilder whereIn(string $column,array $array)
 * @method static SedeBuilder orderBy(string $column,array $sentido)
 * @method static SedeBuilder select(array|string $columns)
 * @method static SedeBuilder distinct()
 * @method static SedeBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static SedeBuilder whereBetween(string $column, array $values)
 * @method static SedeBuilder whereNotBetween(string $column, array $values)
 * @method static SedeBuilder whereNotIn(string $column, array $values)
 * @method static SedeBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static SedeBuilder whereMonth(string $column, string $operator, int $value)
 * @method static SedeBuilder whereYear(string $column, string $operator, int $value)
 * @method static SedeBuilder whereColumn(string $first, string $operator, string $second)
 * @method static SedeBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static SedeBuilder groupBy(string ...$groups)
 * @method static SedeBuilder limit(int $value)
 * @method static int count()
 * @method static SedeCollection get(array|string $columns = ["*"])
 * @method static Sede|null first()
 */
class SedeBuilder extends Builder {}
