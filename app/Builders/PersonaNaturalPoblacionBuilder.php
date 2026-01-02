<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\PersonaNaturalPoblacionCollection;
use App\PersonaNaturalPoblacion;

/**
 * @method static PersonaNaturalPoblacionBuilder query()
 * @method static PersonaNaturalPoblacionBuilder where(string $column,string $operator, string $value)
 * @method static PersonaNaturalPoblacionBuilder where(string $column,string $value)
 * @method static PersonaNaturalPoblacionBuilder whereNotNull(string $column)
 * @method static PersonaNaturalPoblacionBuilder whereNull(string $column)
 * @method static PersonaNaturalPoblacionBuilder whereIn(string $column,array $array)
 * @method static PersonaNaturalPoblacionBuilder orderBy(string $column,array $sentido)
 * @method static PersonaNaturalPoblacionBuilder select(array|string $columns)
 * @method static PersonaNaturalPoblacionBuilder distinct()
 * @method static PersonaNaturalPoblacionBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static PersonaNaturalPoblacionBuilder whereBetween(string $column, array $values)
 * @method static PersonaNaturalPoblacionBuilder whereNotBetween(string $column, array $values)
 * @method static PersonaNaturalPoblacionBuilder whereNotIn(string $column, array $values)
 * @method static PersonaNaturalPoblacionBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static PersonaNaturalPoblacionBuilder whereMonth(string $column, string $operator, int $value)
 * @method static PersonaNaturalPoblacionBuilder whereYear(string $column, string $operator, int $value)
 * @method static PersonaNaturalPoblacionBuilder whereColumn(string $first, string $operator, string $second)
 * @method static PersonaNaturalPoblacionBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static PersonaNaturalPoblacionBuilder groupBy(string ...$groups)
 * @method static PersonaNaturalPoblacionBuilder limit(int $value)
 * @method static int count()
 * @method static PersonaNaturalPoblacionCollection get(array|string $columns = ["*"])
 * @method static PersonaNaturalPoblacion|null first()
 */
class PersonaNaturalPoblacionBuilder extends Builder {}
