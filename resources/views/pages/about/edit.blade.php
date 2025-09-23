<x-app-layout>
    <div class="max-w-2xl mx-auto py-12">
        <h2 class="text-xl font-bold mb-4">Редактировать информацию</h2>

        <form method="POST" action="{{ route('informations.update', $information) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700">Заголовок</label>
                <input type="text" name="title" class="mt-1 block w-full border rounded-md p-2"
                       value="{{ old('title', $information->title) }}" required>
            </div>
            @error('title')
                <div class="mt-2 text-sm text-red-600 bg-red-100 border border-red-400 rounded px-4 py-2">
                    {{ $message }}
                </div>
            @enderror

            <div>
                <label class="block text-sm font-medium text-gray-700">Описание</label>
                <textarea name="text" class="mt-1 block w-full border rounded-md p-2">{{ old('text', $information->text) }}</textarea>
            </div>
            @error('text')
                <div class="mt-2 text-sm text-red-600 bg-red-100 border border-red-400 rounded px-4 py-2">
                    {{ $message }}
                </div>
            @enderror

            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md">
                Обновить
            </button>
        </form>
    </div>
</x-app-layout>
