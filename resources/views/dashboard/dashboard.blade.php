@extends('layouts.app')

@section('content')
    <div class="row mb-5">
        <div class="col-md-6">
            <h3>Welcome {{auth()->user()->name}}</h3>
            <h6 class="font-weight-normal mb-0">Below are <span class="font-weight-bold">{{$start_date->format('d/m/Y')}}</span> up to <span class="font-weight-bold">{{$end_date->format('d/m/Y')}}</span> data!</h6>
        </div>
       
          <form action="{{route('dashboard')}}" method="GET" class="col-md-6 d-flex align-items-center justify-content-end">
            <div class="form-group mb-0">
              <input type="date" class="form-control" name="start" id="startDate" placeholder="Start date" value={{$start_date->format('Y-m-d')}}>
          </div>
          <div class="pl-2">
            <span>-</span>
          </div>
          <div class="form-group mb-0 pl-2">
            <input type="date" class="form-control" id="endDate" name="end" placeholder="d/m/Y" value={{$end_date->format('Y-m-d')}}>
          </div>
          <div class="form-group mb-0 pl-3"> 
            <button class="btn btn-primary rounded-0">Filter</button>
          </div>
        
          </form>
       
    </div>
    <div class="row">
        <div class="col-md-6 mb-4 stretch-card transparent">
          <a class="card text-decoration-none" href="{{route('quotation.index')}}" role="button">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <h4 class="mb-4 text-dark">Total Quotations</h4>
                <p class="fs-30 mb-2 text-dark">{{number_format($quotation,0,'.',',')}}</p>
              </div>
              
              <canvas id="quotationChart" class="w-100"></canvas>
              {{-- <p class="fs-30 mb-2">{{number_format($quotation,0,'.',',')}}</p> --}}
            </div>
          </a>
        </div>
        <div class="col-md-6 mb-4 stretch-card transparent">
            <a class="card text-decoration-none" href="{{route('invoice.index')}}" role="button">
              <div class="card-body">
                <div class="d-flex justify-content-between">
                  <h4 class="mb-4 text-dark">Total Invoices</h4>
                  <p class="fs-30 mb-2 text-dark">{{number_format($invoice,0,'.',',')}}</p>
                </div>
               
                <canvas id="invoiceChart" class="w-100"></canvas>
                {{-- <p class="fs-30 mb-2">{{number_format($invoice,0,'.',',')}}</p> --}}
              </div>
            </a>
        </div>
        <div class="col-md-6 mb-4 stretch-card transparent">
                <div class="card text-decoration-none"  role="button">
                <div class="card-body">
                   
                    <div class="d-flex justify-content-between">
                      <h4 class="mb-4">Purchase Orders</h4>
                      <p class="fs-30 mb-2 text-dark">{{number_format($customerPO,0,'.',',')}}</p>
                    </div>
                    <canvas id="purchaseOrderChart" class="w-100"></canvas>
                    {{-- <div class="row">
                      <a href="{{route('purchase-order.index')}}" class="col-md-6 text-light text-decoration-none">
                        <p class="fs-30 mb-2">{{number_format($purchaseOrder,0,'.',',')}}</p>
                        <p>Contractors</p>
                      </a>
                      <a href="{{route('customer-po.index')}}" class="col-md-6 text-light text-decoration-none">
                        <p class="fs-30 mb-2">{{number_format($customerPO,0,'.',',')}}</p>
                        <p>Customers</p>
                      </a>
                    </div> --}}
                </div>
                </div>
        </div>
    </div>
    <div class="row">
      <div class="col-md-6 mb-4">
        <div class="card card-body h-100">
          <div class="d-flex justify-content-between align-items-center mb-3 border-bottom">
            <h4>Project per client chart</h4>
            <p class="fs-30 mb-2 text-dark" id="projectTotal"></p>
          </div>
          
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
                <td><h5>Extra rigger services</h5></td>
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
            var cashflow = @json($cashflow_chart);
              console.log(cashflow);
              Object.keys(cashflow.original).map((key)=>{
                
                ecgData.push(cashflow.original[key]);
                if(key == 'total_po_amount'){
                    colors.push('rgba(54, 162, 235, 1)');
                    borderColors.push('rgb(54, 162, 235)');
                    dateTime.push('Total P.Os amount');
                }else if(key == 'contact_unpaid_invoice'){
                    colors.push('rgba(255, 99, 71, 1)');
                    borderColors.push('rgb(255, 99, 71)');
                    dateTime.push('Extra rigger services');
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
            var ctx = document.getElementById('doughnutChart').getContext('2d');
            const chartProjects = @json($chart_projects);
           
            if(chartProjects.length > 0){
              let names = chartProjects.map(obj => obj.company_name);
              let projects = chartProjects.map(obj => obj.total_projects);
              let total = projects.reduce((a, b) => a + b, 0);
              $('#projectTotal').text(total);
              var myChart = new Chart(ctx, {
                type: 'pie',
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
                options:{
                  legend:{
                    position:"right",
                  },
                },
            });
            }
            var qtx = document.getElementById('quotationChart').getContext('2d');
            const chartQuotations = @json($chart_quotations);
           
            if(chartQuotations.length > 0){
              let names = chartQuotations.map(obj => obj.client_name);
              let quotations = chartQuotations.map(obj => obj.total_quotations);
              let total = quotations.reduce((a, b) => a + b, 0);
              var myChart = new Chart(qtx, {
                type: 'pie',
                data: {
                    labels: names,
                    datasets: [{
                        data:quotations,
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
                options:{
                  legend:{
                    position:"right",
                  },
                }
            });
            }
            var itx = document.getElementById('invoiceChart').getContext('2d');
            const chartInvoices = @json($chart_invoices);
           
            if(chartInvoices.length > 0){
              let names = chartInvoices.map(obj => obj.company_name);
              let invoices = chartInvoices.map(obj => obj.total_invoices);
              let total = invoices.reduce((a, b) => a + b, 0);
              var myChart = new Chart(itx, {
                type: 'pie',
                data: {
                    labels: names,
                    datasets: [{
                        data:invoices,
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
                options:{
                  legend:{
                    position:"right",
                  },
                }
            });
            }
            var ptx = document.getElementById('purchaseOrderChart').getContext('2d');
            const purchaseOrderChart = @json($chart_po);
           
            if(purchaseOrderChart.length > 0){
              let names = purchaseOrderChart.map(obj => obj.company_name);
              let purchaseOrders = purchaseOrderChart.map(obj => obj.total_po);
              let total = purchaseOrders.reduce((a, b) => a + b, 0);
              var myChart = new Chart(ptx, {
                type: 'pie',
                data: {
                    labels: names,
                    datasets: [{
                        data:purchaseOrders,
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
                options:{
                  legend:{
                    position:"right",
                  },
                }
            });
            }
    </script>
@endpush