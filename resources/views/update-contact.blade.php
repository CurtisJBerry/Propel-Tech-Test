@include('layout.header')
<body>
<!-- Page Content-->
<div class="container px-4 px-lg-5">
    <!-- Heading Row-->
    <div class="row gx-4 gx-lg-5 align-items-center my-5">
        <h2 class="h2">Edit a Contact</h2>
        @include('layout.messages')
        <div class="col-lg-12 mb-5">
            <a href="{{ route('users.index') }}">
                <button class="btn btn-primary float-right">Back</button>
            </a>
            <div class="row align-items-start">
                <div class="col-md-3">
                    <form action="{{ route('update',$id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{$data['first_name']}}" required>
                            @if($errors->has('first_name'))
                                <p style="color: red">{{$errors->first('first_name')}}</p>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="{{$data['last_name']}}" required maxlength="20">
                            @if($errors->has('last_name'))
                                <p style="color: red">{{$errors->first('last_name')}}</p>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="number" class="form-control" id="phone" name="phone" value="{{$data['phone']}}" required maxlength="12">
                            <small>Format: 123456789102</small>
                            @if($errors->has('phone'))
                                <p style="color: red">{{$errors->first('phone')}}</p>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{$data['email']}}" required maxlength="30">
                            @if($errors->has('email'))
                                <p style="color: red">{{$errors->first('email')}}</p>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="col-md-3">

                </div>
                <div class="col-md-3">
                </div>
            </div>
        </div>
    </div>
    <!-- Footer-->
@include('layout.footer')
</body>
