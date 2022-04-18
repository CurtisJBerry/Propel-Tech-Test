@include('layout.header')
<body>

<div class="container">
    <h2>View a Contact</h2>
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

<!-- Footer-->
@include('layout.footer')
</body>
