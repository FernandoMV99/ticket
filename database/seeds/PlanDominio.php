<?php
use Illuminate\Database\Seeder;

class PlanDominioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plan_dominio')->insert([
            'id' => 1 ,
            'nombre'=>'com',
            'moneda'=>'S/.',
            'precio'=>'10',
            'estado'=>'0',
            'user_registrado'=>'1',
            'created_at' => '2021-01-01 11:36:57',
            'updated_at' => '2021-01-01 11:36:57',
        ]);
        DB::table('plan_dominio')->insert([
            'id' => 2 ,
            'nombre'=>'pe',
            'moneda'=>'S/.',
            'precio'=>'15',
            'estado'=>'0',
            'user_registrado'=>'1',
            'created_at' => '2021-01-01 11:36:57',
            'updated_at' => '2021-01-01 11:36:57',
        ]);
        DB::table('plan_dominio')->insert([
            'id' => 3,
            'nombre'=>'org',
            'moneda'=>'S/.',
            'precio'=>'20',
            'estado'=>'0',
            'user_registrado'=>'1',
            'created_at' => '2021-01-01 11:36:57',
            'updated_at' => '2021-01-01 11:36:57',
        ]);


    }
}
