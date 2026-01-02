<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\MonedaCollection;
use App\Moneda;

/**
 * @method static MonedaBuilder query()
 * @method static MonedaBuilder where(string $column,string $operator, string $value)
 * @method static MonedaBuilder where(string $column,string $value)
 * @method static MonedaBuilder whereNotNull(string $column)
 * @method static MonedaBuilder whereNull(string $column)
 * @method static MonedaBuilder whereIn(string $column,array $array)
 * @method static MonedaBuilder orderBy(string $column,array $sentido)
 * @method static MonedaBuilder select(array|string $columns)
 * @method static MonedaBuilder distinct()
 * @method static MonedaBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static MonedaBuilder whereBetween(string $column, array $values)
 * @method static MonedaBuilder whereNotBetween(string $column, array $values)
 * @method static MonedaBuilder whereNotIn(string $column, array $values)
 * @method static MonedaBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static MonedaBuilder whereMonth(string $column, string $operator, int $value)
 * @method static MonedaBuilder whereYear(string $column, string $operator, int $value)
 * @method static MonedaBuilder whereColumn(string $first, string $operator, string $second)
 * @method static MonedaBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static MonedaBuilder groupBy(string ...$groups)
 * @method static MonedaBuilder limit(int $value)
 * @method static int count()
 * @method static MonedaCollection get(array|string $columns = ["*"])
 * @method static Moneda|null first()
 */
class MonedaBuilder extends Builder {}
