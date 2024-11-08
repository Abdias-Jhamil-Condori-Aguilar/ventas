<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Prenda;
use App\Models\Prestamo;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $pagos = Pago::with(['prestamo', 'prestamo.prenda', 'usuario'])->paginate(10);
    return view('pago.index', compact('pagos'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'prestamo_id' => 'required|exists:prestamos,id',
            'monto_pagado' => 'required|numeric|min:0',
            'fecha_pago' => 'required|date',
        ]);
    
        $pago = new Pago();
        $pago->prestamo_id = $request->prestamo_id;
        $pago->monto_pagado = $request->monto_pagado;
        $pago->fecha_pago = $request->fecha_pago;
        $pago->pagado = true; // Puedes ajustarlo según el estado del pago
        $pago->save();
    
        return redirect()->back()->with('success', 'Pago registrado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    // App/Http/Controllers/PagoController.php

    public function abonar(Request $request, $prestamoId)
    {
        $prestamo = Prestamo::find($prestamoId);
        $montoAbono = $request->input('monto_abono');
    
        // Lógica para abonar al capital
        $nuevoSaldo = $prestamo->total_pagar - $montoAbono;
        $prestamo->total_pagar = $nuevoSaldo;
        $prestamo->save();
    
        // Registro de pago
        Pago::create([
            'prestamo_id' => $prestamo->id,
            'monto_pagado' => $montoAbono,
            'fecha_pago' => $request->input('fecha_abono'),
            'pagado' => true,
        ]);
    
        return redirect()->route('prestamos.show', $prestamo->id)->with('success', 'Abono registrado correctamente.');
    }
    
    public function liquidar(Request $request, $prestamoId)
    {
        $prestamo = Prestamo::find($prestamoId);
        
        // Liquidar el préstamo (pago total)
        Pago::create([
            'prestamo_id' => $prestamo->id,
            'monto_pagado' => $prestamo->total_pagar,
            'fecha_pago' => $request->input('fecha_liquidacion'),
            'pagado' => true,
        ]);
    
        // Marcar el préstamo como liquidado
        $prestamo->estado = 'Liquidado';
        $prestamo->total_pagar = 0;
        $prestamo->save();
        
        // Actualizar el estado de la prenda asociada al préstamo
        $prenda = $prestamo->prenda; // Asumiendo que tienes una relación 'prenda' en el modelo Prestamo
        if ($prenda) {
            $prenda->estado = 'Liquidado';
            $prenda->save();
        }
    
        return redirect()->route('prestamos.show', $prestamo->id)->with('success', 'Préstamo y prenda liquidados correctamente.');
    }
    public function eliminarPago($id)
{
    // Buscar el pago
    $pago = Pago::findOrFail($id);
    $prestamo = $pago->prestamo;

    // Sumar el monto pagado de nuevo al total a pagar del préstamo
    $prestamo->total_pagar += $pago->monto_pagado;
    $prestamo->save();

    // Eliminar el pago
    $pago->delete();

    return response()->json([
        'success' => true,
        'message' => 'Pago eliminado y total del préstamo ajustado.'
    ]);
}

    

}
