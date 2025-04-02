<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Antrenor</title>
</head>
<body>
    <h1>Dashboard Antrenor</h1>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <div class="menu">
        <a href="{{ route('clase.antrenor') }}">Clasele Mele</a>
        <a href="{{ route('clase.create') }}">Creează Clasă Nouă</a>
        <a href="{{ route('antrenor.membri') }}">Membri Înscriși</a>
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>

    <div class="clase-curente">
        <h2>Clasele Tale Curente</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Denumire</th>
                    <th>Durată</th>
                    <th>Sală</th>
                    <th>Membri Înscriși</th>
                    <th>Acțiuni</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clase as $clasa)
                    <tr>
                        <td>{{ $clasa->denumire_clasa }}</td>
                        <td>{{ $clasa->durata }}</td>
                        <td>{{ $clasa->denumire_sala }}</td>
                        <td>{{ $clasa->numar_inscrisi }}/{{ $clasa->capacitate }}</td>
                        <td>
                            <a href="{{ route('clase.edit', $clasa->id_clasa) }}">Editează</a>
                            <form action="{{ route('clase.destroy', $clasa->id_clasa) }}" 
                                  method="POST" 
                                  style="display:inline;"
                                  onsubmit="return confirm('Sigur doriți să ștergeți această clasă?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Șterge</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="statistici">
        <h2>Statistici</h2>
        <ul>
            <li>Total membri înscriși: {{ $totalMembri }}</li>
            <li>Clase active: {{ $totalClase }}</li>
            <li>Membri activi în ultima săptămână: {{ $membriActivi }}</li>
        </ul>
    </div>
</body>
</html>