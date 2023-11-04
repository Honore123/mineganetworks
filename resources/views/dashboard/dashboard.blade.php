@extends('layouts.app')

@section('content')
    <div class="row mb-5">
        <div class="col-md-12">
            <h3>Welcome {{auth()->user()->name}}</h3>
            <h6 class="font-weight-normal mb-0">Below are current <span class="text-primary">data!</span></h6>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent">
                  <a class="card card-tale text-decoration-none" href="{{route('quotation.index')}}" role="button">
                    <div class="card-body">
                      <p class="mb-4">Total Quotations</p>
                      <p class="fs-30 mb-2">{{number_format($quotation,0,'.',',')}}</p>
                      <p>(All)</p>
                    </div>
                  </a>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent ">
                  <a class="card card-dark-blue text-decoration-none" href="{{route('invoice.index')}}" role="button">
                    <div class="card-body">
                      <p class="mb-4">Total Invoices</p>
                      <p class="fs-30 mb-2">{{number_format($invoice,0,'.',',')}}</p>
                      <p>(All)</p>
                    </div>
                  </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                <a class="card text-light text-decoration-none" href="{{route('purchase-order.index')}}" role="button" style="background: #2f3683">
                <div class="card-body">
                    <p class="mb-4">Total POs</p>
                    <p class="fs-30 mb-2">{{number_format($purchaseOrder,0,'.',',')}}</p>
                    <p>(All)</p>
                </div>
                </a>
            </div>
            <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                <a class="card text-light text-decoration-none" href="{{route('riggers.index')}}" role="button" style="background: #c7ad36">
                <div class="card-body">
                    <p class="mb-4">Number of Riggers</p>
                    <p class="fs-30 mb-2">{{number_format($rigger,0,'.',',')}}</p>
                    <p>(All)</p>
                </div>
                </a>
            </div>
        </div>
        </div>
    </div>
    <div class="row">
      <div class="col-md-6 mb-4 mb-lg-0">
        <div class="h-100 card card-body">
          <canvas id="dashboard_chart"></canvas>
      </div>
      </div>
      <div class="col-md-6 mb-4 mb-lg-0">
        <div class="card card-body table-responsive">
          <table class="table table-bordered bg-white table-striped">
            <thead>
              <tr>
                <th class="bg-primary text-white">Item</th>
                <th class="bg-success text-white">Amount</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><h5>Uninvoiced P.O amount</h5></td>
                <td><h6>{{number_format($total_unpaid_amount,2,'.',',') }}</h6></td>
              </tr>
              <tr>
                <td><h5>Invoiced P.Os amount</h5></td>
                <td><h6>{{number_format($total_invoiced_amount,2,'.',',') }}</h6></td>
              </tr>
              <tr>
                <td><h5>Contract based invoice</h5></td>
                <td><h6>{{number_format($contact_unpaid_invoice,2,'.',',') }}</h6></td>
              </tr>
              <tr>
                <td><h5>Paid P.Os amount</h5></td>
                <td><h6>{{number_format($total_paid_amount,2,'.',',') }}</h6></td>
              </tr>
              <tr>
                <td><h5>Total P.Os amount</h5></td>
                <td><h6>{{number_format($total_po_amount,2,'.',',')}}</h6></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

@endsection
@push('scripts')
    <script>
        const url = "{{route('dashboard')}}";
            var dateTime = new Array();
            var ecgData = new Array();
            var colors = new Array();
            var borderColors = new Array();
            $.get(url, function(response){
              Object.keys(response).map((key)=>{
                
                ecgData.push(response[key]);
                if(key == 'total_po_amount'){
                    colors.push('rgba(54, 162, 235, 1)');
                    borderColors.push('rgb(54, 162, 235)');
                    dateTime.push('Total P.Os amount');
                }else if(key == 'contact_unpaid_invoice'){
                    colors.push('rgba(255, 99, 71, 1)');
                    borderColors.push('rgb(255, 99, 71)');
                    dateTime.push('Unpaid contract invoices');
                } else if(key == 'total_invoiced_amount'){
                    colors.push('rgba(255, 205, 86, 1)');
                    borderColors.push('rgb(255, 205, 86)');
                    dateTime.push('Invoiced P.Os amount');
                }else if(key == 'total_paid_amount'){
                  colors.push('rgba(87, 182, 87, 1)');
                    borderColors.push('rgb(87, 182, 87)');
                    dateTime.push('Paid P.Os amount');
                }else {
                  colors.push('rgba(255, 99, 71, 1)');
                    borderColors.push('rgb(255, 99, 71)');
                    dateTime.push('Uninvoiced P.O amount');
                }
              })
                ecgData.push(Chart.helpers.max(ecgData)+1);
                var ecgChart = document.getElementById("dashboard_chart").getContext('2d');

                var ecgDiagram = new Chart(ecgChart, {
                    type: 'horizontalBar',
                    data: {
                        labels:dateTime,
                        datasets: [{
                            label: 'Report Count',
                            data: ecgData,
                            borderWidth: 1,
                           backgroundColor: colors,
                           borderColor:borderColors
                        }]
                    },
                    options: {
                      tooltips: {
                            callbacks: {
                                label: function(tooltipItem, data) {
                                        value = Math.floor(tooltipItem.xLabel);
                                        value = value.toString();
                                        value = value.split(/(?=(?:...)*$)/);
                                        value = value.join(',');
                                        return value;
                                }
                            }
                        },
                        legend: {
                            display: false
                        },
                        animation:{
                            duration: 0
                        },
                        scales: {
                            xAxes: [{
                                ticks: {
                                    beginAtZero:true,
                                    userCallback: function(value, index, values) {
                                        value = value.toString();
                                        value = value.split(/(?=(?:...)*$)/);
                                        value = value.join(',');
                                        return value;
                                    }
                                }
                            }],
                        }
                    }
                });
            });
    </script>
@endpush