@extends('template')

@section('title', 'Crear Tipo de Documento')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
                <h1 class="h3 fw-bold mb-1">Crear Tipo de Documento</h1>
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ route('panel') }}">Inicio</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ route('tipo_documentos.index') }}">Tipo de Documento</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">Crear Tipo de Documento</li>
                </ol>
            </nav>
        </div>
        <div class="container w-100 p-4 mt-3">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Crear Tipo de Documento</h3>
                </div>
                <div class="block-content block-content-full">
                    <form action="{{ route('tipo_documentos.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Tipo de Documento</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" placeholder="Nombre  ">
                            @error('nombre')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Descripcion</label>
                            <input type="text" name="descripcion" id="descripcion" class="form-control" value="{{ old('descripcion') }}" placeholder="Descripcion ">
                            @error('descripcion')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Guardar</button>
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
