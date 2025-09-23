<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Таблица информации --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-7xl">
                    <h2 class="text-xl font-bold mb-4">Информация</h2>
                    <table class="w-full table-fixed border-collapse border border-gray-500">
                        <thead class="bg-gray-200">
                        <tr>
                            <th class="border border-gray-400 px-2 py-1">ID</th>
                            <th class="border border-gray-400 px-2 py-1">Заголовок</th>
                            <th class="border border-gray-400 px-2 py-1">Описание</th>
                            <th class="border border-gray-400 px-2 py-1">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($information as $info)
                            <tr>
                                <td class="border px-2 py-1">{{ $info->id }}</td>
                                <td class="border px-2 py-1">{{ $info->title }}</td>
                                <td class="border px-2 py-1">{{ \Illuminate\Support\Str::limit($info->text, 50) }}</td>
                                <td class="border px-2 py-1 flex gap-2">
                                    <a href="{{ route('informations.edit', $info) }}"
                                       class="text-blue-600 hover:underline">Редактировать</a>

                                    <form method="POST" action="{{ route('informations.destroy', $info) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Удалить</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="max-w-xl">
                    <div class="mt-6">
                        <form method="POST" action="{{ route('informations.store') }}" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Заголовок</label>
                                <input type="text" name="title" class="mt-1 block w-full border rounded-md p-2" required>
                            </div>
                            @error('title')
                            <div class="mt-2 text-sm text-red-600 bg-red-100 border border-red-400 rounded px-4 py-2">
                                {{ $message }}
                            </div>
                            @enderror

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Описание</label>
                                <textarea name="text" class="mt-1 block w-full border rounded-md p-2"></textarea>
                            </div>
                            @error('text')
                            <div class="mt-2 text-sm text-red-600 bg-red-100 border border-red-400 rounded px-4 py-2">
                                {{ $message }}
                            </div>
                            @enderror

                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md">
                                Сохранить
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Статистика --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-7xl">
                    <h2 class="text-xl font-bold mb-4">Статистика</h2>
                    <table class="w-full table-fixed border-collapse border border-gray-500 mb-5">
                        <thead class="bg-gray-200">
                        <tr>
                            <th class="border border-gray-400 px-2 py-1">ID</th>
                            <th class="border border-gray-400 px-2 py-1">Значение</th>
                            <th class="border border-gray-400 px-2 py-1">Поля</th>
                            <th class="border border-gray-400 px-2 py-1">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($statistics as $stat)
                            <tr>
                                <td class="border border-gray-400 px-2 py-1">{{ $stat->id }}</td>
                                <td class="border border-gray-400 px-2 py-1">{{ $stat->value }}</td>
                                <td class="border border-gray-400 px-2 py-1">{{ $stat->label }}</td>
                                <td class="border border-gray-400 px-2 py-1">
                                    <form method="POST" action="{{ route('statistics.destroy', $stat) }}">
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
                    {{-- Подключение формы добавления --}}
                    @include('pages.about.partials.add-statistic-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
