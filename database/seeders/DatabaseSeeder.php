<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        foreach ( range(1,5) as $dispositivo_id ) {
            
            DB::table('dispositivos')->insert(['id' => $dispositivo_id]);
            
            $comercio_rut = random_int(50000000,80000000).'-'.random_int(0,9);
            //Para poder ejecutar las request entregadas en la collection de Postman
            if( $dispositivo_id == 1){
                $comercio_rut = "55581642-6";
            }
            
            DB::table('comercios')->insert([
                'rut' => $comercio_rut,
                'nombre' => Str::random(10).' S.A.',
                'puntos' => 50
            ]);
            
            foreach ( range(1,5) as $index) {

                DB::table('ventas')->insert([
                    'dispositivo_id' => $dispositivo_id,
                    'comercio_rut' => $comercio_rut,
                    'codigo_seguridad' => Crypt::encryptString('0000'),
                    'monto' => random_int(100,100000)
                ]);

            }
            
        }

    }
}
