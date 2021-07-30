<?php
use Illuminate\Database\Seeder;

class DocumentoIdentificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('documento_identificacion')->insert([
            'id' => 1 ,
            'nombre' => 'RUC' ,
            'created_at' => '2021-01-01 11:36:57',
            'updated_at' => '2021-01-01 11:36:57',
        ]);
        DB::table('documento_identificacion')->insert([
            'id' => 2 ,
            'nombre' => 'DNI' ,
            'created_at' => '2021-01-01 11:36:57',
            'updated_at' => '2021-01-01 11:36:57',
        ]);
        DB::table('documento_identificacion')->insert([
            'id' =>3,
            'nombre' => 'Pasaporte' ,
            'created_at' => '2021-01-01 11:36:57',
            'updated_at' => '2021-01-01 11:36:57',
        ]);

    }
}
