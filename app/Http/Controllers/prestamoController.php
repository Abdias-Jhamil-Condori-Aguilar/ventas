<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePrestamoRequest;
use App\Models\Articulo;
use App\Models\CategoriaProducto;
use App\Models\Cliente;
use App\Models\Intere;
use App\Models\Prenda;
use App\Models\Prestamo;
use App\Models\TipoPago;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PrestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener la fecha actual
        $fechaActual = Carbon::now();
        
        // Obtener los préstamos vencidos hace más de 30 días
        $prestamosParaVenta = Prestamo::where('fecha_fin', '<=', $fechaActual->subDays(30))
                                        ->where('estado', 'activo') // Solo prestamos que están activos
                                        ->get();
    
        // Cambiar el estado de los préstamos y prendas a 'venta'
        foreach ($prestamosParaVenta as $prestamo) {
            $prestamo->estado = 'venta';
            $prestamo->save();
    
            // También actualizar el estado de la prenda asociada
            $prenda = $prestamo->prenda;
            if ($prenda) {
                $prenda->estado = 'venta'; 
                $prenda->save();
            }
        }
        
        // Obtener los préstamos paginados con la relación de cliente y prenda
        $prestamos = Prestamo::with('cliente', 'prenda')->paginate(5);
        
        $categoria_productos = CategoriaProducto::all();
        $clientes = Cliente::all();
        $intereses = Intere::all();
        
        return view('prestamo.index', compact('prestamos', 'clientes', 'categoria_productos', 'intereses'));
    }
    
    
    

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $categoria_productos = CategoriaProducto::all();
       $clienteId = $request->query('cliente_id');
    $cliente = Cliente::find($clienteId);
        $intereses = Intere::all();

        return view('prestamo.create', compact('cliente', 'categoria_productos', 'intereses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validación de los datos recibidos
    $request->validate([
        'categoria_producto_id' => 'required|exists:categoria_productos,id',
        'codigo'=> 'required|string|max:255',
        'descripcion' => 'required|string|max:255',
        'modelo' => 'required|string|max:255',
        'marca' => 'required|string|max:255',
        'serie' => 'nullable|string|max:255',
        'observaciones' => 'nullable|string|max:255',
        'intere_id' => 'required|exists:interes,id',
        'meses' => 'required|integer|min:1',
        'fecha_inicio' => 'required|date',
        'monto' => 'required|numeric|min:0',
        'cliente_id' => 'required|exists:clientes,id',
    ]);

    if ($request->monto <= 0) {
        return back()->with('error', 'El monto no puede ser menor o igual a 0.');
    }
    
        // Creación de la prenda (artículo)
        $prenda = new Prenda();
        $prenda->categoria_producto_id = $request->categoria_producto_id;
        $prenda->codigo = $request->codigo;
        $prenda->descripcion = $request->descripcion;
        $prenda->modelo = $request->modelo;
        $prenda->marca = $request->marca;
        $prenda->serie = $request->serie;
        $prenda->observaciones = $request->observaciones;
        $prenda->save();
    
        // Calcular el interés y monto total a pagar
        $interes = Intere::find($request->intere_id);
        $interes_calculado = ($request->monto * $interes->interes / 100) * $request->meses;
        $total_pagar = $request->monto + $interes_calculado;
    
        // Crear el préstamo
        $prestamo = new Prestamo();
        $prestamo->cliente_id = $request->cliente_id;
        $prestamo->prendas_id = $prenda->id;
        $prestamo->intere_id = $request->intere_id;
        $prestamo->monto = $request->monto;
        $prestamo->meses = $request->meses;
        $prestamo->interes_calculado = $interes_calculado;
        $prestamo->total_pagar = $total_pagar;
        $prestamo->fecha_inicio = $request->fecha_inicio;
        $prestamo->fecha_fin = Carbon::parse($request->fecha_inicio)->addMonths($request->meses);
        $prestamo->save();
    
        // Redirigir con éxito
        return redirect()->route('prestamos.index')->with('success', 'Préstamo registrado exitosamente.');
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $prestamo = Prestamo::findOrFail($id);
        $cliente = Cliente::findOrFail($prestamo->cliente_id); // Cargar el cliente
        $prenda = Prenda::findOrFail($prestamo->prendas_id); // Cargar la prenda
    
        return view('prestamo.edit', compact('prestamo', 'cliente', 'prenda'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validamos los datos que el usuario envía desde el formulario
        $validatedData = $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'monto' => 'required|numeric|min:0',
            'meses' => 'required|integer|min:1',
            'interes_calculado' => 'required|numeric|min:0',
            'total_pagar' => 'required|numeric|min:0',
            'estado' => 'required|in:activo,finalizado',
        ]);
    
        // Buscamos el préstamo a editar por su id
        $prestamo = Prestamo::findOrFail($id);
    
        // Actualizamos los campos del préstamo con los valores validados
        $prestamo->fecha_inicio = $request->input('fecha_inicio');
        $prestamo->fecha_fin = $request->input('fecha_fin');
        $prestamo->monto = $request->input('monto');
        $prestamo->meses = $request->input('meses');
        $prestamo->interes_calculado = $request->input('interes_calculado');
        $prestamo->total_pagar = $request->input('total_pagar');
        $prestamo->estado = $request->input('estado');
    
        // Guardamos los cambios en la base de datos
        $prestamo->save();
    
        // Redirigimos a la página anterior o a una vista con un mensaje de éxito
        return redirect()->route('prestamos.index')->with('success', 'Préstamo actualizado correctamente');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $prestamo = Prestamo::findOrFail($id);
            
            // Eliminar la prenda asociada
            $prenda = Prenda::findOrFail($prestamo->prendas_id);
            $prenda->delete();
            
            // Eliminar el préstamo
            $prestamo->delete();
            
            DB::commit();
            
            return redirect()->route('prestamos.index')->with('success', 'Préstamo eliminado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('prestamos.index')->withErrors('Error al eliminar el préstamo: ' . $e->getMessage());
        }
    }
    /**
 * Display the specified resource.
 */
public function show($id)
{
    $prestamo = Prestamo::with('pagos')->findOrFail($id);
    
    return view('prestamo.show', compact('prestamo'));
}

public function getUltimoCodigoPrenda(Request $request)
{
    // Obtener la categoría seleccionada desde la solicitud
    $categoriaId = $request->input('categoria_producto_id');

    // Buscar la última prenda en la categoría seleccionada
    $ultimaPrenda = Prenda::where('categoria_producto_id', $categoriaId)
                    ->orderBy('codigo', 'desc') // Ordenar por código en orden descendente
                    ->first();

    // Si hay una prenda, extraer el número secuencial
    if ($ultimaPrenda) {
        // Extraer el número secuencial del código (asumiendo que los últimos 4 dígitos son el número)
        $ultimoNumeroSecuencial = (int) substr($ultimaPrenda->codigo, -4);
        $nuevoNumeroSecuencial = $ultimoNumeroSecuencial + 1;
    } else {
        // Si no hay prendas en esta categoría, empezamos desde 1
        $nuevoNumeroSecuencial = 1;
    }

    // Devolver el número secuencial en formato JSON para usar en JavaScript
    return response()->json(['numeroSecuencial' => $nuevoNumeroSecuencial]);
}
public function cancelarPrestamo(Request $request, $id) {
    $prestamo = Prestamo::find($id);

    if ($prestamo) {
        // Cambiar el estado del préstamo
        $prestamo->estado = 'Cancelado';

        // Cambiar el estado de la prenda si es necesario
        $prenda = $prestamo->prenda;
        if ($prenda) {
            $prenda->estado = 'Cancelado'; // o el estado que necesites
            $prenda->save();
        }

        $prestamo->save();

        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false, 'message' => 'Préstamo no encontrado.']);
}
public function reporte(Request $request)
{
    // Obtener el estado seleccionado
    $estado = $request->get('estado');

    // Filtrar los préstamos según el estado
    $prestamos = Prestamo::when($estado, function ($query, $estado) {
        return $query->where('estado', $estado);
    })->with('cliente', 'prenda')->get();

    // Retornar vista con los préstamos y el estado seleccionado
    return view('prestamo.reporte', compact('prestamos', 'estado'));
}

public function exportarPDF(Request $request)
{
    // Obtener el estado seleccionado
    $estado = $request->get('estado');

    // Filtrar los préstamos según el estado
    $prestamos = Prestamo::when($estado, function ($query, $estado) {
        return $query->where('estado', $estado);
    })->with('cliente', 'prenda')->get();

    // Cargar vista y pasar datos a PDF incluyendo el estado
    $pdf = Pdf::loadView('prestamo.pdf', compact('prestamos', 'estado'));

    // Devolver el PDF
    return $pdf->stream('reporte_prestamos.pdf');
}

  public function generarBoleta($prestamo_id)
    {
        // Buscar el préstamo, cliente y prenda relacionados
        $prestamo = Prestamo::findOrFail($prestamo_id);
        $cliente = Cliente::findOrFail($prestamo->cliente_id);
        $prenda = Prenda::findOrFail($prestamo->prendas_id);

        $pdf = Pdf::setPaper('letter', 'portrait') // A5 size
    ->loadView('prestamo.boleta_empeno', [
        'prestamo' => $prestamo,
        'cliente' => $cliente,
        'prenda' => $prenda
    ]);


        // Descargar el PDF
        return $pdf->stream('prestamo.boleta_empeno');

    }
// app/Http/Controllers/PrestamoController.php
public function Boletaliquidado($prestamo_id)
{
    // Buscar el préstamo, cliente y prenda relacionados
    $prestamo = Prestamo::with('pagos')->findOrFail($prestamo_id);
    $cliente = Cliente::findOrFail($prestamo->cliente_id);
    $prenda = Prenda::findOrFail($prestamo->prendas_id);

    $pdf = Pdf::setPaper([0, 0, 420.53, 620.28], 'portrait') // Tamaño A5
        ->loadView('prestamo.boletaliquidado', [
            'prestamo' => $prestamo,
            'cliente' => $cliente,
            'prenda' => $prenda,
            'pagos' => $prestamo->pagos // Pasar los pagos a la vista
        ]);
        
    return $pdf->stream('prestamo.boletaliquidado');
}

}
