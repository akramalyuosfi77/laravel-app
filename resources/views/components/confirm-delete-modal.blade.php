@props(['action', 'state', 'title', 'message'])

<div x-data="{ show: @entangle($state).live }"
     x-show="show"
     x-on:keydown.escape.window="show = null"
     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
     style="display: none;">

    <div @click.away="show = null"
         class="bg-white rounded-xl shadow-2xl w-full max-w-md">

        <div class="p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0 h-12 w-12 flex items-center justify-center rounded-full bg-red-100">
                    <i class="bi bi-exclamation-triangle-fill text-red-600 text-2xl"></i>
                </div>
                <div class="ml-4 rtl:mr-4 rtl:ml-0 text-right">
                    <h3 class="text-xl font-bold text-gray-900">{{ $title }}</h3>
                    <div class="mt-2">
                        <p class="text-md text-gray-600">{{ $message }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-4 rtl:space-x-reverse rounded-b-xl">
            <button type="button"
                    @click="show = null"
                    class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                إلغاء
            </button>
            <button type="button"
                    wire:click="{{ $action }}"
                    class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                نعم، قم بالحذف
            </button>
        </div>
    </div>
</div>
