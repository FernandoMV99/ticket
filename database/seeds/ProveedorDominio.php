<?php
use Illuminate\Database\Seeder;

class ProveedorDominiosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('proveedor_dominios')->insert([
            'id' => 1 ,
            'nombre'=> 'A2Hosting',
            'descripcion'=>'Lorem ipsum, dolor sit, amet consectetur adipisicing elit. Dolore ipsa beatae dicta reprehenderit voluptatum eius mollitia ab quod rerum, ea corrupti placeat enim doloremque soluta inventore, fugit animi, suscipit ipsam.',
            'correo'=> 'a2hosting@hosdtin.com',
            'estado'=> '1',
            'user_registrado'=> '1',
            'created_at' => '2021-01-01 11:36:57',
            'updated_at' => '2021-01-01 11:36:57',
        ]);
         DB::table('proveedor_dominios')->insert([
            'id' => 2 ,
            'nombre'=> 'GooDaddy',
            'descripcion'=>'Lorem ipsum, dolor sit, amet consectetur adipisicing elit. Dolore ipsa beatae dicta reprehenderit voluptatum eius mollitia ab quod rerum, ea corrupti placeat enim doloremque soluta inventore, fugit animi, suscipit ipsam.',
            'correo'=> 'goodaddy@hosdtin.com',
            'estado'=> '1',
            'user_registrado'=> '1',
            'created_at' => '2021-01-01 11:36:57',
            'updated_at' => '2021-01-01 11:36:57',
        ]);


    }
}
