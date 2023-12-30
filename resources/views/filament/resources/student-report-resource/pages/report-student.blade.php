<x-filament-panels::page>
<div>
    @if($record->count() > 0)
    <div class="flex justify-between">
        <div  class="flex">
            <div class="px-1">
                <x-filament::button  type="button" icon="heroicon-o-printer" class="btn btn-primary w-32">Print</x-filament::button>
            </div>
        </div>
    </div>


            <!-- Transcation Table -->
           
            <table class="w-full" style="margin-top: 30px;">
                <thead>
                    <tr>
                        <th class="border border-gray-500 px-4 py-2">First Name</th>
                        <th class="border border-gray-500 px-4 py-2">Last Name</th>
                        <th class="border border-gray-500 px-4 py-2">Grade</th>
                        <th class="border border-gray-500 px-4 py-2">Section</th>
                        <th class="border border-gray-500 px-4 py-2">Address</th>
                        <th class="border border-gray-500 px-4 py-2">Email</th>


                    </tr>
                </thead>
                <tbody>
                    <!-- Sample Data (Replace this with your actual data) -->
                   
                    @foreach ($record as $item)
                    <tr>
                        <td class="border border-gray-500 px-4 py-2">{{strtoupper($item->first_name)}}</td>
                        <td class="border border-gray-500 px-4 py-2">{{strtoupper($item->last_name)}}</td>
                        <td class="border border-gray-500 px-4 py-2">{{$item->grade->name}}</td>
                        <td class="border border-gray-500 px-4 py-2">{{$item->section->name}}</td>
                        <td class="border border-gray-500 px-4 py-2">{{$item->address}}</td>
                        <td class="border border-gray-500 px-4 py-2">{{$item->email != null ? $item->email : 'No Email'}}</td>
                    </tr>
                    @endforeach
                </tbody>
              
            </table>

            <div class="flex justify-between" style="margin-top: 35px;">
                <div>
                    <p class="font-semibold text-md" style="margin-top: 5px;">Prepared By : {{strtoupper(auth()->user()->name)}}</p>
                </div>
    
            </div>
            @else
            <div class="" style="margin-top: 35px;">
                <div>
                    <p class="font-semibold text-lg text-center italic" style="margin-top: 5px;">No Students Yet</p>
                </div>
    
            </div>
            @endif

    </div>
</x-filament-panels::page>
