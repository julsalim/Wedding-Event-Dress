@extends('master')

@section('content')
<div class="container d-flex flex-column justify-content-center" style="">

    <div class="d-flex w-100 justify-content-center align-items-center border-bottom" style="height: 100px">
        <h2>
            Register Page
        </h2>
    </div>
    
    <div class="container mt-4 p-5" style="border-radius: 10px">
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf
           

            <div class="row">
                <div class="col-6">

                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Full Name" name="name" required>

                        @error('name')
                            <div id="name" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
        
                    <label for="dating" class="form-label">Dating Code</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">DT</span>
                        <input type="text" id="dating" name="datingCode" class="form-control @error('datingCode') is-invalid @enderror @if(session()->has('failed')) is-invalid @endif " placeholder="Dating Code (3 Digit)" required>

                        @if(session()->has('failed'))
                            <div id="datingCode" class="invalid-feedback">
                                {{ session()->get('failed') }}
                            </div>
                        @endif
                    </div>
        
                    <div class="mb-3">
                        <label for="birthDate" class="form-label">Birth Date</label>
                        <input name="birthDate" type="date" class="form-control @error('birthDate') is-invalid @enderror" id="birthDate" required>
                        
                        @error('birthDate')
                            <div id="name" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <label for="dating" class="form-label">Gender</label>
                    <select name="gender" id="gender" class="form-select mb-3" aria-label="Default select example" required>
                        <option selected disabled>Select Your Gender</option>
                        <option value="1">Male</option>
                        <option value="2">Female</option>
                    </select>
                    
                </div>

                <div class="col-6">
                    
        
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="name@example.com" required>

                        @error('email')
                            <div id="name" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
        
                    <div class="mb-3">
                        <label for="phoneNumber" class="form-label">Phone Number</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">+65</span>
                            <input type="text" name="phoneNumber" class="form-control @error('phoneNumber') is-invalid @enderror" id="phoneNumber" placeholder="8xxxxxxxxx" required>
                            @error('phoneNumber')
                                <div id="name" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
        
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Upload Photo</label>
                        <input class="form-control" type="file" id="formFile" name="image" required>
                    </div>
        
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="exampleInputPassword1" required>
                        @error('password')
                            <div id="name" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>       

            
            
            <div class="w-100 d-flex justify-content-center mt-2">
                <button type="submit" class="btn buttons align-self-center w-25">Register Now</button>
            </div>
          </form>
    </div>
</div>
@endsection