    <div class="row">
       @include('projects.partials.risk-management.partials.add')
        <div class="col-md-12">
            @include('layouts.partials.notification')
        </div>
       @include('projects.partials.risk-management.partials.edit')
       @include('projects.partials.risk-management.partials.resolved')
        <div class="col-md-12 bg-white px-3 pb-3">
            <div class="mt-3 mb-3 pr-0 d-flex justify-content-between">
                <h5>Statistical report</h5>
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
                <table class="table table-bordered table-striped table-hover" id="project-risk-table" style="width:100%">
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