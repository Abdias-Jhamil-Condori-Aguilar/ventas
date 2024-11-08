<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriaProductoRequest;
use App\Http\Requests\StoreTipoPagoRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Http\Requests\UpdateTipoPagoRequest;
use App\Models\TipoPago;
use App\Models\Caracteristica;
use Exception;
use Illuminate\Support\Facades\DB;

class TipoPagoController extends Controller
{
    public function __construct()
    {
        /*$this->middleware('permission:ver-tipopago|crear-tipopago|editar-tipopago|eliminar-tipopago', ['only' => ['index']]);
        $this->middleware('permission:crear-tipopago', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-tipopago', ['only' => ['edit', 'update']]);
        $this->middleware('permission:eliminar-tipopago', ['only' => ['destroy']]);
    */}

    public function index()
    {
        $tipo_pagos = TipoPago::with('caracteristica')->latest()->get();

        return view('tipo_pago.index', ['tipo_pagos' => $tipo_pagos]);
    }

    public function create()
    {
        return view('tipo_pago.create');
    }

    public function store(StoreCategoriaProductoRequest $request)
    {
        try {
            DB::beginTransaction();
            
            $caracteristica = Caracteristica::create($request->validated());
            TipoPago::create([
                'caracteristica_id' => $caracteristica->id,
                // otros campos que necesites
            ]);
            
            DB::commit();
            return redirect()->route('tipo_pagos.index')->with('success', 'Tipo de pago registrado exitosamente');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('tipo_pagos.index')->with('error', 'Error al registrar el tipo de pago');
        }
    }

    public function edit(TipoPago $tipoPago)
    {
        $caracteristicas = Caracteristica::all();
        return view('tipo_pago.edit', compact('tipoPago', 'caracteristicas'));
    }

    public function update(UpdateCategoriaRequest $request, TipoPago $tipoPago)
    {
        try {
            $tipoPago->update($request->validated());
            return redirect()->route('tipo_pagos.index')->with('success', 'Tipo de pago editado exitosamente');
        } catch (Exception $e) {
            return redirect()->route('tipo_pagos.index')->with('error', 'Error al editar el tipo de pago');
        }
    }

    public function destroy(string $id)
    {
        try {
            $tipoPago = TipoPago::find($id);
            if ($tipoPago) {
                // Eliminar la característica asociada
                if ($tipoPago->caracteristica) {
                    $tipoPago->caracteristica->delete();
                }
                
                // Eliminar el tipo de pago
                $tipoPago->delete();
    
                return redirect()->route('tipo_pagos.index')->with('success', 'Tipo de pago y característica eliminados correctamente');
            } else {
                return redirect()->route('tipo_pagos.index')->with('error', 'Tipo de pago no encontrado');
            }
        } catch (Exception $e) {
            return redirect()->route('tipo_pagos.index')->with('error', 'Error al eliminar el tipo de pago y característica');
        }
    }
}
