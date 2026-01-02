<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\RequerimientoBSCollection;
use App\RequerimientoBS;

/**
 * @method static RequerimientoBSBuilder query()
 * @method static RequerimientoBSBuilder where(string $column,string $operator, string $value)
 * @method static RequerimientoBSBuilder where(string $column,string $value)
 * @method static RequerimientoBSBuilder whereNotNull(string $column)
 * @method static RequerimientoBSBuilder whereNull(string $column)
 * @method static RequerimientoBSBuilder whereIn(string $column,array $array)
 * @method static RequerimientoBSBuilder orderBy(string $column,array $sentido)
 * @method static RequerimientoBSBuilder select(array|string $columns)
 * @method static RequerimientoBSBuilder distinct()
 * @method static RequerimientoBSBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static RequerimientoBSBuilder whereBetween(string $column, array $values)
 * @method static RequerimientoBSBuilder whereNotBetween(string $column, array $values)
 * @method static RequerimientoBSBuilder whereNotIn(string $column, array $values)
 * @method static RequerimientoBSBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static RequerimientoBSBuilder whereMonth(string $column, string $operator, int $value)
 * @method static RequerimientoBSBuilder whereYear(string $column, string $operator, int $value)
 * @method static RequerimientoBSBuilder whereColumn(string $first, string $operator, string $second)
 * @method static RequerimientoBSBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static RequerimientoBSBuilder groupBy(string ...$groups)
 * @method static RequerimientoBSBuilder limit(int $value)
 * @method static int count()
 * @method static RequerimientoBSCollection get(array|string $columns = ["*"])
 * @method static RequerimientoBS|null first()
 */
class RequerimientoBSBuilder extends Builder {}
