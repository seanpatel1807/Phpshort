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
            padding: 10px
        }

        .form-group {
            margin-bottom: 20px;
        }

        .custom-dropdown {
            width: 100%;
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
                    <input type="text" class="form-control" name="original_url" value="{{ $link->original_url }}"
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
                    <input type="text" class="form-control" name="short_url" pattern="[a-zA-Z0-9-_]+"
                        placeholder="Only letters, numbers, dashes, and underscores are allowed." title="Custom Alias">
                </div>

                <button type="submit" class="btn btn-custom">Update Link</button>
            </form>
        </div>
    </div>
</x-app-layout>
