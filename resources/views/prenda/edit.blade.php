@extends('template')

@section('title', 'Editar Prenda')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
                <h1 class="h3 fw-bold mb-1">Editar Prenda</h1>
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ route('panel') }}">Inicio</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ route('prendas.index') }}">Prendas</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">Editar Prenda</li>
                </ol>
            </nav>
        </div>
        <div class="container w-100 p-4 mt-3">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Editar Prenda</h3>
                </div>
                <div class="block-content block-content-full">
                    <form action="{{ route('prendas.update', $prenda->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Selección de categoría -->
                        <div class="mb-3">
                            <label for="categoria_producto_id" class="form-label">Categoría</label>
                            <select name="categoria_producto_id" id="categoria_producto_id" class="form-control" required>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" {{ old('categoria_producto_id', $prenda->categoria_producto_id) == $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->caracteristica->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categoria_producto_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Código de prenda -->
                        <div class="mb-3">
                            <label for="codigo" class="form-label">Código</label>
                            <input type="text" name="codigo" id="codigo" class="form-control" value="{{ old('codigo', $prenda->codigo) }}" required>
                            @error('codigo')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Descripción -->
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <input type="text" name="descripcion" id="descripcion" class="form-control" value="{{ old('descripcion', $prenda->descripcion) }}" required>
                            @error('descripcion')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Modelo -->
                        <div class="mb-3">
                            <label for="modelo" class="form-label">Modelo (opcional)</label>
                            <input type="text" name="modelo" id="modelo" class="form-control" value="{{ old('modelo', $prenda->modelo) }}">
                            @error('modelo')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Marca -->
                        <div class="mb-3">
                            <label for="marca" class="form-label">Marca (opcional)</label>
                            <input type="text" name="marca" id="marca" class="form-control" value="{{ old('marca', $prenda->marca) }}">
                            @error('marca')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Serie -->
                        <div class="mb-3">
                            <label for="serie" class="form-label">Serie (opcional)</label>
                            <input type="text" name="serie" id="serie" class="form-control" value="{{ old('serie', $prenda->serie) }}">
                            @error('serie')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Observaciones -->
                        <div class="mb-3">
                            <label for="observaciones" class="form-label">Observaciones (opcional)</label>
                            <textarea name="observaciones" id="observaciones" class="form-control">{{ old('observaciones', $prenda->observaciones) }}</textarea>
                            @error('observaciones')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Estado -->
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select name="estado" id="estado" class="form-control" required>
                                <option value="disponible" {{ old('estado', $prenda->estado) == 'disponible' ? 'selected' : '' }}>Disponible</option>
                                <option value="prestado" {{ old('estado', $prenda->estado) == 'prestado' ? 'selected' : '' }}>Prestado</option>
                                <option value="vendido" {{ old('estado', $prenda->estado) == 'vendido' ? 'selected' : '' }}>Vendido</option>
                            </select>
                            @error('estado')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Actualizar Prenda</button>
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
