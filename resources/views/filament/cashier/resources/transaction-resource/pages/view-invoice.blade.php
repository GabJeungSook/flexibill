<x-filament-panels::page>
    <div class="flex justify-between">
        <div  class="flex">
            <div class="px-1">
                <x-filament::button type="button" icon="heroicon-o-printer" class="btn btn-primary w-32">Print</x-filament::button>
            </div>
            <div class="px-1">
            @if ($record->student->email != null)
                <x-filament::button wire:click="sendEmailInvoice" type="button" icon="heroicon-o-paper-airplane" class="btn btn-success w-42">Send E-Invoice</x-filament::button>
            @endif
            </div>
        </div>
        <div>
        </div>
    </div>


    <div class="container mx-auto mt-8">
        <div class="border border-black p-6 text-warning rounded-md">
            <!-- Content inside the box -->
            <p class="font-bold text-2xl">INVOICE</p>
            <div class="flex justify-between" style="margin-top: 30px;">
                <div>
                    <p class="font-semibold text-md" style="margin-top: 5px;">Invoice Number : {{$record->invoice->invoice_number}}</p>
                    <p class="font-semibold text-md" style="margin-top: 5px;">Student Name : {{$record->student->first_name.' '.$record->student->last_name}}</p>
                </div>
                <div>
                    <p class="font-semibold text-md" style="margin-top: 5px;">Date : {{Carbon\Carbon::parse($record->invoice->created_at)->format('F d, Y')}}</p>
                    <p class="font-semibold text-md" style="margin-top: 5px;">Time : {{Carbon\Carbon::parse($record->invoice->created_at)->format('H:i:s A')}}</p>
                </div>
            </div>

            <!-- Statement of Account Table -->
            <table class="w-full" style="margin-top: 30px;">
                <thead>
                    <tr>
                        <th class="border border-gray-500 px-4 py-2">Transaction Type</th>
                        <th class="border border-gray-500 px-4 py-2">Amount Paid</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-500 px-4 py-2 text-center">{{strtoupper($record->payment_type)}}</td>
                        <td class="border border-gray-500 px-4 py-2 text-right">₱ {{number_format($record->amount_paid, 2)}}</td>
                    </tr>
                    <tr>
                        <td class=" px-4 py-2 text-right font-bold">Total: </td>
                        <td class=" px-4 py-2 text-right font-bold">₱ {{number_format($record->amount_paid, 2)}}</td>
                    </tr>
                </tbody>
            </table>
            <div class="flex justify-between" style="margin-top: 30px;">
                <div>
                    <p class="font-semibold text-md" style="margin-top: 5px;">Cashier : {{strtoupper(auth()->user()->name)}}</p>
                </div>
                <div>
                    <p class="font-semibold text-md" style="margin-top: 5px;">Received By : {{strtoupper($record->student->first_name.' '.$record->student->last_name)}}</p>
                </div>
            </div>
    </div>
</x-filament-panels::page>
