<x-app-layout>
    <h2>Password Protected Link</h2>
    <form method="post" action="{{ route('check-password', $link->short_url) }}">
        @csrf
        <label for="password">Enter Password:</label>
        <input type="password" name="password" required>
        <button type="submit">Submit</button>
    </form>
</x-app-layout>
