<?php

use Phinx\Db\Adapter\MysqlAdapter;

class AddedTestSistemaParametro extends Phinx\Migration\AbstractMigration
{
    public function change()
    {
        $this->table('parametro_sistema', [
                'id' => false,
                'primary_key' => ['codParametro'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('test', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'codTipoParametro',
            ])
            ->save();
    }
}
