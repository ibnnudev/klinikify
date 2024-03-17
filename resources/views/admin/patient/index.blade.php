<x-app-layout>
    <x-table id="patientTable" label="Pasien" :data=$patients :columns="['Nama', 'Email', 'Umur', 'Gender', 'No Telefon', 'Alergi', 'Penyakit Jantung', '']" createModalId="add-modal">
        @forelse ($patients as $data)
            <tr class="border-b dark:border-gray-700">
                <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $data->user->name }}
                </th>
                <td class="px-6 py-4">
                    {{ $data->user->email }}
                </td>
                <td class="px-6 py-4">
                    {{ $data->user->age }} Tahun
                </td>
                <td class="px-6 py-4">
                    {{ $data->user->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
                </td>
                <td class="px-6 py-4">
                    {{ $data->user->phone }}
                </td>
                <td class="px-6 py-4">
                    {{ $data->is_allergy ? 'Ya' : 'Tidak' }}
                </td>
                <td class="px-6 py-4">
                    {{ $data->is_heart_disease ? 'Ya' : 'Tidak' }}
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
                                    onclick="btnDelete({{ $data->user->id }}, '{{ $data->user->name }}')"
                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Hapus</a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td class="p-2 pl-4" colspan="{{ $patients->count() }}">Data tidak ditemukan</td>
            </tr>
        @endforelse
    </x-table>

    <x-basic-modal id="add-modal" title="Tambah Pasien">
        <form action="{{ route('patient.store') }}" method="POST" class="space-y-6">
            @csrf
            <x-input id="name" label="Nama" name="name" type="text" required />
            <x-input id="email" label="Email" name="email" type="email" required />
            <x-select id="gender" label="Jenis Kelamin" name="gender" required>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </x-select>
            <x-input id="age" label="Umur" name="age" type="number" required />
            <x-input id="phone" label="No Telefon" name="phone" type="text" required />
            <x-select id="is_allergy" label="Punya Alergi?" name="is_allergy" required>
                <option value="1">Ya</option>
                <option value="0">Tidak</option>
            </x-select>
            <x-select id="is_heart_disease" label="Punya Penyakit Jantung?" name="is_heart_disease" required>
                <option value="1">Ya</option>
                <option value="0">Tidak</option>
            </x-select>
            <x-primary-button type="submit">Simpan</x-primary-button>
        </form>
    </x-basic-modal>

    <x-basic-modal id="edit-modal" title="Edit Pasien">
        <form action="{{ route('patient.store') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <input type="hidden" name="user_id" value="">
            <x-input id="name" label="Nama" name="name" type="text" required />
            <x-input id="email" label="Email" name="email" type="email" required />
            <x-select id="gender" label="Jenis Kelamin" name="gender" required>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </x-select>
            <x-input id="age" label="Umur" name="age" type="number" required />
            <x-input id="phone" label="No Telefon" name="phone" type="text" required />
            <x-select id="is_allergy" label="Punya Alergi?" name="is_allergy" required>
                <option value="1">Ya</option>
                <option value="0">Tidak</option>
            </x-select>
            <x-select id="is_heart_disease" label="Punya Penyakit Jantung?" name="is_heart_disease" required>
                <option value="1">Ya</option>
                <option value="0">Tidak</option>
            </x-select>
            <x-primary-button type="submit">Simpan</x-primary-button>
        </form>
    </x-basic-modal>

    <x-delete-modal id="delete-modal" />

    @push('js-internal')
        <script>
            function btnDelete(id, name) {
                console.log(id, name);
                let url = '{{ route('patient.destroy', ':id') }}'.replace(':id', id);
                let modal = $('#delete-modal');
                modal.find('form').attr('action', url);
                modal.find('.deleted-item').text(name);
            }

            function btnEdit(id) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('patient.show', ':id') }}".replace(':id', id),
                    dataType: "json",
                    success: function(response) {
                        let modal = $('#edit-modal');
                        modal.find('form').attr('action', "{{ route('patient.update', ':id') }}".replace(':id',
                            id));
                        modal.find('input[name="user_id"]').val(response.user.id);
                        modal.find('#name').val(response.user.name);
                        modal.find('#email').val(response.user.email);
                        modal.find('#gender').val(response.user.gender);
                        modal.find('#age').val(response.user.age);
                        modal.find('#phone').val(response.user.phone);
                        modal.find('#is_allergy').val(response.is_allergy);
                        modal.find('#is_heart_disease').val(response.is_heart_disease);
                        modal.find('form').attr('action', "{{ route('patient.update', ':id') }}".replace(':id',
                            response.user.id));
                    }
                });
            }
            @include('vendor.alert')
        </script>
    @endpush
</x-app-layout>
