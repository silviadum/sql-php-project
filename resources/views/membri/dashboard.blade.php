<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Membru | Sala Fitness</title>
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .welcome-message {
            margin-bottom: 30px;
        }
        .menu {
            margin-bottom: 20px;
        }
        .menu a {
            margin-right: 15px;
            text-decoration: none;
            padding: 5px 10px;
            background-color: #f0f0f0;
        }
        .section {
            margin-bottom: 30px;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .success-message {
            color: green;
            margin-bottom: 20px;
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
        .warning {
            color: orange;
        }
        .error {
            color: red;
        }
        .anulare-btn {
            padding: 5px 10px;
            background-color: #ff4444;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }
        .anulare-btn:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="welcome-message">
            <h1>Bine ai venit, {{ auth()->user()->nume }} {{ auth()->user()->prenume }}!</h1>
        </div>

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <div class="menu">
            <a href="{{ route('clase.index') }}">Vezi Clase Disponibile</a>
            <a href="{{ route('abonamente.index') }}">Cumpără Abonament</a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" style="padding: 5px 10px;">Logout</button>
            </form>
        </div>

        <!-- Secțiunea Abonament -->
        <!-- Secțiunea Abonament -->
        <div class="section">
            <h2>Abonamentul Tău</h2>
            @if(!empty($abonamentActiv))
                <div class="abonament-info">
                    <p><strong>Tip:</strong> {{ $abonamentActiv[0]->tip_abonament }}</p>
                    <p><strong>Valabil până la:</strong> {{ $abonamentActiv[0]->data_sfarsit }}</p>
                    @php
                        $zileRamase = \Carbon\Carbon::parse($abonamentActiv[0]->data_sfarsit)->diffInDays(now());
                    @endphp
                    <p>
                        <strong>Zile rămase:</strong> {{ $zileRamase }}
                    </p>

                    <form action="{{ route('abonamente.anulare', ['id' => $abonamentActiv[0]->id_abonament]) }}" 
                        method="POST"
                        onsubmit="return confirm('Sigur doriți să anulați acest abonament?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="anulare-btn">Anulează Abonament</button>
                    </form>
                </div>
            @else
                <p class="error">Nu ai niciun abonament activ!</p>
                <a href="{{ route('abonamente.index') }}">Cumpără Abonament</a>
            @endif
        </div>

        <!-- Secțiunea Clase -->
        <div class="section">
            <h2>Clasele Tale</h2>
            @if(!empty($claseleInscris))
                <table>
                    <thead>
                        <tr>
                            <th>Clasă</th>
                            <th>Antrenor</th>
                            <th>Durată</th>
                            <th>Feedback</th>
                            <th>Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($claseleInscris as $clasa)
                            <tr>
                                <td>{{ $clasa->denumire_clasa }}</td>
                                <td>{{ $clasa->antrenor_nume }} {{ $clasa->antrenor_prenume }}</td>
                                <td>{{ $clasa->durata }}</td>
                                <td>
                                    @if(!empty($clasa->feedback))
                                        {{ $clasa->feedback }}
                                    @else
                                        <form action="{{ route('membri.feedback', $clasa->id_clasa) }}" method="POST">
                                            @csrf
                                            <input type="text" name="feedback" placeholder="Adaugă feedback">
                                            <button type="submit">Trimite</button>
                                        </form>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('clase.anulare', $clasa->id_clasa) }}" 
                                          method="POST"
                                          onsubmit="return confirm('Sigur doriți să anulați înscrierea?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">Anulează Înscrierea</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Nu ești înscris la nicio clasă momentan.</p>
                <a href="{{ route('clase.index') }}">Vezi Clase Disponibile</a>
            @endif
        </div>
    </div>
</body>
</html>