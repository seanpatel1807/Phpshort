<x-app-layout>
    <style>
        .password-protected-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 60vh;
        }

        .password-form {
            max-width: 400px;
            width: 100%;
            padding: 20px;
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .password-form label {
            display: block;
            margin-bottom: 8px;
        }

        .password-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .password-form button {
            background-color: #7b60fb;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .password-form button:hover {
            background-color: #6c4fff;
        }
    </style>
    <div class="password-protected-container">

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form method="post" action="{{ route('check-password', $link->short_url) }}" class="password-form">
            @csrf
            <label for="password">Enter Password:</label>
            <input type="password" name="password" required>

            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <button type="submit">Submit</button>
        </form>
    </div>
</x-app-layout>
