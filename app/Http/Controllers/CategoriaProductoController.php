<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriaProductoRequest;
use App\Http\Requests\UpdateCategoriaProductoRequest;
use App\Models\CategoriaProducto;
use App\Models\Caracteristica;
use Exception;
use Illuminate\Support\Facades\DB;

class CategoriaProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-categoria_producto|crear-categoria_producto|editar-categoria_producto|eliminar-categoria_producto', ['only' => ['index']]);
        $this->middleware('permission:crear-categoria_producto', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-categoria_producto', ['only' => ['edit', 'update']]);
        $this->middleware('permission:eliminar-categoria_producto', ['only' => ['destroy']]);
    }

    public function index()
    {
        $categoria_productos = CategoriaProducto::with('caracteristica')->latest()->get();

        return view('categoria_producto.index', ['categoria_productos' => $categoria_productos]);
    }

    public function create()
    {
        return view('categoria_producto.create');
    }

    public function store(StoreCategoriaProductoRequest $request)
    {
        try {
            DB::beginTransaction();
            
            $caracteristica = Caracteristica::create($request->validated());
            $caracteristica->categoria_producto()->create([
                'caracteristica_id' => $caracteristica->id
            ]);
            
            DB::commit();
            return redirect()->route('categoria_productos.index')->with('success', 'Categoría de producto registrada correctamente.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('categoria_productos.index')->with('error', 'Error al registrar la categoría de producto');
        }
    }

    public function edit(CategoriaProducto $categoriaProducto)
    {
        $caracteristicas = Caracteristica::all();
        return view('categoria_producto.edit', compact('categoriaProducto', 'caracteristicas'));
    }

    public function update(UpdateCategoriaProductoRequest $request, CategoriaProducto $categoriaProducto)
    {
        try {
            $categoriaProducto->caracteristica->update($request->validated());
            return redirect()->route('categoria_productos.index')->with('success', 'Categoría de producto editada correctamente.');
        } catch (Exception $e) {
            return redirect()->route('categoria_productos.index')->with('error', 'Error al editar la categoría de producto');
        }
    }

    public function destroy(string $id)
    {
        try {
            $categoriaProducto = CategoriaProducto::find($id);
            if ($categoriaProducto) {
                // Verificar si hay prendas asociadas a esta categoría
                if ($categoriaProducto->prendas()->count() > 0) {
                    // Hay prendas asociadas, no se puede eliminar
                    return redirect()->route('categoria_productos.index')->with('error', 'No se puede eliminar esta categoría porque hay prendas registradas con ella.');
                }
                
                // Eliminar la característica asociada
                if ($categoriaProducto->caracteristica) {
                    $categoriaProducto->caracteristica->delete();
                }
                
                // Eliminar la categoría de producto
                $categoriaProducto->delete();

                return redirect()->route('categoria_productos.index')->with('success', 'Categoría de producto y característica eliminadas correctamente.');
            } else {
                return redirect()->route('categoria_productos.index')->with('error', 'Categoría de producto no encontrada.');
            }
        } catch (Exception $e) {
            return redirect()->route('categoria_productos.index')->with('error', 'Error al eliminar la categoría de producto y característica.');
        }
    }
}
