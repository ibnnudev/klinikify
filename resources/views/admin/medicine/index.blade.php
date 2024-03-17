<x-app-layout>
    <x-table id="medicineTable" label="Obat" :data=$medicines :columns="['Nama', 'Unit', 'Harga', '']" createModalId="add-modal">
        @forelse ($medicines as $data)
            <tr class="border-b dark:border-gray-700">
                <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $data->name }}
                </th>
                <td class="px-6 py-4">
                    {{ $data->unit }}
                </td>
                <td class="px-6 py-4">
                    {{ number_format($data->hpp, 0, ',', '.') }}
                </td>
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
                                    onclick="btnEdit({{ $data->id }})"
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
                <td class="p-2 pl-4" colspan="{{ $medicines->count() }}">Data tidak ditemukan</td>
            </tr>
        @endforelse
    </x-table>

    <x-basic-modal id="add-modal" title="Tambah Obat">
        <form action="{{ route('medicine.store') }}" method="POST" class="space-y-6">
            @csrf
            <x-input id="name" label="Nama" name="name" type="text" required />
            <x-textarea id="description" label="Deskripsi" name="description" required />
            <x-select id="unit" label="Unit" name="unit" required>
                <option value="Pcs">Pcs</option>
                <option value="Botol">Botol</option>
                <option value="Strip">Strip</option>
                <option value="Kotak">Kotak</option>
            </x-select>
            <x-input id="hpp" label="Harga Pokok" name="hpp" type="number" required />
            <x-primary-button type="submit">Simpan</x-primary-button>
        </form>
    </x-basic-modal>

    <x-basic-modal id="edit-modal" title="Edit Obat">
        <form action="{{ route('medicine.store') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <x-input id="name" label="Nama" name="name" type="text" required />
            <x-textarea id="description" label="Deskripsi" name="description" required />
            <x-select id="unit" label="Unit" name="unit" required>
                <option value="Pcs">Pcs</option>
                <option value="Botol">Botol</option>
                <option value="Strip">Strip</option>
                <option value="Kotak">Kotak</option>
            </x-select>
            <x-input id="hpp" label="Harga Pokok" name="hpp" type="number" required />
            <x-primary-button type="submit">Simpan</x-primary-button>
        </form>
    </x-basic-modal>

    <x-delete-modal id="delete-modal" />

    @push('js-internal')
        <script>
            function btnDelete(id, name) {
                console.log(id, name);
                let url = '{{ route('medicine.destroy', ':id') }}'.replace(':id', id);
                let modal = $('#delete-modal');
                modal.find('form').attr('action', url);
                modal.find('.deleted-item').text(name);
            }

            function btnEdit(id) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('medicine.show', ':id') }}".replace(':id', id),
                    dataType: "json",
                    success: function(response) {
                        let modal = $('#edit-modal');
                        modal.find('form').attr('action', "{{ route('medicine.update', ':id') }}".replace(':id',
                            id));
                        modal.find('#name').val(response.name);
                        modal.find('#description').val(response.description);
                        modal.find('#unit').val(response.unit);
                        modal.find('#hpp').val(response.hpp);
                        modal.find('form').attr('action', "{{ route('medicine.update', ':id') }}".replace(':id',
                            response.user.id));
                    }
                });
            }
            @include('vendor.alert')
        </script>
    @endpush
</x-app-layout>
