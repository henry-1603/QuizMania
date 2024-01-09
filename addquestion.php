<?php
include 'connection.php';
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Question Adding Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body>
  <div class="container" style="text-align: center; align-items: center">
    <h1>Add Question to game</h1>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Add Question
        </button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Question :</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
      <form action="" method="post" id="uiz-form">
        <div id="quiz-container">
            <h2></h2>

                <div class="QuestionSection my-5 ">
                  <div class="d-flex justify-content-start">

                    <label for="question">Question : &emsp13;</label>
                    <input type="text" id="question" class="w-75 rounded-5" name="question" placeholder="  Enter Question" required>
                    
                  </div>
                  <div class="optionSection my-2 ">
                      <input type="text" class="my-2 mx-2 rounded-5" name="Option[]" placeholder="  Option 1" required>
                      <input type="text" class="my-2 mx-2 rounded-5" name="Option[]" placeholder="  Option 2" required>
                  </div>
                    <button type="button" onclick="addOption()" class="btn btn-info rounded-5 addOption my-2">+ Option</button>
                    <button type="button" onclick="deleteOption()" class="btn btn-info rounded-5 deleteOption my-2">- Option</button>
                    <div class="correctAnsSection my-2">
                    <input type="text" class="my-2 mx-2 rounded-5" id="Correct" name="Correct" placeholder="  Correct Ans" required>
                  </div>
                </div>

        </div>
    
      </div>
      <div class="modal-footer">
      <button class="btn btn-primary" onclick="addQuestion()" data-bs-dismiss="modal" type="submit" id="submitQuiz">Save Question</button>
      
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>


 <!-- QUESTION DISPLAY -->
 <div id="add">

 </div>

 <div id="QuestionTable" class="my-5">
 </div>


</div>


<div class="container d-flex justify-content-center my-5">
      <button class="btn btn-dark">
        <a href="admin.php?name=<?= $_SESSION['name']?>" class="text-light text-decoration-none">Back To Admin Page</a>
      </button>
</div>

  
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>

  $(document).ready(function() {
      ViewQuestion();
  });


 // SAVE QUESTION TO DATABASE 
  function addQuestion() {
    event.preventDefault();
    
    var questionInput = document.getElementById('question');
    var question =questionInput.value;


    var optionInputs = document.getElementsByName('Option[]');
    let option_array = []
    for(var i = 0 ; i < optionInputs.length ; i++) {
      option_array[i] = optionInputs[i].value;
    }
    option_array = JSON.stringify(option_array);
    
    var correctInput = document.getElementById('Correct');
    var correct =correctInput.value;

    if(question.trim() == "" || optionInputs == "" || correct.trim() == "") {
      alert("missing field");
      return false;
    }
    // MAKING VALUES IN MODAL NULL
    questionInput.value = '';
    for (var i = 0; i < optionInputs.length; i++) {
    optionInputs[i].value = '';
    }
    correctInput.value = '';

    $.ajax({
      url:'functions.php',
      type:'post',
      data:{question:question,
            option:option_array,
            correct:correct,
            action:'questions_to_database'
            },
      success:function(data,status){
            ViewQuestion();
          }
    })
  }


  // VIEW QUESTION ADMIN SIDE
    function ViewQuestion() {
        $.ajax({
            url:"functions.php",
            type:"get",
            data:{  action:"viewquestion"
                  },
            success:function(data,status){
                $('#QuestionTable').html(data);
            }
        })
    }

    // DELETE QUESTION
    function deleteQuestion(deleteid) {
        var conf = confirm("Are u sure?");
        if(conf==true) {
            $.ajax({
            url:"functions.php",
            type:"get",
            data:{deleteid:deleteid,
                  action:'deletequestion'},
            success:function(data,status) {
                ViewQuestion();
              }
            })
        }
    }



  // ADD OPTION
    function addOption(){
        let optionsContainer = event.target.parentElement.querySelector(".optionSection");

        if (optionsContainer.childElementCount < 4) {
        const OptionNew = document.createElement("input");

        OptionNew.type = "text";
        OptionNew.classList.add("my-2", "mx-2" , "rounded-5");
        OptionNew.name = optionsContainer.querySelector("input").name;

        OptionNew.placeholder = `Option ${optionsContainer.childElementCount + 1}`;
        optionsContainer.appendChild(OptionNew);
      }
    }

  // DELETE OPTION
    function deleteOption(){
        let optionsContainer = event.target.parentElement.querySelector(".optionSection");
        if (optionsContainer.childElementCount > 2) {
            optionsContainer.removeChild(optionsContainer.lastElementChild);
        }
    }
</script>

</body>
</html>