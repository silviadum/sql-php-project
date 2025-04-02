<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participare Membri la Clase</title>
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
    <h1>Participare Membri la Clase</h1>
    <table>
        <thead>
            <tr>
                <th>Membru</th>
                <th>Număr Clase</th>
            </tr>
        </thead>
        <tbody>
            @foreach($participare as $membru)
                <tr>
                    <td>{{ $membru->membru }}</td>
                    <td>{{ $membru->numar_clase }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>