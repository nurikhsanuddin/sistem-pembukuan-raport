<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        {{ __('Edit predikat') }}
                    </h2>

                    <form method="POST" action="{{ route('predikat.update', $predikat) }}">
                        @csrf
                        @method('PUT')
                        <div class="grid gap-4 mb-4">
                            <div>
                                <x-input-label for="nilai" value="Nomor predikat" />
                                <x-text-input id="nilai" name="nilai" type="number" class="mt-1 block w-full"
                                    required value="{{ $predikat->nilai }}" />
                                <x-input-error :messages="$errors->get('nilai')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="predikat" value="Deskripsi" />
                                <x-text-input id="predikat" name="predikat" type="text" class="mt-1 block w-full"
                                    required value="{{ $predikat->predikat }}" />
                                <x-input-error :messages="$errors->get('predikat')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Update') }}</x-primary-button>
                            <a href="{{ route('predikat.index') }}"
                                class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
