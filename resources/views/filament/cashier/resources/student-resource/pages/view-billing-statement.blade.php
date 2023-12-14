<x-filament-panels::page>
    <div class="flex justify-between">
        <div  class="flex">
            <div class="px-1">
                <x-filament::button wire:click="addBilling" type="button" icon="heroicon-o-printer" class="btn btn-primary w-32">Print</x-filament::button>
            </div>
            <div class="px-1">
            <x-filament::button wire:click="addBilling" type="button" icon="heroicon-o-paper-airplane" class="btn btn-success w-42">Send E-Statement</x-filament::button>
            </div>
        </div>
        <div>
            <div class="px-1">
                <x-filament::button wire:click="redirectToPayment" type="button" icon="heroicon-o-banknotes" class="btn btn-success w-30">Payment</x-filament::button>
            </div>
        </div>
    </div>


    <div class="container mx-auto mt-8">
        <div class="border border-black p-6 text-warning rounded-md">
            <!-- Content inside the box -->
            <p class="font-bold text-2xl">STATEMENT OF ACCOUNT</p>
            <div class="flex justify-between" style="margin-top: 30px;">
                <div>
                    <p class="font-semibold text-md">Student Number : 000101012</p>
                    <p class="font-semibold text-md">Full Name : {{$record->first_name.' '.$record->last_name}}</p>
                    <p class="font-semibold text-md">Address : </p>
                </div>
                <div>
                    <p class="font-semibold text-md">Grade Level : {{$record->grade->name}}</p>
                    <p class="font-semibold text-md">Section : {{$record->section->name}}</p>
                    <p class="font-semibold text-md">Cashier : {{ucfirst(auth()->user()->name)}}</p>
                </div>
            </div>

            <!-- Statement of Account Table -->
            <table class="w-full" style="margin-top: 30px;">
                <thead>
                    <tr>
                        <th class="border border-gray-500 px-4 py-2">Date</th>
                        <th class="border border-gray-500 px-4 py-2">Description</th>
                        <th class="border border-gray-500 px-4 py-2">References</th>
                        <th class="border border-gray-500 px-4 py-2">Charges</th>
                        <th class="border border-gray-500 px-4 py-2">Credits</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Sample Data (Replace this with your actual data) -->
                    @foreach ($record->grade->fees()->get() as $fee)
                    <tr>
                        <td class="border border-gray-500 px-4 py-2">{{Carbon\Carbon::parse($fee->created_at)->format('m/d/Y')}}</td>
                        <td class="border border-gray-500 px-4 py-2">Tuition Fee</td>
                        <td class="border border-gray-500 px-4 py-2"></td>
                        <td class="border border-gray-500 px-4 py-2 text-center">₱ {{number_format($fee->tuition, 2)}}</td>
                        <td class="border border-gray-500 px-4 py-2"></td>
                    </tr>

                    <tr>
                        <td class="border border-gray-500 px-4 py-2">{{Carbon\Carbon::parse($fee->created_at)->format('m/d/Y')}}</td>
                        <td class="border border-gray-500 px-4 py-2">Miscellaneous Fee</td>
                        <td class="border border-gray-500 px-4 py-2"></td>
                        <td class="border border-gray-500 px-4 py-2 text-center">₱ {{number_format($fee->misc, 2)}}</td>
                        <td class="border border-gray-500 px-4 py-2"></td>
                    </tr>

                    <tr>
                        <td class="border border-gray-500 px-4 py-2">{{Carbon\Carbon::parse($fee->created_at)->format('m/d/Y')}}</td>
                        <td class="border border-gray-500 px-4 py-2">Books GRADE - {{$record->grade->name}}</td>
                        <td class="border border-gray-500 px-4 py-2"></td>
                        <td class="border border-gray-500 px-4 py-2 text-center">₱ {{number_format($fee->books, 2)}}</td>
                        <td class="border border-gray-500 px-4 py-2"></td>
                    </tr>
                    @endforeach
                    <!-- Add more rows for additional items -->
                </tbody>
            </table>
        </div>
    </div>
</x-filament-panels::page>
