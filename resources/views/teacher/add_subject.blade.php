@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Add Subject') }}</div>

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
                   
                    <form method="POST" enctype="multipart/form-data" action="{{ route('teacher.addsubject') }}" id="subject" name="subject">
                        @csrf
                    <div class="form-group row">
                        <label for="inputName" class="col-sm-4 col-form-label">Subject Name</label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputName" value="" autocomplete="subject" autofocus name="subject" placeholder="Enter Subject Name">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputName" class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-8">
                        @forelse($subjects as $subject)
                            <li>{{ $subject->subject }}</li>
                        @empty
                        @endforelse
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-8">
                        <button type="submit" class="btn btn-primary">Add Subject</button>
                        </div>
                    </div>
                    </form>    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
