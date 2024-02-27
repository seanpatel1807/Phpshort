<x-app-layout>
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: auto;
        }

        .center-container {
            width: 400px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .btn-custom {
            background-color: #7b60fb;
            color: #fff;
            padding: 10px;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .custom-dropdown,
        .settings-field {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-top: 5px;
        }

        .custom-dropdown {
            height: 40px;
        }

        .settings-field {
            height: 36px;
        }

        label {
            margin-bottom: 5px;
            display: block;
            font-weight: bold;
        }
    </style>

    <div class="container">
        <div class="center-container">
            <h2>Edit Link</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('link.update', ['id' => $link->id]) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label for="original_url">Original URL:</label>
                    <input type="text" class="settings-field" name="original_url" value="{{ $link->original_url }}"
                        required>
                </div>

                <div class="form-group">
                    <label for="space_id">Select Space:</label>
                    <select name="space_id" id="space_id" class="custom-dropdown" required>
                        @foreach ($allSpaces as $space)
                            <option value="{{ $space->id }}" {{ $link->space_id == $space->id ? 'selected' : '' }}>
                                {{ $space->space_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="short_url">Custom Alias (Optional):</label>
                    <input type="text" class="settings-field" name="short_url" pattern="[a-zA-Z0-9-_]+"
                        value="{{ $link->short_url }}"
                        placeholder="Only letters, numbers, dashes, and underscores are allowed." title="Custom Alias">
                </div>

                <div class="form-group">
                    <label for="click_limit">Click Limit (optional):</label>
                    <input type="number" name="click_limit" min="0"class="settings-field"
                        value="{{ $link->click_limit }}">
                </div>

                <div class="form-group"> <label for="expiration_date">Expiration Date:</label> <input type="date"
                        name="expiration_date"
                        value="{{ $link->expiration_date ? \Carbon\Carbon::parse($link->expiration_date)->format('Y-m-d') : '' }}"
                        class="settings-field" min="{{ date('Y-m-d') }}"> </div>

                @if ($link->access_type === 'password')
                    <input type="password" name="password" id="password">
                @else
                    <label for="password">Password:</label>

                    <input type="password" name="password" id="password" style="display: none">
                @endif
                <label for="access_type">Access Type:</label>
                <select name="access_type" id="access_type">
                    <option value="public">Public</option>
                    <option value="private">Private</option>
                    <option value="password">Password-Protected</option>
                </select>

                {{-- <script>
                    document.getElementById('access_type').addEventListener('change', function() {
                        var selectedValue = this.value;
                        var passwordInput = document.getElementById('password');

                        if (selectedValue === 'password') {
                            passwordInput.style.display = 'block';
                            passwordInput.setAttribute('required', 'required');
                        } else {
                            passwordInput.style.display = 'none';
                            passwordInput.removeAttribute('required');
                        }
                    });
                </script> --}}
                <div class="form-group">
                    <label for="pixels_id">Select Pixel:</label>
                    <select name="pixels_id" id="pixels_id" class="custom-dropdown">
                        @foreach ($allPixels as $pixel)
                            <option value="{{ $pixel->id }}"{{ $link->pixels_id == $pixel->id ? 'selected' : '' }}>
                                {{ $pixel->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn-custom">Update Link</button>
            </form>
        </div>
    </div>
</x-app-layout>
