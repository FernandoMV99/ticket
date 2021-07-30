<?php
use Illuminate\Database\Seeder;

class TipoEquiposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('tipo_equipo')->insert([
            'id' => 1 ,
            'nombre' => 'PC' ,
            'imagen' => 'computadora.svg' ,
            'created_at' => '2021-01-01 11:36:57',
            'updated_at' => '2021-01-01 11:36:57',
        ]);
        DB::table('tipo_equipo')->insert([
            'id' => 2 ,
            'nombre' => 'Laptop' ,
            'imagen' => 'laptop.svg' ,
            'created_at' => '2021-01-01 11:36:57',
            'updated_at' => '2021-01-01 11:36:57',
        ]);
        DB::table('tipo_equipo')->insert([
            'id' =>3 ,
            'nombre' => 'Impresora' ,
            'imagen' => 'impresora.svg' ,
            'created_at' => '2021-01-01 11:36:57',
            'updated_at' => '2021-01-01 11:36:57',
        ]);
          DB::table('tipo_equipo')->insert([
            'id' =>4 ,
            'nombre' => 'Servidores' ,
            'imagen' => 'servidor.svg' ,
            'created_at' => '2021-01-01 11:36:57',
            'updated_at' => '2021-01-01 11:36:57',
        ]);
    }
}
