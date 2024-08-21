<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Invoice|{{$invoice->invoice_code}}</title>
    <style>
        @font-face {
            font-family: 'century';
            src: url('{{ storage_path("fonts/CenturyGothic.ttf") }}') format("truetype");
            font-weight: normal;
            font-style: normal;
        }
        @font-face {
            font-family: 'century_bold';
            src: url('{{ storage_path("fonts/gothicb.ttf") }}') format("truetype");
           
        }
        @page { margin-right:70px; }
        body{
            font-family: 'century';
            font-size: 11px;
        }
        .bg-yellow{
            background: #BDD6EE;
        }
        .bg-grey{
            background: #BDD6EE;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #000000;
            padding-bottom: 0;
            padding-top: 0;
        }
        .table thead th{
            border-bottom: 0;
        }
        .table tbody+tbody {
            border-top:0;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card border-0">
              <div class="card-body p-0">
                  <div>
                    <div class="w-25">
                        <img class="img-fluid" src="{{asset('images/logo1.png')}}" alt="">
                    </div>
                    <div><p class="mb-0 text-center" style="font-size: 18px; font-family: 'century_bold'">Invoice {{$invoice->invoice_code}}</p></div>
                    <div>
                        <p class="mb-0 text-right" style="font-size: 16px; font-family: 'century_bold'">Date: {{$invoice->updated_at->format('d/m/Y')}}</p>
                       </div>
                    <div>
                        <p class="mb-0" style="font-size: 16px;font-family: 'century_bold'">Supplier details</p>
                        <p class="mb-0">MINEGA NETWORKS Ltd</p>
                        <p class="mb-0">KICUKIRO - GIKONDO - KANSEREGE</p>
                        <p class="mb-0"><a href="mailto:info@mineganetworks.rw">E-mail: info@mineganetworks.rw</a></p>
                        <p class="mb-0"><a class="text-dark" href="tel:+250788312962">Telephone: +250788312962</a></p>
                        <p class="mb-0">TIN: 103242639</p>
                    </div>
                    <div class="mt-3">
                        <p class="mb-0" style="font-size: 16px; font-family: 'century_bold'">To</p>
                        <p class="mb-0">{{$invoice->company_name}}</p>
                        <p class="mb-0">TIN {{$invoice->tin_number}}</p>
                        @if(!is_null($invoice->address))
                        <p class="mb-0">{{$invoice->address}}</p>
                        @endif
                        @if($invoice->invoice_type == 1)
                        <p class="mb-0">PO: {{$invoice->purchaseOrder->po_number}}</p>
                        @endif
                    </div>
                    <div class="mt-3 mb-3" style="display: flex; align-items:center">
                        <p class="mb-0" style="font-size: 16px; font-family: 'century_bold'">Project: </p>
                        <p class="mb-0" >{{$invoice->project_title}}</p> 
                    </div>
                  </div>

                  <div class="table-responsive">
                    <table class="table table-bordered table-stripped">
                        <tr class="bg-yellow" style="font-family: 'century_bold'">
                            <th>#</th>
                            <th>Name/description</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                        </tr>
                        <tbody>
                            @forelse($items as $item)
                            <tr>
                                <td>{{$loop->iteration++}}</td>
                                <td>{{$item->item_name}}</td>
                                <td>{{$item->quantity}}</td>
                                <td>{{number_format($item->unit_price,0,'.',',')}}</td>
                                <td>{{number_format($item->total_price,0,'.',',')}}</td>
                            </tr>
                            @empty
                            @endforelse
                            <tr class="bg-grey" style="font-family: 'century_bold'">
                                <td colspan="4" class="text-center"><b>Total Excl. VAT</b></td>
                                <td style="font-family: 'century_bold'"><b>{{$total}}</b></td>
                            </tr>
                            <tr class="bg-grey" style="font-family: 'century_bold'">
                                <td colspan="4" class="text-center"><b>VAT(18%)</b> </td>
                                <td ><b>{{$vat}}</b></td>
                            </tr>
                            <tr class="bg-grey" style="font-family: 'century_bold'">
                                <td colspan="4" class="text-center"><b>Total Incl. VAT</b></td>
                                <td><b>{{$totalVat}}</b></td>
                            </tr>
                        </tbody>
                    </table>
                  </div>
                  <div>
                    <p style="font-size: 16px; font-family: 'century_bold'">Account details:</p>
                    <p>A/C 4014200818633 – MINEGA NETWORKS – Equity Bank Rwanda</p>
                  </div>
              </div>
            </div>
          </div>
    </div>
    <div class="footer">
        <p>Kicukiro District, Gikondo Sector, +250788312962, +250731000166, aimableg@mineganetworks.rw, www.mineganetworks.rw</p>
    </div>
</body>
</html>