<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistici Abonamente</title>
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .back-link {
            margin-bottom: 20px;
            display: block;
            text-decoration: none;
            color: #333;
        }
        .stats-card {
            border: 1px solid #ddd;
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .stats-header {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        .editable {
            cursor: pointer;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <a href="{{ route('admin.dashboard') }}" class="back-link">← Înapoi la Dashboard</a>
        <h1>Statistici Abonamente</h1>

        <div class="stats-grid">
            @foreach($statistici as $statistica)
                <div class="stats-card">
                    <div class="stats-header">{{ $statistica->tip_abonament }}</div>
                    <p>Total vândute: <span class="editable" data-name="total_vandute" data-id="{{ $statistica->id }}">{{ $statistica->total_vandute }}</span></p>
                    <p>Active curent: <span class="editable" data-name="active_curent" data-id="{{ $statistica->id }}">{{ $statistica->active_curent }}</span></p>
                    <p>Venit total: <span class="editable" data-name="venit_total" data-id="{{ $statistica->id }}">{{ $statistica->venit_total }}</span></p>
                    <p>Durata medie: <span class="editable" data-name="durata_medie" data-id="{{ $statistica->id }}">{{ $statistica->durata_medie }}</span></p>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.editable').click(function() {
                var $this = $(this);
                var originalValue = $this.text();
                var name = $this.data('name');
                var id = $this.data('id');
                var input = $('<input>', {
                    type: 'text',
                    value: originalValue,
                    blur: function() {
                        var newValue = $(this).val();
                        if (newValue !== originalValue) {
                            $.ajax({
                                url: '{{ route("statistici-abonamente.update") }}',
                                method: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    id: id,
                                    [name]: newValue
                                },
                                success: function(response) {
                                    $this.text(newValue);
                                    alert(response.success);
                                }
                            });
                        } else {
                            $this.text(originalValue);
                        }
                    },
                    keyup: function(e) {
                        if (e.which === 13) {
                            $(this).blur();
                        }
                    }
                }).appendTo($this.empty()).focus();
            });
        });
    </script>
</body>
</html>