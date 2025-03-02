<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Report Cards by Class') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($classes as $class)
                    <div class="p-6 bg-white rounded-lg shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-semibold text-gray-800">{{ $class->name }}</h3>
                            <span class="px-3 py-1 text-sm text-blue-600 bg-blue-100 rounded-full">
                                {{ $class->students_count }} Students
                            </span>
                        </div>
                        <div class="mb-4">
                            <p class="text-gray-600">Academic Year: {{ $class->academic_year }}</p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('report-cards.class-students', $class->id) }}"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                                View Students
                            </a>
                            <a href="{{ route('report-cards.export-class', $class->id) }}"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700">
                                Export Reports
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
