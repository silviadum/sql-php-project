<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clase Disponibile | Sala Fitness</title>
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border: 2px solid black;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: white;
        }
        .inscrie-btn {
            padding: 5px 10px;
            background-color: white;
            border: 1px solid black;
            cursor: pointer;
            text-decoration: none;
            color: black;
        }
        .inscrie-btn:hover {
            background-color: #f0f0f0;
        }
        h1 {
            font-size: 36px;
            margin-bottom: 30px;
        }
        .grad-ocupare {
            margin-top: 20px;
        }
        .grad-ocupare-ridicat {
            color: red;
        }
        .grad-ocupare-mediu {
            color: orange;
        }
        .grad-ocupare-scazut {
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Clase Disponibile</h1>

        @if(session('success'))
            <div style="color: green; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="color: red; margin-bottom: 20px;">
                {{ session('error') }}
            </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Denumire Clasă</th>
                    <th>Durata</th>
                    <th>Antrenor</th>
                    <th>Sală</th>
                    <th>Capacitate</th>
                    <th>Număr Înscriși</th>
                    <th>Acțiuni</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clase as $clasa)
                    <tr>
                        <td>{{ $clasa->denumire_clasa }}</td>
                        <td>{{ $clasa->durata }}</td>
                        <td>{{ $clasa->antrenor_nume }} {{ $clasa->antrenor_prenume }}</td>
                        <td>Sala {{ $clasa->id_sala }}</td>
                        <td>{{ $clasa->capacitate }}</td>
                        <td>{{ $clasa->numar_inscrisi }}</td>
                        <td>
                            @if($clasa->numar_inscrisi < $clasa->capacitate)
                                <form action="{{ route('clase.inscriere', $clasa->id_clasa) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inscrie-btn">Înscrie-te</button>
                                </form>
                            @else
                                <span style="color: red;">Clasă plină</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="grad-ocupare">
            <p>
                <span class="grad-ocupare-ridicat">■</span> Grad ocupare ridicat (≥80%)<br>
                <span class="grad-ocupare-mediu">■</span> Grad ocupare mediu (50-79%)<br>
                <span class="grad-ocupare-scazut">■</span> Grad ocupare scăzut (<50%)
            </p>
        </div>
    </div>
</body>
</html>