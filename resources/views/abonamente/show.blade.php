<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abonamentul Tău</title>
</head>
<body>
    <h1>Abonamentul Tău Curent</h1>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    @if($abonament)
        <div class="abonament-info">
            <p><strong>Tip:</strong> {{ $abonament->tip_abonament }}</p>
            <p><strong>Valabil până la:</strong> {{ $abonament->data_sfarsit }}</p>
            <p><strong>Preț:</strong> {{ $abonament->pret }} RON</p>
            
            <form action="{{ route('abonament.anulare', $abonament->id_abonament) }}" 
                method="POST"
                onsubmit="return confirm('Sigur doriți să anulați acest abonament? Această acțiune nu poate fi anulată.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">Anulează Abonament</button>
            </form>
        </div>

        @if($zileRamase <= 7)
            <div style="color: orange;">
                <p>Abonamentul tău expiră în curând! Nu uita să îl reînnoiești.</p>
                <a href="{{ route('abonamente.index') }}" class="btn-primary">Reînnoiește Abonament</a>
            </div>
        @endif
    @else
        <div style="color: red;">
            <p>Nu ai niciun abonament activ în acest moment.</p>
            <a href="{{ route('abonamente.index') }}" class="btn-primary">Cumpără un Abonament</a>
        </div>
    @endif

    <div class="actiuni">
        <a href="{{ route('dashboard') }}">Înapoi la Dashboard</a>
        <a href="{{ route('abonament.istoric') }}">Vezi Istoricul Abonamentelor</a>
    </div>
</body>
</html>