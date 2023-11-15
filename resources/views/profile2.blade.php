@extends('layouts.app')
@section('main')

<div class="container">
    <div class="row">
        <div class="col-sm-8 justify-content-center mt-4">
            <div class="card p-4">
                <h3>User Profile</h3>
                <p>Username: <b><span id="name"></span></b></p>
                <p>Email Id: <b><span id="email"></span></b></p>
            </div>
                <button id="logout" onclick="logout()" class="form-control btn btn-dark">Logout</button>
        </div>
    </div>
</div>
<script>
            document.addEventListener("DOMContentLoaded", function () {
                const access_token = localStorage.getItem('access_token');
                
                fetch('/api/profile', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${access_token}`
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 200) {
                        console.log(data);

                        document.getElementById('name').innerText = data.user.name;
                        document.getElementById('email').innerText = data.user.email;

                        
                    } else {
                        console.log("error");
                    }
                })
                .catch(error => {
                    console.log('Error:', error);
                });
            });



            const logout = () => {
                access_token = localStorage.getItem('access_token');
                console.log(access_token)
                
                // Send a POST request to your server to log in the user
                fetch('/api/logout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${access_token}`
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 200) {
                        // console.log(data);
                        localStorage.removeItem('access_token');
                        // document.getElementById('response').textContent = 'Logout successful';
                        alert("logout success");

                        window.location.href = '/';
                    } else {
                        // Login failed, display an error message
                        console.log("error");
                        // document.getElementById('response').textContent = 'Logout failed';
                        alert("logout fail");
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        </script>

@endsection 