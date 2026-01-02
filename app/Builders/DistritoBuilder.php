<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\DistritoCollection;
use App\Distrito;

/**
 * @method static DistritoBuilder query()
 * @method static DistritoBuilder where(string $column,string $operator, string $value)
 * @method static DistritoBuilder where(string $column,string $value)
 * @method static DistritoBuilder whereNotNull(string $column)
 * @method static DistritoBuilder whereNull(string $column)
 * @method static DistritoBuilder whereIn(string $column,array $array)
 * @method static DistritoBuilder orderBy(string $column,array $sentido)
 * @method static DistritoBuilder select(array|string $columns)
 * @method static DistritoBuilder distinct()
 * @method static DistritoBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static DistritoBuilder whereBetween(string $column, array $values)
 * @method static DistritoBuilder whereNotBetween(string $column, array $values)
 * @method static DistritoBuilder whereNotIn(string $column, array $values)
 * @method static DistritoBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static DistritoBuilder whereMonth(string $column, string $operator, int $value)
 * @method static DistritoBuilder whereYear(string $column, string $operator, int $value)
 * @method static DistritoBuilder whereColumn(string $first, string $operator, string $second)
 * @method static DistritoBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static DistritoBuilder groupBy(string ...$groups)
 * @method static DistritoBuilder limit(int $value)
 * @method static int count()
 * @method static DistritoCollection get(array|string $columns = ["*"])
 * @method static Distrito|null first()
 */
class DistritoBuilder extends Builder {}
