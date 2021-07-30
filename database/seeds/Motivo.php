<?php
use Illuminate\Database\Seeder;

class MotivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('motivo')->insert([
            'id' => 1 ,
            'nombre' => 'Problemas Web' ,
            'estado_id' => '1' ,
            'created_at' => '2021-01-01 11:36:57',
            'updated_at' => '2021-01-01 11:36:57',
        ]);
         DB::table('motivo')->insert([
            'id' => 2 ,
            'nombre' => 'Configuraciones Web' ,
            'estado_id' => '1' ,
            'created_at' => '2021-01-01 11:36:57',
            'updated_at' => '2021-01-01 11:36:57',
        ]);
    }
}
