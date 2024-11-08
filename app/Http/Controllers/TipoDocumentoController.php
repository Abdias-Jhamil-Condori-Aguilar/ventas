<?php
namespace App\Http\Controllers;
use App\Http\Requests\StoreCategoriaProductoRequest;
use App\Http\Requests\UpdateCategoriaProductoRequest;
use App\Models\Caracteristica;
use App\Models\TipoDocumento;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipoDocumentoController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-tipo_documento|crear-tipo_documento|editar-tipo_documento|eliminar-tipo_documento', ['only' => ['index']]);
        $this->middleware('permission:crear-tipo_documento', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-tipo_documento', ['only' => ['edit', 'update']]);
        $this->middleware('permission:eliminar-tipo_documento', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipo_documentos = TipoDocumento::with('caracteristica')->latest()->get();

        return view('tipodocumento.index', ['tipo_documentos' => $tipo_documentos]);
    }

    public function create()
    {
        return view('tipodocumento.create');
    }

    public function store(StoreCategoriaProductoRequest $request)
    {
        try {
            DB::beginTransaction();
            $caracteristica = Caracteristica::create($request->validated());
            $caracteristica->tipo_documento()->create([
                'caracteristica_id' => $caracteristica->id
              
            ]);
            
            DB::commit();
            return redirect()->route('tipo_documentos.index')->with('success', 'Tipo de documento registrado');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('tipo_documentos.index')->with('error', 'Error al registrar el tipo de documento');
        }
    }

    public function edit(TipoDocumento $tipoDocumento)
    {
        return view('tipodocumento.edit', compact('tipoDocumento'));
    }

    public function update(UpdateCategoriaProductoRequest $request, TipoDocumento $tipoDocumento)
    {
        try {
            $tipoDocumento->update($request->validated());
            return redirect()->route('tipo_documentos.index')->with('success', 'Tipo de documento editado');
        } catch (Exception $e) {
            return redirect()->route('tipo_documentos.index')->with('error', 'Error al editar el tipo de documento');
        }
    }

    public function destroy(string $id)
    {
        try {
            $tipoDocumento = TipoDocumento::find($id);
    
            if ($tipoDocumento) {
                // Verificar si el tipo de documento está asociado a algún cliente
                if ($tipoDocumento->clientes()->exists()) {
                    return redirect()->route('tipo_documentos.index')->with('error', 'No se puede eliminar, este tipo de documento está asociado a uno o más clientes');
                }
    
                // Si no está asociado, proceder con la eliminación
                $tipoDocumento->delete();
                return redirect()->route('tipo_documentos.index')->with('success', 'Tipo de documento eliminado');
            } else {
                return redirect()->route('tipo_documentos.index')->with('error', 'Tipo de documento no encontrado');
            }
        } catch (Exception $e) {
            return redirect()->route('tipo_documentos.index')->with('error', 'Error al eliminar el tipo de documento');
        }
    }
    
}
