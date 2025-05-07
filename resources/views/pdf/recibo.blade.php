<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo PDF</title>
    <style>
        body { font-family: DejaVu Sans; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Recibo de {{ $recibo->cliente->nombres_cliente }}</h2>
    <p><strong>Fecha:</strong> {{ $recibo->fecha }}</p>
    <p><strong>Total:</strong> ${{ number_format($recibo->total, 2) }}</p>

    <h3>Datos del Cliente</h3>
    <p><strong>Nombre:</strong> {{ $recibo->cliente->nombres_cliente }} {{ $recibo->cliente->apellidos_cliente }}</p>
    <p><strong>DUI:</strong> {{ $recibo->cliente->dui_cliente }}</p>
    <p><strong>Teléfono:</strong> {{ $recibo->cliente->telefono_cliente }}</p>
    <p><strong>Correo:</strong> {{ $recibo->cliente->email_cliente }}</p>

    <h3>Productos Comprados</h3>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recibo->productos as $producto)
                <tr>
                    <td>{{ $producto->nombre_producto }}</td>
                    <td>{{ $producto->pivot->cantidad }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
