<div>
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5>
                <i class="ti-close"></i>
                Error!
            </h5>
            @foreach($errors->all() as $error)
                <ul>
                    <li>{{$error}}</li>
                </ul>
            @endforeach
        </div>
    @endif
    @if(session('duplicates'))
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5>
            <i class="ti-info"></i>
            The following items exists
        </h5>
        @foreach(session('duplicates') as $duplicate)
            <ul>
                <li>{{$duplicate}}</li>
            </ul>
        @endforeach
    </div>
@endif
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5>
                <i class="ti-check"></i>
                Success
            </h5>
            {!! session('success') !!}
        </div>
    @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5>
                    <i class="ti-close"></i>
                    Error!
                </h5>
                {!! session('error') !!}
            </div>
        @endif
</div>
