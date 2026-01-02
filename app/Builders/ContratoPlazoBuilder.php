<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\ContratoPlazoCollection;
use App\ContratoPlazo;

/**
 * @method static ContratoPlazoBuilder query()
 * @method static ContratoPlazoBuilder where(string $column,string $operator, string $value)
 * @method static ContratoPlazoBuilder where(string $column,string $value)
 * @method static ContratoPlazoBuilder whereNotNull(string $column)
 * @method static ContratoPlazoBuilder whereNull(string $column)
 * @method static ContratoPlazoBuilder whereIn(string $column,array $array)
 * @method static ContratoPlazoBuilder orderBy(string $column,array $sentido)
 * @method static ContratoPlazoBuilder select(array|string $columns)
 * @method static ContratoPlazoBuilder distinct()
 * @method static ContratoPlazoBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static ContratoPlazoBuilder whereBetween(string $column, array $values)
 * @method static ContratoPlazoBuilder whereNotBetween(string $column, array $values)
 * @method static ContratoPlazoBuilder whereNotIn(string $column, array $values)
 * @method static ContratoPlazoBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static ContratoPlazoBuilder whereMonth(string $column, string $operator, int $value)
 * @method static ContratoPlazoBuilder whereYear(string $column, string $operator, int $value)
 * @method static ContratoPlazoBuilder whereColumn(string $first, string $operator, string $second)
 * @method static ContratoPlazoBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static ContratoPlazoBuilder groupBy(string ...$groups)
 * @method static ContratoPlazoBuilder limit(int $value)
 * @method static int count()
 * @method static ContratoPlazoCollection get(array|string $columns = ["*"])
 * @method static ContratoPlazo|null first()
 */
class ContratoPlazoBuilder extends Builder {}
