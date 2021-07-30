<?php
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'id' => 1 ,
            'nombre' => 'Programador' ,
            'estado_id' => '1' ,
            'created_at' => '2021-01-01 11:36:57',
            'updated_at' => '2021-01-01 11:36:57',
        ]);
        DB::table('roles')->insert([
            'id' => 2 ,
            'nombre' => 'Trabajador' ,
            'estado_id' => '1' ,
            'created_at' => '2021-01-01 11:36:57',
            'updated_at' => '2021-01-01 11:36:57',
        ]);
        DB::table('roles')->insert([
            'id' =>3,
            'nombre' => 'Cliente' ,
            'estado_id' => '1' ,
            'created_at' => '2021-01-01 11:36:57',
            'updated_at' => '2021-01-01 11:36:57',
        ]);

    }
}
