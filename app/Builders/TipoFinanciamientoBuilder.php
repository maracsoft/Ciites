<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\TipoFinanciamientoCollection;
use App\TipoFinanciamiento;

/**
 * @method static TipoFinanciamientoBuilder query()
 * @method static TipoFinanciamientoBuilder where(string $column,string $operator, string $value)
 * @method static TipoFinanciamientoBuilder where(string $column,string $value)
 * @method static TipoFinanciamientoBuilder whereNotNull(string $column)
 * @method static TipoFinanciamientoBuilder whereNull(string $column)
 * @method static TipoFinanciamientoBuilder whereIn(string $column,array $array)
 * @method static TipoFinanciamientoBuilder orderBy(string $column,array $sentido)
 * @method static TipoFinanciamientoBuilder select(array|string $columns)
 * @method static TipoFinanciamientoBuilder distinct()
 * @method static TipoFinanciamientoBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static TipoFinanciamientoBuilder whereBetween(string $column, array $values)
 * @method static TipoFinanciamientoBuilder whereNotBetween(string $column, array $values)
 * @method static TipoFinanciamientoBuilder whereNotIn(string $column, array $values)
 * @method static TipoFinanciamientoBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static TipoFinanciamientoBuilder whereMonth(string $column, string $operator, int $value)
 * @method static TipoFinanciamientoBuilder whereYear(string $column, string $operator, int $value)
 * @method static TipoFinanciamientoBuilder whereColumn(string $first, string $operator, string $second)
 * @method static TipoFinanciamientoBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static TipoFinanciamientoBuilder groupBy(string ...$groups)
 * @method static TipoFinanciamientoBuilder limit(int $value)
 * @method static int count()
 * @method static TipoFinanciamientoCollection get(array|string $columns = ["*"])
 * @method static TipoFinanciamiento|null first()
 */
class TipoFinanciamientoBuilder extends Builder {}
