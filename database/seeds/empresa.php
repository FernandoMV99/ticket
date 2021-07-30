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
            'nombre' => 'JYP PERIFERICOS' ,
            'ruc' => '20545122520' ,
            'telefono' => '901675119' ,
            'celular' => '9106755119' ,
            'pais' => 'Perú' ,
            'departamento' => 'Lima' ,
            'provincia' => 'Lima' ,
            'distrito' => 'Santa Beatriz' ,
            'rubro' => 'Perifericos e impresoras' ,
            'descripcion' => 'Empresa dedicada al rubro de Servicio tecnico' ,
            'pagina_web' => 'https://www.jypsac.com/' ,
            'foto' => 'logo_empresa.png' ,
            'correo' => 'desarrollo@grupojypsac.com' ,
            'contrasena' => '2rWO,O=SIzLn' ,
            'encryption' => 'SSL' ,
            'smpt' => 'mail.grupojypsac.com' ,
            'puerto' => '465' ,
            'created_at' => '2021-01-01 11:36:57',
            'updated_at' => '2021-01-01 11:36:57',
        ]);
    }
}
