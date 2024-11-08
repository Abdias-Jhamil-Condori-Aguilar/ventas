<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Prenda;
use App\Models\Prestamo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class BoletaController extends Controller
{
    public function generarBoleta($prestamo_id)
    {
        // Buscar el préstamo, cliente y prenda relacionados
        $prestamo = Prestamo::findOrFail($prestamo_id);
        $cliente = Cliente::findOrFail($prestamo->cliente_id);
        $prenda = Prenda::findOrFail($prestamo->prendas_id);

        // Generar el PDF usando la vista y los datos del préstamo
        $pdf = Pdf::loadView('boleta_empeno', [
            'prestamo' => $prestamo,
            'cliente' => $cliente,
            'prenda' => $prenda
        ]);

        // Descargar el PDF
        return $pdf->stream('prestamo.boleta_empeno');

    }
}
