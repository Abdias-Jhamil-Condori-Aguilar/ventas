<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documento Privado de Compra y Venta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .text-underline {
            text-decoration: underline;
        }
        .border-top {
            border-top: 1px solid black;
        }
        h3 {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <h3 class="text-center text-uppercase" >DOCUMENTO PRIVADO DE COMPRA Y VENTA</h3>

        <p>
            Conste por el tenor del presente <strong>DOCUMENTO PRIVADO DE COMPRA Y VENTA CON PACTO DE RESCATE</strong>, que debidamente reconocida las firmas y rúbricas, surtirá efectos de instrumento público de acuerdo a las siguientes cláusulas y condiciones:
        </p>

        <p><strong>PRIMERA.- (PARTES CONTRATANTES)</strong>.- Son partes del presente documento:</p>
        <p>1.1. El o La Sr(a): {{ $prestamo->cliente->nombre }} {{ $prestamo->cliente->papellido }} {{ $prestamo->cliente->sapellido }} con {{ $prestamo->cliente->tipo_documento->caracteristica->nombre }}: {{ $prestamo->cliente->numero_identificacion }}, mayor de edad, con domicilio en {{ $prestamo->cliente->domicilio }} en la ciudad de {{ $prestamo->cliente->ciudad }}, quien para el presente documento se denominará como el o la <strong>VENDEDOR(A)</strong>.</p>
        
        <p>1.2. La Sra. <strong>SILVIA YAPURA UGARTE</strong> con C.I. N° <strong>7843765 Cbba.</strong>, soltera, mayor de edad, hábil por ley, vecina de esta ciudad, quien a efectos del presente documento se denominará como la <strong>COMPRADORA</strong>.</p>

        <p><strong>SEGUNDA.- (ANTECEDENTES)</strong>.- Se hace constar que el <strong>VENDEDOR(A)</strong> declara y asegura que es <strong>LEGÍTIMO(A) PROPIETARIO(A)</strong> de los bienes que a continuación detalla, así mismo también demuestra su derecho propietario a través de la nota de venta o garantía de los presentes artefactos, como son y así también se describe sus características:   Descripción:{{ $prestamo->prenda->descripcion }} <br> Modelo: {{ $prestamo->prenda }}
        </p>

        <p class="border-top mb-4" style="height: 100px;"></p>

        <p><strong>TERCERA.- (OBJETO, PLAZO Y CONSOLIDACIÓN DE DERECHOS)</strong>.- A través del presente documento el o la <strong>VENDEDOR(A)</strong> declara que sin que medie ningún tipo de presión violencia ni dolo y es más ejerciendo su libre y espontánea voluntad por vender y no convenir a sus intereses enajena el valor con pacto de rescate el bien o bienes descritos en la cláusula segunda del presente documento a favor de la <strong>COMPRADORA</strong> por el monto libremente convenido entre las partes, bajo el cual se declara que el <strong>VENDEDOR(A)</strong> recibe a su entera satisfacción y en moneda de curso legal.</p>

        <p>
            Como el presente documento se realiza con Pacto de Rescate, el <strong>VENDEDOR(A)</strong> tiene plazo de {{ $prestamo->meses }} MES (MESES) a partir de la fecha para poder recuperar los bienes mencionados de acuerdo al Código Civil en su Art. 641 y siguientes. Pero así mismo el <strong>VENDEDOR(A)</strong> tendrá que reconocer TODOS LOS GASTOS HECHOS POR MANTENIMIENTO, RESTITUCIÓN ENTRE OTROS.
        </p>

        <p>Una vez vencido el plazo otorgado de {{ $prestamo->meses }} MES (MESES) la <strong>COMPRADORA</strong> consolidará su derecho propietario pudiendo enajenar en venta pública o privada o a la persona que crea conveniente sin que esto implique obligación alguna de las Leyes Civiles en cuanto al pacto de rescate.</p>

        <p><strong>CUARTA.- (CONFORMIDAD)</strong>.- En señal de conformidad con todos y cada una de las Cláusulas pactadas y amparada en las leyes vigentes, suscriben las partes.</p>

        <p class="text-center">Cochabamba, 30 de Octubre de 2024</p>

        <div class="row text-center mt-4">
            <div class="col-6">
                <p class="mb-0"><strong>VENDEDOR(A)</strong></p>
                <p class="border-top mt-4">Nombre: {{ $prestamo->cliente->nombre }} {{ $prestamo->cliente->papellido }} {{ $prestamo->cliente->sapellido }}</p>
                <p class="border-top">{{ $prestamo->cliente->tipo_documento->caracteristica->nombre }}: {{ $prestamo->cliente->numero_identificacion }}</p>
            </div>
            <div class="col-6">
                <p class="mb-0"><strong>COMPRADORA</strong></p>
            </div>
        </div>
    </div>
</body>
</html>
