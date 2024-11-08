@extends('template')

@section('title', 'Crear Cliente')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
                <h1 class="h3 fw-bold mb-1">Crear Cliente</h1>
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ route('panel') }}">Inicio</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ route('clientes.index') }}">Clientes</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">Crear Cliente</li>
                </ol>
            </nav>
        </div>
        <div class="container w-100 p-4 mt-3">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Crear Cliente</h3>
                </div>
                <div class="block-content block-content-full">
                    <form action="{{ route('clientes.store') }}" method="post" id="clienteForm">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre(s)</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" placeholder="Nombre(s) del cliente" onkeypress="return soloLetras(event)">
                            @error('nombre')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="papellido" class="form-label">Primer Apellido</label>
                            <input type="text" name="papellido" id="papellido" class="form-control" value="{{ old('papellido') }}" placeholder="Primer Apellido " onkeypress="return soloLetras(event)">
                            @error('apellido_paterno')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="sapellido" class="form-label">Segundo Apellido </label>
                            <input type="text" name="sapellido" id="sapellido" class="form-control" value="{{ old('sapellido') }}" placeholder="Segundo Apellido" onkeypress="return soloLetras(event)">
                         
                        </div>
                        <div class="mb-3">
                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento') }}">
                            @error('fecha_nacimiento')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="correo_electronico" class="form-label">Correo Electrónico</label>
                            <input type="email" name="correo_electronico" id="correo_electronico" class="form-control" value="{{ old('correo_electronico') }}" placeholder="correo@ejemplo.com">
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" name="telefono" id="telefono" class="form-control" value="{{ old('telefono') }}" placeholder="+591 00000000">
                            @error('telefono')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="domicilio" class="form-label">Domicilio</label>
                            <input type="text" name="domicilio" id="domicilio" class="form-control" value="{{ old('domicilio') }}" placeholder="Calle, número, colonia">
                            @error('domicilio')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="ciudad" class="form-label">Ciudad</label>
                            <select name="ciudad" id="ciudad" class="form-control">
                                <option value="">Seleccione una ciudad</option>
                                <option value="La Paz" {{ old('ciudad') == 'La Paz' ? 'selected' : '' }}>La Paz</option>
                                <option value="Cochabamba" {{ old('ciudad') == 'Cochabamba' ? 'selected' : '' }}>Cochabamba</option>
                                <option value="Santa Cruz" {{ old('ciudad') == 'Santa Cruz' ? 'selected' : '' }}>Santa Cruz</option>
                                <option value="Oruro" {{ old('ciudad') == 'Oruro' ? 'selected' : '' }}>Oruro</option>
                                <option value="Potosí" {{ old('ciudad') == 'Potosí' ? 'selected' : '' }}>Potosí</option>
                                <option value="Tarija" {{ old('ciudad') == 'Tarija' ? 'selected' : '' }}>Tarija</option>
                                <option value="Sucre" {{ old('ciudad') == 'Sucre' ? 'selected' : '' }}>Sucre</option>
                                <option value="Beni" {{ old('ciudad') == 'Beni' ? 'selected' : '' }}>Beni</option>
                                <option value="Pando" {{ old('ciudad') == 'Pando' ? 'selected' : '' }}>Pando</option>
                            </select>
                            @error('ciudad')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="tipo_documento_id" class="form-label">Tipo de Identificación:</label>
                            <select data-size="4" title="Seleccione una identificación" data-live-search="true" name="tipo_documento_id" id="tipo_documento_id" class="form-control selectpicker show-tick">
                                @foreach ($tipo_documentos as $item)
                                    <option value="{{ $item->id }}"{{ old('tipo_documento_id') == $item->id ? 'selected' : '' }}>{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                            @error('tipo_documento_id')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="numero_identificacion" class="form-label">Documento de identidad</label>
                                <input type="text" name="numero_identificacion" id="numero_identificacion" value="{{ old('numero_identificacion') }}" class="form-control" placeholder="Número de identificación" onkeypress="return soloNumeros(event)">
                                @error('numero_identificacion')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="complemento" class="form-label">¿Complemento?</label><br>
                                <input type="checkbox" id="toggleComplemento" onchange="toggleComplementoField()">
                            </div>
                        </div>

                        <div class="mb-3" id="complementoField" style="display:none;">
                            <label for="complemento" class="form-label">Complemento</label>
                            <input type="text" name="complemento" id="complemento" class="form-control" value="{{ old('complemento') }}" placeholder="Ingrese el complemento">
                            @error('complemento')
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

<script>
    function toggleComplementoField() {
        var complementoField = document.getElementById("complementoField");
        var complementoInput = document.getElementById("complemento");

        if (document.getElementById("toggleComplemento").checked) {
            complementoField.style.display = "block";
        } else {
            complementoField.style.display = "none";
            complementoInput.value = ""; // Limpia el campo de complemento si se desactiva
        }
    }

    function combineFields() {
        var numeroIdentificacion = document.getElementById("numero_identificacion").value;
        var complemento = document.getElementById("complemento").value;

        if (document.getElementById("toggleComplemento").checked && complemento) {
            // Combina los dos valores si el complemento está activado
            var combined = numeroIdentificacion + complemento;
            document.getElementById("numero_identificacion").value = combined; // Envía el valor combinado
        }

        return true; // Permite que el formulario se envíe
    }

    // Validación para permitir solo números en el documento de identidad
    function soloNumeros(event) {
        var key = event.charCode || event.keyCode;
        return (key >= 48 && key <= 57);
    }

    // Validación para permitir solo letras y espacios
    function soloLetras(event) {
        var key = event.charCode || event.keyCode;
        return ((key >= 65 && key <= 90) || (key >= 97 && key <= 122) || key === 32);
    }
</script>


@endsection

@push('js')
<script src="{{ asset('assets/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('assets/demo/chart-bar-demo.js') }}"></script>
<script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
<script src="{{ asset('js/scripts.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
@endpush
