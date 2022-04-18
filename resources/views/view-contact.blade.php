@include('header')
<body>

<div class="container">
    <h2>View the Address Book</h2>
    <button class="btn btn-success float-right">Add new Contact</button>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>ID</th>
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
            @foreach($data as $val)
                <tr>
                    <td>{{$val['id']}}</td>
                    <td>{{$val['first_name']}}</td>
                    <td>{{$val['last_name']}}</td>
                    <td>{{$val['phone']}}</td>
                    <td>{{$val['email']}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>


</body>
</html>
