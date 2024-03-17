<x-app-layout>
    @push('css-internal')
        @include('admin.libraries.datatablecss')
    @endpush
    <x-card>
        <p>Dokter</p>
    </x-card>

    @push('js-internal')
        @include('admin.libraries.datatablejs')
    @endpush
</x-app-layout>
