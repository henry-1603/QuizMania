<?php
include "connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
<div class="container m-5">
    <h1 class="text-center text-primary">Welcome <?php echo $_GET['name']?>!</h1>

    <div class="d-flex justify-content-end">
        <form method="post">
        <button onclick="logOut()" type="button" class="btn btn-danger">Log-Out</button>
        </form>
    </div>
        <div class="container mx-auto d-grid  justify-content-center align-items-center my-5 border w-25 bg-dark px-0 rounded-5">
            <a href="addquestion.php" class="rounded-5 btn btn-secondary p-2 m-2 w-100 mx-0">Add Questions</a>
            <button class="rounded-5 btn btn-secondary p-2 m-2 mx-0"><a href="home.php?name=<?= $_SESSION['name'] ?>" class="text-white text-decoration-none"> Go to Customer side</a></button>
        </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>

    function logOut() {
        $.ajax({
            url:'loginClass.php',
            type:'post',
            data:{action: 'logout'},
            success:function(data,status){
                location.href = data;
            },
            error:function() {
                console.log("ERROR");
            }
        })
    }
</script>

</body>
</html>