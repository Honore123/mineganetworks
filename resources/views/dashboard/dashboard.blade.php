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
                <div class="card"  role="button" style="background: #2f3683">
                <div class="card-body text-light">
                    <p class="mb-4">Purchase Orders</p>
                    <div class="row">
                      <a href="{{route('purchase-order.index')}}" class="col-md-6 text-light text-decoration-none">
                        <p class="fs-30 mb-2">{{number_format($purchaseOrder,0,'.',',')}}</p>
                        <p>Contractors</p>
                      </a>
                      <a href="{{route('customer-po.index')}}" class="col-md-6 text-light text-decoration-none">
                        <p class="fs-30 mb-2">{{number_format($customerPO,0,'.',',')}}</p>
                        <p>Customers</p>
                      </a>
                    </div>
                </div>
                </div>
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
      <div class="col-md-6 mb-4">
        <div class="card card-body h-100">
          <h4 class="mb-3 border-bottom pb-3">Project per client chart</h4>
          <canvas id="doughnutChart"></canvas>
        </div>
      </div>
      <div class="col-md-6 mb-4">
        <div class="card card-body h-100 table-responsive">
          <h4 class="mb-3 border-bottom pb-3">Project per client</h4>
          <table class="table table-bordered bg-white table-striped">
            <thead>
              <tr>
                <th class="bg-primary text-white">Item</th>
                <th class="bg-success text-white">No of Projects</th>
              </tr>
            </thead>
            <tbody>
              @forelse($chart_projects as $projects)
              <tr>
                <td><h5>{{$projects->company_name}}</h5></td>
                <td><h6>{{number_format($projects->total_projects,0,'.',',') }}</h6></td>
              </tr>
              @empty
                  
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 mb-4 mb-lg-0">
        <div class="h-100 card card-body">
          <h4 class="mb-3 border-bottom pb-3">Cashflow chart</h4>
          <canvas id="dashboard_chart"></canvas>
      </div>
      </div>
      <div class="col-md-6 mb-4 mb-lg-0">
        <div class="card card-body table-responsive">
          <h4 class="mb-3 border-bottom pb-3">Cashflow</h4>
          <table class="table table-bordered bg-white table-striped">
            <thead>
              <tr>
                <th class="bg-primary text-white">Item</th>
                <th class="bg-success text-white">Amount (Rwf)</th>
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
                <td><h5>Rigger services</h5></td>
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
                    dateTime.push('Rigger services');
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
            var ctx = document.getElementById('doughnutChart').getContext('2d');
            const chartProjects = @json($chart_projects);
           
            if(chartProjects.length > 0){
              let names = chartProjects.map(obj => obj.company_name);
              let projects = chartProjects.map(obj => obj.total_projects);
              let total = projects.reduce((a, b) => a + b, 0);
              var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: names,
                    datasets: [{
                        data:projects,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(153, 102, 255, 0.7)',
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                plugins: {
                  afterDraw: (chart) => {
                      let ctx = chart.ctx;
                      let width = chart.width;
                      let height = chart.height;
                      let posX = width / 2;
                      let posY = height / 2;
                      ctx.font = '30px Verdana';
                      ctx.textAlign = 'center';
                      ctx.textBaseline = 'middle';
                      ctx.fillText(total, posX, posY);
                      ctx.fillText('Total', posX, (posY*1.3))
                  }
              }
            });
            }
            
    </script>
@endpush