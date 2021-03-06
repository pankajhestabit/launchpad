@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Student Profile') }}</div>

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
                   
                    <form method="POST" enctype="multipart/form-data" action="{{ route('student.store') }}" id="userProfile" name="userProfile">
                        @csrf
                    <div class="form-group row">
                        <label for="inputName" class="col-sm-4 col-form-label">Name</label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputName" value="{{ $student->name }}" autocomplete="name" autofocus name="name" placeholder="Enter Name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-4 col-form-label">Email</label>
                        <div class="col-sm-8">
                        <input type="text" readonly class="form-control-plaintext" name="email" id="staticEmail" value="{{ $student->email }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputAddress" class="col-sm-4 col-form-label">Address</label>
                        <div class="col-sm-8">
                        <textarea name="address" id="inputAddress" class="form-control">{{ $student->studentDetails->address }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputUrl" class="col-sm-4 col-form-label">Profile Picture</label>
                        <div class="col-sm-4">
                        <input type="file" class="form-control" id="inputFile" name="profilepic" placeholder="Profile picture">
                        </div>
                        <div class="col-sm-4">
                        <img src="{{ asset('storage'.$student->studentDetails->profile_picture) }}" width="100" height="100" title="user image">
                        <input type="hidden" name="p_pic" value="{{ $student->studentDetails->profile_picture }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPSchool" class="col-sm-4 col-form-label">Previous School</label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputPSchool" name="pschool" value="{{ $student->studentDetails->previous_school }}" placeholder="Previous School">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputCSchool" class="col-sm-4 col-form-label">Current School</label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputCSchool" name="cschool" value="{{ $student->studentDetails->current_school }}" placeholder="Current School">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputParent" class="col-sm-4 col-form-label">Parent Details</label>
                        <div class="col-sm-8">
                        <input type="text" name="pdetails" class="form-control" id="inputParent" value="{{ $student->studentDetails->parent_details }}" placeholder="Parent Details">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-8">
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                        </div>
                    </div>
                    </form>    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
