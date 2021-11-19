<?php
use Illuminate\Database\Seeder;

class MarcasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('marcas')->insert([
            'id' => 1 ,
            'nombre' => 'HP' ,
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);

        // DB::table('marcas')->insert([
        //     'id' => 2 ,
        //     'nombre' => 'AMD' ,
        //     'created_at' => date('2019-08-01 00:00:00'),
        //     'updated_at' => date('2019-08-01 00:00:00')
        // ]);
        // DB::table('marcas')->insert([
        //     'id' => 3 ,
        //     'nombre' => 'MSI' ,
        //     'created_at' => date('2019-08-01 00:00:00'),
        //     'updated_at' => date('2019-08-01 00:00:00')
        // ]);

        // DB::table('marcas')->insert([
        //     'id' => 4 ,
        //     'nombre' => 'ADVANCE' ,
        //     'created_at' => date('2019-08-01 00:00:00'),
        //     'updated_at' => date('2019-08-01 00:00:00')
        // ]);

        // DB::table('marcas')->insert([
        //     'id' => 5 ,
        //     'nombre' => 'WESTER DIGITAL' ,
        //     'created_at' => date('2019-08-01 00:00:00'),
        //     'updated_at' => date('2019-08-01 00:00:00')
        // ]);

        // DB::table('marcas')->insert([
        //     'id' => 6 ,
        //     'nombre' => 'LENOVO' ,
        //     'created_at' => date('2019-08-01 00:00:00'),
        //     'updated_at' => date('2019-08-01 00:00:00')
        // ]);

        // DB::table('marcas')->insert([
        //     'id' => 7 ,
        //     'nombre' => 'D-LINK' ,
        //     'created_at' => date('2019-08-01 00:00:00'),
        //     'updated_at' => date('2019-08-01 00:00:00')
        // ]);

        // DB::table('marcas')->insert([
        //     'id' => 8 ,
        //     'nombre' => 'TOSHIBA' ,
        //     'created_at' => date('2019-08-01 00:00:00'),
        //     'updated_at' => date('2019-08-01 00:00:00')
        // ]);

        // DB::table('marcas')->insert([
        //     'id' => 9 ,
        //     'nombre' => 'KIGSTON' ,
        //     'created_at' => date('2019-08-01 00:00:00'),
        //     'updated_at' => date('2019-08-01 00:00:00')
        // ]);
        // DB::table('marcas')->insert([
        //     'id' => 10 ,
        //     'nombre' => 'NEXXT' ,
        //     'created_at' => date('2019-08-01 00:00:00'),
        //     'updated_at' => date('2019-08-01 00:00:00')
        // ]);

        // DB::table('marcas')->insert([
        //     'id' => 11 ,
        //     'nombre' => 'HALION' ,
        //     'created_at' => date('2019-08-01 00:00:00'),
        //     'updated_at' => date('2019-08-01 00:00:00')
        // ]);

        // DB::table('marcas')->insert([
        //     'id' => 12 ,
        //     'nombre' => 'AVATEC' ,
        //     'created_at' => date('2019-08-01 00:00:00'),
        //     'updated_at' => date('2019-08-01 00:00:00')
        // ]);

        // DB::table('marcas')->insert([
        //     'id' => 13 ,
        //     'nombre' => 'EPSON' ,
        //     'created_at' => date('2019-08-01 00:00:00'),
        //     'updated_at' => date('2019-08-01 00:00:00')
        // ]);

        // DB::table('marcas')->insert([
        //     'id' => 14 ,
        //     'nombre' => 'DELL' ,
        //     'created_at' => date('2019-08-01 00:00:00'),
        //     'updated_at' => date('2019-08-01 00:00:00')
        // ]);

        // DB::table('marcas')->insert([
        //     'id' => 15 ,
        //     'nombre' => 'INTEL' ,
        //     'created_at' => date('2019-08-01 00:00:00'),
        //     'updated_at' => date('2019-08-01 00:00:00')
        // ]);
        // DB::table('marcas')->insert([
        //     'id' => 16 ,
        //     'nombre' => 'CANON' ,
        //     'created_at' => date('2019-08-01 00:00:00'),
        //     'updated_at' => date('2019-08-01 00:00:00')
        // ]);
    }
}
