<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Simple Table</title>
  <link rel="stylesheet">
  <style>
  /* Basic styling for the table */
    .simple-table {
    border-collapse: collapse;
    width: 100%;
    border: 2px solid black; /* Border color and thickness */
    }

    .simple-table th, .simple-table td {
    border: 1px solid black; /* Border for table cells */
    padding: 8px; /* Padding for content within cells */
    text-align: left; /* Align text to the left within cells */
    }
    #statement_title {
        text-align: center;
        font-size: 30px;
        font-weight: bold;
    }
  </style>
</head>
<body>
    <div>
        <h1>Good Day Mr./Mrs: {{$record->last_name}},</h1>
        <p>This is to inform you that your child <span style="font-weight: bold">{{$record->first_name}} {{$record->last_name}}</span> has a balance of <span style="font-weight: bold; text-decoration: underline;">₱ {{number_format($record->transactions()->latest()->first()->balance, 2)}}</span>.</p>
        <p>Here is a copy of your statement of account.</p>
        <p>Thank You.</p>
    </div>

<div>
    <p id="statement_title">STATEMENT OF ACCOUNT</p>
</div>
<table class="simple-table">
  <thead>
    <tr>
      <th>Date</th>
      <th>Description</th>
      <th>References</th>
      <th>Charges</th>
      <th>Credits</th>
    </tr>
  </thead>
  <tbody>
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
<div style="margin-top: 50px">
    {{now()}} End of Message.
</div>
</body>
</html>
