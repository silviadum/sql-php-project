<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titlu }} | Rapoarte Admin</title>
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .back-link {
            margin-bottom: 20px;
            display: block;
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
        tr:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('admin.dashboard') }}" class="back-link">← Înapoi la Dashboard</a>
        
        <h1>{{ $titlu }}</h1>
        
        <table>
            <thead>
                <tr>
                    @foreach($coloane as $coloana)
                        <th>{{ $coloana }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($date as $rand)
                    <tr>
                        @foreach($coloane as $coloana)
                            <td>{{ $rand->$coloana }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>