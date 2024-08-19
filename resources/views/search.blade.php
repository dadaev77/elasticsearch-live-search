<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Search</title>
    <link rel="stylesheet" href="{{ asset('css/search.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="search-container">
    <form>
        <input type="text" id="search" placeholder="Поиск..." autocomplete="off">
    </form>
    <ul id="results"></ul>
</div>

<script>
    $(document).ready(function() {
        $('#search').on('input', function() {
            var query = $(this).val().trim();

            if (query.length > 0) {
                $.ajax({
                    url: '{{ route("search") }}',
                    method: 'GET',
                    data: { query: query },
                    success: function(data) {
                        $('#results').empty().show();
                        if (data.length > 0) {
                            data.forEach(function(item) {
                                $('#results').append('<li>' + item._source.my_field + '</li>');
                            });
                        } else {
                            $('#results').append('<li>Результаты не найдены</li>');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                $('#results').empty().hide();
            }
        });

        // Убираем результаты при клике за пределами поиска
        $(document).on('click', function(event) {
            if (!$(event.target).closest('.search-container').length) {
                $('#results').hide();
            }
        });

        // Выбор результата кликом
        $(document).on('click', '#results li', function() {
            $('#search').val($(this).text());
            $('#results').empty().hide();
        });
    });
</script>
</body>
</html>