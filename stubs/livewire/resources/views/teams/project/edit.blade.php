<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Team Project
        </h2>
    </x-slot>

    <div>
        <div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="block mb-8">
                <a href="{{ route('teams.project.show-project', Auth::user()->currentTeam->id) }}" class="bg-gray-200 hover:bg-gray-300 text-black font-bold py-2 px-4 rounded">Back to list</a>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form method="post" action="{{ route('projects.update', $project) }}">
                    @csrf
                    @method('PUT')
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6">
                            <label for="title" class="block font-medium text-sm text-gray-700">Name</label>
                            <input name="title" id="title" type="text" rows="4" class="form-input rounded-md shadow-sm mt-1 block w-full"
                                   value="{{ old('title', $project->title) }}" />
                            @error('title')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6">
                            <label for="description" class="block font-medium text-sm text-gray-700">Description</label>
                            <input name="description" id="description" type="text" rows="4" class="form-input rounded-md shadow-sm mt-1 block w-full"
                                   value="{{ old('description', $project->description) }}" />
                            @error('description')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Pause system start -->
                        <div class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6">
                            <h3 class="text-lg font-medium text-gray-900">Pause System</h3>
                            <div class="px-4 py-5 text-lg sm:p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                                <div class="px-4 sm:px-0">
                                    <p class="mt-1 text-gray-600">
                                        Prima pauza este
                                            <input name="pause_time_1" id="pause_time_1" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-20 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                value="{{ old('pause_time_1', date('H:i', strtotime($project->pause_time_1))) }}" />
                                            @error('pause_time_1')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        dupa
                                            <input name="work_time_1" id="work_time_1" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-20 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                value="{{ old('work_time_1', date('H:i', strtotime($project->work_time_1))) }}" />
                                            @error('work_time_1')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        minute de lucru.
                                    </p>
                                </div>

                                <div class="px-4 sm:px-0">
                                    <p class="mt-1 text-gray-600">
                                        A 2-a pauza este
                                            <input name="pause_time_2" id="pause_time_2" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-20 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                value="{{ old('pause_time_2', date('H:i', strtotime($project->pause_time_2))) }}" />
                                            @error('pause_time_2')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        dupa
                                            <input name="work_time_2" id="work_time_2" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-20 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                value="{{ old('work_time_2', date('H:i', strtotime($project->work_time_2))) }}" />
                                            @error('work_time_2')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        minute de lucru.
                                    </p>
                                </div>

                                <div class="px-4 sm:px-0">
                                    <p class="mt-1 text-gray-600">
                                        A 3-a pauza este
                                            <input name="pause_time_3" id="pause_time_3" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-20 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                value="{{ old('pause_time_3', date('H:i', strtotime($project->pause_time_3))) }}" />
                                            @error('pause_time_3')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        dupa
                                            <input name="work_time_3" id="work_time_3" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-20 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                value="{{ old('work_time_3', date('H:i', strtotime($project->work_time_3))) }}" />
                                            @error('work_time_3')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        minute de lucru.
                                    </p>
                                </div>

                                <div class="px-4 sm:px-0">
                                    <p class="mt-1 text-gray-600">
                                        A 4-a pauza este
                                            <input name="pause_time_4" id="pause_time_4" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-20 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                value="{{ old('pause_time_4', date('H:i', strtotime($project->pause_time_4))) }}" />
                                            @error('pause_time_4')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        dupa
                                            <input name="work_time_4" id="work_time_4" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-20 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                value="{{ old('work_time_4', date('H:i', strtotime($project->work_time_4))) }}" />
                                            @error('work_time_4')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        minute de lucru.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Pause system end -->
                        <div class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6">
                            <label for="status" class="block font-medium text-sm text-gray-700">Status</label>
                            <select id="status" name="status"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="1" {{ $project->status == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $project->status == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6">
                            <x-action-section>
                                <x-slot name="title">
                                    {{ __('Team Members') }}
                                </x-slot>

                                <x-slot name="description">
                                    {{ __('All of the people that are part of this team and can be attach to project.') }}
                                </x-slot>

                                <!-- Team Member List -->
                                <x-slot name="content">
                                    <div class="space-y-6">
                                        @foreach ($team->allUsers() as $user)
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <img class="w-8 h-8 rounded-full" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                                                    <div class="ml-4">{{ $user->name }}</div>
                                                    <div class="ml-4"><input type="checkbox" name="{{ $user->name }}"  @checked($user->name)/></div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </x-slot>
                            </x-action-section>
                        </div>

                        <div class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6">
                            <x-action-section>
                                <x-slot name="title">
                                    {{ __('Team Tasks') }}
                                </x-slot>

                                <x-slot name="description">
                                    {{ __('All the tasks that are part of this team and can be attached to this project.') }}
                                </x-slot>

                                <!-- Team Task List -->
                                <x-slot name="content">
                                    <div class="space-y-6"> De facut
                                        @foreach ($team->allUsers() as $user)
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <img class="w-8 h-8 rounded-full" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                                                    <div class="ml-4">{{ $user->name }}</div>
                                                    <div class="ml-4"><input type="checkbox" name="{{ $user->name }}"  @checked($user->name)/></div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </x-slot>
                            </x-action-section>
                        </div>

                        <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                Edit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
