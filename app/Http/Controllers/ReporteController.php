<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Pago;
use App\Models\Prestamo;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Log;

class ReporteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('reporte.index');
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
        //
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
    public function exportarPDF(Request $request)
{
       // Obtener el campo y la dirección de orden
       $ordenarPor = $request->get('ordenarPor', 'nombre'); // Por defecto ordena por 'nombre'
       $direccion = $request->get('direccion', 'asc'); // Dirección de orden por defecto 'asc'
   
       // Consultar clientes con el orden seleccionado
       $clientes = Cliente::orderBy($ordenarPor, $direccion)->get();
   
       // Generar el PDF con los clientes ordenados
       $pdf = PDF::loadView('reporte.clientespdf', compact('clientes'));
       return $pdf->stream('reporte.clientes.pdf');
}
    public function reporteClientes(Request $request)
    {
        $ordenarPor = $request->get('ordenarPor', 'nombre'); // Por defecto ordena por 'nombre'
        $direccion = $request->get('direccion', 'asc'); // Dirección de orden por defecto 'asc'
    
        // Consultar clientes con el orden seleccionado
        $clientes = Cliente::orderBy($ordenarPor, $direccion)->get();

        // Pasar los clientes a la vista
        return view('reporte.clientes', compact('clientes', 'ordenarPor', 'direccion'));
    }
   
    public function cumpleanierosMes(Request $request)
    {
        // Obtenemos el mes del formulario (si no se selecciona, por defecto es el mes actual)
        $mes = $request->input('mes', date('m'));

        // Obtenemos los clientes cuyo mes de cumpleaños coincide con el mes seleccionado
        $clientes = Cliente::whereMonth('fecha_nacimiento', $mes)->get();

        // Devolvemos la vista con los clientes filtrados
        return view('reporte.cumpleanieros', compact('clientes', 'mes'));
    }

    public function prestamosActivos()
{
    // Obtener los préstamos con estado 'activo'
    $prestamos = Prestamo::where('estado', 'activo')->get();

    // Pasar los préstamos a la vista
    return view('reporte.prestamos', compact('prestamos'));
}
public function reportePrestamos(Request $request)
{
    // Obtener el estado desde la solicitud
    $estado = $request->input('estado');

    // Si se selecciona un estado, filtrar por ese estado
    if ($estado) {
        $prestamos = Prestamo::where('estado', $estado)->get();
    } else {
        // Si no se selecciona un estado, obtener todos los préstamos
        $prestamos = Prestamo::all();
    }

    // Retornar la vista con los préstamos filtrados
    return view('reporte.prestamos', compact('prestamos'));
}
// Reporte de Préstamos por Vencer (fecha_fin dentro de los próximos 30 días)
public function prestamosPorVencer()
{
    $hoy = Carbon::now();
    $proximos_30_dias = Carbon::now()->addDays(30);
    
    // Préstamos con fecha_fin dentro de los próximos 30 días y aún no vencidos
    $prestamos = Prestamo::where('estado', 'activo')
                ->whereBetween('fecha_fin', [$hoy, $proximos_30_dias])
                ->get();
                
    return view('reporte.prestamos_por_vencer', compact('prestamos'));
}

// Reporte de Préstamos Vencidos (fecha_fin anterior a la fecha actual)
public function prestamosVencidos()
{
    $hoy = Carbon::now();
    
    // Préstamos vencidos (fecha_fin ya pasó)
    $prestamos = Prestamo::where('estado', 'activo')
                ->where('fecha_fin', '<', $hoy)
                ->get();
                
    return view('reporte.prestamos_vencidos', compact('prestamos'));
}
public function clientes(Request $request)
{
    // Obtener clientes ordenados alfabéticamente
    $clientes = Cliente::orderBy('nombre')->get();

    // Verificar si la petición es para generar el PDF
    if ($request->input('pdf') == '1') {
        $anio = Carbon::now()->year;
        $mesSeleccionado = Carbon::now()->month;

        $pdf = Pdf::loadView('reporte.clientespdf', compact('clientes', 'anio', 'mesSeleccionado'));
        return $pdf->stream('reporte_clientes_' . $mesSeleccionado . '_' . $anio . '.pdf');
    }

    return view('clientes.index', compact('clientes'));
}
// Función para mostrar el reporte de Monto Prestado en pantalla
public function montoPrestado()
{
    return view('reporte.montoPrestadov'); // Retorna la vista del calendario
}

public function obtenerPrestamos(Request $request)
{
    // Filtrar préstamos por estado, año, y mes, si están presentes
    $prestamos = Prestamo::whereIn('estado', ['Liquidado', 'Activo', 'Venta']);

    if ($request->filled('anio')) {
        $prestamos->whereYear('fecha_inicio', $request->anio);
    }

    if ($request->filled('mes')) {
        $prestamos->whereMonth('fecha_inicio', $request->mes);
    }

    if ($request->filled('estado')) {
        $prestamos->where('estado', $request->estado);
    }

    $prestamos = $prestamos->get()->map(function ($prestamo) {
        return [
            'title' => 'Bs. ' . number_format($prestamo->monto, 2),
            'start' => $prestamo->fecha_inicio,
            'color' => '#003366',  // Azul marino
            'textColor' => '#FFFFFF',  // Blanco
            'allDay' => true,
        ];
    });

    return response()->json($prestamos);
}

// Función para generar el PDF del reporte de Monto Prestado
public function exportarMontoPrestadoPDF(Request $request)
{
    $meses_espanol = [
        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
        5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
        9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
    ];

    // Filtrar préstamos por año, mes y estado según lo seleccionado
    $prestamos = Prestamo::whereIn('estado', ['Liquidado', 'Activo', 'Venta']);

    if ($request->filled('anio')) {
        $prestamos->whereYear('fecha_inicio', $request->anio);
    }

    if ($request->filled('mes')) {
        $prestamos->whereMonth('fecha_inicio', $request->mes);
    }

    if ($request->filled('estado')) {
        $prestamos->where('estado', $request->estado);
    }

    $prestamos = $prestamos->with('cliente', 'prenda')->get()->groupBy(function ($prestamo) {
        return \Carbon\Carbon::parse($prestamo->fecha_inicio)->format('n');
    });

    // Generar el PDF utilizando Dompdf
    $pdf = Pdf::loadView('reporte.montoprestadopdf', compact('prestamos', 'meses_espanol'));

    return $pdf->stream('reporte_monto_prestado.pdf');
}

public function montoPagado()
{
    return view('reporte.pagos'); // Retorna la vista del calendario de pagos
}

public function obtenerPagos(Request $request)
{
    $pagos = Pago::where('pagado', true); // Filtra solo los pagos completados

    // Filtros de año y mes
    if ($request->filled('anio')) {
        $pagos->whereYear('fecha_pago', $request->anio);
    }

    if ($request->filled('mes')) {
        $pagos->whereMonth('fecha_pago', $request->mes);
    }

    $pagos = $pagos->get()->map(function ($pago) {
        return [
            'title' => 'Bs. ' . number_format($pago->monto_pagado, 2),
            'start' => $pago->fecha_pago,
            'color' => '#28a745', // Verde para indicar pago realizado
            'textColor' => '#FFFFFF', // Texto en blanco
            'allDay' => true,
        ];
    });

    return response()->json($pagos);
}

public function exportarPagosPdf(Request $request)
{
    $meses_espanol = [
        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
        5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
        9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
    ];

    // Filtrar pagos basados en el año y mes seleccionados
    $pagos = Pago::where('pagado', true);

    if ($request->filled('anio')) {
        $pagos->whereYear('fecha_pago', $request->anio);
    }

    if ($request->filled('mes')) {
        $pagos->whereMonth('fecha_pago', $request->mes);
    }

    $pagos = $pagos->get(); 

    // Agrupar pagos por mes
    $pagosPorMes = $pagos->groupBy(function ($pago) {
        return Carbon::parse($pago->fecha_pago)->format('n'); // Cambiar a 'n' para el número del mes sin ceros
    });

    // Generar el PDF utilizando Dompdf
    $pdf = Pdf::loadView('reporte.pagospdf', compact('pagos', 'pagosPorMes', 'meses_espanol'));

    return $pdf->stream('reporte_pagos.pdf');
}   
public function flujoDeCaja()
{
    return view('reporte.flujocaja');
}



public function obtenerFlujoCaja(Request $request)
{
    $anio = $request->input('anio') ?? date('Y');
    $mes = $request->input('mes');

    $prestamosPorMes = [];
    $pagosPorMes = [];
    $totalPrestamos = 0;
    $totalPagos = 0;

    for ($i = 1; $i <= 12; $i++) {
        if ($mes && $i != $mes) {
            $prestamosPorMes[] = 0;
            $pagosPorMes[] = 0;
            continue;
        }

        $prestamos = Prestamo::whereIn('estado', ['Activo', 'Liquidado'])
            ->whereYear('fecha_inicio', $anio)
            ->whereMonth('fecha_inicio', $i)
            ->sum('monto');

        $pagos = Pago::whereYear('fecha_pago', $anio)
            ->whereMonth('fecha_pago', $i)
            ->sum('monto_pagado');

        $prestamosPorMes[] = $prestamos;
        $pagosPorMes[] = $pagos;

        $totalPrestamos += $prestamos;
        $totalPagos += $pagos;
    }

    $diferencia = $totalPagos - $totalPrestamos;

    return response()->json([
        'prestamos' => $prestamosPorMes,
        'pagos' => $pagosPorMes,
        'totalPrestamos' => $totalPrestamos,
        'totalPagos' => $totalPagos,
        'diferencia' => $diferencia,
    ]);
}




public function exportarFlujoCajaPDF(Request $request)
{
    $anio = $request->input('anio') ?? date('Y');
    $mes = $request->input('mes');

    $prestamosPorMes = [];
    $pagosPorMes = [];
    $totalPrestamos = 0;
    $totalPagos = 0;

    $inicioMes = $mes ? $mes : 1;
    $finMes = $mes ? $mes : 12;

    for ($m = $inicioMes; $m <= $finMes; $m++) {
        $prestamos = Prestamo::whereIn('estado', ['Activo', 'Liquidado'])
            ->whereYear('fecha_inicio', $anio)
            ->whereMonth('fecha_inicio', $m)
            ->sum('monto');

        $pagos = Pago::whereYear('fecha_pago', $anio)
            ->whereMonth('fecha_pago', $m)
            ->sum('monto_pagado');

        $prestamosPorMes[$m - 1] = $prestamos;
        $pagosPorMes[$m - 1] = $pagos;

        $totalPrestamos += $prestamos;
        $totalPagos += $pagos;
    }

    $diferencia = $totalPagos - $totalPrestamos;

    $pdf = PDF::loadView('reporte.flujocajapdf', compact('anio', 'mes', 'prestamosPorMes', 'pagosPorMes', 'totalPrestamos', 'totalPagos', 'diferencia'));

    return $pdf->stream('flujo_de_caja.pdf');
}

}
