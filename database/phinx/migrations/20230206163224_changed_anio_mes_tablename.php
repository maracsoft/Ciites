<?php

use Phinx\Db\Adapter\MysqlAdapter;

class ChangedAnioMesTablename extends Phinx\Migration\AbstractMigration
{
    public function change()
    {
        $this->table('mes_anio', [
                'id' => false,
                'primary_key' => ['codMesAño'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('codMesAño', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('año', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codMesAño',
            ])
            ->addColumn('codMes', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'año',
            ])
            ->create();
        $this->table('mes_a??o')->drop()->save();
    }
}
