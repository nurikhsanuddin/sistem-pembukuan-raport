<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        {{ __('Tambah Semester Baru') }}
                    </h2>

                    @if (session('success'))
                        <div class="bg-green-100 border mt-1 border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('semesters.store') }}">
                        @csrf
                        <div class="grid gap-4 mb-4">
                            <div>
                                <x-input-label for="number" value="Nomor Semester" />
                                <x-text-input id="number" name="number" type="number" min="1" max="6"
                                    class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('number')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="description" value="Deskripsi" />
                                <x-text-input id="description" name="description" type="text"
                                    class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm mt-6 mx-2 my-2">

                @include('semesters.show')
            </div>
        </div>
    </div>
</x-app-layout>
