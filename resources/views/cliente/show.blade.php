@extends('layouts.app')

@section('title', 'Detalles del Cliente')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/font-awesome@5.15.4/css/all.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="bg-body-light">
  <div class="content content-full">
    <!-- Steps Navigation -->
    <div class="block block-rounded">
      <div class="block-header block-header-default">
        <h3 class="block-title">Detalles del Cliente</h3>
      </div>
      <div class="block-content block-content-full space-y-3">
        <nav class="d-flex flex-column flex-lg-row items-center justify-content-between gap-2">
          <a href="javascript:void(0)" onclick="showStep(1)" id="step1-btn" class="btn btn-lg btn-alt-secondary bg-transparent w-100 text-start fs-sm d-flex align-items-center justify-content-between gap-3 step-button">
            <div class="flex-grow-0 rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
              <i class="fa fa-fw fa-user"></i>
            </div>
            <div class="flex-grow-1">
              <div>Información del Cliente</div>
              <div class="fw-normal">Detalles personales</div>
            </div>
          </a>
          <a href="javascript:void(0)" onclick="showStep(2)" id="step2-btn" class="btn btn-lg btn-alt-secondary bg-transparent w-100 text-start fs-sm d-flex align-items-center justify-content-between gap-3 step-button">
            <div class="flex-grow-0 rounded-circle border border-3 border-primary d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
              2
            </div>
            <div class="flex-grow-1">
              <div class="text-primary">Préstamos</div>
              <div class="fw-normal">Historial de préstamos</div>
            </div>
          </a>
        </nav>

        <!-- Step 1: Información del Cliente -->
        <div id="step1" class="step-content d-none">
          <div class="block-header block-header-default">
            <h3 class="block-title">Información del Cliente</h3>
          </div>
          <div class="block-content block-content-full">
            <table class="table table-striped table-borderless">
              <thead>
                <tr>
                  <th colspan="2">Datos del Cliente</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 20%;">Nombre</td>
                  <td>{{ $cliente->nombre }} {{ $cliente->papellido }} {{ $cliente->sapellido }}</td>
                </tr>
                <tr>
                  <td>Fecha de Nacimiento</td>
                  <td>{{ $cliente->fecha_nacimiento }}</td>
                </tr>
                <tr>
                  <td>Correo Electrónico</td>
                  <td>{{ $cliente->correo_electronico }}</td>
                </tr>
                <tr>
                  <td>Teléfono</td>
                  <td>{{ $cliente->telefono }}</td>
                </tr>
                <tr>
                  <td>Domicilio</td>
                  <td>{{ $cliente->domicilio }}</td>
                </tr>
                
                  <td>Ciudad</td>
                  <td>{{ $cliente->ciudad }}</td>
                </tr>
                <tr>
                  <td>Tipo de Identificación</td>
                  <td>{{ $cliente->tipo_documento->caracteristica->nombre ?? 'N/A' }}</td>
                </tr>
                <tr>
                  <td>Número de Identificación</td>
                  <td>{{ $cliente->numero_identificacion }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="content content-full text-end mt-4">
            <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-primary">
              <i class="fas fa-edit"></i> Editar
            </a>
          </div>
        </div>

        <!-- Step 2: Información de Préstamos -->
        <div id="step2" class="step-content d-none">
          <div class="block-header block-header-default">
            <h3 class="block-title">Préstamos del Cliente</h3>
          </div>
          <div class="block-content block-content-full">
            <a href="{{ route('prestamos.create', ['cliente_id' => $cliente->id]) }}" class="btn btn-dark btn-lg mb-4">Agregar Préstamo</a>

            @if($prestamos->count() > 0)
              <table class="table table-striped table-borderless">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Monto</th>
                    <th>Fecha de Inicio</th>
                    <th>Fecha de Vencimiento</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($prestamos as $prestamo)
                  <tr>
                    <td>{{ $prestamo->id }}</td>
                    <td>{{ $prestamo->monto }}</td>
                    <td>{{ $prestamo->fecha_inicio }}</td>
                    <td>{{ $prestamo->fecha_fin }}</td>
                    <td>{{ $prestamo->estado }}</td>
                    <td>
                      <a href="{{ route('prestamos.show', $prestamo->id) }}" class="btn btn-info btn-sm">Ver Detalles</a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            @else
              <p class="text-muted">Este cliente no tiene préstamos registrados.</p>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
<script>
  function showStep(step) {
    // Oculta todos los pasos
    document.querySelectorAll('.step-content').forEach(function(content) {
      content.classList.add('d-none');
    });

    // Desmarca todos los botones
    document.querySelectorAll('.step-button').forEach(function(btn) {
      btn.classList.remove('active');
    });

    // Muestra el paso seleccionado
    document.getElementById('step' + step).classList.remove('d-none');
    document.getElementById('step' + step + '-btn').classList.add('active');
  }

  // Mostrar el primer paso por defecto
  document.addEventListener('DOMContentLoaded', function() {
    showStep(1);
  });
</script>
@endpush
