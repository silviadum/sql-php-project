<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionare Echipamente</title>
</head>
<body>
    <h1>Gestionare Echipamente</h1>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.echipamente.create') }}" class="btn-primary">Adaugă Echipament Nou</a>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Denumire</th>
                <th>Necesită Achiziție</th>
                <th>Total Bucăți</th>
                <th>Locații</th>
                <th>Acțiuni</th>
            </tr>
        </thead>
        <tbody>
            @foreach($echipamente as $echipament)
                <tr>
                    <td>{{ $echipament->id_echipament }}</td>
                    <td>{{ $echipament->denumire_echipament }}</td>
                    <td>{{ $echipament->necesita_achizitie ? 'Da' : 'Nu' }}</td>
                    <td>{{ $echipament->total_bucati ?? 0 }}</td>
                    <td>{{ $echipament->locatii ?? 'Neatribuit' }}</td>
                    <td>
                        <a href="{{ route('admin.echipamente.edit', $echipament->id_echipament) }}">Editează</a>
                        <form action="{{ route('admin.echipamente.destroy', $echipament->id_echipament) }}" 
                              method="POST" 
                              style="display:inline;"
                              onsubmit="return confirm('Sigur doriți să ștergeți acest echipament?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Șterge</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Raport Echipamente</h2>
    <a href="{{ route('admin.rapoarte.echipamente') }}" class="btn-secondary">Vezi Raport Detaliat</a>
</body>
</html>
