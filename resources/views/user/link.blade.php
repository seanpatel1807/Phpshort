<x-app-layout>
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

    @if(isset($shortUrl))
        <p>Short Link: <a href="{{ $shortUrl }}">{{ $shortUrl }}</a></p>
    @endif

    <form method="POST" action="/create-link" class="flex" style="gap:10px">
        @csrf
        <textarea class="w-full"  type="url" id="original_url" name="original_url" placeholder="Type or paste the link" required></textarea>
        <button type="submit" style="background-color:#7b60fb; padding:10px">Shorten</button>
    </form>
    
</body>
</html>
</x-app-layout>
