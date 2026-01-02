<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\PersonaJuridicaPoblacionCollection;
use App\PersonaJuridicaPoblacion;

/**
 * @method static PersonaJuridicaPoblacionBuilder query()
 * @method static PersonaJuridicaPoblacionBuilder where(string $column,string $operator, string $value)
 * @method static PersonaJuridicaPoblacionBuilder where(string $column,string $value)
 * @method static PersonaJuridicaPoblacionBuilder whereNotNull(string $column)
 * @method static PersonaJuridicaPoblacionBuilder whereNull(string $column)
 * @method static PersonaJuridicaPoblacionBuilder whereIn(string $column,array $array)
 * @method static PersonaJuridicaPoblacionBuilder orderBy(string $column,array $sentido)
 * @method static PersonaJuridicaPoblacionBuilder select(array|string $columns)
 * @method static PersonaJuridicaPoblacionBuilder distinct()
 * @method static PersonaJuridicaPoblacionBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static PersonaJuridicaPoblacionBuilder whereBetween(string $column, array $values)
 * @method static PersonaJuridicaPoblacionBuilder whereNotBetween(string $column, array $values)
 * @method static PersonaJuridicaPoblacionBuilder whereNotIn(string $column, array $values)
 * @method static PersonaJuridicaPoblacionBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static PersonaJuridicaPoblacionBuilder whereMonth(string $column, string $operator, int $value)
 * @method static PersonaJuridicaPoblacionBuilder whereYear(string $column, string $operator, int $value)
 * @method static PersonaJuridicaPoblacionBuilder whereColumn(string $first, string $operator, string $second)
 * @method static PersonaJuridicaPoblacionBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static PersonaJuridicaPoblacionBuilder groupBy(string ...$groups)
 * @method static PersonaJuridicaPoblacionBuilder limit(int $value)
 * @method static int count()
 * @method static PersonaJuridicaPoblacionCollection get(array|string $columns = ["*"])
 * @method static PersonaJuridicaPoblacion|null first()
 */
class PersonaJuridicaPoblacionBuilder extends Builder {}
