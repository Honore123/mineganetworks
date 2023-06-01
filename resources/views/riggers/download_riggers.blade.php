<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>List of Riggers</title>
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
            background: yellow;
        }
        .bg-grey{
            background: rgb(212, 211, 211);
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #000000;
        }
        .table thead th{
            border-bottom: 0;
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
                        <img class="img-fluid" src="data:image/png;base64,{{ base64_encode(file_get_contents(asset('images/logo1.png'))) }}" alt="">
                    </div>
                   <p class="mb-0">MINEGA NETWORKS Ltd</p>
                   <p class="mb-0">KICUKIRO - GIKONDO - KANSEREGE</p>
                   <p class="mb-0"><a href="mailto:info@mineganetworks.rw">E-mail: info@mineganetworks.rw</a></p>
                   <p class="mb-0"><a class="text-dark" href="tel:+250788312962">Telephone: +250788312962</a></p>
                  </div>
                  <div class="text-center mt-4 bg-warning" style="padding: 1px 0px; border: 1px solid #000000; border-bottom:0">
                    <p style="font-family: 'century_bold'">List of Riggers</p>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-bordered table-stripped">
                        <thead>
                            <tr class="bg-yellow" style="font-family: 'century_bold'">
                                <th>#</th>
                                <th>Names</th>
                                <th>National ID</th>
                                <th>Phone number</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                            <tr>
                                <td>{{$loop->iteration++}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->nid}}</td>
                                <td>{{$item->phone}}</td>
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                  </div>
              </div>
            </div>
          </div>
    </div>
</body>
</html>