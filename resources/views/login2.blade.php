@extends('layouts.app')
@section('main')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-8" >
            <div class="card mt-3 p-3">
                <h5 class="text-muted">Fill the details to login!!</h5>
                <form id="login-form">
                    @csrf
                    <div class="form-group row">
                        <div class="col">
                            <label for="email">Email</label>
                            <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" />
                        </div>
                        <div class="col">
                            <label for="password">Password</label>
                            <input id="password" type="password" name="password" class="form-control" value="{{ old('password') }}" />
                        </div>
                    </div>
                    <button type="submit" class="form-control btn btn-dark">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>

        document.getElementById('login-form').addEventListener('submit', function(e) {
            e.preventDefault();
            console.log("hi")
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            // Send a POST request to your server to log in the user
            fetch('/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    email: email,
                    password: password,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 200) {
                    console.log(data);

                    localStorage.setItem('access_token', data.access_token);

                    // Login successful, you can handle the response as needed
                    // document.getElementById('response').textContent = 'Login successful';
                    console.log("success")

                    window.location.href = '/profile2';
                } else {
                    // Login failed, display an error message
                    // document.getElementById('response').textContent = 'Login failed';
                    console.log("error")
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
        
    </script>
@endsection