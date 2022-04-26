<?php

namespace App\Http\Controllers;

use App\Models\Comercio;
use Illuminate\Routing\Controller;

class ComercioController extends Controller
{

    private const AUMENTO_PUNTAJE     = 10;
    private const DISMINUCION_PUNTAJE = -10;
    
    public function index() { 

        $ventas = Comercio::all();

        $response = [];

        foreach ($ventas as $id => $venta) {
            $response[$id] = [
                "rut"    => $venta->rut,
                "nombre" => $venta->nombre,
                "puntos" => $venta->puntos
            ];
        }

        if (!$response){
            return response(['SUCCESS' => false, 'ERROR' => 'No hay comercios registrados'], 404);
        }

        return response(['SUCCESS' => true, 'RESPONSE' => $response], 200);
    }

    public function show($rut) { 
        $venta = Comercio::where('rut',$rut)->first(); 

        return response([
            'SUCCESS' => true,
            'RESPONSE' => [
                "rut"    => $venta->rut,
                "nombre" => $venta->nombre,
                "puntos" => $venta->puntos
            ]
        ], 200);
    }

    public static function aumentarPuntaje( $venta ){ ComercioController::modificarPuntaje( $venta, ComercioController::AUMENTO_PUNTAJE ); }

    public static function disminuirPuntaje( $venta ){ ComercioController::modificarPuntaje( $venta, ComercioController::DISMINUCION_PUNTAJE ); }

    private static function modificarPuntaje( $venta, $cantidad ){
        $comercio = Comercio::where('rut', $venta->comercio_rut)->first();

        $comercio->puntos += $cantidad;

        $comercio->where('rut', $venta->comercio_rut)->update(['puntos' => $comercio->puntos]);
    }
}
