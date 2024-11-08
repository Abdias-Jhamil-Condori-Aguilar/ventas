@extends('template')

@section('title', 'Editar Artículo')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
                <h1 class="h3 fw-bold mb-1">Editar Artículo</h1>
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ route('panel') }}">Inicio</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ route('articulos.index') }}">Artículos</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">Editar Artículo</li>
                </ol>
            </nav>
        </div>
        <div class="container w-100 p-4 mt-3">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Editar Artículo</h3>
                </div>
                <div class="block-content block-content-full">
                    <form action="{{ route('articulos.update', ['articulo' => $articulo->id]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="codigo" class="form-label">Código del Artículo</label>
                            <input type="text" name="codigo" id="codigo" class="form-control" value="{{ old('codigo', $articulo->codigo) }}">
                            @error('codigo')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Artículo</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $articulo->nombre) }}">
                            @error('nombre')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion', $articulo->descripcion) }}</textarea>
                            @error('descripcion')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                       
                        <div class="mb-3">
                            <label for="img_path" class="form-label">Imagen del Artículo</label>
                            <input type="file" name="img_path" id="img_path" class="form-control" accept="image/*">
                            @if ($articulo->img_path)
                                <img src="{{ Storage::url('articulos/'.$articulo->img_path) }}" alt="{{ $articulo->nombre }}" class="img-fluid img-thumbnail border border-4 rounded mt-2">
                            @endif
                            @error('img_path')
                            <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="categoria_id" class="form-label">Categoría:</label>
                            <select data-size="4" title="Seleccione una Categoría" data-live-search="true" name="categoria_id" id="categoria_id" class="form-control selectpicker show-tick">
                                @foreach ($categorias as $item)
                                    <option value="{{ $item->id }}" {{ old('categoria_id', $articulo->categoria_id) == $item->id ? 'selected' : '' }}>{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                            @error('categoria_id')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
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
