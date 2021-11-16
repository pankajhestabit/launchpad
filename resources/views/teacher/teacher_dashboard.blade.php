@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Profile') }}</div>

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
                   
                    <form method="POST" enctype="multipart/form-data" action="{{ route('teacher.store') }}" id="userProfile" name="userProfile">
                        @csrf
                    <div class="form-group row">
                        <label for="inputName" class="col-sm-4 col-form-label">Name</label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputName" value="{{ $user->name }}" autocomplete="name" autofocus name="name" placeholder="Enter Name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-4 col-form-label">Email</label>
                        <div class="col-sm-8">
                        <input type="text" readonly class="form-control-plaintext" name="email" id="staticEmail" value="{{ $user->email }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputAddress" class="col-sm-4 col-form-label">Address</label>
                        <div class="col-sm-8">
                        <textarea name="address" id="inputAddress" class="form-control">value="{{ $user->address }}"</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputUrl" class="col-sm-4 col-form-label">Profile Picture</label>
                        <div class="col-sm-4">
                        <input type="file" class="form-control" id="inputFile" name="profilepic" placeholder="Profile picture">
                        </div>
                        <div class="col-sm-4">
                        <img src="{{ asset('storage'.$user->profile_picture) }}" width="100" height="100" title="user image">
                        <input type="hidden" name="p_pic" value="{{ $user->profile_picture }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPSchool" class="col-sm-4 col-form-label">Previous School (Optional)</label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputPSchool" name="pschool"value="{{ $user->previous_school }}" placeholder="Previous School">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputCSchool" class="col-sm-4 col-form-label">Current School (Optional)</label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputCSchool" name="cschool" value="{{ $user->current_school }}" placeholder="Current School">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputParent" class="col-sm-4 col-form-label">Experience</label>
                        <div class="col-sm-8">
                        <input type="text" name="experience" class="form-control" value="{{ $user->experience }}" id="inputExperience" placeholder="Experience">
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
