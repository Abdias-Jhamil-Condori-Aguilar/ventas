<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInteresRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\Intere;
use Exception;
use Illuminate\Support\Facades\DB;

class InteresController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-interes|crear-interes|editar-interes|eliminar-interes', ['only' => ['index']]);
        $this->middleware('permission:crear-interes', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-interes', ['only' => ['edit', 'update']]);
        $this->middleware('permission:eliminar-interes', ['only' => ['destroy']]);
    }

    /**
     * Muestra la lista de intereses.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $intereses = Intere::all();
        return view('intere.index', ['intereses' => $intereses]);
    }

    /**
     * Muestra el formulario para crear un nuevo interés.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('intere.create');
    }

    /**
     * Almacena un nuevo interés en la base de datos.
     *
     * @param  StoreInteresRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreInteresRequest $request)
    {
        try {
            DB::beginTransaction();
            Intere::create($request->validated());
            DB::commit();
            return redirect()->route('intereses.index')->with('success', 'Interés registrado');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('intereses.index')->with('error', 'Error al registrar el interés');
        }
    }

    /**
     * Muestra el formulario de edición para un interés específico.
     *
     * @param  Intere  $intere
     * @return \Illuminate\View\View
     */
    public function edit(Intere $intereses)
    {
        return view('intere.edit', ['intereses' => $intereses]);
    }

    
    public function update(UpdateCategoriaRequest $request, Intere $intereses)
    {
        try {
            $intereses->update($request->validated());
            return redirect()->route('intereses.index')->with('success', 'Interés editado');
        } catch (Exception $e) {
            return redirect()->route('intereses.index')->with('error', 'Error al editar el interés');
        }
    }

    /**
     * Elimina un interés específico de la base de datos.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id)
    {
        try {
            $intere = Intere::find($id);

            if (!$intere) {
                return redirect()->route('intereses.index')->with('error', 'Interés no encontrado');
            }

            // Verifica si el interés está asociado a algún préstamo
            if ($intere->prestamos()->exists()) {
                return redirect()->route('intereses.index')->with('error', 'No se puede eliminar el interés porque está asociado a uno o más préstamos.');
            }

            // Elimina el interés
            $intere->delete();
            return redirect()->route('intereses.index')->with('success', 'Interés eliminado correctamente');
        } catch (Exception $e) {
            return redirect()->route('intereses.index')->with('error', 'Error al eliminar el interés');
        }
    }
}
