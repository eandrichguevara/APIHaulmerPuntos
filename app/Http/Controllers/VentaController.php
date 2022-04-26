<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class VentaController extends Controller
{
    
    public function create()
    {
        
        $venta = new Venta;
        $venta->monto            = request('monto');
        $venta->comercio_rut     = request('comercio_rut');
        $venta->dispositivo_id   = request('dispositivo_id');
        $venta->codigo_seguridad = Hash::make( request('codigo_seguridad') );

        if( !$venta->save() ){
            return ['SUCCESS' => false, 'ERROR' => 'La venta no pudo ser guardada']; 
        }

        //Amplicamos regla de negocio puntos+=10
        ComercioController::aumentarPuntaje($venta);
        
        return [ 'SUCCESS' => true ];
    }
    
    public function show($id)
    {
        $venta = Venta::find($id);

        if( $venta == null ){
            return ['SUCCESS' => false, 'ERROR' => 'Venta no encontrada']; 
        }
        
        return [
            'venta_id'       => $venta->id,
            'monto'          => $venta->monto,
            'comercio'       => $venta->comercio_rut,
            'dispositivo_id' => $venta->dispositivo_id
        ];
    }
    
    public function destroy($id)
    {
        //Verificamos si existe la venta
        $venta = Venta::where(['id'=> $id])->first();

        if( $venta == null ){
            return ['SUCCESS' => false, 'ERROR' => 'Venta no encontrada']; 
        }
        
        if ( Hash::check($venta->codigo_seguridad, request('codigo_seguridad'))) {
            return ['SUCCESS' => false, 'ERROR' => 'Codigo de seguridad incorrecto'];
        }

        //Anulamos la venta
        if( !$venta->delete() ){
            return ['SUCCESS' => false, 'ERROR' => 'La venta no se pudo eliminar']; 
        }
        
        //Amplicamos regla de negocio puntos-=10
        ComercioController::disminuirPuntaje($venta);
        
        return ['SUCCESS' => true ];
    }
}
