<x-app-layout>
    <x-table id="reservationTable" label="Reservasi" :data=$reservations :columns="['Jadwal', 'Pasien', 'Dokter', 'Deposito', 'Status', '']"
        createModalId="add-reservation-modal">
        @forelse ($reservations as $data)
            <tr class="border-b dark:border-gray-700">
                <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <div class="space-y-2">
                        <p class="font-medium">
                            {{ \Carbon\Carbon::parse($data->date)->locale('id')->isoFormat('D/MM/Y') .' ' .date('H:i', strtotime($data->time)) }}
                    </div>
                </th>
                <td class="px-6 py-4">
                    <div class="space-y-2">
                        <h3 class="font-medium text-white">{{ $data->patient->user->name }}</h3>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="space-y-2">
                        <h3 class="font-medium text-white">{{ $data->doctor->user->name }}</h3>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <p class="font-medium text-primary-200">
                        Rp{{ number_format($data->total_deposit, 0, ',', '.') }}
                    </p>
                </td>
                <td class="px-6 py-4">
                    @switch($data->status)
                        @case('pending')
                            <span
                                class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300">Menunggu
                                Pembayaran</span>
                        @break

                        @case('confirmed')
                            <span
                                class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-700 dark:text-green-300 border border-green-300">Pembayaran
                                Berhasil</span>
                        @break

                        @case('canceled')
                            <span
                                class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-700 dark:text-red-300 border border-red-300">Batal</span>
                        @break

                        @default
                            <span
                                class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300 border border-gray-300">Selesai</span>
                        @break

                        @case('examination')
                            <span
                                class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-700 dark:text-blue-300 border border-blue-300">Pemeriksaan</span>
                        @break
                    @endswitch
                </td>
                <td class="px-6 py-4 flex items-center justify-end">
                    <div class="inline-flex items-center rounded-md shadow-sm">
                        <a href="#" aria-current="page" data-modal-toggle="detail-reservation-modal"
                            data-modal-target="detail-reservation-modal" onclick="btnDetail('{{ $data->id }}')"
                            class="px-4 py-2 text-sm font-medium text-blue-700 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                            Detail
                        </a>
                        <a href="#" data-modal-toggle="edit-reservation-modal"
                            data-modal-target="edit-reservation-modal" onclick="btnEdit('{{ $data->id }}')"
                            class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                            Edit
                        </a>
                        <a href="#" data-modal-toggle="delete-reservation-modal"
                            data-modal-target="delete-reservation-modal"
                            onclick="btnDelete('{{ $data->id }}', '{{ $data->code }}')"
                            class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                            Hapus
                        </a>
                    </div>
                </td>
            </tr>
            @empty
                <tr>
                    <td class="p-2 pl-4" colspan="{{ $reservations->count() }}">Data tidak ditemukan</td>
                </tr>
            @endforelse
        </x-table>

        <x-basic-modal id="add-reservation-modal" title="Tambah Reservasi">
            <form action="{{ route('reservation.store') }}" method="POST" class="space-y-6">
                @csrf
                <x-select id="patient_id" name="patient_id" label="Pasien" required>
                    <option value="" disabled selected>Pilih Pasien</option>
                    @foreach ($patients as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->user->name }}</option>
                    @endforeach
                </x-select>
                <x-select id="doctor_id" name="doctor_id" label="Dokter" required>
                    <option value="" disabled selected>Pilih Dokter</option>
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}" data-price="{{ $doctor->doctorCategory->price }}">
                            {{ $doctor->user->name }} ( {{ $doctor->doctorCategory->name }} )
                        </option>
                    @endforeach
                </x-select>
                <x-input id="date" label="Tanggal" name="date" type="date" required />
                <x-select id="time" name="time" label="Waktu" required>
                    <option value="" disabled selected>Pilih Waktu</option>
                    @for ($i = 8; $i <= 21; $i++)
                        @for ($j = 0; $j < 60; $j += 30)
                            <option
                                value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) . ':' . str_pad($j, 2, '0', STR_PAD_LEFT) }}">
                                {{ str_pad($i, 2, '0', STR_PAD_LEFT) . ':' . str_pad($j, 2, '0', STR_PAD_LEFT) }}
                            </option>
                        @endfor
                    @endfor
                </x-select>
                <x-input id="total_deposit" label="Total Deposito" name="total_deposit" type="text" readonly required />
                <x-primary-button type="submit">Simpan</x-primary-button>
            </form>
        </x-basic-modal>

        <x-basic-modal id="edit-reservation-modal" title="Ubah Reservasi">
            <form action="" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <x-select id="patient_id" name="patient_id" label="Pasien" required>
                    <option value="" disabled selected>Pilih Pasien</option>
                    @foreach ($patients as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->user->name }}</option>
                    @endforeach
                </x-select>
                <x-select id="doctor_id" name="doctor_id" label="Dokter" required>
                    <option value="" disabled selected>Pilih Dokter</option>
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}" data-price="{{ $doctor->doctorCategory->price }}">
                            {{ $doctor->user->name }} ( {{ $doctor->doctorCategory->name }} )
                        </option>
                    @endforeach
                </x-select>
                <x-input id="date" label="Tanggal" name="date" type="date" required />
                <x-select id="time" name="time" label="Waktu" required>
                    <option value="" disabled selected>Pilih Waktu</option>
                    @for ($i = 8; $i <= 21; $i++)
                        @for ($j = 0; $j < 60; $j += 30)
                            <option
                                value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) . ':' . str_pad($j, 2, '0', STR_PAD_LEFT) }}">
                                {{ str_pad($i, 2, '0', STR_PAD_LEFT) . ':' . str_pad($j, 2, '0', STR_PAD_LEFT) }}
                            </option>
                        @endfor
                    @endfor
                </x-select>
                <x-input id="total_deposit" label="Total Deposito" name="total_deposit" type="text" readonly required />
                <x-primary-button type="submit">Simpan</x-primary-button>
            </form>
        </x-basic-modal>

        <x-delete-modal id="delete-reservation-modal" />

        <x-basic-modal id="detail-reservation-modal" title="Detail Reservasi">
            <div id="result"></div>
        </x-basic-modal>

        @push('js-internal')
            <script>
                function rupiahFormat(value) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(value);
                }

                function timeFormat(value) {
                    return value.split(':').slice(0, 2).join(':');
                }

                function dateFormat(value) {
                    return new Intl.DateTimeFormat('id-ID', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    }).format(new Date(value));
                }

                const date = new Date();
                const tomorrow = new Date(date);
                tomorrow.setDate(date.getDate() + 1);
                const tomorrowString = tomorrow.toISOString().split('T')[0];
                $('input[type="date"]').attr('min', tomorrowString);

                $('select[name="doctor_id"]').on('change', function() {
                    const price = $(this).find(':selected').data('price');
                    $('input[name="total_deposit"]').val(rupiahFormat(price));
                    $('input[name="date"]').val('');
                    $('select[name="time"]').val('');
                });

                $('input[name="date"]').on('change', function() {
                    $('select[name="time"]').val('');
                });

                $('select[name="time"]').on('change', function() {
                    let doctorId = $('select[name="doctor_id"]').val();
                    let date = $('input[name="date"]').val();
                    let time = $(this).val();

                    $.ajax({
                        type: "POST",
                        url: "{{ route('reservation.check') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            doctor_id: doctorId,
                            date: date,
                            time: time
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.length > 0) {
                                alert('Waktu yang anda pilih sudah terisi');
                                $('select[name="time"]').val('');
                            }
                        }
                    });
                });

                function btnEdit(id) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('reservation.show', ':id') }}".replace(':id', id),
                        dataType: "json",
                        success: function(response) {
                            $('#edit-reservation-modal form').attr('action',
                                "{{ route('reservation.update', ':id') }}"
                                .replace(':id', id));
                            $('#edit-reservation-modal #patient_id').val(response.patient_id);
                            $('#edit-reservation-modal #doctor_id').val(response.doctor_id);
                            $('#edit-reservation-modal #date').val(response.date);
                            $('#edit-reservation-modal #time').val(timeFormat(response.time));
                            $('#edit-reservation-modal #total_deposit').val(rupiahFormat(response
                                .total_deposit));
                        }
                    });
                }

                function btnDelete(id, code) {
                    $('#delete-reservation-modal form').attr('action', "{{ route('reservation.destroy', ':id') }}".replace(':id',
                        id));
                    $('#delete-reservation-modal .deleted-item').text(code);
                }

                function btnDetail(id) {
                    event.preventDefault();
                    $.ajax({
                        type: "GET",
                        url: "{{ route('reservation.show', ':id') }}".replace(':id', id),
                        success: function(response) {
                            $('#detail-reservation-modal #result').html(response);
                            return false
                        },
                        finaly: function() {
                            return false
                        }
                    });
                }

                @include('vendor.alert')
            </script>
        @endpush
    </x-app-layout>
