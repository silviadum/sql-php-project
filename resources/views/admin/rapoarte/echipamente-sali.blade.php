<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Echipamente pe Săli</title>
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
        .editable {
            cursor: pointer;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Echipamente pe Săli</h1>
        @foreach($saliEchipamente as $sala => $echipamente)
            <h2>{{ $sala }}</h2>
            <table>
                <thead>
                    <tr>
                        <th>Echipament</th>
                        <th>Număr Bucăți</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($echipamente as $echipament)
                        <tr>
                            <td class="editable" data-name="denumire_echipament" data-id="{{ $echipament->id_echipament }}">{{ $echipament->denumire_echipament }}</td>
                            <td class="editable" data-name="bucati" data-id="{{ $echipament->id_echipament }}">{{ $echipament->bucati }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
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
                                url: '{{ route("echipamente-sali.update") }}',
                                method: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    id_echipament: id,
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