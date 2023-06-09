<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Privat Appointment
        </h2>
    </x-slot>

    <div>
        <div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form method="post" action="{{ route('appointments.store') }}">
                    @csrf
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6">
                            <label for="description" class="block font-medium text-sm text-gray-700">Description</label>
                            <input type="text" name="description" id="description" type="text" class="form-input rounded-md shadow-sm mt-1 block w-full"
                                   value="{{ old('description', '') }}" />
                            @error('description')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6">
                            <label for="start_date" class="block font-medium text-sm text-gray-700">Start date</label>
                            <input name="start_date" id="start_date" type="date" class="form-input rounded-md shadow-sm mt-1 block w-full"
                                   value="{{ old('start_date', '') }}" />
                            @error('start_date')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6">
                            <label for="end_date" class="block font-medium text-sm text-gray-700">End date</label>
                            <input name="end_date" id="end_date" type="date" class="form-input rounded-md shadow-sm mt-1 block w-full"
                                   value="{{ old('end_date', '') }}" />
                            @error('end_date')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6">
                            <label for="start_time" class="block font-medium text-sm text-gray-700">Start time</label>
                            <input name="start_time" id="start_time" type="time" class="form-input rounded-md shadow-sm mt-1 block w-full"
                                   value="{{ old('start_time', '') }}" />
                            @error('start_time')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6">
                            <label for="end_time" class="block font-medium text-sm text-gray-700">End time</label>
                            <input name="end_time" id="end_time" type="time" class="form-input rounded-md shadow-sm mt-1 block w-full"
                                   value="{{ old('end_time', '') }}" />
                            @error('end_time')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                Create
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
