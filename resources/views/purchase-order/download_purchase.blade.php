<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Purchase Order|{{$purchaseOrder->vendor->vendor_name}}_{{$purchaseOrder->po_code}}</title>
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
        }
        .table thead th{
            border-bottom: 0;
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
                    
                    <div class="mb-3">
                        <p class="mb-0" style="font-size: 18px; font-family: 'century_bold'">Purchase Order</p>
                        <p class="mb-0" style="font-size: 16px; font-family: 'century_bold'">Date: {{$purchaseOrder->created_at->format('d/m/Y')}}</p>
                        <p class="mb-0" style="font-size: 16px; font-family: 'century_bold'">PO. No: {{$purchaseOrder->po_code}}</p>
                    </div>
                    <div class="text-right" style="position:fixed;top:0; right:0">
                        <div class="w-25" style="position:fixed;top:0; right:0">
                            <img class="img-fluid" src="{{asset('images/logo1.png')}}" alt="">
                        </div>
                        <p class="mb-0" style="margin-top: 4em !important">MINEGA NETWORKS Ltd</p>
                        <p class="mb-0">KICUKIRO - GIKONDO - KANSEREGE</p>
                        <p class="mb-0"><a href="mailto:info@mineganetworks.rw">E-mail: info@mineganetworks.rw</a></p>
                        <p class="mb-0"><a class="text-dark" href="tel:+250788312962">Telephone: +250788312962</a></p>
                    </div>
                    <div class="mt-3 mb-4" style="margin-top: 4em !important">
                        <p class="mb-0" style="font-size: 16px; font-family: 'century_bold'">Vendor</p>
                        <p class="mb-0">Vendor Name: {{$purchaseOrder->vendor->vendor_name}}</p>
                        @if(!is_null($purchaseOrder->vendor->phone_number))
                        <p class="mb-0">Phone: {{$purchaseOrder->vendor->phone_number}}</p>
                        @endif
                        @if(!is_null($purchaseOrder->vendor->email))
                        <p class="mb-0">Email: {{$purchaseOrder->vendor->email}}</p>
                        @endif
                        @if(!is_null($purchaseOrder->vendor->tin))
                        <p class="mb-0">TIN: {{$purchaseOrder->vendor->tin}}</p>
                        @endif
                    </div>
                  </div>

                  <div class="table-responsive">
                    <table class="table table-bordered table-stripped">
                        <thead>
                            <tr class="bg-yellow" style="font-family: 'century_bold'">
                                <th>#</th>
                                <th>Name/description</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                            <tr>
                                <td>{{$loop->iteration++}}</td>
                                <td>{{$item->product->product_name}}</td>
                                <td>{{$item->quantity}}</td>
                                <td>{{number_format($item->unit_price,0,'.',',')}}</td>
                                <td>{{number_format($item->total_price,0,'.',',')}}</td>
                            </tr>
                            @empty
                            @endforelse
                            <tr class="bg-grey" style="font-family: 'century_bold'">
                                <td colspan="4" class="text-center"><b>Total</b></td>
                                <td style="font-family: 'century_bold'"><b>{{$total}} Rwf</b></td>
                            </tr>
                        </tbody>
                    </table>
                  </div>
                  <div style="margin-top: 10em !important">
                    <p class="pt-2 w-25" style="position: fixed; left:0;font-size: 12px; font-family: 'century';border-top: 1px dashed #000">Date</p>
                    <p class="pt-2 w-25" style="position: fixed; right:0;font-size: 12px; font-family: 'century'; border-top: 1px dashed #000">Authorized Signature</p>
                  </div>
              </div>
            </div>
          </div>
    </div>
    <div class="footer">
        <p class="mb-4" style="color:#000000">If you haveany questions, concerns or queries regarding this PO, please feel free to write to us through (info@mineganetworks.rw)</p>
        <p>Kicukiro District, Gikondo Sector, +250788312962, +250731000166, aimableg@mineganetworks.rw, www.mineganetworks.rw</p>
    </div>
</body>
</html>