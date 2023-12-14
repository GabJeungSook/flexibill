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
    @endif
  </tbody>
</table>
<div style="margin-top: 50px">
    {{now()}} End of Message.
</div>
</body>
</html>
