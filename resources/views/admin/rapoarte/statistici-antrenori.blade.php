<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistici Antrenori</title>
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
    <h1>Statistici Antrenori</h1>
    <table>
        <thead>
            <tr>
                <th>Nume</th>
                <th>Prenume</th>
                <th>Specializare</th>
                <th>Membri Personali</th>
                <th>Clase Predate</th>
                <th>Total Membri Clase</th>
            </tr>
        </thead>
        <tbody>
            @foreach($antrenori as $antrenor)
                <tr>
                    <td>{{ $antrenor->nume }}</td>
                    <td>{{ $antrenor->prenume }}</td>
                    <td>{{ $antrenor->specializare }}</td>
                    <td>{{ $antrenor->membri_personali }}</td>
                    <td>{{ $antrenor->clase_predate }}</td>
                    <td>{{ $antrenor->total_membri_clase }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>