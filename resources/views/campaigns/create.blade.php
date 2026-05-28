<x-layouts::app :title="__('campaigns')">
    <x-h2>
        {{ __('campaigns') }} > {{ __('Create a new campaign') }}
    </x-h2>

    <x-card>

        <x-tabs :tabs="[
            __('Setup') => route('campaigns.create'),
            __('Email Body') => route('campaigns.create',['tab' => 'template']),
            __('Schedule') => route('campaigns.create',['tab' => 'schedule'])
        ]">
            <x-form :action="route('campaigns.create')" post enctype="multipart/form-data">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" name="name" :value="old('name')"
                            autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="subject" :value="__('Subject')" />
                        <x-text-input id="subject" class="block mt-1 w-full" name="subject" :value="old('subject')"
                            autofocus />
                        <x-input-error :messages="$errors->get('subject')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email_list_id" :value="__('Email List')" />
                        <x-text-input id="email_list_id" class="block mt-1 w-full" name="email_list_id"
                            :value="old('email_list_id')" autofocus />
                        <x-input-error :messages="$errors->get('email_list_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="template_id" :value="__('Template')" />
                        <x-text-input id="template_id" class="block mt-1 w-full" name="template_id" :value="old('template_id')"
                            autofocus />
                        <x-input-error :messages="$errors->get('template_id')" class="mt-2" />
                    </div>

                    <div class="flex items-center space-x-4">
                        <x-link-button secondary :href="route('campaigns.index')">
                            {{ __('Cancel') }}
                        </x-link-button>

                        <x-primary-button type="submit">
                            {{ __('Save') }}
                        </x-primary-button>
                    </div>
                </div>
            </x-form>
        </x-tabs.index>
    </x-card>
</x-layouts::app>
