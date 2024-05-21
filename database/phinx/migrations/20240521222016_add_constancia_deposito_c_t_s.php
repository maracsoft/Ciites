<?php

use Phinx\Db\Adapter\MysqlAdapter;

class AddConstanciaDepositoCTS extends Phinx\Migration\AbstractMigration
{
    public function change()
    {
        $this->execute('SET unique_checks=0; SET foreign_key_checks=0;');
        $this->table('constancia_deposito_cts', [
                'id' => false,
                'primary_key' => ['codConstancia'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codConstancia', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('codigo_unico', 'string', [
                'null' => false,
                'limit' => 25,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'codConstancia',
            ])
            ->addColumn('codEmpleadoCreador', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codigo_unico',
            ])
            ->addColumn('fechaHoraCreacion', 'datetime', [
                'null' => false,
                'after' => 'codEmpleadoCreador',
            ])
            ->addColumn('codPeriodoDirector', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'fechaHoraCreacion',
            ])
            ->addColumn('ultimo_sueldo_bruto', 'float', [
                'null' => false,
                'after' => 'codPeriodoDirector',
            ])
            ->addColumn('monto_ultima_grati', 'float', [
                'null' => false,
                'after' => 'ultimo_sueldo_bruto',
            ])
            ->addColumn('nombres', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'monto_ultima_grati',
            ])
            ->addColumn('apellidos', 'string', [
                'null' => false,
                'limit' => 200,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'nombres',
            ])
            ->addColumn('dni', 'string', [
                'null' => false,
                'limit' => 20,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'apellidos',
            ])
            ->addColumn('fecha_deposito', 'date', [
                'null' => false,
                'after' => 'dni',
            ])
            ->addColumn('nro_cuenta', 'string', [
                'null' => false,
                'limit' => 50,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'fecha_deposito',
            ])
            ->addColumn('nro_meses_laborados', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'nro_cuenta',
            ])
            ->addColumn('nro_dias_laborados', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'nro_meses_laborados',
            ])
            ->addColumn('monto_total_cts', 'float', [
                'null' => false,
                'after' => 'nro_dias_laborados',
            ])
            ->addColumn('fecha_inicio', 'date', [
                'null' => false,
                'comment' => 'del periodo',
                'after' => 'monto_total_cts',
            ])
            ->addColumn('fecha_fin', 'date', [
                'null' => false,
                'comment' => 'del periodo',
                'after' => 'fecha_inicio',
            ])
            ->addColumn('fecha_emision', 'date', [
                'null' => true,
                'default' => null,
                'comment' => 'emision formal del documento, no es la fecha de creacion del registro en bd. Es logica negocio',
                'after' => 'fecha_fin',
            ])
            ->addColumn('nombre_banco', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 300,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'fecha_emision',
            ])
            ->create();
        $this->execute('SET unique_checks=1; SET foreign_key_checks=1;');
    }
}
