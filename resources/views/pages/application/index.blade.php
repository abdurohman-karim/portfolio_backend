<x-app-layout>
    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-8xl">
                    <h2 class="text-xl font-bold mb-4">Applications</h2>
                    <table class="w-full border-collapse border border-gray-500">
                        <thead class="bg-gray-200">
                        <tr>
                            <th class="border border-gray-400 px-2 py-1">ID</th>
                            <th class="border border-gray-400 px-2 py-1">Project Title</th>
                            <th class="border border-gray-400 px-2 py-1">Description</th>
                            <th class="border border-gray-400 px-2 py-1">Email</th>
                            <th class="border border-gray-400 px-2 py-1">Budget</th>
                            <th class="border border-gray-400 px-2 py-1">Deadline</th>
                            <th class="border border-gray-400 px-2 py-1">Files</th>
                            <th class="border border-gray-400 px-2 py-1">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($applications as $application)
                            <tr>
                                <td class="border border-gray-400 px-2 py-1">{{ $application->id }}</td>
                                <td class="border border-gray-400 px-2 py-1">{{ $application->project_title }}</td>
                                <td class="border border-gray-400 px-2 py-1">{{ $application->description }}</td>
                                <td class="border border-gray-400 px-2 py-1">{{ $application->email }}</td>
                                <td class="border border-gray-400 px-2 py-1">{{ $application->budget }}</td>
                                <td class="border border-gray-400 px-2 py-1">{{ $application->deadline }}</td>
                                <td class="border border-gray-400 px-2 py-1">
                                    <div class="flex flex-col space-y-1">
                                        @foreach($application->files as $file)
                                            <a href="{{ asset('storage/' . $file->file) }}"
                                               download
                                               class="flex items-center text-blue-600 hover:text-blue-800 transition">
                                                @if(str_starts_with($file->type, 'image/'))
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                         viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M4 16l4-4a2 2 0 012.828 0l4.586 4.586a2 2 0 002.828 0L20 14" />
                                                    </svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                         viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M12 4v8m0 0l3-3m-3 3l-3-3m0 9h6a2 2 0 002-2v-2a2 2 0 00-2-2h-6a2 2 0 00-2 2v2a2 2 0 002 2z" />
                                                    </svg>
                                                @endif
                                                Download {{ basename($file->file) }}
                                            </a>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="border border-gray-400 px-2 py-1">
                                    <form method="POST" action="{{ route('applications.destroy', $application) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:underline" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
