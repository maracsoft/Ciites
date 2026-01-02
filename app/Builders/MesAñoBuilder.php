<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\MesAñoCollection;
use App\MesAño;

/**
 * @method static MesAñoBuilder query()
 * @method static MesAñoBuilder where(string $column,string $operator, string $value)
 * @method static MesAñoBuilder where(string $column,string $value)
 * @method static MesAñoBuilder whereNotNull(string $column)
 * @method static MesAñoBuilder whereNull(string $column)
 * @method static MesAñoBuilder whereIn(string $column,array $array)
 * @method static MesAñoBuilder orderBy(string $column,array $sentido)
 * @method static MesAñoBuilder select(array|string $columns)
 * @method static MesAñoBuilder distinct()
 * @method static MesAñoBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static MesAñoBuilder whereBetween(string $column, array $values)
 * @method static MesAñoBuilder whereNotBetween(string $column, array $values)
 * @method static MesAñoBuilder whereNotIn(string $column, array $values)
 * @method static MesAñoBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static MesAñoBuilder whereMonth(string $column, string $operator, int $value)
 * @method static MesAñoBuilder whereYear(string $column, string $operator, int $value)
 * @method static MesAñoBuilder whereColumn(string $first, string $operator, string $second)
 * @method static MesAñoBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static MesAñoBuilder groupBy(string ...$groups)
 * @method static MesAñoBuilder limit(int $value)
 * @method static int count()
 * @method static MesAñoCollection get(array|string $columns = ["*"])
 * @method static MesAño|null first()
 */
class MesAñoBuilder extends Builder {}
