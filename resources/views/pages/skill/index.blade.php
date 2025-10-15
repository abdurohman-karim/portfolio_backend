<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Таблица информации --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-7xl">
                    <h2 class="text-xl font-bold mb-4">Навыки</h2>
                    <table class="w-full table-fixed border-collapse border border-gray-500">
                        <thead class="bg-gray-200">
                        <tr>
                            <th class="border border-gray-400 px-2 py-1">ID</th>
                            <th class="border border-gray-400 px-2 py-1">Название</th>
                            <th class="border border-gray-400 px-2 py-1">URL</th>
                            <th class="border border-gray-400 px-2 py-1">Иконка</th>
                            <th class="border border-gray-400 px-2 py-1">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($skills as $skill)
                            <tr>
                                <td class="border border-gray-400 px-2 py-1">{{ $skill->id }}</td>
                                <td class="border border-gray-400 px-2 py-1">{{ $skill->name }}</td>
                                <td class="border border-gray-400 px-2 py-1">{{ $skill->url }}</td>
                                <td class="border border-gray-400 px-2 py-1 text-center">
                                    @if ($skill->icon)
                                        <img src="{{ asset('storage/icons/' . $skill->icon) }}" alt="{{ $skill->name }}" class="h-8 inline-block">
                                    @else
                                        <span class="text-gray-400 italic">Нет</span>
                                    @endif
                                </td>
                                <td class="border border-gray-400 px-2 py-1">
                                    <form method="POST" action="{{ route('skill.destroy', $skill) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:underline" type="submit">Удалить</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="max-w-xl">
                    <div class="mt-6">
                        <form method="POST" action="{{ route('skill.store') }}" class="space-y-4" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Название</label>
                                <input type="text" name="name" class="mt-1 block w-full border rounded-md p-2" required>
                                @error('name')
                                <div class="mt-2 text-sm text-red-600 bg-red-100 border border-red-400 rounded px-4 py-2">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">URL</label>
                                <input type="text" name="url" class="mt-1 block w-full border rounded-md p-2">
                                @error('url')
                                <div class="mt-2 text-sm text-red-600 bg-red-100 border border-red-400 rounded px-4 py-2">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Иконка</label>
                                <input type="file" name="icon" class="mt-1 block w-full border rounded-md p-2">
                                @error('icon')
                                <div class="mt-2 text-sm text-red-600 bg-red-100 border border-red-400 rounded px-4 py-2">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md">
                                Сохранить
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
