<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\AvanceEntregableCollection;
use App\AvanceEntregable;

/**
 * @method static AvanceEntregableBuilder query()
 * @method static AvanceEntregableBuilder where(string $column,string $operator, string $value)
 * @method static AvanceEntregableBuilder where(string $column,string $value)
 * @method static AvanceEntregableBuilder whereNotNull(string $column)
 * @method static AvanceEntregableBuilder whereNull(string $column)
 * @method static AvanceEntregableBuilder whereIn(string $column,array $array)
 * @method static AvanceEntregableBuilder orderBy(string $column,array $sentido)
 * @method static AvanceEntregableBuilder select(array|string $columns)
 * @method static AvanceEntregableBuilder distinct()
 * @method static AvanceEntregableBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static AvanceEntregableBuilder whereBetween(string $column, array $values)
 * @method static AvanceEntregableBuilder whereNotBetween(string $column, array $values)
 * @method static AvanceEntregableBuilder whereNotIn(string $column, array $values)
 * @method static AvanceEntregableBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static AvanceEntregableBuilder whereMonth(string $column, string $operator, int $value)
 * @method static AvanceEntregableBuilder whereYear(string $column, string $operator, int $value)
 * @method static AvanceEntregableBuilder whereColumn(string $first, string $operator, string $second)
 * @method static AvanceEntregableBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static AvanceEntregableBuilder groupBy(string ...$groups)
 * @method static AvanceEntregableBuilder limit(int $value)
 * @method static int count()
 * @method static AvanceEntregableCollection get(array|string $columns = ["*"])
 * @method static AvanceEntregable|null first()
 */
class AvanceEntregableBuilder extends Builder {}
