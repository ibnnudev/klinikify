<div class="space-y-2 text-sm">
    <div class="flex items-center justify-between">
        <p class="text-gray-200 font-medium">Jadwal</p>
        <p id="schedule" class="text-gray-300">
            {{ \Carbon\Carbon::parse($reservation->date)->locale('id_ID')->isoFormat('dddd, D MMMM Y') .
                ' ' .
                date('H:i', strtotime($reservation->time)) .
                ' WIB' }}
        </p>
    </div>
    <div class="flex items-center justify-between">
        <p class="text-gray-200 font-medium">Pasien</p>
        <p id="patient" class="text-gray-300">
            {{ $reservation->patient->user->name }}
        </p>
    </div>
    <div class="flex items-center justify-between">
        <p class="text-gray-200 font-medium">Dokter</p>
        <p id="doctor" class="text-gray-300">
            {{ $reservation->doctor->user->name }}
        </p>
    </div>
    <div class="flex items-center justify-between">
        <p class="text-gray-200 font-medium">Deposito</p>
        <p id="deposit" class="text-gray-300">
            Rp {{ number_format($reservation->total_deposit, 0, ',', '.') }}
        </p>
    </div>
    <div class="flex items-center justify-between">
        <p class="text-gray-200 font-medium">Status</p>
        <p id="status" class="text-gray-300">
            @switch($reservation->status)
                @case('pending')
                    <span
                        class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300">Menunggu
                        Pembayaran</span>
                @break

                @case('confirmed')
                    <span
                        class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-700 dark:text-green-300 border border-green-300">Pembayaran
                        Berhasil</span>
                @break

                @case('canceled')
                    <span
                        class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-700 dark:text-red-300 border border-red-300">Batal</span>
                @break

                @default
                    <span
                        class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300 border border-gray-300">Selesai</span>
                @break

                @case('examination')
                    <span
                        class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-700 dark:text-blue-300 border border-blue-300">Pemeriksaan</span>
                @break
            @endswitch
        </p>
    </div>
</div>
