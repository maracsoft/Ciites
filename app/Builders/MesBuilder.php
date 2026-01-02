<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\MesCollection;
use App\Mes;

/**
 * @method static MesBuilder query()
 * @method static MesBuilder where(string $column,string $operator, string $value)
 * @method static MesBuilder where(string $column,string $value)
 * @method static MesBuilder whereNotNull(string $column)
 * @method static MesBuilder whereNull(string $column)
 * @method static MesBuilder whereIn(string $column,array $array)
 * @method static MesBuilder orderBy(string $column,array $sentido)
 * @method static MesBuilder select(array|string $columns)
 * @method static MesBuilder distinct()
 * @method static MesBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static MesBuilder whereBetween(string $column, array $values)
 * @method static MesBuilder whereNotBetween(string $column, array $values)
 * @method static MesBuilder whereNotIn(string $column, array $values)
 * @method static MesBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static MesBuilder whereMonth(string $column, string $operator, int $value)
 * @method static MesBuilder whereYear(string $column, string $operator, int $value)
 * @method static MesBuilder whereColumn(string $first, string $operator, string $second)
 * @method static MesBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static MesBuilder groupBy(string ...$groups)
 * @method static MesBuilder limit(int $value)
 * @method static int count()
 * @method static MesCollection get(array|string $columns = ["*"])
 * @method static Mes|null first()
 */
class MesBuilder extends Builder {}
