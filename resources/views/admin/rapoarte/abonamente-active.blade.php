<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abonamente Active</title>
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
    <h1>Abonamente Active</h1>
    <table>
        <thead>
            <tr>
                <th>Nume</th>
                <th>Prenume</th>
                <th>Tip Abonament</th>
                <th>Data Sfârșit</th>
                <th>Zile Rămase</th>
            </tr>
        </thead>
        <tbody>
            @foreach($abonamente as $abonament)
                <tr>
                    <td>{{ $abonament->nume }}</td>
                    <td>{{ $abonament->prenume }}</td>
                    <td>{{ $abonament->tip_abonament }}</td>
                    <td>{{ $abonament->data_sfarsit }}</td>
                    <td>{{ $abonament->zile_ramase }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>