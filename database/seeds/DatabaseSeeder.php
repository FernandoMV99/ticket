<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DocumentoIdentificacionSeeder::class);
        $this->call(EstadoSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(MotivoSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PaisesSeeder::class);
        $this->call(TicketsAgregadoSeeder::class);
        $this->call(ArchivoSeeder::class);
        $this->call(EmpresaSeeder::class);
        $this->call(MonedaSeeder::class);
        $this->call(PlanHostingSeeder::class);
        $this->call(ProveedorDominiosSeeder::class);
        $this->call(PlanSslSeeder::class);
        $this->call(PlanDominioSeeder::class);
        $this->call(TipoEquiposSeeder::class);
        $this->call(MarcasSeeder::class);
        $this->call(PlanSoporteSeeder::class);
    }
}
