<?php
use Illuminate\Database\Seeder;

class PlanHostingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plan_hosting')->insert([
            'id' => 1 ,
            'nombre'=>'Plan Basico',
            'descripcion'=>'Lorem ipsum, dolor sit, amet consectetur adipisicing elit. Dolore ipsa beatae dicta reprehenderit voluptatum eius mollitia ab quod rerum, ea corrupti placeat enim doloremque soluta inventore, fugit animi, suscipit ipsam.',
            'moneda'=>'S/.',
            'precio'=>'10',
            'estado'=>'1',
            'user_registrado'=>'1',
            'created_at' => '2021-01-01 11:36:57',
            'updated_at' => '2021-01-01 11:36:57',
        ]);
        DB::table('plan_hosting')->insert([
            'id' => 2 ,
            'nombre'=>'Plan intermedio',
            'descripcion'=>'Lorem ipsum, dolor sit, amet consectetur adipisicing elit. Dolore ipsa beatae dicta reprehenderitn voluptatum eius mollitia ab quod rerum, ea corrupti placeat enim doloremque soluta inventore, fugit animi, suscipit ipsam.',
            'moneda'=>'S/.',
            'precio'=>'15',
            'estado'=>'1',
            'user_registrado'=>'1',
            'created_at' => '2021-01-01 11:36:57',
            'updated_at' => '2021-01-01 11:36:57',
        ]);
        DB::table('plan_hosting')->insert([
            'id' => 3,
            'nombre'=>'Plan avanzado',
            'descripcion'=>'Lorem ipsum, dolor sit, amet consectetur adipisicing elit. Dolore ipsa beatae dicta reprehenderitn voluptatum eius mollitia ab quod rerum, ea corrupti placeat enim doloremque soluta inventore, fugit animi, suscipit ipsam.',
            'moneda'=>'S/.',
            'precio'=>'20',
            'estado'=>'1',
            'user_registrado'=>'1',
            'created_at' => '2021-01-01 11:36:57',
            'updated_at' => '2021-01-01 11:36:57',
        ]);


    }
}
