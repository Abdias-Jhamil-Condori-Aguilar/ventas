@extends('layouts.app')

@section('title', 'Detalles del Préstamo')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/font-awesome@5.15.4/css/all.min.css" rel="stylesheet">
<link href="{{ asset('assets/css/plugins/magnific-popup/magnific-popup.css') }}" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endpush

@section('content')
<div class="bg-body-light">
  <div class="content content-full">
    <!-- Steps Navigation -->
    <div class="block block-rounded">
      <div class="block-header block-header-default">
        <h3 class="block-title">Detalles del Préstamo</h3>
      </div>
      <div class="block-content block-content-full space-y-3">
        <nav class="d-flex flex-column flex-lg-row items-center justify-content-between gap-2">
          <a href="javascript:void(0)" onclick="showStep(1)" class="btn btn-lg btn-alt-secondary bg-transparent w-100 text-start fs-sm d-flex align-items-center justify-content-between gap-3 step-button" data-step="1">
            <div class="flex-grow-0 rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
              <i class="fa fa-fw fa-credit-card"></i>
            </div>
            <div class="flex-grow-1">
              <div>Información del Préstamo</div>
              <div class="fw-normal">Detalles del préstamo</div>
            </div>
          </a>
          <a href="javascript:void(0)" onclick="showStep(2)" class="btn btn-lg btn-alt-secondary bg-transparent w-100 text-start fs-sm d-flex align-items-center justify-content-between gap-3 step-button" data-step="2">
            <div class="flex-grow-0 rounded-circle border border-3 border-primary d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
              2
            </div>
            <div class="flex-grow-1">
              <div class="text-primary">Información del Cliente</div>
              <div class="fw-normal">Datos del cliente</div>
            </div>
          </a>
          <a href="javascript:void(0)" onclick="showStep(3)" class="btn btn-lg btn-alt-secondary bg-transparent w-100 text-start fs-sm d-flex align-items-center justify-content-between gap-3 step-button" data-step="3">
            <div class="flex-grow-0 rounded-circle border border-3 border-primary d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
              3
            </div>
            <div class="flex-grow-1">
              <div class="text-primary">Pagos Realizados</div>
              <div class="fw-normal">Historial de pagos</div>
            </div>
          </a>
        </nav>

        <!-- Step 1: Información del Préstamo -->
        <div id="step1" class="step-content">
          <div class="block-header block-header-default">
            <h3 class="block-title">Información del Préstamo</h3>
          </div>
          <div class="block-header block-header-default">
            <a href="{{ route('prestamos.generarBoleta', $prestamo->id) }}" class="btn btn-primary" target="_blank">Imprimir Contrato </a>
          </div>
          <div class="block-content block-content-full">
            <table class="table table-striped table-borderless">
              <thead>
                <tr>
                  <th colspan="2">Detalles del Préstamo</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 20%;">Monto del Préstamo</td>
                  <td>{{ $prestamo->monto }} Bs</td>
                </tr>
                <tr>
                  <td>Interés</td>
                  <td>{{ $prestamo->interes_calculado }} Bs</td>
                </tr>
                <tr>
                  <td>Total Pagar</td>
                  <td>{{ $prestamo->total_pagar }} Bs</td>
                </tr>
                <tr>
                  <td>Cantidad de Meses</td>
                  <td>{{ $prestamo->meses }}</td>
                </tr>
                <tr>
                  <td>Fecha de Inicio</td>
                  <td>{{ $prestamo->fecha_inicio }}</td>
                </tr>
                <tr>
                  <td>Fecha de Vencimiento</td>
                  <td>{{ $prestamo->fecha_fin }}</td>
                </tr>
                <tr>
                  <td>Estado</td>
                  <td>{{ $prestamo->estado }}</td>
                </tr>
              </tbody>
            </table>
                          <!-- Botón para cancelar el préstamo -->
              <form action="{{ route('prestamos.cancelar', $prestamo->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas cancelar este préstamo?');">
                @csrf
                @method('PATCH')
                <button type="button" class="btn btn-warning" id="cancelarPrestamoBtn">Cancelar Préstamo</button>
              </form>


            <!-- Botón para abrir el modal de la prenda -->
            <button type="button" class="btn btn-dark btn-lg" data-bs-toggle="modal" data-bs-target="#prendaModal">
              Ver Prenda
            </button>
          </div>
        </div>

        <!-- Step 2: Información del Cliente -->
        <div id="step2" class="step-content d-none">
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
                  <td>{{ $prestamo->cliente->nombre }} {{ $prestamo->cliente->apellidos }}</td>
                </tr>
                <tr>
                  <td>{{ $prestamo->cliente->tipo_documento->caracteristica->nombre }}</td>
                  <td>{{ $prestamo->cliente->numero_identificacion }}</td>
                </tr>
                <tr>
                  <td>Teléfono</td>
                  <td>{{ $prestamo->cliente->telefono }}</td>
                </tr>
                <tr>
                  <td>Dirección</td>
                  <td>{{ $prestamo->cliente->domicilio }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
<!-- Step 3: Pagos Realizados -->
<div id="step3" class="step-content d-none">
  <div class="block-header block-header-default">
    <h3 class="block-title">Pagos Realizados</h3>
  </div>
  <div class="block-header block-header-default">
    <a href="{{ route('prestamo.boletaLiquidado', $prestamo->id) }}" class="btn btn-primary" target="_blank">Imprimir Recibo</a>
  </div>
  <div class="block-content block-content-full">
    <table class="table table-striped table-borderless">
      <thead>
        <tr>
          <th>#</th>
          <th>Monto</th>
          <th>Fecha de Pago</th>
          <th>Estado</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($prestamo->pagos as $pago)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $pago->monto_pagado }}</td>
            <td>{{ $pago->fecha_pago }}</td>
            <td>{{ $pago->pagado ? 'Pagado' : 'Pendiente' }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="text-center">No hay pagos registrados.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#abonarModal">
      Abono
    </button>
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#liquidarModal">
      Liquidar
    </button>
  </div>
</div>

<!-- Modal: Abonar a Capital -->
<div class="modal fade" id="abonarModal" tabindex="-1" aria-labelledby="abonarModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="abonarModalLabel">Abono</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('pagos.abonar', $prestamo->id) }}" method="POST" id="abonarForm">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="monto_abono" class="form-label">Monto a Abonar</label>
            <input type="number" step="0.01" class="form-control" id="monto_abono" name="monto_abono" required>
          </div>
          <div class="mb-3">
            <label for="fecha_abono" class="form-label">Fecha del Abono</label>
            <input type="date" class="form-control" id="fecha_abono" name="fecha_abono" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Abonar</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal: Liquidar Préstamo -->
<div class="modal fade" id="liquidarModal" tabindex="-1" aria-labelledby="liquidarModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="liquidarModalLabel">Liquidar Préstamo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('pagos.liquidar', $prestamo->id) }}" method="POST" id="liquidarForm">
        @csrf
        <div class="modal-body">
          <p>¿Estás seguro de que deseas liquidar el préstamo por el total de <strong>{{ $prestamo->total_pagar }}</strong> Bs?</p>
          <input type="hidden" name="monto_liquidacion" value="{{ $prestamo->total_pagar }}">
          <div class="mb-3">
            <label for="fecha_abono" class="form-label">Fecha de Liquidación</label>
            <input type="date" class="form-control" id="fecha_abono" name="fecha_abono" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-danger">Liquidar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Step 3: Pagos Realizados -->
<div id="step3" class="step-content d-none">
  <div class="block-header block-header-default">
    <h3 class="block-title">Pagos Realizados</h3>
  </div>
  <div class="block-content block-content-full">
    <table class="table table-striped table-borderless">
      <thead>
        <tr>
          <th>#</th>
          <th>Monto</th>
          <th>Fecha de Pago</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($prestamo->pagos as $pago)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $pago->monto_pagado }}</td>
            <td>{{ $pago->fecha_pago }}</td>
            <td>{{ $pago->pagado ? 'Pagado' : 'Pendiente' }}</td>
            <td>
              <button type="button" class="btn btn-danger" onclick="eliminarPago({{ $pago->id }})">
                  Eliminar
              </button>
          </td>
          
          </tr>
        @empty
          <tr>
            <td colspan="4" class="text-center">No hay pagos registrados.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#abonarModal">
      Abonar a Capital
    </button>
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#liquidarModal">
      Liquidar
    </button>
  </div>
</div>

<!-- Modal: Abonar a Capital -->
<div class="modal fade" id="abonarModal" tabindex="-1" aria-labelledby="abonarModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="abonarModalLabel">Abonar a Capital</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('pagos.abonar', $prestamo->id) }}" method="POST" id="abonarForm">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="monto_abono" class="form-label">Monto a Abonar</label>
            <input type="number" step="0.01" class="form-control" id="monto_abono" name="monto_abono" required>
          </div>
          <div class="mb-3">
            <label for="fecha_liquidar" class="form-label">Fecha del Abono</label>
            <input type="date" class="form-control" id="fecha_liquidar" name="fecha_liquidar" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Abonar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal: Liquidar -->
<div class="modal fade" id="liquidarModal" tabindex="-1" aria-labelledby="liquidarModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="liquidarModalLabel">Liquidar Préstamo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('pagos.liquidar', $prestamo->id) }}" method="POST">
        @csrf
        <div class="modal-body">
          <p>¿Está seguro de que desea liquidar el préstamo?</p>
          <p><strong>Total a Pagar:</strong> {{ $prestamo->total_pagar }} Bs</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-danger">Liquidar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal: Detalles de la Prenda -->
<div class="modal fade" id="prendaModal" tabindex="-1" aria-labelledby="prendaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="prendaModalLabel">Detalles de la Prenda</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-striped table-borderless">
          <thead>
            <tr>
              <th colspan="2">Información de la Prenda</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="width: 20%;">Nombre de la Prenda</td>
              <td>{{ $prestamo->prenda ? $prestamo->prenda->descripcion : 'No disponible' }}</td>
            </tr>
            <tr>
              <td>Descripción</td>
              <td>{{ $prestamo->prenda ? $prestamo->prenda->observaciones : 'No disponible' }}</td>
            </tr>
            <tr>
              <td>Estado</td>
              <td>{{ $prestamo->prenda ? $prestamo->prenda->estado : 'No disponible' }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('js')
<script>
  document.getElementById('cancelarPrestamoBtn').addEventListener('click', function() {
      Swal.fire({
          title: '¿Estás seguro?',
          text: "¡Esta acción cancelará el préstamo!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Sí, cancelar',
          cancelButtonText: 'No, mantener'
      }).then((result) => {
          if (result.isConfirmed) {
              // Realiza la petición para cancelar el préstamo
              cancelarPrestamo();
          }
      })
  });
  
  function cancelarPrestamo() {
      // Puedes usar Axios, Fetch o un formulario para hacer la solicitud de cancelación
      fetch('{{ route("prestamos.cancelar", $prestamo->id) }}', {
          method: 'POST',
          headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Content-Type': 'application/json',
          },
          body: JSON.stringify({
              prestamo_id: {{ $prestamo->id }},
          })
      }).then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire(
                    '¡Cancelado!',
                    'El préstamo ha sido cancelado.',
                    'success'
                );
                // Recargar la página o actualizar el estado del préstamo dinámicamente
                location.reload();
            } else {
                Swal.fire(
                    'Error',
                    'Hubo un problema al cancelar el préstamo.',
                    'error'
                );
            }
        });
  }
  </script>
  
<script src="{{ asset('assets/js/oneui.app.min.js') }}"></script>
<script src="{{ asset('assets/js/lib/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script>
  function showStep(step) {
    document.querySelectorAll('.step-content').forEach((content) => {
      content.classList.add('d-none');
    });
    document.querySelectorAll('.step-button').forEach((button) => {
      button.classList.remove('text-primary');
      button.querySelector('.rounded-circle').classList.add('border-primary');
    });
    document.getElementById('step' + step).classList.remove('d-none');
    document.querySelector('.step-button[data-step="' + step + '"]').classList.add('text-primary');
    document.querySelector('.step-button[data-step="' + step + '"] .rounded-circle').classList.remove('border-primary');
  }
  
  document.addEventListener('DOMContentLoaded', () => {
    showStep(1); // Start with step 1 visible
  });
  
  document.addEventListener('DOMContentLoaded', function () {
    var abonarModal = document.getElementById('abonarModal');
    var totalAPagar = {{ $prestamo->total_pagar }}; // Total a pagar

    abonarModal.addEventListener('show.bs.modal', function (event) {
      // Establecer la fecha del abono al valor actual
      var fechaAbono = document.getElementById('fecha_abono');
      var today = new Date().toISOString().split('T')[0];
      fechaAbono.value = today;
      var fechaLiquidar = document.getElementById('fecha_liquidar');
      var today = new Date().toISOString().split('T')[0];
      fechaLiquidar.value = today;
      // Validar el monto abonado
      var montoAbonoInput = document.getElementById('monto_abono');

      // Validación al enviar el formulario
      document.getElementById('abonarForm').addEventListener('submit', function (e) {
        var montoAbono = parseFloat(montoAbonoInput.value) || 0;

        // Sumar los pagos ya registrados
        var totalPagos = {{ $prestamo->pagos->sum('monto_pagado') }};

        if (montoAbono + totalPagos > totalAPagar) {
          e.preventDefault();
          alert('El monto a abonar no puede exceder el total a pagar.'); 
        }
      });
    });
  });
  function eliminarPago(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡Esta acción eliminará el pago!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'No, cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/pagos/${id}/eliminar`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('¡Eliminado!', data.message, 'success');
                    location.reload(); // Recarga la página para reflejar el cambio
                } else {
                    Swal.fire('Error', 'No se pudo eliminar el pago.', 'error');
                }
            });
        }
    });
}

</script>

@endpush
