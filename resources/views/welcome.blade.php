@include('header')
<body>

<div class="container">
    <h2>View the Address Book</h2>
    <button class="btn btn-success ">Add new Contact</button>
    <table class="table table-hover">
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
        @foreach($data as $val)
            <tr>
                <td>{{$val['id']}}</td>
                <td>{{$val['first_name']}}</td>
                <td>{{$val['last_name']}}</td>
                <td>{{$val['phone']}}</td>
                <td>{{$val['email']}}</td>
                <td>
                    <a href="{{ route('users.show', $val['id']) }}">
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


</body>

