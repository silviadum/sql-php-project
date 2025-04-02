<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venituri pe Antrenor</title>
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            margin-bottom: 30px;
            font-size: 36px;
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
    <div class="container">
        <h1>Venituri pe Antrenor</h1>
        <table>
            <thead>
                <tr>
                    <th>Antrenor</th>
                    <th>Venit Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($venituri as $venit)
                    <tr>
                        <td>{{ $venit->antrenor }}</td>
                        <td>{{ $venit->venit_total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>