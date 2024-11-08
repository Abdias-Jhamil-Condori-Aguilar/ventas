<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Flujo de Caja</title>
    <style>
        /* Estilos del PDF */
        body { font-family: Arial, sans-serif; font-size: 10px; background-color: #f9f9f9; }
        .container { width: 100%; padding: 20px; background-color: white; }
        h1 { text-align: center; color: #333; }
        .date-time { text-align: right; font-size: 10px; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid #ddd; padding: 5px; text-align: center; }
        th { background-color: #128bc4; color: white; }
        .footer { text-align: center; font-size: 12px; color: #555; position: fixed; bottom: 0; left: 0; right: 0; }
        img.logo { display: block; margin: 0 auto 10px; width: 150px; }
    </style>
</head>
<body>
    <div class="date-time">
        <?php date_default_timezone_set('America/La_Paz'); ?>
        Fecha de impresión: <?php echo date('d/m/Y H:i:s'); ?>
    </div>

    <div class="container">
        <!-- Encabezado -->
        <img src="{{ public_path('images/logo.JPG') }}" alt="Logo Préstamos El Amanecer" class="logo">
        <h1>Reporte de Flujo de Caja</h1>
     <table>
            <thead>
                <tr>
                    <th>Mes</th>
                    <th>Monto de Préstamos (Bs)</th>
                    <th>Monto Pagado en Pagos (Bs)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prestamosPorMes as $index => $prestamo)
                    <tr>
                        <td>{{ \Carbon\Carbon::create()->month($index + 1)->translatedFormat('F') }}</td>
                        <td>{{ number_format($prestamo, 2, ',', '.') }}</td>
                        <td>{{ number_format($pagosPorMes[$index], 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th>{{ number_format($totalPrestamos, 2, ',', '.') }} Bs</th>
                    <th>{{ number_format($totalPagos, 2, ',', '.') }} Bs</th>
                </tr>
                <tr>
                    <th>Resta</th>
                    <th colspan="2">{{ number_format($diferencia, 2, ',', '.') }} Bs</th>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
