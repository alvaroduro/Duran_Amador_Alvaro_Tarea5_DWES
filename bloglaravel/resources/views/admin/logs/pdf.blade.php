<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Listado de Logs</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 12px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Listado de Logs</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>FECHA</th>
                <th>HORA</th>
                <th>USUARIO</th>
                <th>OPERACIÓN</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $log)
                <tr>
                    <td>{{ $log->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($log->fecha)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($log->hora)->format('H:i') }}</td>
                    <td>{{ $log->usuario }}</td>
                    <td>{{ $log->operacion }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
