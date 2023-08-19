@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 d-flex flex-wrap justify-content-between">
            <h3>Issue management</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('projects-risks.index')}}">Projects</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$project->project_name}}'s issues</li>
                </ol>
            </nav>
        </div>
       @include('risk-management.partials.add')
        <div class="col-md-12 mt-3">
            @include('layouts.partials.notification')
        </div>
       @include('risk-management.partials.edit')
       @include('risk-management.partials.resolved')
        <div class="col-md-12 mt-3 bg-white p-3">
            
            <div class="mt-3 mb-3 pr-0 d-flex justify-content-between">
                <h4>Statistical report</h4>
                <a class="btn btn-primary rounded-0" data-toggle="modal" data-target="#risk_add">Record issue</a>
            </div>
            <div class="mb-3 d-flex flex-wrap justify-content-md-center">
                <div class="d-flex mr-2 mr-md-5 mb-2 mb-md-0">
                    <span class="px-3 py-0" style="background: rgba(255, 99, 132, 1)"></span>
                    <p class="ml-1 mb-0">HIGH Severity</p>
                </div>
                <div class="d-flex mr-2 mr-md-5 mb-2 mb-md-0">
                    <span class="px-3 py-0" style="background: rgba(255, 205, 86, 1)"></span>
                    <p class="ml-1 mb-0">MEDIUM Severity</p>
                </div>
                <div class="d-flex mr-2 mr-md-5 mb-2 mb-md-0">
                    <span class="px-3 py-0" style="background: rgba(54, 162, 235, 1)"></span>
                    <p class="ml-1 mb-0">LOW Severity</p>
                </div>
            </div>
            <canvas id="risks_chart"></canvas>
            <div class="mt-5 mb-4">
                <h4>Detail report</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="customers-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Issue</th>
                            <th>Reporter</th>
                            <th>Assigned to</th>
                            <th>Reported at</th>
                            <th>Resolved at</th>
                            <th>Solution</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
           
        </div>
    </div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
     $(document).ready(function(){
        flatpickr('#datetimepicker', {
            enableTime: true,
            dateFormat: 'Y-m-d H:i',
        });
        flatpickr('#edit_datetimepicker', {
            enableTime: true,
            dateFormat: 'Y-m-d H:i',
        });
            
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
                "url": "{{route('risk-management.index',$project->id)}}",
                "type": 'GET',
            },
            "columns": [
                {"data": 'DT_RowIndex', "name": 'DT_RowIndex', orderable: false,searchable: false,"className":"text-middle"},
                { "data": 'risk.risk_name', "name": 'risk.risk_name',"className":"text-middle"},
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