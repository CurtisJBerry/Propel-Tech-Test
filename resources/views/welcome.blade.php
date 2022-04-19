@include('layout.header')
<body>
<!-- Page Content-->
<div class="container px-4 px-lg-5">
    <!-- Heading Row-->
    <div class="row gx-4 gx-lg-5 align-items-center my-5">
        <h2 class="h2">View the Address Book</h2>
        @include('layout.messages')
        <div class="col-lg-12 mb-5">
            <a href="{{ route('create') }}">
                <button class="btn btn-success float-right">Create new Contact</button>
            </a>
            <table class="table table-hover table-responsive">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @if(empty($data))
                    <td>No contacts currently available!</td>
                @else
                    @foreach($data as $key => $val)
                        <tr>
                            <td>{{$key}}</td>
                            <td>{{$val['first_name']}}</td>
                            <td>{{$val['last_name']}}</td>
                            <td>{{$val['phone']}}</td>
                            <td>{{$val['email']}}</td>
                            <td>
                                <a href="{{ route('show', $key) }}">
                                    <button class="btn btn-success">View</button>
                                </a>

                                <a href="{{ route('update-page', $key) }}">
                                    <button class="btn btn-primary">Edit</button>
                                </a>

                                <a href="{{ route('destroy', $key) }}">
                                    <button class="btn btn-danger">Delete</button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div>
<!-- Footer-->
@include('layout.footer')
</body>
