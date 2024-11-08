<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticuloRequest;
use App\Http\Requests\UpdateArticuloRequest;
use App\Models\Articulo;
use App\Models\Categoria;
use App\Models\Imagene;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ArticuloController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-articulo|crear-articulo|editar-articulo|eliminar-articulo', ['only' => ['index']]);
        $this->middleware('permission:crear-articulo', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-articulo', ['only' => ['edit', 'update']]);
        $this->middleware('permission:eliminar-articulo', ['only' => ['destroy']]);
    }

    public function index()
    {
        
        $articulos = Articulo::with([ 'categoria.caracteristica'])->latest()->get();
        return view('articulo.index', compact('articulos'));
    }

    public function create()
    {
        $categorias = Categoria::join('caracteristicas as c', 'categorias.caracteristica_id', '=', 'c.id')
        ->select('categorias.id as id', 'c.nombre as nombre')
        ->where('c.estado', 1)
        ->get();
        return view('articulo.create', compact('categorias'));
    }

    public function store(StoreArticuloRequest $request)
    {
        try {
            // Verificar si se ha subido una imagen
            if ($request->hasFile('img_path')) {
                // Guardar la imagen en la carpeta 'public/articulos'
                $path = $request->file('img_path')->store('public/articulos');

                // Obtener la URL pública
                $url = Storage::url($path);
            } else {
                $url = null; // En caso de que no haya imagen
            }

            // Crear el artículo y guardar la URL de la imagen
            $articulo = Articulo::create([
                'codigo' => $request->codigo,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'img_path' => $url, // Almacenar solo la URL en la base de datos
                'categorias' => $request->categoria_id,
            ]);

            // Asociar las categorías al artículo
            $articulo->save();
           

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear el artículo: ' . $e->getMessage());
        }
        return redirect()->route('articulos.index')->with('success', 'Artículo creado con éxito.');

    }
    

    public function edit(Articulo $articulo)
    {
        $categorias = Categoria::join('caracteristicas as c', 'categorias.caracteristica_id', '=', 'c.id')
            ->select('categorias.id as id', 'c.nombre as nombre')
            ->where('c.estado', 1)
            ->get();
        
        return view('articulo.edit', compact('articulo', 'categorias'));
    }

    public function update(UpdateArticuloRequest $request, Articulo $articulo)
    {
        try {
            DB::beginTransaction();

            if ($request->hasFile('img_path')) {
                $name = $articulo->handleUploadImage($request->file('img_path'));

                if ($articulo->img_path && Storage::exists('public/articulos/' . $articulo->img_path)) {
                    Storage::delete('public/articulos/' . $articulo->img_path);
                }
            } else {
                $name = $articulo->img_path;
            }

            $articulo->fill([
                'codigo' => $request->codigo,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'categoria_id' => $request->categoria_id,
                'img_path' => $name
            ]);

            $articulo->save();

            DB::commit();

            return redirect()->route('articulos.index')->with('success', 'Artículo editado con éxito.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al editar el artículo.');
        }
    }

    public function destroy($id)
    {
        try {
            $articulo = Articulo::findOrFail($id);
            $estado = $articulo->estado;
            $nuevoEstado = $estado == 1 ? 0 : 1;
            $message = $estado == 1 ? 'Artículo eliminado' : 'Artículo restaurado';

            $articulo->update(['estado' => $nuevoEstado]);

            return redirect()->route('articulos.index')->with('success', $message);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al cambiar el estado del artículo.');
        }
    }
}
