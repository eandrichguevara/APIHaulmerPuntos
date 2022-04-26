<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class VentaController extends Controller
{
    
    public function create( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'monto'          => 'bail|required|max:255',
            'comercio_rut'   => 'bail|required|max:10',
            'dispositivo_id' => 'required'
        ]);

        if ( $validator->fails() ){
            return response(['SUCCESS' => false, 'ERROR' => 'Error al validar los campos requeridos'], 400);
        }

        $venta = new Venta;
        $venta->monto            = request('monto');
        $venta->comercio_rut     = request('comercio_rut');
        $venta->dispositivo_id   = request('dispositivo_id');
        $venta->codigo_seguridad = Hash::make( request('codigo_seguridad') );

        if( !$venta->save() ){
            return response(['SUCCESS' => false, 'ERROR' => 'La venta no pudo ser guardada'], 400); 
        }

        //Amplicamos regla de negocio puntos+=10
        ComercioController::aumentarPuntaje($venta);
        
        return response([ 'SUCCESS' => true ], 201);
    }
    
    public function show($id)
    {
        $venta = Venta::find($id);

        if( $venta == null ){
            return response(['SUCCESS' => false, 'ERROR' => 'Venta no encontrada'], 404); 
        }
        
        return response([
            'SUCCESS'        => true, 
            'RESPONSE'       => [
                'venta_id'       => $venta->id,
                'monto'          => $venta->monto,
                'comercio'       => $venta->comercio_rut,
                'dispositivo_id' => $venta->dispositivo_id
            ]
        ], 200);
    }
    
    public function destroy($id)
    {
        //Verificamos si existe la venta
        $venta = Venta::where(['id'=> $id])->first();

        if( $venta == null ){
            return response(['SUCCESS' => false, 'ERROR' => 'Venta no encontrada'], 404); 
        }
        
        if ( Hash::check($venta->codigo_seguridad, request('codigo_seguridad'))) {
            return response(['SUCCESS' => false, 'ERROR' => 'Codigo de seguridad incorrecto'], 401);
        }

        //Anulamos la venta
        if( !$venta->delete() ){
            return response(['SUCCESS' => false, 'ERROR' => 'La venta no se pudo eliminar'], 400); 
        }
        
        //Amplicamos regla de negocio puntos-=10
        ComercioController::disminuirPuntaje($venta);
        
        return response(['SUCCESS' => true ], 200);
    }
}
