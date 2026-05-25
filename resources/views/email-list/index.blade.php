<x-layouts::app :title="__('Email List')">
    <x-h2>
        {{__('Email List')}}
    </x-h2>
     <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="dark:border-neutral-700 dark:bg-gray-600 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6  text-gray-900 dark:text-gray-100">
                    @forelse ($emailLists as $list)
                        Lista das listas
                    @empty
                        <div class="flex justify-center">
                            <x-link-button :href="route('email-list.create')">
                                {{ __('Create your first email list') }}
                            </x-link-button>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
