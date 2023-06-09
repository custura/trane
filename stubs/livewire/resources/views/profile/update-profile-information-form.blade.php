<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Custura\Trane\Trane::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            wire:model="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-label for="photo" value="{{ __('Photo') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </x-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remove Photo') }}
                    </x-secondary-button>
                @endif

                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Name') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" autocomplete="name" />
            <x-input-error for="name" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" autocomplete="username" />
            <x-input-error for="email" class="mt-2" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <p class="text-sm mt-2 dark:text-white">
                    {{ __('Your email address is unverified.') }}

                    <button type="button" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" wire:click.prevent="sendEmailVerification">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            @endif
        </div>

        <!-- User birthday -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="birthday" value="{{ __('Birthday mm-dd-yyyy') }}" />
            <x-input id="birthday" type="date" class="mt-1 block w-full" wire:model.defer="state.birthday" autocomplete="birthday" title="Provide a date in the format dd-mm-yyyy" />
            <x-input-error for="birthday" class="mt-2" />
        </div>

        <!-- Gender -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="gender" value="{{ __('Gender') }}" />
            <select id="gender" name="genderlist" form="gender" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
              wire:model.defer="state.gender" autocomplete="gender">
                <option value="0">Select your gender</option>
                <option value="1">Male</option>
                <option value="2">Female</option>
                <option value="3">Divers</option>
            </select>
        </div>

         <!-- Country -->
         <div class="col-span-6 sm:col-span-4">
            <x-label for="country" value="{{ __('Country') }}" />
            <x-input id="country" type="text" class="mt-1 block w-full" wire:model.defer="state.country" autocomplete="country" />
            <x-input-error for="country" class="mt-2" />
        </div>

        <!-- Town -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="town" value="{{ __('Town') }}" />
            <x-input id="town" type="text" class="mt-1 block w-full" wire:model.defer="state.town" autocomplete="town" />
            <x-input-error for="town" class="mt-2" />
        </div>

        <!-- Homepage -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="homepage" value="{{ __('Homepage') }}" />
            <x-input id="homepage" type="text" class="mt-1 block w-full" wire:model.defer="state.homepage" autocomplete="homepage" />
            <x-input-error for="homepage" class="mt-2" />
        </div>

        <!-- About -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="about" value="{{ __('About myself') }}" />
            <x-input id="about" type="text" class="mt-1 block w-full" wire:model.defer="state.about" autocomplete="about" />
            <x-input-error for="about" class="mt-2" />
        </div>

        <!-- User Description -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="userdescription" value="{{ __('Description') }}" />
            <textarea id="userdescription" type="text" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
            wire:model.defer="state.userdescription" autocomplete="userdescription"></textarea>
            <x-input-error for="userdescription" class="mt-2" />
        </div>

    </x-slot>

    <x-slot name="actions">
        <x-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section>
