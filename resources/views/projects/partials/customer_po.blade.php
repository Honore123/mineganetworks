<div class="col-md-12 bg-white p-3">
    <div class="border rounded-lg row mx-0 justify-content-between py-3 mb-3">
        <div class="col-md-4 d-flex flex-column">
            <label class="text-muted font-weight-bold">Pending amount</label>
            <label for="" class="font-weight-bolder mt-1 text-danger display-5">{{number_format($pendingAmountPO,2,'.',',')}}</label>
        </div>
        <div class="col-md-4 d-flex flex-column">
            <label class="text-muted font-weight-bold">Paid amount</label>
            <label for="" class="font-weight-bolder mt-1 text-success display-5">{{number_format($paidAmountPO,2,'.',',')}}</label>
        </div>
        <div class="col-md-4 d-flex flex-column">
            <label class="text-muted font-weight-bold">Total amount</label>
            <label for="" class="font-weight-bolder mt-1 text-primary display-5">{{number_format($totalAmountPO,2,'.',',')}}</label>
        </div>
    </div>
    <table class="table table-bordered table-striped table-hover table-responsive" id="customers-table" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>P.O No</th>
                <th>P.O Name</th>
                <th>Status</th>
                <th>Total amount</th>
                <th>Remaining amount</th>
                <th>Created date</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>