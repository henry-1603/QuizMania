<?php 
include "connection.php";
    if(isset($_GET['username'])){
        $username = $_GET['username'];       
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz App</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</head>

<body>
<div id="quiz-container" >
        <h1 class="d-flex justify-content-center text-danger">Choose The Correct..</h1>
        <div id="question-container">

            <p id="question">Question Will be Displayed Here...</p>

        </div>
    </div>
   
    <div class="d-flex justify-content-center">
    <button onclick="homepage()" class="btn btn-warning p-3 m-3 ">Go To Home page</button>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script type="text/javascript">  


$(document).ready(function () {
    readquestion(1); // Load the initial page
});

function homepage() {
    var conf = confirm("Sure U want to Quit Quiz ??");
    if(conf==true) {
        $.ajax({
            url:'functions.php',
            type:'post',
            data:{
                action:'homeRedirect',
            },
            success:function(data,status) {
                location.href = data;
            },
            error:function() {
                console.log("Error");
            }
        })
    }
}

$(document).on("click", "#pagination #next_btn, #pagination #prev_btn , #pagination #submit", function(e) {
    e.preventDefault(); 
    var action = $(this).attr("id");
    if (action === "next_btn") {

        readquestion('next');
    } else if (action === "prev_btn") {
        readquestion('prev');
    } else if(action === 'submit') {
        submitQuiz();
    }
});

function readquestion(action) {
    var getquestion = 'getquestion';
    $.ajax({
        url: 'functions.php',
        type: 'get',
        data: { pageaction: action,
                action:getquestion},
        success: function (data, status) {
            $('#question').html(data);
        },
    });
}




function goToHomePage() {
        var confirmResult = confirm("Are you sure you want to go to the home page?");
        if (confirmResult) {
            window.location.href = 'home.php?name=<?php echo $_GET['username'] ?>';
        } 
    }

function submitQuiz() {
        alert("Quiz Submitted Successfully! Click Ok To View Score!!!!");
        console.log(selectedOptions);
        $.ajax({
        url:"functions.php",
        type:'get',
        data:{
            selectedOptions:selectedOptions,
            action : 'calculatescore'
        },
        success:function(data,status){
            window.location.href = 'score.php?name=<?php echo $_GET['username'] ?>&score=' + encodeURIComponent(data);
        }
        });
        <?php
            $_SESSION['current_question_index'] = 0 ;
            $_SESSION['current_page'] = 1;
        ?>

    }
    

var selectedOptions = [];
var score1 = 0;
function submitAnswer(questionId, correctAnswer) {

    var selectedOption = document.querySelector('input[name="opt"]:checked') || { value: "not selected" };

    var selectedValue = selectedOption.value;
    var isCorrect = selectedValue === correctAnswer;
    var existingIndex = selectedOptions.findIndex(item => item.questionId === questionId);

    console.log(correctAnswer);
    console.log(selectedValue);

    if (existingIndex !== -1) {
        // Update values for the existing question
        selectedOptions[existingIndex].selectedValue = selectedValue;
        selectedOptions[existingIndex].isCorrect = isCorrect;
    } else {
        // Add a new entry for the question
        selectedOptions.push({
            questionId: questionId,
            selectedValue: selectedValue,
            isCorrect: isCorrect
        });
    }

    // FOR PRESERVING CHECKED OPTIONS
    $.ajax({
        url:'functions.php',
        type:'post',
        data : {
            questionId:questionId,
            selectedValue:selectedValue,
            action:'preserveRadio'
        },
        success:function(data,status) {
            console.log("success stored");
        }
    })
}

</script>





</body>
</html>

