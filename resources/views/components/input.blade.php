@props([
    'id' => '',
    'label' => '',
    'name' => '',
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
    'value' => '',
    'autocomplete' => 'off',
])

<div>
    <label for="{{ $id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
        {{ $label }} {!! $required ? '<span class="text-red-500">*</span>' : '' !!}
    </label>
    <input
        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        id="{{ $id }}" name="{{ $name }}" type="{{ $type }}" placeholder="{{ $placeholder }}"
        autocomplete="{{ $autocomplete }}" value="{{ $value }}" {{ $required ? 'required' : '' }}>

    @error($name)
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
