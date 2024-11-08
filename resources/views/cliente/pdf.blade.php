<!-- resources/views/clientes/pdf.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Clientes</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid black;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Clientes por Orden Alfabético</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Primer Apellido</th>
                <th>Segundo Apellido</th>
                <th>Fecha de Nacimiento</th>
                <th>Teléfono</th>
                <th>Correo Electrónico</th>
                <th>Tipo de Identificación</th>
                <th>No. Identificación</th>
                <th>Fecha de Registro</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clientes as $cliente)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $cliente->nombre }}</td>
                <td>{{ $cliente->papellido }}</td>
                <td>{{ $cliente->sapellido }}</td>
                <td>{{ $cliente->fecha_nacimiento }}</td>
                <td>{{ $cliente->telefono }}</td>
                <td>{{ $cliente->correo_electronico }}</td>
                <td>{{ $cliente->tipo_documento->caracteristica->nombre ?? 'N/A' }}</td>
                <td>{{ $cliente->numero_identificacion }}</td>
                <td>{{ $cliente->created_at->format('d-m-Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
