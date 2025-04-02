<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statisticile Mele | Sala Fitness</title>
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .section {
            margin-bottom: 30px;
            padding: 20px;
            border: 1px solid #ddd;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .back-link {
            margin-bottom: 20px;
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('membri.dashboard') }}" class="back-link">← Înapoi la Dashboard</a>
        
        <h1>Statisticile Mele</h1>

        <!-- Statistici Generale -->
        <div class="section">
            <h2>Statistici Generale</h2>
            <ul>
                <li>Total clase la care ai participat: {{ $statisticiGenerale[0]->total_clase_participate }}</li>
                <li>Număr total abonamente: {{ $statisticiGenerale[0]->total_abonamente }}</li>
                <li>Total investit: {{ number_format($statisticiGenerale[0]->total_investit, 2) }} RON</li>
            </ul>
        </div>

        <!-- Statistici Clase -->
        <div class="section">
            <h2>Participare la Clase</h2>
            <table>
                <thead>
                    <tr>
                        <th>Clasă</th>
                        <th>Participări</th>
                        <th>Rată Feedback</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($statisticiClase as $statistica)
                        <tr>
                            <td>{{ $statistica->denumire_clasa }}</td>
                            <td>{{ $statistica->participari }}</td>
                            <td>{{ number_format($statistica->rata_feedback, 1) }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Istoric Abonamente -->
        <div class="section">
            <h2>Istoric Abonamente</h2>
            <table>
                <thead>
                    <tr>
                        <th>Tip Abonament</th>
                        <th>Data Început</th>
                        <th>Data Sfârșit</th>
                        <th>Durată (zile)</th>
                        <th>Preț</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($istoricAbonamente as $abonament)
                        <tr>
                            <td>{{ $abonament->tip_abonament }}</td>
                            <td>{{ $abonament->data_incepere }}</td>
                            <td>{{ $abonament->data_sfarsit }}</td>
                            <td>{{ $abonament->durata_zile }}</td>
                            <td>{{ number_format($abonament->pret, 2) }} RON</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>