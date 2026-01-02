<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Collections\DocumentoAdministrativoCollection;
use App\DocumentoAdministrativo;

/**
 * @method static DocumentoAdministrativoBuilder query()
 * @method static DocumentoAdministrativoBuilder where(string $column,string $operator, string $value)
 * @method static DocumentoAdministrativoBuilder where(string $column,string $value)
 * @method static DocumentoAdministrativoBuilder whereNotNull(string $column)
 * @method static DocumentoAdministrativoBuilder whereNull(string $column)
 * @method static DocumentoAdministrativoBuilder whereIn(string $column,array $array)
 * @method static DocumentoAdministrativoBuilder orderBy(string $column,array $sentido)
 * @method static DocumentoAdministrativoBuilder select(array|string $columns)
 * @method static DocumentoAdministrativoBuilder distinct()
 * @method static DocumentoAdministrativoBuilder orWhere(string $column, string $operator = null, mixed $value = null)
 * @method static DocumentoAdministrativoBuilder whereBetween(string $column, array $values)
 * @method static DocumentoAdministrativoBuilder whereNotBetween(string $column, array $values)
 * @method static DocumentoAdministrativoBuilder whereNotIn(string $column, array $values)
 * @method static DocumentoAdministrativoBuilder whereDate(string $column, string $operator, string|\DateTimeInterface $value)
 * @method static DocumentoAdministrativoBuilder whereMonth(string $column, string $operator, int $value)
 * @method static DocumentoAdministrativoBuilder whereYear(string $column, string $operator, int $value)
 * @method static DocumentoAdministrativoBuilder whereColumn(string $first, string $operator, string $second)
 * @method static DocumentoAdministrativoBuilder orWhereColumn(string $first, string $operator, string $second)
 * @method static DocumentoAdministrativoBuilder groupBy(string ...$groups)
 * @method static DocumentoAdministrativoBuilder limit(int $value)
 * @method static int count()
 * @method static DocumentoAdministrativoCollection get(array|string $columns = ["*"])
 * @method static DocumentoAdministrativo|null first()
 */
class DocumentoAdministrativoBuilder extends Builder {}
