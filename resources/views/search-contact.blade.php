@include('layout.header')
<body>
<!-- Page Content-->
<div class="container px-4 px-lg-5">
    <!-- Heading Row-->
    <div class="row gx-4 gx-lg-5 align-items-center my-5">
        <h2 class="h2">Search Results</h2>
        @include('layout.messages')
        <div class="col-lg-12 mb-5">
            <a href="{{ route('users.index') }}">
                <button class="btn btn-primary float-right">Back</button>
            </a>
            <table class="table table-hover table-responsive">
                <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                </tr>
                </thead>
                <tbody>
                @if(!$data->count())
                    <td>No contacts currently available!</td>
                @else
                    @foreach($data as $key => $val)
                        <tr>
                            <td>{{$val['first_name']}}</td>
                            <td>{{$val['last_name']}}</td>
                            <td>{{$val['phone']}}</td>
                            <td>{{$val['email']}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
            {{$data->links()}}
        </div>
    </div>
</div>
<!-- Footer-->
@include('layout.footer')
</body>
