<?php
include "connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
    

    <div class="container m-5">
        <h1 class="text-center text-primary">LOGIN FORM</h1>
        <form action="" method="post" class="d-flex justify-content-center flex-column">
            <div class="form-group w-25 mx-auto">
                <label for="email" class="h5">Email </label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter Email">
            </div>
            
            <div class="form-group w-25 mx-auto my-3">
                <label for="password" class="h5">Password  </label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password" autocomplete="off">
            </div>
           <div class="mx-auto w-50 d-flex justify-content-center">
            <button class="btn btn-success my-4 w-50" onclick="submitForm()" name="submit">Login</button>
            </div>
        </form>
        <div id="test"></div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function submitForm() {
            var email = document.getElementById('email').value;
            var password = document.getElementById('password').value;
            $.ajax({
                url:'loginClass.php',
                type:'post',
                data:{email:email,
                    password:password,
                    action:'login'},
                success: function(data, status) {
                    location.href = data;
                },
                error: function (jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown);
                console.log("ERRRRRRRR");
            }
            });
     
        }
        
    </script>
</body>
</html>