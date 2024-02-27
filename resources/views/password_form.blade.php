<x-app-layout>
    <h2>Password Protected Link</h2>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form method="post" action="{{ route('check-password', $link->short_url) }}">
        @csrf
        <label for="password">Enter Password:</label>
        <input type="password" name="password" required>

        @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <button type="submit">Submit</button>
    </form>
</x-app-layout>
