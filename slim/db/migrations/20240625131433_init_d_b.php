<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class InitDB extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $this->table('users')
            ->addColumn('name', 'string', ['null' => false])
            ->addColumn('ni_number', 'string', ['null' => true])
            ->addColumn('api_token', 'string', ['null' => true])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('deleted_at', 'timestamp', ['null' => true, 'default' => null])
            ->create();

        $this->table('account_types')
            ->addColumn('name', 'string', ['null' => false])
            ->addColumn('max_allowance', 'integer')
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('deleted_at', 'timestamp', ['null' => true, 'default' => null])
            ->create();

        $this->table('fund_types')
            ->addColumn('name', 'string', ['null' => false])
            ->addColumn('current_price', 'decimal', ['null' => false, 'precision' => 10, 'scale' => 4])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('deleted_at', 'timestamp', ['null' => true, 'default' => null])
            ->create();

        $this->table('accounts')
            ->addColumn('user', 'integer', ['signed' => false, 'null' => false])
            ->addColumn('type', 'integer', ['signed' => false, 'null' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('deleted_at', 'timestamp', ['null' => true, 'default' => null])
            ->addForeignKey('user', 'users', 'id', ['delete'=> 'RESTRICT', 'update'=> 'NO_ACTION'])
            ->addForeignKey('type', 'account_types', 'id', ['delete'=> 'RESTRICT', 'update'=> 'NO_ACTION'])
            ->create();

        $this->table('fund_allocations')
            ->addColumn('account', 'integer', ['signed' => false, 'null' => false])
            ->addColumn('fund', 'integer', ['signed' => false, 'null' => false])
            ->addColumn('percentage_allocation', 'float', ['null' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('deleted_at', 'timestamp', ['null' => true, 'default' => null])
            ->addForeignKey('account', 'accounts', 'id', ['delete'=> 'RESTRICT', 'update'=> 'NO_ACTION'])
            ->addForeignKey('fund', 'fund_types', 'id', ['delete'=> 'RESTRICT', 'update'=> 'NO_ACTION'])
            ->create();

        $this->table('account_transactions')
            ->addColumn('account', 'integer', ['signed' => false, 'null' => false])
            ->addColumn('fund', 'integer', ['signed' => false, 'null' => true])
            ->addColumn('transaction_type', 'enum', ['values' => ['buy', 'sell', 'deposit'], 'null' => false])
            ->addColumn('units', 'decimal', ['null' => true, 'precision' => 10, 'scale' => 4])
            ->addColumn('gbp_total', 'decimal', ['null' => false, 'precision' => 10, 'scale' => 4])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('deleted_at', 'timestamp', ['null' => true, 'default' => null])
            ->addForeignKey('account', 'accounts', 'id', ['delete'=> 'RESTRICT', 'update'=> 'NO_ACTION'])
            ->addForeignKey('fund', 'fund_types', 'id', ['delete'=> 'RESTRICT', 'update'=> 'NO_ACTION'])
            ->create();
    }
}
