@extends('template')

@section('title', 'Editar Préstamo')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
                <h1 class="h3 fw-bold mb-1">Editar Préstamo</h1>
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ route('panel') }}">Inicio</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ route('prestamos.index') }}">Préstamos</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">Editar Préstamo</li>
                </ol>
            </nav>
        </div>

        <div class="container w-100 p-4 mt-3">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Editar Préstamo</h3>
                </div>
                <div class="block-content block-content-full">
                    <form action="{{ route('prestamos.update', $prestamo->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Cliente (Información no editable) -->
                        <div class="mb-3">
                            <label for="cliente" class="form-label">Cliente</label>
                            <input type="text" class="form-control" value="{{ $cliente->nombre }} {{ $cliente->papellido }} {{ $cliente->sapellido }}" disabled>
                        </div>

                        <!-- Prenda (Información no editable) -->
                        <div class="mb-3">
                            <label for="prenda" class="form-label">Prenda</label>
                            <input type="text" class="form-control" value="{{ $prenda->descripcion }}" disabled>
                        </div>

                        <!-- Fecha de Inicio -->
                        <div class="mb-3">
                            <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                            <input type="date" name="fecha_inicio" class="form-control" value="{{ old('fecha_inicio', $prestamo->fecha_inicio) }}">
                            @error('fecha_inicio')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Fecha de Fin -->
                        <div class="mb-3">
                            <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                            <input type="date" name="fecha_fin" class="form-control" value="{{ old('fecha_fin', $prestamo->fecha_fin) }}">
                            @error('fecha_fin')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Monto -->
                        <div class="mb-3">
                            <label for="monto" class="form-label">Monto</label>
                            <input type="number" name="monto" class="form-control" value="{{ old('monto', $prestamo->monto) }}" step="0.01">
                            @error('monto')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Meses -->
                        <div class="mb-3">
                            <label for="meses" class="form-label">Meses</label>
                            <input type="number" name="meses" class="form-control" value="{{ old('meses', $prestamo->meses) }}">
                            @error('meses')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Interés Calculado -->
                        <div class="mb-3">
                            <label for="interes_calculado" class="form-label">Interés Calculado</label>
                            <input type="number" name="interes_calculado" class="form-control" value="{{ old('interes_calculado', $prestamo->interes_calculado) }}" step="0.01">
                            @error('interes_calculado')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Total a Pagar -->
                        <div class="mb-3">
                            <label for="total_pagar" class="form-label">Total a Pagar</label>
                            <input type="number" name="total_pagar" class="form-control" value="{{ old('total_pagar', $prestamo->total_pagar) }}" step="0.01">
                            @error('total_pagar')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Estado -->
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select name="estado" class="form-control">
                                <option value="activo" {{ old('estado', $prestamo->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                                <option value="finalizado" {{ old('estado', $prestamo->estado) == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                            </select>
                            @error('estado')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('assets/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('assets/demo/chart-bar-demo.js') }}"></script>
<script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
<script src="{{ asset('js/scripts.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
@endpush
