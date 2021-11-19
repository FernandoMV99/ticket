<?php
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('empresa')->insert([
            'id' => 1 ,
            'nombre' => 'nombre de Empresa' ,
            'ruc' => '000000000' ,
            'telefono' => '000000000' ,
            'celular' => '000000000' ,
            'pais' => 'Perú' ,
            'departamento' => 'Lima' ,
            'provincia' => 'Lima' ,
            'distrito' => 'distrito' ,
            'rubro' => 'Rubro' ,
            'descripcion' => 'descripción' ,
            'pagina_web' => 'www.00000.com' ,
            'foto' => 'defecto.jpg' ,
            'correo' => 'correo_corporativo@correo.com' ,
            'contrasena' => '2rWO,O=SIzLn' ,
            'encryption' => 'SSL' ,
            'smpt' => 'mail.correo.com' ,
            'puerto' => '465' ,
            'created_at' => '2021-01-01 11:36:57',
            'updated_at' => '2021-01-01 11:36:57',
        ]);
    }
}
