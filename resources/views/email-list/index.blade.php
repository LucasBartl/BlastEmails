<x-layouts::app :title="__('Email List')">
    <x-h2>
        {{ __('Email List') }}
    </x-h2>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="dark:border-neutral-700 dark:bg-gray-600 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6  text-gray-900 dark:text-gray-100">
                    @unless ($emailLists->isEmpty())
                        <x-table :headers="['#', __('Email List'),__('# Subscribers'),__('Actions')]">
                            <x-slot name="body">
                                @foreach ($emailLists as $list)
                                    <tr>
                                        <x-table.td>{{ $list->id }}</x-table.td>
                                        <x-table.td>{{ $list->title }}</x-table.td>
                                        <x-table.td>{{ $list->subscribers()->count() }}</x-table.td>
                                        <x-table.td>//</x-td>
                                    </tr>
                                @endforeach
                            </x-slot>
                        </x-table>
                    @else
                        <div class="flex justify-center">
                            <x-link-button :href="route('email-list.create')">
                                {{ __('Create your first email list') }}
                            </x-link-button>
                        </div>
                    @endunless
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
