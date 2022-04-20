@include('layout.header')
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-4">
            <img src="https://picsum.photos/300/300" alt="randomly generated profile placeholder">
            <h3 class="mt-4">About me</h3>
            <p>About me text that isnt important but could be filled with real data.</p>
            <p>About me text that isnt important but could be filled with real data.</p>
        </div>
        <div class="col-sm-8">
            <a href="{{ route('users.index') }}">
                <button class="btn btn-primary float-right">Back</button>
            </a>
            <h2 class="h2">{{$data['first_name'] . " " . $data['last_name']}}</h2>
            <h5 style="font-size: large">Contact Details</h5>
            <p>Contact number: {{$data['phone']}}</p>
            <p>Email address: <a href="mailto:">{{$data['email']}} </a></p>
        </div>
    </div>
</div>

<!-- Footer-->
@include('layout.footer')
</body>
