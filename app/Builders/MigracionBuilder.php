<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\MigracionCollection;
use App\Migracion;

/**
 * @method static MigracionBuilder query()
 * @method static MigracionBuilder where(string $column,string $operator, string $value)
 * @method static MigracionBuilder where(string $column,string $value)
 * @method static MigracionBuilder whereNotNull(string $column)
 * @method static MigracionBuilder whereNull(string $column)
 * @method static MigracionBuilder whereIn(string $column,array $array)
 * @method static MigracionBuilder orderBy(string $column,array $sentido)
 * @method static MigracionBuilder select(array|string $columns)
 * @method static MigracionBuilder distinct()
 * @method static MigracionBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static MigracionBuilder whereBetween(string $column, array $values)
 * @method static MigracionBuilder whereNotBetween(string $column, array $values)
 * @method static MigracionBuilder whereNotIn(string $column, array $values)
 * @method static MigracionBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static MigracionBuilder whereMonth(string $column, string $operator, int $value)
 * @method static MigracionBuilder whereYear(string $column, string $operator, int $value)
 * @method static MigracionBuilder whereColumn(string $first, string $operator, string $second)
 * @method static MigracionBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static MigracionBuilder groupBy(string ...$groups)
 * @method static MigracionBuilder limit(int $value)
 * @method static int count()
 * @method static MigracionCollection get(array|string $columns = ["*"])
 * @method static Migracion|null first()
 */
class MigracionBuilder extends Builder {}
