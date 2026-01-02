<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\SemestreCollection;
use App\Semestre;

/**
 * @method static SemestreBuilder query()
 * @method static SemestreBuilder where(string $column,string $operator, string $value)
 * @method static SemestreBuilder where(string $column,string $value)
 * @method static SemestreBuilder whereNotNull(string $column)
 * @method static SemestreBuilder whereNull(string $column)
 * @method static SemestreBuilder whereIn(string $column,array $array)
 * @method static SemestreBuilder orderBy(string $column,array $sentido)
 * @method static SemestreBuilder select(array|string $columns)
 * @method static SemestreBuilder distinct()
 * @method static SemestreBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static SemestreBuilder whereBetween(string $column, array $values)
 * @method static SemestreBuilder whereNotBetween(string $column, array $values)
 * @method static SemestreBuilder whereNotIn(string $column, array $values)
 * @method static SemestreBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static SemestreBuilder whereMonth(string $column, string $operator, int $value)
 * @method static SemestreBuilder whereYear(string $column, string $operator, int $value)
 * @method static SemestreBuilder whereColumn(string $first, string $operator, string $second)
 * @method static SemestreBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static SemestreBuilder groupBy(string ...$groups)
 * @method static SemestreBuilder limit(int $value)
 * @method static int count()
 * @method static SemestreCollection get(array|string $columns = ["*"])
 * @method static Semestre|null first()
 */
class SemestreBuilder extends Builder {}
