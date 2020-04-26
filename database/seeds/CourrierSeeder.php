<?php

use App\Shop\Courriers\Courrier;
use Illuminate\Database\Seeder;

class CourrierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Courrier::class)->create();
    }
}
