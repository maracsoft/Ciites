<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\JobCollection;
use App\Job;

/**
 * @method static JobBuilder query()
 * @method static JobBuilder where(string $column,string $operator, string $value)
 * @method static JobBuilder where(string $column,string $value)
 * @method static JobBuilder whereNotNull(string $column)
 * @method static JobBuilder whereNull(string $column)
 * @method static JobBuilder whereIn(string $column,array $array)
 * @method static JobBuilder orderBy(string $column,array $sentido)
 * @method static JobBuilder select(array|string $columns)
 * @method static JobBuilder distinct()
 * @method static JobBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static JobBuilder whereBetween(string $column, array $values)
 * @method static JobBuilder whereNotBetween(string $column, array $values)
 * @method static JobBuilder whereNotIn(string $column, array $values)
 * @method static JobBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static JobBuilder whereMonth(string $column, string $operator, int $value)
 * @method static JobBuilder whereYear(string $column, string $operator, int $value)
 * @method static JobBuilder whereColumn(string $first, string $operator, string $second)
 * @method static JobBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static JobBuilder groupBy(string ...$groups)
 * @method static JobBuilder limit(int $value)
 * @method static int count()
 * @method static JobCollection get(array|string $columns = ["*"])
 * @method static Job|null first()
 */
class JobBuilder extends Builder {}
