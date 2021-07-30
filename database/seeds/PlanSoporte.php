<?php
use Illuminate\Database\Seeder;

class PlanSoporteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plan_soporte_tecnico')->insert([
            'id' => 1 ,
            'nombre'=>'Plan Basico',
            'descripcion'=>'Lorem ipsum, dolor sit, amet consectetur adipisicing elit. Dolore ipsa beatae dicta reprehenderit voluptatum eius mollitia ab quod rerum, ea corrupti placeat enim doloremque soluta inventore, fugit animi, suscipit ipsam.',
            'user_registrado'=>'1',
            'estado'=>'0',
            'created_at' => '2021-01-01 11:36:57',
            'updated_at' => '2021-01-01 11:36:57',
        ]);
        // DB::table('plan_soporte_tecnico')->insert([
        //     'id' => 2 ,
        //     'nombre'=>'Plan Empresarial',
        //     'descripcion'=>'Lorem ipsum, dolor sit, amet consectetur adipisicing elit. Dolore ipsa beatae dicta reprehenderitn voluptatum eius mollitia ab quod rerum, ea corrupti placeat enim doloremque soluta inventore, fugit animi, suscipit ipsam.',
        //     'user_registrado'=>'1',
        //     'estado'=>'0',
        //     'created_at' => '2021-01-01 11:36:57',
        //     'updated_at' => '2021-01-01 11:36:57',
        // ]);
    }
}
