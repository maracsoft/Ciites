<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\MaracModelCollection;
use App\MaracModel;

/**
 * @method static MaracModelBuilder query()
 * @method static MaracModelBuilder where(string $column,string $operator, string $value)
 * @method static MaracModelBuilder where(string $column,string $value)
 * @method static MaracModelBuilder whereNotNull(string $column)
 * @method static MaracModelBuilder whereNull(string $column)
 * @method static MaracModelBuilder whereIn(string $column,array $array)
 * @method static MaracModelBuilder orderBy(string $column,array $sentido)
 * @method static MaracModelBuilder select(array|string $columns)
 * @method static MaracModelBuilder distinct()
 * @method static MaracModelBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static MaracModelBuilder whereBetween(string $column, array $values)
 * @method static MaracModelBuilder whereNotBetween(string $column, array $values)
 * @method static MaracModelBuilder whereNotIn(string $column, array $values)
 * @method static MaracModelBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static MaracModelBuilder whereMonth(string $column, string $operator, int $value)
 * @method static MaracModelBuilder whereYear(string $column, string $operator, int $value)
 * @method static MaracModelBuilder whereColumn(string $first, string $operator, string $second)
 * @method static MaracModelBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static MaracModelBuilder groupBy(string ...$groups)
 * @method static MaracModelBuilder limit(int $value)
 * @method static int count()
 * @method static MaracModelCollection get(array|string $columns = ["*"])
 * @method static MaracModel|null first()
 */
class MaracModelBuilder extends Builder {}
