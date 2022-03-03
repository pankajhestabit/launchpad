@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Assigned Teacher List') }}</div>

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
                            <td><img src="{{ asset('storage/'.$teacher->profile_picture) }}" height="50" width="50"></td>
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
