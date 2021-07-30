<?php
use Illuminate\Database\Seeder;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('estado')->insert([
            'id' => 1 ,
    		'nombre' => 'Activo' ,
            'created_at' => '2021-01-01 11:36:57',
    		'updated_at' => '2021-01-01 11:36:57',
    	]);
        DB::table('estado')->insert([
            'id' => 2 ,
            'nombre' => 'Desactivo' ,
            'created_at' => '2021-01-01 11:36:57',
            'updated_at' => '2021-01-01 11:36:57',
        ]);

    }
}
