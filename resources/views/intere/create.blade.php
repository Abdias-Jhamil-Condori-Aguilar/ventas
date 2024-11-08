@extends('template')

@section('title', 'Crear Interés')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
                <h1 class="h3 fw-bold mb-1">Crear Interés</h1>
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ route('panel') }}">Inicio</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ route('intereses.index') }}">Intereses</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">Crear Interés</li>
                </ol>
            </nav>
        </div>
        <div class="container w-100 p-4 mt-3">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Crear Interés</h3>
                </div>
                <div class="block-content block-content-full">
                    <form action="{{ route('intereses.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" required>
                            @error('nombre')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="interes" class="form-label">Interés (%)</label>
                            <input type="number" name="interes" id="interes" class="form-control" value="{{ old('interes') }}" step="0.01" min="0" max="100" required>
                            @error('interes')
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

@push('js')
<script src="{{ asset('assets/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('assets/demo/chart-bar-demo.js') }}"></script>
<script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
<script src="{{ asset('js/scripts.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
@endpush
