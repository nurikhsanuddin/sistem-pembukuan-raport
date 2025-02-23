<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">  
                    <h2 class="text-2xl font-bold mb-4">Import Data Raport</h2>

                    @if(session('success'))
                        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 " role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('reportcard.import') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <div>
                            <label for="class_id" class="block mb-2 text-sm font-medium text-gray-900 ">Pilih Kelas</label>
                            <select name="class_id" id="class_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  " required>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="semester_id" class="block mb-2 text-sm font-medium text-gray-900 ">Pilih Semester</label>
                            <select name="semester_id" id="semester_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  " required>
                                @foreach($semesters as $semester)
                                    <option value="{{ $semester->id }}">Semester {{ $semester->number }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 " for="file">Pilih File Excel</label>
                            <input type="file" name="file" id="file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 " required>
                        </div>

                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                            Import Data
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
