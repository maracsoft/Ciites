<?php

namespace App\Utils;

use App\EstadoDesembolsoConvenio;
use App\SolicitudFondos;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/*
Esta clase sirve para generar los ordenamientos de nuestras tablas segun distintos roles, pero no haciendo el order by con una columna de una tabla estado
Sino generando una tabla artificial que desde código (esta tabla solo se usa en la consulta actual)

De esta manera en todos los ambientes tenemos el mismo ordenamiento, ya no tenemos una tabla de estados, y los cod estado son texto


La forma de generar la tabla artificial es con UNION:

SELECT 0 as 'codigo ',0 as 'orden'
  UNION
SELECT 'Abonada',1
  UNION
SELECT 'Cancelada',2


select
*
from
solicitud_fondos SOF
INNER JOIN
(SELECT 'Abonada',1 UNION SELECT 'Cancelada',2) temporal
ON temporal.codigo = SOF.estado_text;

*/

class OrdenadorEstados
{




  public static function buildSqlRaw(array $estados)
  {
    $rows = [];

    foreach ($estados as $estado => $orden) {
      if ($orden != 0)
        $rows[] = "SELECT '$estado' as 'codigo',$orden as 'orden_estado'";
    }

    $sql = implode(" UNION ", $rows);
    $sql = "($sql) temporal";

    return $sql;
  }

  public static function ordenarQuerySegunEstados(Builder $queryBuilder, array $estados): Builder
  {

    $tablename = $queryBuilder->getTableName();

    $raw_sql_temporal = DB::raw(static::buildSqlRaw($estados));

    $queryBuilder = $queryBuilder->join($raw_sql_temporal, "temporal.codigo", '=', "$tablename.estado")
      ->orderBy('orden_estado', 'ASC');

    return $queryBuilder;
  }
}
