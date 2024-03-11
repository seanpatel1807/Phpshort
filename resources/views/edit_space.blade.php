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
            <h2>Edit Space</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-danger">
                    {{ session('success') }}
                </div>
            @endif


            <form action="{{ route('spaces.update', ['id' => $space->id]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="space_name">Name :</label>
                    <input type="text" class="form-control" name="space_name" value="{{ $space->space_name }}"
                        required>
                </div>

                <button type="submit" class="btn btn-custom">Update Space</button>
            </form>
        </div>
    </div>
</x-app-layout>
