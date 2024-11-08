<?php

namespace App\Http\Controllers;

use App\Models\CategoriaProducto;
use App\Models\Prenda;
use Illuminate\Http\Request;

class PrendaController extends Controller
{
    public function index()
    {
        $prendas = Prenda::with('categoriaProducto.caracteristica')->paginate(5); // Ajusta el número de elementos por página
        return view('prenda.index', compact('prendas'));
    }
    


    public function create()
    {
        return view('prenda.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'estado' => 'required|string|max:50',
        ]);

        Prenda::create($request->all());
        return redirect()->route('prendas.index')->with('success', 'Prenda creada con éxito.');
    }

    public function show(Prenda $prenda)
    {
        return view('prendas.show', compact('prenda'));
    }

    public function edit($id)
    {
        $prenda = Prenda::findOrFail($id);
        $categorias = CategoriaProducto::all(); // Obtiene todas las categorías para mostrarlas en el select
        return view('prenda.edit', compact('prenda', 'categorias'));
    }

    // Método para actualizar los datos de la prenda
    public function update(Request $request, $id)
    {
        $request->validate([
            'categoria_producto_id' => 'required|exists:categoria_productos,id',
            'codigo' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'modelo' => 'nullable|string|max:255',
            'marca' => 'nullable|string|max:255',
            'serie' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string',
            'estado' => 'required|in:disponible,prestado,vendido'
        ]);

        $prenda = Prenda::findOrFail($id);
        $prenda->update($request->all());

        return redirect()->route('prendas.index')->with('success', 'Prenda actualizada exitosamente.');
    }

    public function destroy(Prenda $prenda)
    {
        $prenda->delete();
        return redirect()->route('prendas.index')->with('success', 'Prenda eliminada con éxito.');
    }
}
