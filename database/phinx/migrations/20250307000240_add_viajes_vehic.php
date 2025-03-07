<?php

use Phinx\Db\Adapter\MysqlAdapter;

class AddViajesVehic extends Phinx\Migration\AbstractMigration
{
  public function change()
  {
    $this->execute('SET unique_checks=0; SET foreign_key_checks=0;');


    $this->table('empleado', [
      'id' => false,
      'primary_key' => ['codEmpleado'],
      'engine' => 'InnoDB',
      'encoding' => 'utf8mb4',
      'collation' => 'utf8mb4_general_ci',
      'comment' => '',
      'row_format' => 'DYNAMIC',
    ])
      ->addColumn('tipo_menu_lateral', 'string', [
        'null' => false,
        'limit' => 50,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'mostrarEnListas',
      ])
      ->addColumn('menus_abiertos', 'text', [
        'null' => true,
        'default' => null,
        'limit' => 65535,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'tipo_menu_lateral',
      ])
      ->save();



    $this->table('vehiculo', [
      'id' => false,
      'primary_key' => ['codVehiculo'],
      'engine' => 'InnoDB',
      'encoding' => 'utf8mb4',
      'collation' => 'utf8mb4_general_ci',
      'comment' => '',
      'row_format' => 'DYNAMIC',
    ])
      ->addColumn('codVehiculo', 'integer', [
        'null' => false,
        'limit' => MysqlAdapter::INT_REGULAR,
        'identity' => 'enable',
      ])
      ->addColumn('placa', 'string', [
        'null' => false,
        'limit' => 20,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'codVehiculo',
      ])
      ->addColumn('fecha_compra', 'date', [
        'null' => false,
        'after' => 'placa',
      ])
      ->addColumn('codSede', 'integer', [
        'null' => false,
        'limit' => MysqlAdapter::INT_REGULAR,
        'after' => 'fecha_compra',
      ])
      ->addColumn('kilometraje_actual', 'float', [
        'null' => true,
        'default' => null,
        'comment' => 'se actualiza con cada viaje',
        'after' => 'codSede',
      ])
      ->addColumn('codEmpleadoRegistrador', 'integer', [
        'null' => false,
        'limit' => MysqlAdapter::INT_REGULAR,
        'comment' => 'el que lo registró en el sistema',
        'after' => 'kilometraje_actual',
      ])
      ->addColumn('fechaHoraRegistro', 'datetime', [
        'null' => false,
        'comment' => 'el que lo registró en el sistema',
        'after' => 'codEmpleadoRegistrador',
      ])
      ->addColumn('modelo', 'string', [
        'null' => false,
        'limit' => 200,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'fechaHoraRegistro',
      ])
      ->addColumn('color', 'string', [
        'null' => false,
        'limit' => 200,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'modelo',
      ])
      ->addColumn('codigo_factura', 'string', [
        'null' => false,
        'limit' => 200,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'color',
      ])
      ->addIndex(['placa'], [
        'name' => 'unique_vehiculo',
        'unique' => true,
      ])
      ->create();



    $this->table('viaje_vehiculo', [
      'id' => false,
      'primary_key' => ['codViaje'],
      'engine' => 'InnoDB',
      'encoding' => 'utf8mb4',
      'collation' => 'utf8mb4_general_ci',
      'comment' => '',
      'row_format' => 'DYNAMIC',
    ])
      ->addColumn('codViaje', 'integer', [
        'null' => false,
        'limit' => MysqlAdapter::INT_REGULAR,
        'identity' => 'enable',
      ])
      ->addColumn('codVehiculo', 'integer', [
        'null' => false,
        'limit' => MysqlAdapter::INT_REGULAR,
        'after' => 'codViaje',
      ])
      ->addColumn('fechaHoraSalida', 'datetime', [
        'null' => false,
        'after' => 'codVehiculo',
      ])
      ->addColumn('kilometraje_salida', 'float', [
        'null' => false,
        'after' => 'fechaHoraSalida',
      ])
      ->addColumn('motivo', 'text', [
        'null' => false,
        'limit' => 65535,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'kilometraje_salida',
      ])
      ->addColumn('codEmpleadoAprobador', 'integer', [
        'null' => false,
        'limit' => MysqlAdapter::INT_REGULAR,
        'after' => 'motivo',
      ])
      ->addColumn('fechaHoraLlegada', 'datetime', [
        'null' => true,
        'default' => null,
        'after' => 'codEmpleadoAprobador',
      ])
      ->addColumn('kilometraje_llegada', 'float', [
        'null' => true,
        'default' => null,
        'after' => 'fechaHoraLlegada',
      ])
      ->addColumn('codigo_factura_combustible', 'string', [
        'null' => true,
        'default' => null,
        'limit' => 100,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'kilometraje_llegada',
      ])
      ->addColumn('monto_factura_combustible', 'float', [
        'null' => true,
        'default' => null,
        'after' => 'codigo_factura_combustible',
      ])
      ->addColumn('kilometraje_recorrido', 'float', [
        'null' => true,
        'default' => null,
        'after' => 'monto_factura_combustible',
      ])
      ->addColumn('rendimiento', 'float', [
        'null' => true,
        'default' => null,
        'comment' => 'kilometro por sol',
        'after' => 'kilometraje_recorrido',
      ])
      ->addColumn('codEmpleadoRegistrador', 'integer', [
        'null' => false,
        'limit' => MysqlAdapter::INT_REGULAR,
        'after' => 'rendimiento',
      ])
      ->addColumn('fechaHoraRegistro', 'datetime', [
        'null' => false,
        'after' => 'codEmpleadoRegistrador',
      ])
      ->addColumn('estado', 'string', [
        'null' => false,
        'limit' => 200,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'fechaHoraRegistro',
      ])
      ->addColumn('fechaHoraValidacion', 'datetime', [
        'null' => true,
        'default' => null,
        'after' => 'estado',
      ])
      ->addColumn('fechaHoraConclusion', 'datetime', [
        'null' => true,
        'default' => null,
        'comment' => 'fecha hora que el usuario marco que ya esta concluido el viaje',
        'after' => 'fechaHoraValidacion',
      ])
      ->addColumn('lugar_origen', 'string', [
        'null' => false,
        'limit' => 200,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'fechaHoraConclusion',
      ])
      ->addColumn('lugar_destino', 'string', [
        'null' => false,
        'limit' => 200,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'lugar_origen',
      ])
      ->addColumn('observaciones_salida', 'text', [
        'null' => true,
        'default' => null,
        'limit' => 65535,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'lugar_destino',
      ])
      ->addColumn('observaciones_llegada', 'text', [
        'null' => true,
        'default' => null,
        'limit' => 65535,
        'collation' => 'utf8mb4_general_ci',
        'encoding' => 'utf8mb4',
        'after' => 'observaciones_salida',
      ])
      ->create();
    $this->execute('SET unique_checks=1; SET foreign_key_checks=1;');


    $this->execute("INSERT INTO `puesto` (`nombre`, `estado`, `nombreAparente`, `descripcion`, `ordenListado`) VALUES ('Conductor', 1, 'Conductor', 'Puede realizar viajes en vehiculos de CEDEPAS', 1),('aprobador_viajes', 1, 'Aprobador de viajes', 'a', 1);");
  }
}
