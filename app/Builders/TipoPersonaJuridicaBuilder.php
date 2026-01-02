<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\TipoPersonaJuridicaCollection;
use App\TipoPersonaJuridica;

/**
 * @method static TipoPersonaJuridicaBuilder query()
 * @method static TipoPersonaJuridicaBuilder where(string $column,string $operator, string $value)
 * @method static TipoPersonaJuridicaBuilder where(string $column,string $value)
 * @method static TipoPersonaJuridicaBuilder whereNotNull(string $column)
 * @method static TipoPersonaJuridicaBuilder whereNull(string $column)
 * @method static TipoPersonaJuridicaBuilder whereIn(string $column,array $array)
 * @method static TipoPersonaJuridicaBuilder orderBy(string $column,array $sentido)
 * @method static TipoPersonaJuridicaBuilder select(array|string $columns)
 * @method static TipoPersonaJuridicaBuilder distinct()
 * @method static TipoPersonaJuridicaBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static TipoPersonaJuridicaBuilder whereBetween(string $column, array $values)
 * @method static TipoPersonaJuridicaBuilder whereNotBetween(string $column, array $values)
 * @method static TipoPersonaJuridicaBuilder whereNotIn(string $column, array $values)
 * @method static TipoPersonaJuridicaBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static TipoPersonaJuridicaBuilder whereMonth(string $column, string $operator, int $value)
 * @method static TipoPersonaJuridicaBuilder whereYear(string $column, string $operator, int $value)
 * @method static TipoPersonaJuridicaBuilder whereColumn(string $first, string $operator, string $second)
 * @method static TipoPersonaJuridicaBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static TipoPersonaJuridicaBuilder groupBy(string ...$groups)
 * @method static TipoPersonaJuridicaBuilder limit(int $value)
 * @method static int count()
 * @method static TipoPersonaJuridicaCollection get(array|string $columns = ["*"])
 * @method static TipoPersonaJuridica|null first()
 */
class TipoPersonaJuridicaBuilder extends Builder {}
