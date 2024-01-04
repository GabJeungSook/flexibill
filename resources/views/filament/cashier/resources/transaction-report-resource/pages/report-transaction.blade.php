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
                        <th class="border border-gray-500 px-4 py-2">Date</th>
                        <th class="border border-gray-500 px-4 py-2">Name</th>
                        <th class="border border-gray-500 px-4 py-2">Payment Type</th>
                        <th class="border border-gray-500 px-4 py-2">Total</th>
                        <th class="border border-gray-500 px-4 py-2">Balance</th>
                        <th class="border border-gray-500 px-4 py-2">Amount Paid</th>

                    </tr>
                </thead>
                <tbody>
                    <!-- Sample Data (Replace this with your actual data) -->
                   
                    @foreach ($record as $item)
                    <tr>
                        <td class="border border-gray-500 px-4 py-2">{{Carbon\Carbon::parse($item->created_at)->format('m/d/Y')}}</td>
                        <td class="border border-gray-500 px-4 py-2">{{strtoupper($item->student->first_name.' '.$item->student->last_name)}}</td>
                        <td class="border border-gray-500 px-4 py-2">{{$item->payment_type}}</td>
                        <td class="border border-gray-500 px-4 py-2">{{number_format($item->total, 2)}}</td>
                        <td class="border border-gray-500 px-4 py-2">{{number_format($item->balance, 2)}}</td>
                        <td class="border border-gray-500 px-4 py-2">{{number_format($item->amount, 2)}}</td>
                    </tr>
                    @endforeach
                </tbody>
              
            </table>

            <div class="flex justify-between" style="margin-top: 35px;">
                <div>
                    <p class="font-semibold text-md" style="margin-top: 5px;">Cashier : {{strtoupper(auth()->user()->name)}}</p>
                </div>
    
            </div>
            @else
            <div class="" style="margin-top: 35px;">
                <div>
                    <p class="font-semibold text-lg text-center italic" style="margin-top: 5px;">No Transactions Yet</p>
                </div>
    
            </div>
            @endif

    </div>

</x-filament-panels::page>