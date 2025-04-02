<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistici Abonamente</title>
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
    <h1>Statistici Abonamente</h1>
    <table>
        <thead>
            <tr>
                <th>Tip Abonament</th>
                <th>Total Vândute</th>
                <th>Active Curent</th>
                <th>Venit Total</th>
                <th>Durata Medie</th>
            </tr>
        </thead>
        <tbody>
            @foreach($statistici as $statistica)
                <tr>
                    <td>{{ $statistica->tip_abonament }}</td>
                    <td>{{ $statistica->total_vandute }}</td>
                    <td>{{ $statistica->active_curent }}</td>
                    <td>{{ $statistica->venit_total }}</td>
                    <td>{{ $statistica->durata_medie }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>