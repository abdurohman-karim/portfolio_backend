<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Добавить статистику
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Заполните поля и нажмите сохранить
        </p>
    </header>

    <form method="POST" action="{{ route('statistics.store') }}" class="mt-6 space-y-6">
        @csrf
        <div>
            <label for="value" class="block text-sm font-medium text-gray-700">Значение</label>
            <input id="value" name="value" type="text" class="mt-1 block w-full border-gray-300 rounded-md" required>
        </div>

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Поля</label>
            <input id="label" name="label" type="text" class="mt-1 block w-full border-gray-300 rounded-md" required>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md">Сохранить</button>
        </div>
    </form>
</section>
