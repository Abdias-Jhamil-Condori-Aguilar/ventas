@extends('template')

@section('title', 'Crear Tipo de Pago')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
                <h1 class="h3 fw-bold mb-1">Crear Tipo de Pago</h1>
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ route('panel') }}">Inicio</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ route('tipo_pagos.index') }}">Tipos de Pago</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">Crear Tipo de Pago</li>
                </ol>
            </nav>
        </div>

        <div class="container w-100 p-4 mt-3">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Crear Tipo de Pago</h3>
                </div>
                <div class="block-content block-content-full">
                    <form action="{{ route('tipo_pagos.store') }}" method="post">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre de la Característica</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" required>
                            @error('nombre')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción de la Característica</label>
                            <textarea name="descripcion" id="descripcion" class="form-control" rows="3" required>{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
