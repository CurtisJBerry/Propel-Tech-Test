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
                <button class="btn btn-success float-right inline">Create new Contact</button>
            </a>
            <form class="row g-3" method="POST" action="{{ route('search') }}">
                @csrf
                <div class="col-auto">
                    <input type="text" class="form-control" id="value" name="value" placeholder="Search Contacts">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-3">Search</button>
                </div>
            </form>
            <table class="table table-hover table-responsive">
                <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @if(!$data->count() or empty($data))
                    <td>No contacts currently available!</td>
                @else
                    @foreach($data as $key => $val)
                        <tr>
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
        @if($data->count())
            {{$data->links()}}
        @endif
    </div>
</div>
<!-- Footer-->
@include('layout.footer')
</body>
