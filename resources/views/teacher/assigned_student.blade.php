@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Assigned Student List') }}</div>

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
                            <th scope="col">Parent Details</th>
                            <th scope="col">Pic</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                            <tr>
                            <th scope="row">{{ $sn++ }}</th>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->address }}</td>
                            <td>{{ $student->previous_school }}</td>
                            <td>{{ $student->current_school }}</td>
                            <td>{{ $student->parent_details }}</td>
                            <td><img src="{{ asset('storage/'.$student->profile_picture) }}" height="50" width="50"></td>
                            <td></td>
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
