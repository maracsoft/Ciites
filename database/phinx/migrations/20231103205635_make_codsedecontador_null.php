<?php

use Phinx\Db\Adapter\MysqlAdapter;

class MakeCodsedecontadorNull extends Phinx\Migration\AbstractMigration
{
    public function change()
    {
        $this->table('empleado', [
                'id' => false,
                'primary_key' => ['codEmpleado'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->changeColumn('codSedeContador', 'integer', [
                'null' => true,
                'default' => '0',
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'nroTelefono',
            ])
            ->removeIndexByName("fk_relation_empleado_and_sede_contador")
            ->addIndex(['codSedeContador'], [
                'name' => 'fk_relation_empleado_and_sede_contador',
                'unique' => false,
            ])
            ->save();
    }
}
