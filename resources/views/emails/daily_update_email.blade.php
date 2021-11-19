<!DOCTYPE html>
<html">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

           <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body>
    <div class="container">
    <div class="row justify-content-center">
    <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div><br><br> Student List <br><br></div>    
                    <table class="table" style="text-align: center;">
                        <thead>
                            <tr>
                            <th scope="col" style="width: 20%;">Name</th>
                            <th scope="col" style="width: 20%;">Email</th>
                            <th scope="col" style="width: 20%;">Address</th>
                            <th scope="col" style="width: 20%;">Cur. School</th>
                            <th scope="col" style="width: 20%;">Parent Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                            <tr>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->address }}</td>
                            <td>{{ $student->current_school }}</td>
                            <td>{{ $student->parent_details }}</td>
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                    <div><br><br></div>
                    <hr style="width: 100%;">
                    <div><br><br> Teacher List <br><br></div>
                    <table class="table" style="text-align: center;">
                        <thead>
                            <tr>
                            <th scope="col" style="width: 20%;">Name</th>
                            <th scope="col" style="width: 20%;">Email</th>
                            <th scope="col" style="width: 20%;">Address</th>
                            <th scope="col" style="width: 20%;">Cur. School</th>
                            <th scope="col" style="width: 20%;">Experience</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($teachers as $teacher)
                            <tr>
                            <td>{{ $teacher->name }}</td>
                            <td>{{ $teacher->email }}</td>
                            <td>{{ $teacher->address }}</td>
                            <td>{{ $teacher->current_school }}</td>
                            <td>{{ $teacher->experience }}</td>
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div></div>
    </body>
</html>
