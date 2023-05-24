@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3>System Logs</h3>
        </div>
        <div class="col-md-12 mt-4 bg-white p-3">
            <div class="table-responsive">
                <table class="table table-bordered table-stripped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activities as $activity)
                        <tr>
                            <td>{{$loop->iteration++}}</td>
                            <td>{{ $activity->causer ? $activity->causer->name : '-' }} {{ $activity->subject ? ' on ' . $activity->subject->name : null  }}</td>
                            <td>{{ $activity->description }}</td>
                            <td>
                                {{ $activity->created_at->diffForHumans() }}
                                &nbsp;&nbsp;&nbsp;{{ $activity->created_at->format('d/m H:i') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center" colspan="7">No logs!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection