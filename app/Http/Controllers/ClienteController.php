<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Cliente;
use App\Models\TipoDocumento;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-cliente|crear-cliente|editar-cliente|eliminar-cliente', ['only' => ['index']]);
        $this->middleware('permission:crear-cliente', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-cliente', ['only' => ['edit', 'update']]);
        $this->middleware('permission:eliminar-cliente', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::with('tipo_documento')->orderBy('created_at', 'desc')->paginate(6); // Cargar la relación tipo_documento
        return view('cliente.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tipo_documentos = TipoDocumento::join('caracteristicas as c', 'tipo_documentos.caracteristica_id', '=', 'c.id')
            ->select('tipo_documentos.id as id', 'c.nombre as nombre')
            ->get();
        return view('cliente.create', ['tipo_documentos' => $tipo_documentos]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClienteRequest $request)
    {
        try {
            DB::beginTransaction();

            // Combinar numero_identificacion con complemento
            $numero_identificacion = $request->input('numero_identificacion');
            $complemento = $request->input('complemento');

            // Concatenar si el complemento existe
            if ($complemento) {
                $numero_identificacion = $numero_identificacion . '-' . $complemento;
            }

            // Crear el cliente con los datos validados y el numero_identificacion modificado
            Cliente::create(array_merge($request->validated(), ['numero_identificacion' => $numero_identificacion]));

            DB::commit();
            return redirect()->route('clientes.index')->with('success', 'Cliente registrado');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('clientes.create')->with('error', 'Error al registrar cliente');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        // Cargar los préstamos del cliente
        $prestamos = $cliente->prestamos()->get();
        return view('cliente.show', compact('cliente', 'prestamos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        $tipo_documentos = TipoDocumento::join('caracteristicas as c', 'tipo_documentos.caracteristica_id', '=', 'c.id')
        ->select('tipo_documentos.id as id', 'c.nombre as nombre')
        ->get();        
        return view('cliente.edit', ['cliente' => $cliente, 'tipo_documentos' => $tipo_documentos]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClienteRequest $request, Cliente $cliente)
    {
        // Combinar numero_identificacion con complemento
        $numero_identificacion = $request->input('numero_identificacion');
        $complemento = $request->input('complemento');

        // Concatenar si el complemento existe
        if ($complemento) {
            $numero_identificacion = $numero_identificacion . '-' . $complemento;
        }

        // Actualizar el cliente con los datos validados y el numero_identificacion modificado
        $cliente->update(array_merge($request->validated(), ['numero_identificacion' => $numero_identificacion]));

        return redirect()->route('clientes.index')->with('success', 'Cliente editado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return redirect()->route('clientes.index')->with('error', 'Cliente no encontrado');
        }

        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado exitosamente');
    }
    public function exportarPDF()
    {
        // Obtenemos todos los clientes
        $clientes = Cliente::all();

        // Cargamos la vista 'clientes.pdf' con los datos de los clientes
        $pdf = Pdf::loadView('cliente.pdf', compact('clientes'));

        // Retornamos el PDF para descargar
        return $pdf->download('cliente.pdf');
    }
}
