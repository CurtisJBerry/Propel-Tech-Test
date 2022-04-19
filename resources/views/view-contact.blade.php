@include('layout.header')
<body>
<!-- Page Content-->
<div class="container px-4 px-lg-5">
    <!-- Heading Row-->
    <div class="row gx-4 gx-lg-5 align-items-center my-5">
        <h2 class="h2">View a Contact</h2>
        <div class="col-lg-12 mb-5">
            <a href="{{ route('users.index') }}">
                <button class="btn btn-primary float-right">Back</button>
            </a>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                </tr>
                </thead>
                <tbody>
                @if(empty($data))
                    <td>No contacts currently available!</td>
                @else
                    <tr>
                        <td>{{$data['first_name']}}</td>
                        <td>{{$data['last_name']}}</td>
                        <td>{{$data['phone']}}</td>
                        <td>{{$data['email']}}</td>
                    </tr>
                </tbody>
            </table>
            @endif
        </div>
    </div>
    <!-- Footer-->
@include('layout.footer')
</body>
