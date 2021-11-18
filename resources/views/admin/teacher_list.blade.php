@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Student List') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                   
                    
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Address</th>
                            <th scope="col">Pre. School</th>
                            <th scope="col">Cur. School</th>
                            <th scope="col">Experience</th>
                            <th scope="col">Pic</th>
                            <th scope="col">Approve</th>
                            <th scope="col">Assign Student</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($teachers as $teacher)
                            <tr>
                            <th scope="row">{{ $sn++ }}</th>
                            <td>{{ $teacher->name }}</td>
                            <td>{{ $teacher->email }}</td>
                            <td>{{ $teacher->address }}</td>
                            <td>{{ $teacher->previous_school }}</td>
                            <td>{{ $teacher->current_school }}</td>
                            <td>{{ $teacher->experience }}</td>
                            <td><img src="{{ asset('storage/'.$teacher->profile_picture) }}" height="50" title="Img" alt="Img" width="50"></td>
                            @if($teacher->status == 0)
                                <td><a href="{{ route('admin.tapprove', $teacher->uid) }}" class="btn btn-info">Approve</a></td>
                                <td></td>
                            @else
                                <td><a class="btn btn-success" style="pointer-events: none;">Approved</a></td>
                                <td><a href="{{ route('admin.assign_student', $teacher->uid) }}" class="btn btn-info">Assign</a></td>
                            @endif
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
@endsection
