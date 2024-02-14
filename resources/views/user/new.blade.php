<x-app-layout>
    <form method="POST" action="{{ route('storeSpace') }}" id="valueForm">
        @csrf
        <label for="value">Name</label>
        <input type="text" id="value" name="value" required>
        <button type="submit" style="background-color:#7b60fb;color:white;padding:10px">Save</button>
    </form>
    </button>
</x-app-layout>
