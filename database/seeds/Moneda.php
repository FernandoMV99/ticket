<?php
use Illuminate\Database\Seeder;

class MonedaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('moneda')->insert([
            'id' => 1 ,
            'nombre'=>'Soles',
            'simbolo'=>'S/.',
            'pais'=>'Peru',
            'created_at' => '2021-01-01 11:36:57',
            'updated_at' => '2021-01-01 11:36:57',
        ]);
        // DB::table('moneda')->insert([
        //     'id' => 2,
        //     'nombre'=>'Dolares',
        //     'simbolo'=>'$',
        //     'pais'=>'EE.UU',
        //     'created_at' => '2021-01-01 11:36:57',
        //     'updated_at' => '2021-01-01 11:36:57',
        // ]);

    }
}
