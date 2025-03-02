<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Mata Pelajaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('mapel.update', $subject) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Mapel</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $subject->name) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="description" id="description" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('description', $subject->description) }}</textarea>
                    </div>

                    <!-- Pengetahuan Fields -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Deskripsi Pengetahuan</h3>

                        <div class="space-y-4">
                            <div>
                                <label for="pengetahuan_A" class="block text-sm font-medium text-gray-700">Pengetahuan
                                    A</label>
                                <textarea name="pengetahuan_A" id="pengetahuan_A" rows="2"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('pengetahuan_A', $subject->pengetahuan_A) }}</textarea>
                            </div>

                            <div>
                                <label for="pengetahuan_B" class="block text-sm font-medium text-gray-700">Pengetahuan
                                    B</label>
                                <textarea name="pengetahuan_B" id="pengetahuan_B" rows="2"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('pengetahuan_B', $subject->pengetahuan_B) }}</textarea>
                            </div>

                            <div>
                                <label for="pengetahuan_C" class="block text-sm font-medium text-gray-700">Pengetahuan
                                    C</label>
                                <textarea name="pengetahuan_C" id="pengetahuan_C" rows="2"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('pengetahuan_C', $subject->pengetahuan_C) }}</textarea>
                            </div>

                            <div>
                                <label for="pengetahuan_D" class="block text-sm font-medium text-gray-700">Pengetahuan
                                    D</label>
                                <textarea name="pengetahuan_D" id="pengetahuan_D" rows="2"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('pengetahuan_D', $subject->pengetahuan_D) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Keterampilan Fields -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Deskripsi Keterampilan</h3>

                        <div class="space-y-4">
                            <div>
                                <label for="keterampilan_A" class="block text-sm font-medium text-gray-700">Keterampilan
                                    A</label>
                                <textarea name="keterampilan_A" id="keterampilan_A" rows="2"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('keterampilan_A', $subject->keterampilan_A) }}</textarea>
                            </div>

                            <div>
                                <label for="keterampilan_B" class="block text-sm font-medium text-gray-700">Keterampilan
                                    B</label>
                                <textarea name="keterampilan_B" id="keterampilan_B" rows="2"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('keterampilan_B', $subject->keterampilan_B) }}</textarea>
                            </div>

                            <div>
                                <label for="keterampilan_C" class="block text-sm font-medium text-gray-700">Keterampilan
                                    C</label>
                                <textarea name="keterampilan_C" id="keterampilan_C" rows="2"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('keterampilan_C', $subject->keterampilan_C) }}</textarea>
                            </div>

                            <div>
                                <label for="keterampilan_D" class="block text-sm font-medium text-gray-700">Keterampilan
                                    D</label>
                                <textarea name="keterampilan_D" id="keterampilan_D" rows="2"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('keterampilan_D', $subject->keterampilan_D) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('mapel.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
