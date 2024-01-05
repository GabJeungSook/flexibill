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
        <h1>Good Day Mr./Mrs: {{$record->student->last_name}},</h1>
        <p>Your payment amounting of <span style="font-weight: bold; text-decoration: underline">₱ {{number_format($record->amount_paid, 2)}}</span>
           has been confirmed.</p>
        <p>Date: <span style="font-weight: bold;">{{Carbon\Carbon::parse($record->created_at)->format('F d, Y')}}</span></p>
        <p>Time: <span style="font-weight: bold;">{{Carbon\Carbon::parse($record->created_at)->format('h:i A')}}</span></p>
        <p>Payment Type: <span style="font-weight: bold;">{{strtoupper($record->payment_type)}}</span></p>
        <p>Invoice Number: <span style="font-weight: bold;">{{$record->invoice->invoice_number}}</span></p>
        <p>Here is a copy of your invoice.</p>
        <p>Thank You.</p>
    </div>

<div>
    <p id="statement_title">INVOICE</p>
</div>
<table class="simple-table">
  <thead>
    <tr>
      <th>Transaction Type</th>
      <th>Amount Paid</th>
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
<div style="margin-top: 50px">
    {{now()}} End of Message.
</div>
</body>
</html>
