<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Report Cards') }} - {{ $student->name }}
            </h2>
            <button onclick="history.back()"
                class="px-4 py-2 text-sm font-medium text-white bg-gray-600 rounded-md hover:bg-gray-700">
                Back
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="mb-6">
                        <h3 class="mb-4 text-lg font-medium text-gray-900">Student Information</h3>
                        <div class="grid grid-cols-2 gap-4 p-4 bg-gray-50 rounded-md md:grid-cols-3">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Student Name</p>
                                <p class="font-medium text-gray-900">{{ $student->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">NIS</p>
                                <p class="font-medium text-gray-900">{{ $student->student_no }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">NISN</p>
                                <p class="font-medium text-gray-900">{{ $student->nisn }}</p>
                            </div>
                        </div>
                    </div>

                    <h3 class="mb-4 text-lg font-medium text-gray-900">Available Report Cards</h3>

                    <div class="overflow-hidden border border-gray-200 rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        No
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Class
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Academic Year
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Semester
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($semesters as $index => $reportCard)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                            {{ $reportCard->schoolClass->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $reportCard->schoolClass->academic_year ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $reportCard->semester->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                            <div class="flex items-center space-x-3">
                                                <a href="{{ route('report-cards.show', ['student' => $student->id, 'semester' => $reportCard->semester_id]) }}"
                                                    class="text-blue-600 hover:text-blue-900">
                                                    View
                                                </a>
                                                <button onclick="confirmDelete({{ $reportCard->id }})"
                                                    class="text-red-600 hover:text-red-900">
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-sm text-center text-gray-500">
                                            No report cards found for this student.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this report card? This action cannot be undone.')) {
                // Create form and submit for DELETE request
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/report-cards/${id}`;
                form.style.display = 'none';

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';

                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';

                form.appendChild(csrfToken);
                form.appendChild(method);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</x-app-layout>
