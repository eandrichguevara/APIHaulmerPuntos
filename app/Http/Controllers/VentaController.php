<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
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

        return [ 'SUCCESS' => true ];
        //Amplicamos regla de negocio puntos+=10
        ComercioController::aumentarPuntaje($venta);
        
    }
    
    public function show($id)
    {
        $venta = Venta::find($id);

        if( $venta == null ){
            return ['SUCCESS' => false, 'ERROR' => 'Venta no encontrada']; 
        }
        
        return $venta;
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
        
        return ['SUCCESS' => true ];
        //Amplicamos regla de negocio puntos-=10
        ComercioController::disminuirPuntaje($venta);
            
    }
}
