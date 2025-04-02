<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utilizare Săli</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h1>Utilizare Săli</h1>
    <table>
        <thead>
            <tr>
                <th>Denumire Sală</th>
                <th>Capacitate</th>
                <th>Număr Clase</th>
                <th>Număr Echipamente</th>
                <th>Total Echipamente</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sali as $sala)
                <tr>
                    <td>{{ $sala->denumire_sala }}</td>
                    <td>{{ $sala->capacitate }}</td>
                    <td>{{ $sala->numar_clase }}</td>
                    <td>{{ $sala->numar_echipamente }}</td>
                    <td>{{ $sala->total_echipamente }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>