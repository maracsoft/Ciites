<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\TipoParametroSistemaCollection;
use App\TipoParametroSistema;

/**
 * @method static TipoParametroSistemaBuilder query()
 * @method static TipoParametroSistemaBuilder where(string $column,string $operator, string $value)
 * @method static TipoParametroSistemaBuilder where(string $column,string $value)
 * @method static TipoParametroSistemaBuilder whereNotNull(string $column)
 * @method static TipoParametroSistemaBuilder whereNull(string $column)
 * @method static TipoParametroSistemaBuilder whereIn(string $column,array $array)
 * @method static TipoParametroSistemaBuilder orderBy(string $column,array $sentido)
 * @method static TipoParametroSistemaBuilder select(array|string $columns)
 * @method static TipoParametroSistemaBuilder distinct()
 * @method static TipoParametroSistemaBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static TipoParametroSistemaBuilder whereBetween(string $column, array $values)
 * @method static TipoParametroSistemaBuilder whereNotBetween(string $column, array $values)
 * @method static TipoParametroSistemaBuilder whereNotIn(string $column, array $values)
 * @method static TipoParametroSistemaBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static TipoParametroSistemaBuilder whereMonth(string $column, string $operator, int $value)
 * @method static TipoParametroSistemaBuilder whereYear(string $column, string $operator, int $value)
 * @method static TipoParametroSistemaBuilder whereColumn(string $first, string $operator, string $second)
 * @method static TipoParametroSistemaBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static TipoParametroSistemaBuilder groupBy(string ...$groups)
 * @method static TipoParametroSistemaBuilder limit(int $value)
 * @method static int count()
 * @method static TipoParametroSistemaCollection get(array|string $columns = ["*"])
 * @method static TipoParametroSistema|null first()
 */
class TipoParametroSistemaBuilder extends Builder {}
