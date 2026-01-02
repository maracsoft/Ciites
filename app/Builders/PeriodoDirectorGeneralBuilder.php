<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\PeriodoDirectorGeneralCollection;
use App\PeriodoDirectorGeneral;

/**
 * @method static PeriodoDirectorGeneralBuilder query()
 * @method static PeriodoDirectorGeneralBuilder where(string $column,string $operator, string $value)
 * @method static PeriodoDirectorGeneralBuilder where(string $column,string $value)
 * @method static PeriodoDirectorGeneralBuilder whereNotNull(string $column)
 * @method static PeriodoDirectorGeneralBuilder whereNull(string $column)
 * @method static PeriodoDirectorGeneralBuilder whereIn(string $column,array $array)
 * @method static PeriodoDirectorGeneralBuilder orderBy(string $column,array $sentido)
 * @method static PeriodoDirectorGeneralBuilder select(array|string $columns)
 * @method static PeriodoDirectorGeneralBuilder distinct()
 * @method static PeriodoDirectorGeneralBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static PeriodoDirectorGeneralBuilder whereBetween(string $column, array $values)
 * @method static PeriodoDirectorGeneralBuilder whereNotBetween(string $column, array $values)
 * @method static PeriodoDirectorGeneralBuilder whereNotIn(string $column, array $values)
 * @method static PeriodoDirectorGeneralBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static PeriodoDirectorGeneralBuilder whereMonth(string $column, string $operator, int $value)
 * @method static PeriodoDirectorGeneralBuilder whereYear(string $column, string $operator, int $value)
 * @method static PeriodoDirectorGeneralBuilder whereColumn(string $first, string $operator, string $second)
 * @method static PeriodoDirectorGeneralBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static PeriodoDirectorGeneralBuilder groupBy(string ...$groups)
 * @method static PeriodoDirectorGeneralBuilder limit(int $value)
 * @method static int count()
 * @method static PeriodoDirectorGeneralCollection get(array|string $columns = ["*"])
 * @method static PeriodoDirectorGeneral|null first()
 */
class PeriodoDirectorGeneralBuilder extends Builder {}
