<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membri și Antrenori</title>
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
    <h1>Membri și Antrenori</h1>
    <table>
        <thead>
            <tr>
                <th>Nume</th>
                <th>Prenume</th>
                <th>Email</th>
                <th>Antrenor</th>
                <th>Specializare</th>
            </tr>
        </thead>
        <tbody>
            @foreach($membri as $membru)
                <tr>
                    <td>{{ $membru->nume }}</td>
                    <td>{{ $membru->prenume }}</td>
                    <td>{{ $membru->email }}</td>
                    <td>{{ $membru->antrenor }}</td>
                    <td>{{ $membru->specializare }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>