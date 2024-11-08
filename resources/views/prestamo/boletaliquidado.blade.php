<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boleta de Empeño {{ $prestamo->prenda->descripcion }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            font-size: 0.75rem;
        }
        .container {
            max-width: 100%;
            margin: 5px auto;
            padding: 8px;
            background-color: #fff;
            border-radius: 3px;
            box-shadow: 0 2px 3px rgba(0,0,0,0.1);
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 8px;
        }
        .header h2 {
            font-size: 1rem;
            text-decoration: underline;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #b3cde0;
            padding: 3px;
        }
        .blue-background {
            background-color: #b3cde0;
            text-align: center;
            font-weight: bold;
        }
        .signature-group {
            display: flex;
            justify-content: space-between;
            margin-top: 100px; /* Ajuste de margen superior */
        }
        .signature-left, .signature-right {
            text-align: center;
            width: 40%; /* Ajuste de ancho para que las firmas no sean demasiado grandes */
        }
        .signature-line {
            border-top: 1px solid black;
            margin-bottom: 10px;
            width: 100%;
        }
        img.logo {
            display: block;
            margin: 0 auto 3px auto;
            width: 60px;
        }
        h4 {
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        p {
            margin-bottom: 4px;
        }
        @media print {
            .container {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <img src="{{ public_path() . '/images/logo.JPG' }}" alt="Logo Préstamos El Amanecer" class="logo">
        <h2>BOLETA DE EMPEÑO</h2>
        <p>Prestamos "El Amanecer"</p>
        <p>Av. Panamericana - Cercado, Cochabamba</p>
    </div>

    <!-- Datos del Cliente -->
    <h4>Datos del Cliente</h4>
    <table class="table table-bordered">
        <tr>
            <td class="blue-background">Nombre:</td>
            <td colspan="3">{{ $cliente->nombre }}</td>
        </tr>
        <tr>
            <td class="blue-background">Apellido(s):</td>
            <td>{{ $cliente->papellido }} {{ $cliente->sapellido }}</td>
            <td class="blue-background">F. Nacimiento:</td>
            <td>{{ $cliente->fecha_nacimiento }}</td>
        </tr>
        <tr>
            <td class="blue-background">Identificación:</td>
            <td>{{ $cliente->tipo_documento->caracteristica->nombre }}</td>
            <td class="blue-background">N°:</td>
            <td>{{ $cliente->numero_identificacion }}</td>
        </tr>
        <tr>
            <td class="blue-background">Correo:</td>
            <td >{{ $cliente->correo_electronico }}</td>
            <td class="blue-background">Teléfono:</td>
            <td>{{ $cliente->telefono }}</td>
        </tr>
        <tr> 
            <td class="blue-background">Ciudad:</td>
            <td>{{ $cliente->ciudad }}</td>
             <td class="blue-background">Domicilio:</td>
            <td colspan="3">{{ $cliente->domicilio }}</td>
        </tr>
    </table>

    <h4>Préstamo</h4>
    <table class="table table-bordered">
        <tr>
            <td class="blue-background">Monto Prestado:</td>
            <td>{{ $prestamo->monto }} Bs.</td>
            <td class="blue-background">Interes:</td>
            <td>{{ $prestamo->interes->interes }}%</td>
            <td class="blue-background">Interes calculado</td>
            <td>{{ $prestamo->interes_calculado }} Bs.</td>
            <td class="blue-background">Total a pagar:</td>
            <td>{{ $prestamo->total_pagar }} Bs.</td>
        </tr>
    </table>

    <!-- Garantía -->
    <h4>Garantía</h4>
    <table class="table table-bordered">
        <thead>
            <tr class="blue-background">
                <th>Código</th>
                <th>Descripción</th>
                <th>Modelo</th>
                <th>Serie</th>
                <th>Categoría</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $prenda->codigo }}</td>
                <td>{{ $prenda->descripcion }}</td>
                <td>{{ $prenda->modelo }}</td>
                <td>{{ $prenda->serie }}</td>
                <td>{{ $prenda->categoriaProducto->caracteristica->nombre }}</td>
                <td>{{ $prenda->observaciones }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Pagos Realizados -->
    <h4>Pagos Realizados</h4>
    <table class="table table-bordered">
        <thead>
            <tr class="blue-background">
                <th>Fecha de Pago</th>
                <th>Monto (Bs)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pagos as $pago)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') }}</td>
                    <td>{{ number_format($pago->monto_pagado, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="text-center">No se han realizado pagos</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Firmas -->
    <div class="signature-group">
        <div class="signature-left">
            <div class="signature-line"></div>
            <p>Firma del Cliente</p>
        </div>
        
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
