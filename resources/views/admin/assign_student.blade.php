@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Assign Students') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                    @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>	
                            <strong>{{ $message }}</strong>
                    </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                   
                    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.assignStudentSave') }}" id="userProfile" name="userProfile">
                        @csrf
                    <div class="form-group row">
                        <label for="inputName" class="col-sm-4 col-form-label">Teacher Name</label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control-plaintext" readonly id="inputName" value="{{ $teacher->name }}" name="name" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-4 col-form-label">Teacher Email</label>
                        <div class="col-sm-8">
                        <input type="text" readonly class="form-control-plaintext" name="email" id="staticEmail" value="{{ $teacher->email }}">
                        <input type="hidden" name="tid" value="{{$teacher->id}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputAddress" class="col-sm-4 col-form-label">Approved Students List</label>
                        <div class="col-sm-8">
                        <select name="students[]" id="students" class="form-control" multiple required>
                            @forelse($students as $student)
                            <option value="{{ $student->user->id }}" @if(in_array($student->user->id, $asList)) selected @endif>{{ $student->user->name }} - {{ $student->user->email }}</option>
                            @empty
                            @endforelse
                        </select>
                        </div>
                    </div>
                   
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-8">
                        <button type="submit" class="btn btn-primary">Assign Student</button>
                        </div>
                    </div>
                    </form>    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
