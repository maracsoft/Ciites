<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\CDPCollection;
use App\CDP;

/**
 * @method static CDPBuilder query()
 * @method static CDPBuilder where(string $column,string $operator, string $value)
 * @method static CDPBuilder where(string $column,string $value)
 * @method static CDPBuilder whereNotNull(string $column)
 * @method static CDPBuilder whereNull(string $column)
 * @method static CDPBuilder whereIn(string $column,array $array)
 * @method static CDPBuilder orderBy(string $column,array $sentido)
 * @method static CDPBuilder select(array|string $columns)
 * @method static CDPBuilder distinct()
 * @method static CDPBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static CDPBuilder whereBetween(string $column, array $values)
 * @method static CDPBuilder whereNotBetween(string $column, array $values)
 * @method static CDPBuilder whereNotIn(string $column, array $values)
 * @method static CDPBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static CDPBuilder whereMonth(string $column, string $operator, int $value)
 * @method static CDPBuilder whereYear(string $column, string $operator, int $value)
 * @method static CDPBuilder whereColumn(string $first, string $operator, string $second)
 * @method static CDPBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static CDPBuilder groupBy(string ...$groups)
 * @method static CDPBuilder limit(int $value)
 * @method static int count()
 * @method static CDPCollection get(array|string $columns = ["*"])
 * @method static CDP|null first()
 */
class CDPBuilder extends Builder {}
