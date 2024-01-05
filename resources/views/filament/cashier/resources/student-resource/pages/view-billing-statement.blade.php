<x-filament-panels::page>
    <div class="flex justify-between">
        <div  class="flex">
            <div class="px-1">
                <x-filament::button  type="button" icon="heroicon-o-printer" class="btn btn-primary w-32"  onclick="printDiv('printarea')">Print</x-filament::button>
            </div>
            <div class="px-1">
            @if ($record->email != null)
                <x-filament::button wire:click="sendEmailStatement" type="button" icon="heroicon-o-paper-airplane" class="btn btn-success w-42">Send E-Statement</x-filament::button>
            @endif
            </div>
        </div>
        <div>
            <div class="px-1">
                <x-filament::button wire:click="redirectToPayment" type="button" icon="heroicon-o-banknotes" class="btn btn-success w-30">Payment</x-filament::button>
            </div>
        </div>
    </div>


    <div id="printarea" class="container mx-auto mt-8">
        <div class="border border-black p-6 text-warning rounded-md">
            <!-- Content inside the box -->
            <p class="font-bold text-2xl">STATEMENT OF ACCOUNT</p>
            <div class="flex justify-between" style="margin-top: 30px;">
                <div>
                    <p class="font-semibold text-md" style="margin-top: 5px;">Student ID : 00000{{$record->id}}</p>
                    <p class="font-semibold text-md" style="margin-top: 5px;">Full Name : {{$record->first_name.' '.$record->last_name}}</p>
                    <p class="font-semibold text-md" style="margin-top: 5px;">Address : {{$record->address}}</p>
                </div>
                <div>
                    <p class="font-semibold text-md" style="margin-top: 5px;">Grade Level : {{$record->grade->name}}</p>
                    <p class="font-semibold text-md" style="margin-top: 5px;">Section : {{$record->section->name}}</p>
                    <p class="font-semibold text-md" style="margin-top: 5px;">Cashier : {{ucfirst(auth()->user()->name)}}</p>
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
                    @if ($fee->additional_fees()->count() > 0)
                        @foreach ($fee->additional_fees()->get() as $additional_fee)

                        <tr>
                            <td class="border border-gray-500 px-4 py-2">{{Carbon\Carbon::parse($additional_fee->created_at)->format('m/d/Y')}}</td>
                            <td class="border border-gray-500 px-4 py-2"><span class="font-semibold">Additional Fee</span> - {{$additional_fee->description}}</td>
                            <td class="border border-gray-500 px-4 py-2"></td>
                            <td class="border border-gray-500 px-4 py-2 text-center">₱ {{number_format($additional_fee->amount, 2)}}</td>
                            <td class="border border-gray-500 px-4 py-2"></td>
                        </tr>
                        @endforeach
                    @endif
                    @endforeach
                    @if ($record->transactions()->count() > 0)
                    @foreach ($record->transactions as $transaction)
                    <tr>
                        <td class="border border-gray-500 px-4 py-2">{{Carbon\Carbon::parse($transaction->created_at)->format('m/d/Y')}}</td>
                        <td class="border border-gray-500 px-4 py-2">{{strtoupper($transaction->payment_type)}}</td>
                        <td class="border border-gray-500 px-4 py-2">{{$transaction->invoice->invoice_number}}</td>
                        <td class="border border-gray-500 px-4 py-2 text-center"></td>
                        <td class="border border-gray-500 px-4 py-2">₱ {{number_format($transaction->amount_paid, 2)}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td class=""></td>
                        <td class=""></td>
                        <td class=""></td>
                        <td class=""></td>
                        <td class=""></td>
                    </tr>
                    <tr>
                        <td class=""></td>
                        <td class=""></td>
                        <td class=" px-4 py-2 font-bold">Total : </td>
                        <td class=" px-4 py-2 text-center font-bold">₱ {{number_format($transaction->total, 2)}}</td>
                        <td class=" px-4 py-2 font-bold">₱ {{number_format($record->transactions->sum('amount_paid'), 2)}}</td>
                    </tr>
                    <tr>
                        <td class=""></td>
                        <td class=""></td>
                        <td class="border-t border-gray-500 px-4 py-2 font-bold">Balance : </td>
                        <td class="border-t border-gray-500 px-4 py-2 text-center"></td>
                        <td class="border-t border-gray-500 px-4 py-2 font-bold">₱ {{number_format($record->transactions()->latest()->first()->balance, 2)}}</td>
                    </tr>
                    @else
                    <tr>
                        <td class=""></td>
                        <td class=""></td>
                        <td class=""></td>
                        <td class=""></td>
                        <td class=""></td>
                    </tr>
                    <tr>
                        <td class=""></td>
                        <td class=""></td>
                        <td class=" px-4 py-2 font-bold">Total : </td>
                        @php
                            if($record->grade->fees()->first()->additional_fees()->count() > 0)
                            {
                                $total_additional = 0;
                                foreach ($record->grade->fees()->first()->additional_fees()->get() as $key => $additional_fee) {
                                    $total_additional += $additional_fee->amount;
                                }
                                $total = $record->grade->fees()->first()->tuition + $record->grade->fees()->first()->misc + $record->grade->fees()->first()->books + $total_additional;
                            }else{
                                $total = $record->grade->fees()->first()->tuition + $record->grade->fees()->first()->misc + $record->grade->fees()->first()->books;

                            }
                        @endphp
                        <td class=" px-4 py-2 text-center font-bold">₱ {{number_format($total, 2)}}</td>
                        <td class=" px-4 py-2 font-bold">₱ 0.00</td>
                    </tr>
                    <tr>
                        <td class=""></td>
                        <td class=""></td>
                        <td class="border-t border-gray-500 px-4 py-2 font-bold">Balance : </td>
                        <td class="border-t border-gray-500 px-4 py-2 text-center"></td>
                        <td class="border-t border-gray-500 px-4 py-2 font-bold">₱ {{number_format($total, 2)}}</td>
                    </tr>

                    @endif

                </tbody>
            </table>
            <div class="flex justify-between" style="margin-top: 35px;">
                <div>
                    <p class="font-semibold text-md" style="margin-top: 5px;">Cashier : {{strtoupper(auth()->user()->name)}}</p>
                </div>
                <div>
                    <p class="font-semibold text-md" style="margin-top: 5px;">Received By : {{strtoupper($record->first_name.' '.$record->last_name)}}</p>
                </div>
            </div>
        </div>
    </div>
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;

        }
    </script>
</x-filament-panels::page>
