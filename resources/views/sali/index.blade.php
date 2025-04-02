<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionare Săli</title>
</head>
<body>
    <h1>Gestionare Săli</h1>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div style="color: red;">{{ session('error') }}</div>
    @endif

    <div class="actions">
        <a href="{{ route('sali.create') }}" class="btn-primary">Adaugă Sală Nouă</a>
        <a href="{{ route('sali.ocupare') }}" class="btn-secondary">Vezi Raport Ocupare</a>
    </div>

    <table border="1">
        <thead>
            <tr>
                <th>Denumire</th>
                <th>Capacitate</th>
                <th>Clase Active</th>
                <th>Antrenori Activi</th>
                <th>Echipamente</th>
                <th>Acțiuni</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sali as $sala)
                <tr>
                    <td>{{ $sala->denumire_sala }}</td>
                    <td>{{ $sala->capacitate }}</td>
                    <td>{{ $sala->numar_clase }}</td>
                    <td>{{ $sala->antrenori_activi }}</td>
                    <td>{{ $sala->echipamente ?? 'Fără echipamente' }}</td>
                    <td>
                        <a href="{{ route('sali.edit', $sala->id_sala) }}">Editează</a>
                        <form action="{{ route('sali.destroy', $sala->id_sala) }}" 
                              method="POST" 
                              style="display:inline;"
                              onsubmit="return confirm('Sigur doriți să ștergeți această sală?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Șterge</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>