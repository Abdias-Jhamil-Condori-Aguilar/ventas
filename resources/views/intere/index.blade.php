@extends('template')

@section('title', 'Listado de Intereses')

@section('content')
@include('layouts.partials.alert')

<div class="bg-body-light">
  <div class="content content-full">
      @include('configuracion.index')

  @can('crear-interes')
  <div class="container w-100 p-4 mt-3">
    <div class="mb-4">
      <a href="{{ route('intereses.create') }}">
      <button type="button" class="btn btn-dark btn-lg">Añadir nuevo registro</button>
      </a>
    </div>
  @endcan

  <div class="block block-rounded">
    <div class="block-header block-header-default">
        <h3 class="block-title">Lista de Interes del Prestamo</h3>
    </div>
    <div class="block-content block-content-full">
        <table id="interesTable" class="table table-striped table-bordered">
        
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Interés (%)</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach($intereses as $intere)
          <tr>
            <td>{{ $intere->nombre }}</td>
            <td>{{ $intere->interes }}%</td>
            <td>
              <form action="{{ route('intereses.destroy', $intere->id) }}" method="POST" id="deleteForm-{{ $intere->id }}" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $intere->id }}, '{{ $intere->nombre }}')">
                  Eliminar
                </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
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

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  // Función para mostrar la confirmación de eliminación
  function confirmDelete(interesId, interesNombre) {
      Swal.fire({
          title: '¿Estás seguro?',
          text: "Estás a punto de eliminar el interés: " + interesNombre,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Sí, eliminar',
          cancelButtonText: 'Cancelar'
      }).then((result) => {
          if (result.isConfirmed) {
              // Enviar el formulario de eliminación
              document.getElementById('deleteForm-' + interesId).submit();
          }
      });
  }

  // Mostrar mensajes de éxito o error con SweetAlert
  @if(session('success'))
      Swal.fire({
          icon: 'success',
          title: 'Éxito',
          text: '{{ session('success') }}',
          timer: 3000,
          showConfirmButton: false
      });
  @endif

  @if(session('error'))
      Swal.fire({
          icon: 'error',
          title: 'Error',
          text: '{{ session('error') }}',
          timer: 5000,
          showConfirmButton: false
      });
  @endif
</script>
@endpush
