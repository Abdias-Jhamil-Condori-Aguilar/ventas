@extends('template')

@section('title', 'Registrar Préstamo')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush

@section('content')
    <!-- Alertas SweetAlert -->
    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}",
                confirmButtonText: 'OK'
            });
        </script>
    @endif
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
                <h1 class="h3 fw-bold mb-1">Registrar Préstamo</h1>
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ route('panel') }}">Inicio</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ route('prestamos.index') }}">Préstamos</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">Registrar Préstamo</li>
                </ol>
            </nav>
        </div>

        <div class="container w-100 p-4 mt-3">
            <!-- Pasos de registro -->
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Proceso de Registro de Préstamo</h3>
                </div>
                <div class="block-content block-content-full space-y-3">
                    <!-- Navegación entre pasos -->
                    <nav class="d-flex flex-column flex-lg-row items-center justify-content-between gap-2">
                        <a href="javascript:void(0)" onclick="showStep(1)" id="step1-btn" class="btn btn-lg btn-alt-secondary bg-transparent w-100 text-start fs-sm d-flex align-items-center justify-content-between gap-3 btn-step active">
                            <div class="flex-grow-0 rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                1
                            </div>
                            <div class="flex-grow-1">
                                <div>Información de la Prenda</div>
                                <div class="fw-normal">Detalles del artículo</div>
                            </div>
                        </a>
                        <a href="javascript:void(0)" onclick="showStep(2)" id="step2-btn" class="btn btn-lg btn-alt-secondary bg-transparent w-100 text-start fs-sm d-flex align-items-center justify-content-between gap-3 btn-step">
                            <div class="flex-grow-0 rounded-circle border border-3 border-primary d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                2
                            </div>
                            <div class="flex-grow-1">
                                <div>Condiciones del Préstamo</div>
                                <div class="fw-normal">Interés y plazo</div>
                            </div>
                        </a>
                        <a href="javascript:void(0)" onclick="showStep(3)" id="step3-btn" class="btn btn-lg btn-alt-secondary bg-transparent w-100 text-start fs-sm d-flex align-items-center justify-content-between gap-3 btn-step">
                            <div class="flex-grow-0 rounded-circle bg-body-dark d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                3
                            </div>
                            <div class="flex-grow-1">
                                <div>Verificación y Registro</div>
                                <div class="fw-normal">Revisión final</div>
                            </div>
                        </a>
                    </nav>

                    <!-- Contenido del formulario -->
                    <form action="{{ route('prestamos.store') }}" method="POST">
                        @csrf

                        <!-- Paso 1: Información de la Prenda -->
                        <div id="step1" class="step-content">
                            <div class="rounded-2 py-4 bg-body-light text-muted fs-sm">
                                <h4 class="mb-3">Paso 1: Información de la Prenda</h4>
                                <div class="mb-3">
                                    <label for="categoria_producto_id" class="form-label">Categoría Producto <span class="text-danger">*</span></label>
                                    <select name="categoria_producto_id" id="categoria_producto_id" class="form-control" onchange="updateCodigoPrenda()" required>
                                        <option value="">Selecciona una categoría</option>
                                        @foreach ($categoria_productos as $item)
                                            <option value="{{ $item->id }}" data-nombre="{{ $item->caracteristica->nombre }}">
                                                {{ $item->caracteristica->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                                <div class="mb-3">
                                    <label for="codigo_prenda" class="form-label">Código de la Prenda</label>
                                    <input type="text" id="codigo_prenda" name="codigo" class="form-control" value="{{ old('codigo')}}" readonly>
                                </div>
                                

                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripción de la Prenda <span class="text-danger">*</span></label>
                                    <input type="text" name="descripcion" id="descripcion" class="form-control" value="{{ old('descripcion') }}"  oninput="updateVerification('descripcion')"  required>
                                </div>

                                <div class="mb-3">
                                    <label for="modelo" class="form-label">Modelo <span class="text-danger"></span></label>
                                    <input type="text" name="modelo" id="modelo" class="form-control" value="{{ old('modelo') }}" oninput="updateVerification('modelo')" required>
                                </div>

                                <div class="mb-3">
                                    <label for="marca" class="form-label">Marca <span class="text-danger"></span></label>
                                    <input type="text" name="marca" id="marca" class="form-control" value="{{ old('marca') }}" oninput="updateVerification('marca')" required>
                                </div>

                                <div class="mb-3">
                                    <label for="serie" class="form-label">Serie <span class="text-danger"></span></label>
                                    <input type="text" name="serie" id="serie" class="form-control" value="{{ old('serie') }}" oninput="updateVerification('serie')" >
                                </div>

                                <div class="mb-3">
                                    <label for="observaciones" class="form-label">Observaciones</label>
                                    <input type="text" name="observaciones" id="observaciones" class="form-control" value="{{ old('observaciones') }}" oninput="updateVerification('observaciones')">
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary" onclick="nextStep(2)">Siguiente</button>
                            </div>
                        </div>

                  
                        <!-- Paso 2: Condiciones del Préstamo -->
                        <div id="step2" class="step-content d-none">
                            <div class="rounded-2 py-4 bg-body-light text-muted fs-sm">
                                <h4 class="mb-3">Paso 2: Condiciones del Préstamo</h4>
                                <div class="mb-3">
                                    <label for="intere_id" class="form-label">Interés <span class="text-danger">*</span></label>
                                    <select name="intere_id" id="intere_id" class="form-control" onchange="calcularInteres()" required>
                                        <option value="">Selecciona el interés</option>
                                        @foreach($intereses as $interes)
                                            <option value="{{ $interes->id }}" data-porcentaje="{{ $interes->interes }}">
                                                {{ $interes->nombre }} - {{ $interes->interes }}%
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('intere_id')
                                        <small class="text-danger">{{ '*' . $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="meses" class="form-label">Cantidad de Meses <span class="text-danger">*</span></label>
                                    <input type="number" step="1" min="1" name="meses" id="meses" class="form-control" value="{{ old('meses') }}" onchange="actualizarFechaFin(); calcularInteres()" required>
                                    @error('meses')
                                        <small class="text-danger">{{ '*' . $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="fecha_inicio" class="form-label">Fecha inicio de Préstamo <span class="text-danger">*</span></label>
                                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ old('fecha_inicio') }}" onchange="actualizarFechaFin()" required>
                                    @error('fecha_inicio')
                                        <small class="text-danger">{{ '*' . $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="fecha_fin" class="form-label">Fecha fin de Préstamo</label>
                                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ old('fecha_fin') }}" readonly>
                                </div>

                                <div class="mb-3">
                                    <label for="monto" class="form-label">Monto <span class="text-danger">*</span></label>
                                    <input type="text" name="monto" id="monto" class="form-control" value="{{ old('monto') }}" oninput="calcularInteres()" required>
                                    @error('monto')
                                        <small class="text-danger">{{ '*' . $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="interes_calculado" class="form-label">Interés Calculado</label>
                                    <input type="text" name="interes_calculado" id="interes_calculado" class="form-control" value="{{ old('interes_calculado') }}" readonly>
                                </div>

                                <div class="mb-3">
                                    <label for="total_pagar" class="form-label">Total a Pagar</label>
                                    <input type="text" name="total_pagar" id="total_pagar" class="form-control" value="{{ old('total_pagar') }}" readonly>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" onclick="prevStep(1)">Atrás</button>
                                <button type="button" class="btn btn-primary" onclick="nextStep(3)">Siguiente</button>
                            </div>
                        </div>
 
                       <!-- Paso 3: Verificación y Registro -->
<div id="step3" class="step-content d-none">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Paso 3: Verificación y Registro</h4>
        </div>
        <div class="card-body bg-light">
            <!-- Mostrar información registrada -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Cliente</label>
                    <p>{{ $cliente->nombre }} {{ $cliente->apellidos }}</p>
                    <input type="hidden" name="cliente_id" value="{{ $cliente->id }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">{{ $cliente->tipo_documento->caracteristica->nombre }}</label>
                    <p>{{ $cliente->numero_identificacion }}</p>
                </div>
            </div>
            <hr>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Categoría Producto</label>
                    <p id="ver_categoria_producto"></p>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Descripción de la Prenda</label>
                    <p id="ver_descripcion_prenda"></p>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Modelo</label>
                    <p id="ver_modelo"></p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Marca</label>
                    <p id="ver_marca"></p>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Serie</label>
                    <p id="ver_serie"></p>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Observaciones</label>
                    <p id="ver_observaciones"></p>
                </div>
            </div>
            <hr>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Interés</label>
                    <p id="ver_cinteres"></p>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Meses</label>
                    <p id="ver_cmeses"></p>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Fecha Fin</label>
                    <p id="ver_cfecha_fin"></p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Monto</label>
                    <p id="ver_cmonto"></p>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Interés Calculado</label>
                    <p id="ver_cinteres_calculado"></p>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Total a Pagar</label>
                    <p id="ver_ctotal_pagar"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Navegación -->
    <div class="d-flex justify-content-between mt-3">
        <button type="button" class="btn btn-secondary" onclick="prevStep(2)">Atrás</button>
        <button type="submit" class="btn btn-success">Registrar</button>
    </div>
</div>


                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
let contadorCodigoPrenda = 1;

function showStep(step) {
    // Hide all steps
    document.querySelectorAll('.step-content').forEach(function(content) {
        content.classList.add('d-none');
    });

    // Deselect all buttons
    document.querySelectorAll('.btn-step').forEach(function(btn) {
        btn.classList.remove('active');
    });

    // Show the selected step
    document.getElementById('step' + step).classList.remove('d-none');
    document.getElementById('step' + step + '-btn').classList.add('active');

    // If it's the final step (step 3), update the displayed values for verification
    if (step === 3) {
        document.getElementById('ver_categoria_producto').innerText = document.getElementById('categoria_producto_id').options[document.getElementById('categoria_producto_id').selectedIndex].text;
        document.getElementById('ver_descripcion_prenda').innerText = document.getElementById('descripcion').value;
        document.getElementById('ver_modelo').innerText = document.getElementById('modelo').value;
        document.getElementById('ver_marca').innerText = document.getElementById('marca').value;
        document.getElementById('ver_serie').innerText = document.getElementById('serie').value;
        document.getElementById('ver_observaciones').innerText = document.getElementById('observaciones').value;

        // Step 2 values
        document.getElementById('ver_cinteres').innerText = document.getElementById('intere_id').options[document.getElementById('intere_id').selectedIndex].text;
        document.getElementById('ver_cmeses').innerText = document.getElementById('meses').value;
        document.getElementById('ver_cfecha_fin').innerText = document.getElementById('fecha_fin').value;
        document.getElementById('ver_cmonto').innerText = document.getElementById('monto').value;
        document.getElementById('ver_cinteres_calculado').innerText = document.getElementById('interes_calculado').value;
        document.getElementById('ver_ctotal_pagar').innerText = document.getElementById('total_pagar').value;
    }
}

function nextStep(step) {
    showStep(step);
}

function prevStep(step) {
    showStep(step);
}

// Function to update the calculated interest and total amount
function calcularInteres() {
    const monto = parseFloat(document.getElementById('monto').value);
    const interes = parseFloat(document.getElementById('intere_id').options[document.getElementById('intere_id').selectedIndex].dataset.porcentaje);
    const meses = parseInt(document.getElementById('meses').value);

    if (!isNaN(monto) && !isNaN(interes) && !isNaN(meses)) {
        const interesCalculado = (monto * interes / 100) * meses;
        const totalPagar = monto + interesCalculado;

        document.getElementById('interes_calculado').value = interesCalculado.toFixed(2);
        document.getElementById('total_pagar').value = totalPagar.toFixed(2);
    }
}

// Function to update end date based on the selected number of months
function actualizarFechaFin() {
    const fechaInicio = new Date(document.getElementById('fecha_inicio').value);
    const meses = parseInt(document.getElementById('meses').value);

    if (!isNaN(fechaInicio) && !isNaN(meses)) {
        fechaInicio.setMonth(fechaInicio.getMonth() + meses);
        const fechaFin = fechaInicio.toISOString().split('T')[0];
        document.getElementById('fecha_fin').value = fechaFin;
    }
}

// Function to update verification for inputs
function updateVerification(id) {
    const value = document.getElementById(id).value;
    document.getElementById('ver_' + id).innerText = value;
}
function generateCodigoPrenda(categoria) {
    const codigoCategoria = categoria.substring(0, 3).toUpperCase();
    const numeroSecuencial = contadorCodigoPrenda.toString().padStart(4, '0');
    contadorCodigoPrenda++; // Incrementar el contador para que el siguiente código sea secuencial
    return codigoCategoria + numeroSecuencial;
}

function updateCodigoPrenda() {
    const categoriaSelect = document.getElementById('categoria_producto_id');
    const categoriaNombre = categoriaSelect.options[categoriaSelect.selectedIndex].dataset.nombre;
    const categoriaId = categoriaSelect.value; // Obtener el ID de la categoría seleccionada

    if (categoriaId) {
        // Hacer una solicitud AJAX al servidor para obtener el siguiente número secuencial
        fetch(`/api/ultimo-codigo-prenda?categoria_producto_id=${categoriaId}`)
            .then(response => response.json())
            .then(data => {
                const numeroSecuencial = data.numeroSecuencial.toString().padStart(4, '0'); // Asegurarse de que tenga 4 dígitos
                const codigoPrenda = categoriaNombre.substring(0, 3).toUpperCase() + numeroSecuencial;

                // Asignar el código generado al campo de texto
                document.getElementById('codigo_prenda').value = codigoPrenda;
            })
            .catch(error => console.error('Error al generar el código de la prenda:', error));
    }
}

document.getElementById('monto').addEventListener('input', function() {
    let monto = parseFloat(this.value);
    if (monto <= 0) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'El monto no puede ser menor o igual a 0.',
            confirmButtonText: 'OK'
        });
        this.value = '';
    }
});


</script>
<!-- JS de Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Inicializar Select2
        $('#categoria_producto_id').select2({
            placeholder: 'Selecciona una categoría',
            allowClear: true
        });

       
    });
</script>
@endpush
