<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Membri</title>
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
    <h1>Top Membri</h1>
    <table>
        <thead>
            <tr>
                <th>Nume</th>
                <th>Prenume</th>
                <th>Participări Clase</th>
                <th>Număr Abonamente</th>
                <th>Total Plătit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($membri as $membru)
                <tr>
                    <td>{{ $membru->nume }}</td>
                    <td>{{ $membru->prenume }}</td>
                    <td>{{ $membru->participari_clase }}</td>
                    <td>{{ $membru->numar_abonamente }}</td>
                    <td>{{ $membru->total_platit }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>