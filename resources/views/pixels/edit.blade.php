<x-app-layout>
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: auto;
        }

        .form-container {
            width: 400px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
    </style>

    <div class="container">
        <div class="form-container">
            <h2>Create Pixel</h2>

            <form action="{{ route('pixels.update', ['id' => $pixel->id]) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" required>
                </div>

                <div class="form-group">
                    <label for="type">Type:</label>
                    <select name="type" required>
                        <option value="adrol">Adroll</option>
                        <option value="bing">Bing</option>
                        <option value="facebook">Facebook</option>
                        <option value="google_ads">Google Ads</option>
                        <option value="linkedin">LinkedIn</option>
                        <option value="pinterest">Pinterest</option>
                        <option value="quota">Quota</option>
                        <option value="X">X</option>
                    </select>
                </div>

                <button type="submit" style="background-color: #7b60fb; padding:10px">Submit</button>
            </form>
        </div>
    </div>
</x-app-layout>
