<x-layouts::app :title="__('Templates')">
    <x-h2>
        {{ __('Templates') }} 
    </x-h2>

    <x-card class="space-y-4">

        <div class="flex justify-between">
            <x-link-button :href="route('template.create')">
                {{ __('Add a new template') }}
            </x-link-button>
            <x-form :action="route('template.index')" class="w-2/5" x-data x-ref="form">

                <x-checkbox-input :label="__('Show Deleted Records')" name="withTrash" value="1" @click="$refs.form.submit()"
                    :checked="$withTrash" />

                <x-text-input name="search" :placeholder="__('Search')" :value="$search" />

            </x-form>
        </div>

        <x-table :headers="['#', __('Name'), __('Actions')]">
            <x-slot name="body">

                @foreach ($templates as $template)
                    <tr>
                        <x-table.td>{{ $template->id }}</x-table.td>
                        <x-table.td>{{ $template->name }}</x-table.td>

                        <x-table.td class="flex space-x-4 ">
                            <x-link-button secondary :href="route('template.show',$template)">{{__('Preview')}}</x-link-button>
                            <x-link-button secondary :href="route('template.edit',$template)">{{__('Edit')}}</x-link-button>
                            @unless ($template->trashed())
                                <x-form :action="route('template.destroy', $template)" delete flat onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                    <x-secondary-button type="submit">
                                        {{__('Delete')}}
                                    </x-secondary-button>
                                </x-form>
                            @else
                                <x-danger danger>
                                    {{ __('Deleted') }}
                                </x-danger>
                            @endunless
                        </x-table.td>
                    </tr>
                @endforeach

            </x-slot>
        </x-table>

       
    </x-card>
</x-layouts::app>
