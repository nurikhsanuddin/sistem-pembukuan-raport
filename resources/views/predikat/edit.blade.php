<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        {{ __('Edit Predikat') }}
                    </h2>

                    <form method="POST" action="{{ route('predikat.update', $predikat) }}">
                        @csrf
                        @method('PUT')
                        <div class="grid gap-4 mb-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="nilai_min" value="Nilai Minimum" />
                                    <x-text-input id="nilai_min" name="nilai_min" type="number"
                                        class="mt-1 block w-full" min="0" max="100" required
                                        value="{{ $predikat->nilai_min }}" />
                                    <x-input-error :messages="$errors->get('nilai_min')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="nilai_max" value="Nilai Maximum" />
                                    <x-text-input id="nilai_max" name="nilai_max" type="number"
                                        class="mt-1 block w-full" min="0" max="100" required
                                        value="{{ $predikat->nilai_max }}" />
                                    <x-input-error :messages="$errors->get('nilai_max')" class="mt-2" />
                                </div>
                            </div>

                            <div>
                                <x-input-label for="predikat" value="Predikat" />
                                <x-text-input id="predikat" name="predikat" type="text" class="mt-1 block w-full"
                                    required value="{{ $predikat->predikat }}" />
                                <x-input-error :messages="$errors->get('predikat')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="deskripsi" value="Deskripsi" />
                                <textarea id="deskripsi" name="deskripsi"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                                    rows="3">{{ $predikat->deskripsi }}</textarea>
                                <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Update') }}</x-primary-button>
                            <a href="{{ route('predikat.index') }}"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded hover:bg-gray-200">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
