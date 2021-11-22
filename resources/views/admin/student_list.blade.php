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
                            <th scope="col">Parents</th>
                            <th scope="col">Pic</th>
                            <th scope="col">Approve Stu.</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                            <tr>
                            <th scope="row">{{ $sn++ }}</th>
                            <td>{{ $student->user->name }}</td>
                            <td>{{ $student->user->email }}</td>
                            <td>{{ $student->address }}</td>
                            <td>{{ $student->previous_school }}</td>
                            <td>{{ $student->current_school }}</td>
                            <td>{{ $student->parent_details }}</td>
                            <td><img src="{{ asset('storage/'.$student->profile_picture) }}" height="50" width="50"></td>
                            @if($student->status == 0)
                                <td><a href="{{ route('admin.sapprove', $student->user->id) }}" class="btn btn-info">Approve</a></td>
                            @else
                                <td><a class="btn btn-success" style="pointer-events: none;">Approved</a></td>
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
