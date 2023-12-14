<x-filament-panels::page>
{{$this->form}}
<div>
    <div class="flex justify-end">
        <x-filament::button wire:click="redirectToStatement" type="button" style="margin-right: 0.25rem; background-color: transparent; color: indigo; border: 1px solid indigo;">Cancel</x-filament::button>

        <x-filament::button wire:click="addBilling" type="button" icon="heroicon-o-plus-circle" class="btn btn-primary">Add Payment</x-filament::button>
    </div>
</div>
</x-filament-panels::page>
