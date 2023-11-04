<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Quotation|{{$quotation->quotation_code}}</title>
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
            background: yellow;
        }
        .bg-grey{
            background: rgb(212, 211, 211);
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
                    <div class="mb-3 " >
                        <div class="w-25">
                            <img class="img-fluid" src="{{asset('images/logo1.png')}}" alt="">
                        </div>
                        <p class="mb-0" style="margin-top: 1em !important">MINEGA NETWORKS Ltd</p>
                        <p class="mb-0">KICUKIRO - GIKONDO - KANSEREGE</p>
                        <p class="mb-0"><a href="mailto:info@mineganetworks.rw">E-mail: info@mineganetworks.rw</a></p>
                        <p class="mb-0"><a class="text-dark" href="tel:+250788312962">Telephone: +250788312962</a></p>
                    </div>
                    <div class="text-right" style="position:fixed;top:0; right:0">
                        <p class="mb-0" style="font-size: 18px; font-family: 'century_bold'">Quotation</p>
                        <p class="mb-0">Date: {{$quotation->created_at->format('d/m/Y')}}</p>
                    </div>
                    <div class="mt-3 mb-4">
                        <p class="mb-0" style="font-size: 16px; font-family: 'century_bold'">Quotation for:</p>
                        @if ($quotation->client_id == 0)
                        <p class="mb-0">{{$client}}</p>
                        @else
                        <p class="mb-0">{{$client->customer_name}}</p>
                        @if(!is_null($client->address))
                        <p class="mb-0">{{$client->address}}</p>
                        @endif
                        @if(!is_null($client->phone_number))
                        <p class="mb-0">{{$client->phone_number}}</p>
                        @endif
                        @if(!is_null($client->email))
                        <p class="mb-0">{{$client->email}}</p>
                        @endif
                        @if(!is_null($client->tin))
                        <p class="mb-0">TIN: {{$client->tin}}</p>
                        @endif
                        @endif
                      
                    </div>
                  </div>
                  <div class="text-center mt-4 bg-warning" style="padding: 0px; border: 1px solid #000000; border-bottom:0">
                    <p style="font-family: 'century_bold'; font-size:14px; margin-bottom:0;">{{$quotation->project_title}}</p>
                  </div>
                  <div>
                    <table class="table table-bordered table-stripped">
                        <tr class="bg-yellow" style="font-family: 'century_bold'">
                            <th>#</th>
                            <th>Item name/description</th>
                            <th>UOM</th>
                            <th>Unit Price</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                        </tr>
                        <tbody>
                            @forelse($items as $item)
                            <tr>
                                <td width="5%">{{$loop->iteration++}}</td>
                                <td  width="25%">{{$item->product->product_name}}</td>
                                <td  width="8%">{{$item->product->unit->unit_abbr}}</td>
                                <td  width="17%">{{number_format($item->unit_price,0,'.',',')}}</td>
                                <td  width="10%">{{$item->quantity}}</td>
                                <td  width="35%">{{number_format($item->total_price,0,'.',',')}}</td>
                            </tr>
                            @empty
                            @endforelse
                            <tr class="bg-grey" style="font-family: 'century_bold'">
                                <td colspan="5" class="text-center"><b>Total Excl. VAT</b></td>
                                <td style="font-family: 'century_bold'"><b>{{$total}}</b></td>
                            </tr>
                            <tr class="bg-grey" style="font-family: 'century_bold'">
                                <td colspan="5" class="text-center"><b>VAT(18%)</b> </td>
                                <td ><b>{{$vat}}</b></td>
                            </tr>
                            <tr class="bg-grey" style="font-family: 'century_bold'">
                                <td colspan="5" class="text-center"><b>Total Incl. VAT</b></td>
                                <td><b>{{$totalVat}}</b></td>
                            </tr>
                        </tbody>
                    </table>
                  </div>
                  <div>
                    <p class="mb-2" style="font-size: 16px; font-family: 'century_bold'">Note:</p>
                    <p>This quotation document is valid for 30 days only.</p>
                  </div>
              </div>
            </div>
          </div>
    </div>
</body>
</html>