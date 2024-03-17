<x-app-layout>

    <x-table id="doctorCategoryTable" label="Kategori" :data=$categories :columns="['Nama', '']" createModalId="add-modal">
        @forelse ($categories as $data)
            <tr class="border-b dark:border-gray-700">
                <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $data->name }}
                </th>
                <td class="px-4 py-3 flex items-center justify-end">
                    <button id="{{ $data->id }}-dropdown-button" data-dropdown-toggle="{{ $data->id }}-dropdown"
                        class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                        type="button">
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                        </svg>
                    </button>
                    <div id="{{ $data->id }}-dropdown"
                        class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="{{ $data->id }}-dropdown-button">
                            <li>
                                <a href="#" data-modal-toggle="edit-modal" data-modal-target="edit-modal"
                                    onclick="btnEdit({{ $data->id }}, '{{ $data->name }}')"
                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                            </li>
                            <li>
                                <a href="#" data-modal-toggle="delete-modal" data-modal-target="delete-modal"
                                    onclick="btnDelete({{ $data->id }}, '{{ $data->name }}')"
                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Hapus</a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td class="p-2 pl-4" colspan="2">Data tidak ditemukan</td>
            </tr>
        @endforelse
    </x-table>

    <x-basic-modal id="add-modal">
        <form action="{{ route('doctor-category.store') }}" method="POST" class="space-y-6">
            @csrf
            <x-input id="name" label="Nama" name="name" type="text" required />
            <x-primary-button type="submit">Simpan</x-primary-button>
        </form>
    </x-basic-modal>

    <x-basic-modal id="edit-modal">
        <form action="" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <x-input id="name" label="Nama" name="name" type="text" required />
            <x-primary-button type="submit">Simpan</x-primary-button>
        </form>
    </x-basic-modal>

    <x-delete-modal id="delete-modal" />

    @push('js-internal')
        <script>
            function btnEdit(id, name) {
                const modal = $('#edit-modal');
                modal.find('.modal-title').text('Edit Kategori Dokter');
                let url = "{{ route('doctor-category.update', ':id') }}";
                url = url.replace(':id', id);
                modal.find('form').attr('action', url);
                modal.find('#name').val(name);
            }

            function btnDelete(id, name) {
                const modal = $('#delete-modal');
                modal.find('.deleted-item').text(name);
                let url = "{{ route('doctor-category.destroy', ':id') }}";
                url = url.replace(':id', id);
                modal.find('form').attr('action', url);
                modal.find('.modal-body').text(`Apakah anda yakin ingin menghapus kategori dokter ${name}?`);
            }

            @include('vendor.alert')
        </script>
    @endpush
</x-app-layout>
