@props(['id', 'label', 'name', 'required' => false])

<div>
    <label for="{{ $id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
        {{ $label }} {!! $required ? '<span class="text-red-500">*</span>' : '' !!}
    </label>
    <textarea id="{{ $id }}" rows="4" name="{{ $name }}" {{ $required ? 'required' : '' }}
        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>

    @error($name)
        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
    @enderror
</div>
