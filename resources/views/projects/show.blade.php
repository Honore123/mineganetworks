@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12  ">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
                <h4 class="card-title">{{$project->project_name}} project</h4>
                <div>
                    <a href="{{url()->previous()}}" class="btn btn-outline-primary rounded-0">Go Back</a>
                </div>
            </div>
            <div class="mt-2">
                @include('layouts.partials.notification')
            </div>
            <p class="card-description">All documents are below</p>
            <ul class="nav nav-pills nav-pills-primary" id="pills-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="pills-quotation-tab" data-toggle="pill" href="#pills-quotation" role="tab" aria-controls="pills-quotation" aria-selected="true">Quotations</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="pills-po-tab" data-toggle="pill" href="#pills-po" role="tab" aria-controls="pills-po" aria-selected="false">Purchase order</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="pills-acceptance-tab" data-toggle="pill" href="#pills-acceptance" role="tab" aria-controls="pills-acceptance" aria-selected="false">Acceptance docs</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="pills-invoices-tab" data-toggle="pill" href="#pills-invoices" role="tab" aria-controls="pills-invoices" aria-selected="false">Invoices</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="pills-issues-tab" data-toggle="pill" href="#pills-issues" role="tab" aria-controls="pills-issues" aria-selected="false">Issues</a>
              </li>
            </ul>
            <div class="tab-content border-0 px-0" id="pills-tabContent">
              <div class="tab-pane fade show active" id="pills-quotation" role="tabpanel" aria-labelledby="pills-quotation-tab">
                <h5>List of quotations</h5>
                <div class="row">
                  @include('projects.partials.quotation')
                </div>
              </div>
              <div class="tab-pane fade" id="pills-po" role="tabpanel" aria-labelledby="pills-po-tab">
                <h5>Purchase orders</h5>
                <div class="row">
                  @include('projects.partials.customer_po')
                </div>
              </div>
              <div class="tab-pane fade" id="pills-acceptance" role="tabpanel" aria-labelledby="pills-acceptance-tab">
                <div class="row">
                  @include('projects.partials.acceptance.index')
                </div>
              </div>
              <div class="tab-pane fade" id="pills-invoices" role="tabpanel" aria-labelledby="pills-invoices-tab">
                <h5>Invoices</h5>
                <div class="row">
                  @include('projects.partials.invoice')
                </div>
              </div>
              <div class="tab-pane fade" id="pills-issues" role="tabpanel" aria-labelledby="pills-issues-tab">
                  @include('projects.partials.risk-management.index')
              </div>
            </div>
          </div>
        </div>
      </div>
</div>
@endsection
@push('scripts')
<script>
  $('#quotations-table').DataTable({
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            'responsive': false,
            "aLengthMenu": [[10,25, 50, 75, -1], [10,25, 50, 75, "All"]],
            "iDisplayLength": 25,
            "processing":true,
            "serverSide":true,
            "ajax": {
                "url": "{{route('project.quotation',$project->id)}}",
                "type": 'GET',
            },
            "columns": [
                {"data": 'DT_RowIndex', "name": 'DT_RowIndex', orderable: false,searchable: false,"className":"text-middle"},
                { "data": 'quotation_code', "name": 'quotation_code'},
                { "data": 'project_title', "name": 'project_title',"className":"w-25"},
                { "data": 'total_inc_vat', "name": 'total_inc_vat',"className":"text-middle"},
                { "data": 'date', "name": 'date',"className":"text-middle"},
                {"data": 'option', "name": 'option', orderable:false, searchable:false,"className":"text-middle"},
            ]
        })
        $('#customers-table').DataTable({
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            'responsive': true,
            "aLengthMenu": [[10,25, 50, 75, -1], [10,25, 50, 75, "All"]],
            "iDisplayLength": 10,
            "processing":true,
            "serverSide":true,
            "ajax": {
                "url": "{{route('project.customer-po',$project->id)}}",
                "type": 'GET',
            },
            "columns": [
                {"data": 'DT_RowIndex', "name": 'DT_RowIndex', orderable: false,searchable: false,"className":"text-middle"},
                { "data": 'po_number', "name": 'po_number'},
                { "data": 'status', "name": 'status',"className":"text-center"},
                { "data": 'total_amount', "name": 'total_amount',"className":"text-center"},
                { "data": 'remaining_amount', "name": 'remaining_amount',"className":"text-center"},
                { "data": 'created_at', "name": 'created_at',"className":"text-center"},
                {"data": 'option', "name": 'option', orderable:false, searchable:false,"className":"text-middle"},
            ]
        })
        $('#invoices-table').DataTable({
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            'responsive': false,
            "aLengthMenu": [[10,25, 50, 75, -1], [10,25, 50, 75, "All"]],
            "iDisplayLength": 10,
            "processing":true,
            "serverSide":true,
            "ajax": {
                "url": "{{route('project.invoice',$project->id)}}",
                "type": 'GET',
            },
            "columns": [
                {"data": 'DT_RowIndex', "name": 'DT_RowIndex', orderable: false,searchable: false,"className":"text-middle"},
                { "data": 'invoice_code', "name": 'invoice_code'},
                { "data": 'status', "name": 'status',"className":"text-middle"},
                { "data": 'purchase_order.po_number', "name": 'purchase_order.po_number',"defaultContent":'-',"className":"text-middle"},
                { "data": 'total_inc_vat', "name": 'total_inc_vat',"className":"text-middle"},
                { "data": 'date', "name": 'date',"className":"text-middle"},
                {"data": 'option', "name": 'option', orderable:false, searchable:false,"className":"text-middle"},
            ]
        })
        $(document).ready(function(){
        flatpickr('#datetimepicker', {
            enableTime: true,
            dateFormat: 'Y-m-d H:i',
        });
        flatpickr('#edit_datetimepicker', {
            enableTime: true,
            dateFormat: 'Y-m-d H:i',
        });
        $('#customer_purchase_order_id').select2();
       
            $('#risk_id').select2();
            $('#edit_risk_id').select2();
            const url = "{{route('risk-management.chart',$project->id)}}";
            var dateTime = new Array();
            var ecgData = new Array();
            var colors = new Array();
            var borderColors = new Array();
            $.get(url, function(response){
                response.forEach(function(data){
                    dateTime.push(data.risk_name);
                    ecgData.push(data.total_risks);
                    if(data.risk_severity == 'High'){
                        colors.push('rgba(255, 99, 132, 1)');
                        borderColors.push('rgb(255, 99, 132)');
                    } else if(data.risk_severity == 'Medium'){
                        colors.push('rgba(255, 205, 86, 1)');
                        borderColors.push('rgb(255, 205, 86)');
                    }else {
                        colors.push('rgba(54, 162, 235, 1)');
                        borderColors.push('rgb(54, 162, 235)');
                    }
                });
                ecgData.push(Chart.helpers.max(ecgData)+1);
                var ecgChart = document.getElementById("risks_chart").getContext('2d');

                var ecgDiagram = new Chart(ecgChart, {
                    type: 'bar',
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
                        legend: {
                            display: false
                        },
                        animation:{
                            duration: 0
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true,
                                    userCallback: function(label, index, labels) {
                    
                                        if (Math.floor(label) === label) {
                                            return label;
                                        }
                                    }
                                }
                            }],
                            xAxes: [{
                                // Change here
                                barPercentage: 0.2,
                                categoryPercentage:1
                            }]
                        }
                    }
                });
            });
           
        });
        
        function issueResolved(id){
            var url = '{{ route("risk-management.resolve", ":id") }}';
            url = url.replace(':id',id);
            $('#issue_resolved_form').attr("action",url)
            $('#resolved_modal').modal('show');
           
        }
        function editAcceptance(id){
            $('#edit_customer_purchase_order_id_'+id).select2();

        }
        function editProjectRisk(id){
            const projectRisks = @json($projectRisks);
            const risks = @json($risks);
            const projectRisk = projectRisks.find(projectRisk => projectRisk.id == id)

            $.each(risks, function(index, risk) {
                var $option = $('<option>', {
                    value: risk.id,
                    text: risk.risk_name
                });

                if (risk.id === projectRisk.risk_id) {
                    $option.attr('selected', 'selected');
                }

                $('#edit_risk').append($option);
            });
            $('#edit_reportee').val(projectRisk.reportee);
            $('#edit_assigned_to').val(projectRisk.assigned_to);
            $('#edit_datetimepicker').val(projectRisk.reported_at);
            var url = '{{ route("risk-management.update", ":id") }}';
            url = url.replace(':id',id);
            $('#edit_risk_project').attr("action",url)
            $('#risk_edit').modal('show');
        }
        function deleteAlert(id, name){
            swal.fire( {
                title:'Confirmation',
                text:'Are you sure you want to remove '+ name + ' risk ?',
                icon: 'warning',
                confirmButtonText: 'Yes',
                cancelButtonText:'No',
                showCancelButton: true,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-risk-project-'+ id).submit();
                }
            });
        }
        function deleteAcceptance(id, name){
            swal.fire( {
                title:'Confirmation',
                text:'Are you sure you want to remove acceptance document with PO number: '+ name + '?',
                icon: 'warning',
                confirmButtonText: 'Yes',
                cancelButtonText:'No',
                showCancelButton: true,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete_acceptance_form_'+ id).submit();
                }
            });
        }
     $('#project-risk-table').DataTable({
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            'responsive': true,
            "aLengthMenu": [[10,25, 50, 75, -1], [10,25, 50, 75, "All"]],
            "iDisplayLength": 10,
            "processing":true,
            "serverSide":true,
            "ajax": {
                "url": "{{route('project.issues',$project->id)}}",
                "type": 'GET',
            },
            "columns": [
                {"data": 'DT_RowIndex', "name": 'DT_RowIndex', orderable: false,searchable: false,"className":"text-middle"},
                { "data": 'risk_name', "name": 'risk_name',"className":"text-middle"},
                { "data": 'reportee', "name": 'reportee',"className":"text-middle"},
                { "data": 'assigned_to', "name": 'assigned_to',"className":"text-middle","defaultContent":"-"},
                { "data": 'reported_at', "name": 'reported_at',"className":"text-middle", "defaultContent":"-"},
                { "data": 'resolved_at', "name": 'resolved_at',"className":"text-middle", "defaultContent":"-"},
                { "data": 'solution', "name": 'solution',"className":"text-middle", "defaultContent":"-"},
                {"data": 'option', "name": 'option', orderable:false, searchable:false,"className":"text-middle"},
            ]
        })

</script>
@endpush