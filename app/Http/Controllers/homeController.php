<?php

namespace App\Http\Controllers;

use App\Models\CategoriaProducto;
use App\Models\Cliente;
use App\Models\Prenda;
use App\Models\Prestamo;
use App\Models\TipoDocumento;
use App\Models\User;
use Illuminate\Http\Request;

class homeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes=Cliente::all();
        $prendas=Prenda::all();
    
        $prestamos=Prestamo::all();
        $usuarios=User::all();
        $categoria_producto=CategoriaProducto::all();
        $tipo_documentos=TipoDocumento::all();
        return view('panel.index',compact('clientes','prendas','prestamos','usuarios','categoria_producto','tipo_documentos'));
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
}
