<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class InitDBSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        //Initial fund_types
        $data = [
            [
                'name'    => 'Cushon Equities Fund',
                'current_price' => 12.3456
            ]
        ];
        $this->table('fund_types')->insert($data)->saveData();

        //Initial account_types
        $data = [
            [
                'name'    => 'Cushon ISA',
                'max_allowance' => 20000
            ],
            [
                'name'    => 'Cushon Lifetime ISA',
                'max_allowance' => 4000
            ],
            [
                'name'    => 'Cushon Junior ISA',
                'max_allowance' => 9000
            ],
        ];
        $this->table('account_types')->insert($data)->saveData();

        //Initial users
        $data = [
            [
                'name'    => 'John Doe',
                'ni_number' => 'AB 12 34 56 C',
                'api_token' => 'my_secret_token'
            ],
            [
                'name'    => 'Jane Ray',
                'ni_number' => 'DE 34 56 78 F',
                'api_token' => 'my_secret_token2'
            ]
        ];
        $this->table('users')->insert($data)->saveData();
    }
}
