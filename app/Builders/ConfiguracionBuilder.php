<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\ConfiguracionCollection;
use App\Utils\Configuracion;

/**
 * @method static ConfiguracionBuilder query()
 * @method static ConfiguracionBuilder where(string $column,string $operator, string $value)
 * @method static ConfiguracionBuilder where(string $column,string $value)
 * @method static ConfiguracionBuilder whereNotNull(string $column)
 * @method static ConfiguracionBuilder whereNull(string $column)
 * @method static ConfiguracionBuilder whereIn(string $column,array $array)
 * @method static ConfiguracionBuilder orderBy(string $column,array $sentido)
 * @method static ConfiguracionBuilder select(array|string $columns)
 * @method static ConfiguracionBuilder distinct()
 * @method static ConfiguracionBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static ConfiguracionBuilder whereBetween(string $column, array $values)
 * @method static ConfiguracionBuilder whereNotBetween(string $column, array $values)
 * @method static ConfiguracionBuilder whereNotIn(string $column, array $values)
 * @method static ConfiguracionBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static ConfiguracionBuilder whereMonth(string $column, string $operator, int $value)
 * @method static ConfiguracionBuilder whereYear(string $column, string $operator, int $value)
 * @method static ConfiguracionBuilder whereColumn(string $first, string $operator, string $second)
 * @method static ConfiguracionBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static ConfiguracionBuilder groupBy(string ...$groups)
 * @method static ConfiguracionBuilder limit(int $value)
 * @method static int count()
 * @method static ConfiguracionCollection get(array|string $columns = ["*"])
 * @method static Configuracion|null first()
 */
class ConfiguracionBuilder extends Builder {}
