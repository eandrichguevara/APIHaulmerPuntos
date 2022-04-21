<?php

namespace App\Http\Controllers;

use App\Models\Comercio;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ComercioController extends Controller
{

    private const AUMENTO_PUNTAJE     = 10;
    private const DISMINUCION_PUNTAJE = -10;
    
    public function index() { return Comercio::all(); }

    public function show($rut) { return Comercio::where('rut',$rut)->get(); }

    public static function aumentarPuntaje( $venta ){ ComercioController::modificarPuntaje( $venta, ComercioController::AUMENTO_PUNTAJE ); }

    public static function disminuirPuntaje( $venta ){ ComercioController::modificarPuntaje( $venta, ComercioController::DISMINUCION_PUNTAJE ); }

    private static function modificarPuntaje( $venta, $cantidad ){
        $comercio = Comercio::where('rut', $venta->comercio_rut)->first();

        $comercio->puntos += $cantidad;

        $comercio->where('rut', $venta->comercio_rut)->update(['puntos' => $comercio->puntos]);
    }
}
