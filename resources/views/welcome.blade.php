@include('layout.header')
<body>
<!-- Page Content-->
<div class="container px-4 px-lg-5">
    <!-- Heading Row-->
    <div class="row gx-4 gx-lg-5 align-items-center my-5">
        <h2>View the Address Book</h2>
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
                                <a href="{{ route('users.show', $key) }}">
                                    <button class="btn btn-success">View</button>
                                </a>

                                <button class="btn btn-primary">Edit</button>
                                <button class="btn btn-danger">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
{{--    <!-- Content Row-->--}}
{{--    <div class="row gx-4 gx-lg-5">--}}
{{--        <div class="col-md-4 mb-5">--}}
{{--            <div class="card h-100">--}}
{{--                <div class="card-body">--}}
{{--                    <h2 class="card-title">Subjects</h2>--}}
{{--                    <p class="card-text">All of the 31 GCSE subjects are covered including several different exam boards for better content availability. The subjects are broken down into modules and sub modules within these so that the right content can be found easily.</p>--}}
{{--                </div>--}}
{{--                <div class="card-footer"><a class="btn btn-primary btn-sm" href="#!">More Info</a></div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-md-4 mb-5">--}}
{{--            <div class="card h-100">--}}
{{--                <div class="card-body">--}}
{{--                    <h2 class="card-title">Learner Type Test</h2>--}}
{{--                    <p class="card-text">This is a short test we suggest you take once you have created an account and logged in for the first time, this test will try to analyse your answers to certain questions and based on your responses we will suggest which learner type you may be.</p>--}}
{{--                </div>--}}
{{--                <div class="card-footer"><a class="btn btn-primary btn-sm" href="#!">More Info</a></div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-md-4 mb-5">--}}
{{--            <div class="card h-100">--}}
{{--                <div class="card-body">--}}
{{--                    <h2 class="card-title">Learner Relevant Content</h2>--}}
{{--                    <p class="card-text">Update this section!!</p>--}}
{{--                </div>--}}
{{--                <div class="card-footer"><a class="btn btn-primary btn-sm" href="#!">More Info</a></div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
</div>
<!-- Footer-->
@include('layout.footer')
</body>
