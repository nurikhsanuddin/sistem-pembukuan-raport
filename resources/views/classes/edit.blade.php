<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        {{ __('Edit Kelas') }}
                    </h2>

                    <form method="POST" action="{{ route('classes.update', $class) }}">
                        @csrf
                        @method('PUT')
                        <div class="grid gap-4 mb-4">
                            <div>
                                <x-input-label for="name" value="Nama Kelas" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                    required value="{{ $class->name }}" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="academic_year" value="Tahun Akademik" />
                                <x-text-input id="academic_year" name="academic_year" type="text"
                                    class="mt-1 block w-full" required value="{{ $class->academic_year }}" />
                                <x-input-error :messages="$errors->get('academic_year')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Update') }}</x-primary-button>
                            <a href="{{ route('classes.create') }}"
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
