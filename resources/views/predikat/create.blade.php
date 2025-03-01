<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        {{ __('Tambah Semester Baru') }}
                    </h2>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('predikat.store') }}">
                        @csrf
                        <div class="grid gap-4 mb-4">
                            <div>
                                <x-input-label for="number" value="Nilai" />
                                <x-text-input id="nilai" name="nilai" type="number" class="mt-1 block w-full"
                                    required />
                                <x-input-error :messages="$errors->get('nilai')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="predikat" value="Deskripsi" />
                                <x-text-input id="predikat" name="predikat" type="text" class="mt-1 block w-full"
                                    required />
                                <x-input-error :messages="$errors->get('predikat')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm mt-6 mx-2 my-2">

                @include('predikat.show')
            </div>
        </div>
    </div>
</x-app-layout>
