{{-- resources/views/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Redirecting...</title>
    <script>
        // Redirect immediately to the desired page.
        window.location.href = "{{ route('posts.index') }}";
    </script>
</head>
<body>
    <!-- Fallback message if JavaScript is disabled -->
    <noscript>
        If you are not redirected automatically, follow this <a href="{{ route('posts.index') }}">link to the posts page</a>.
    </noscript>
</body>
</html>
