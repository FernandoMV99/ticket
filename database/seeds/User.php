<?php
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('users')->insert([
            'id' => 1 ,
            'name' => 'Desarrollador' ,
            'last_name' => 'Web' ,
            'empresa' => 'JYP PERIFERICOS S.A.C' ,
            'documento_identificacion' => 2 ,
            'numero_identificacion' => '0000000000' ,
            'email' => 'desarrollo@jypsac.com' ,
            'password' => bcrypt('@G^e^Fet&VGTsUBqLekW'),
            'codigo_confirmacion' => '123' ,
            'estado_confirmado' => '1' ,
            'roles_id' => '1' ,
            'estado_activo' => '1' ,
            'foto' => 'usuario.svg' ,
            'celular' => '0000' ,
            'pais' => 'Perú' ,
            'created_at' => '2021-01-01 11:36:57',
            'updated_at' => '2021-01-01 11:36:57',
        ]);
        // DB::table('users')->insert([
        //     'id' => 2 ,
        //     'name' => 'Julio' ,
        //     'last_name' => 'FLores' ,
        //     'empresa' => 'Perfirecos' ,
        //     'email' => 'fernandomv.0102@gmail.com' ,
        //     'password' => bcrypt('123'),
        //     'codigo_confirmacion' => '123' ,
        //     'estado_confirmado' => '1' ,
        //     'roles_id' => '3' ,
        //     'estado_activo' => '1' ,
        //     'foto' => 'persona2.jpg' ,
        //     'created_at' => '2021-01-01 11:36:57',
        //     'celular' => '98565465' ,
        //     'pais' => 'Perú' ,
        //     'updated_at' => '2021-01-01 11:36:57',
        // ]);
        // DB::table('users')->insert([
        //     'id' => 3 ,
        //     'name' => 'gerasl' ,
        //     'last_name' => 'oropeza' ,
        //     'empresa' => 'KFC' ,
        //     'email' => '3@gmail.com' ,
        //     'password' =>bcrypt('123'),
        //     'codigo_confirmacion' => '123' ,
        //     'estado_confirmado' => '1' ,
        //     'roles_id' => '1' ,
        //     'estado_activo' => '1' ,
        //     'foto' => 'persona3.jpg' ,
        //     'celular' => '98565465' ,
        //     'pais' => 'Perú' ,
        //     'created_at' => '2021-01-01 11:36:57',
        //     'updated_at' => '2021-01-01 11:36:57',
        // ]);
        // DB::table('users')->insert([
        //     'id' => 4,
        //     'name' => 'pedro' ,
        //     'last_name' => 'sanchez' ,
        //     'empresa' => 'Reniec' ,
        //     'email' => '4@gmail.com' ,
        //     'password' => bcrypt('123'),
        //     'codigo_confirmacion' => '123' ,
        //     'estado_confirmado' => '1' ,
        //     'roles_id' => '3' ,
        //     'estado_activo' => '1' ,
        //     'foto' => 'persona4.jpg' ,
        //     'celular' => '98565465' ,
        //     'pais' => 'Perú' ,
        //     'created_at' => '2021-01-01 11:36:57',
        //     'updated_at' => '2021-01-01 11:36:57',
        // ]);

    }
}
