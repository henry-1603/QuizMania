<?php
include "connection.php";
include "classes.php";
session_start();

class Question extends Connection
{
    public $conn; 
    public $query;
    function __construct() {
        $this->conn = parent::connect();
        $this->query = new SQLqueries();
        
        $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
        if (method_exists($this, $action)) {
            echo $this->$action($_REQUEST);
        }
        
    }

    // SAVING QUESTION
    public function questions_to_database(){

        $questions = isset($_REQUEST['question']) ? $_REQUEST['question'] : '';
        $options = isset($_REQUEST['option']) ? $_REQUEST['option'] : '';
        $correct = isset($_REQUEST['correct']) ? $_REQUEST['correct'] : '';
 
        $result = $this->query->insertQuery('questions', ['question', 'options', 'correct'],[$questions, $options, $correct] );

        if ($result === FALSE) {
            echo "Error: " . $this->conn->error;
        }
    }

    // VIEW QUESTION IN ADMIN PANEL
    public function viewquestion() {
        
        $result = $this->query->selectQuery('questions', '*', NULL , 'RAND()');
        ob_start(); // Start output buffering
        
        ?>
        <div style="height:360px;width:100%;overflow:auto">
        <table class="table table-bordered table-striped">
            <tr>
                <th>No.</th>
                <th>Question</th>
                <th>Options</th>
                <th>Correct Ans</th>
                <th>Operation</th>
            </tr>
        <?php
        
        if (mysqli_num_rows($result) > 0) {
            $number = 1;
            $num = 12;
    
            while ($row = mysqli_fetch_assoc($result)) {
                $options = "";
                $optionDecoded = json_decode($row['options']);
                
                for ($i = 0; $i < count($optionDecoded); $i++) {
                    $options .= $optionDecoded[$i] . " , ";
                }
    
                $options = rtrim($options, ' ,');
                $correct = str_replace("\"", "", $row['correct']);
    
                ?>
                <tr>
                    <td><?php echo $number; ?></td>
                    <td><?php echo $row['question']; ?></td>
                    <td><?php echo $options; ?></td>
                    <td><?php echo $correct; ?></td>
                    <td class="d-flex">
                        <button class="btn btn-danger mx-1" onclick="deleteQuestion(<?php echo $row['id']; ?>)">Delete</button>
                    </td>
                </tr>
                <?php
                $number++;
            }
        }
        
        ?>
        </table>
        </div>
        <?php
        
        $data = ob_get_clean(); // End output buffering and capture the content
        return $data;
    }
    

    // PLAYING LOGIC IN USER SIDE
    public function getquestion(){

        // PAGE NUMBER
        if (!isset($_SESSION['current_page'])) {
            $_SESSION['current_page'] = 1;
        }

        // STORING ANS
        if (!isset($_SESSION['answersubmit'])) {
            $_SESSION['answersubmit'] = [];
        }

        // RANDOM ORDER LOGIC FOR QUESSTION
        if (!isset($_SESSION['all_question_ids'])) {

            $result_all_question_ids = $this->query->selectQuery('questions' , 'id' , '10');
            $question_ids = [];

            while ($row_id = mysqli_fetch_assoc($result_all_question_ids)) {
                $question_ids[] = $row_id['id'];
            }
            
            shuffle($question_ids); // Shuffle the question IDs randomly
            $_SESSION['all_question_ids'] = $question_ids;
            $_SESSION['current_question_index'] = 0; // Initialize the current index
        }
        
        $action = isset($_GET['pageaction']) ? $_GET['pageaction'] : '';


        if ($action === 'next') {
            $_SESSION['current_question_index'] += 1;
            $_SESSION['current_page']++;
        } elseif ($action === 'prev') {
            $_SESSION['current_page'] = max($_SESSION['current_page'] - 1, 1);
            $_SESSION['current_question_index'] -= 1;
        }

        $current_question_id = $_SESSION['all_question_ids'][$_SESSION['current_question_index']];

        $result = $this->query->selectQuery('questions' , "id, question, options, correct" , "id = $current_question_id");

        ob_start();
        if (mysqli_num_rows($result) > 0) {
            $data = "";

            while ($row = mysqli_fetch_assoc($result)) {
                $question_id = $row['id'];
                $optionDecoded = json_decode($row["options"]);
        ?>
                <h3 class="d-flex justify-content-center text-primary">Question : <?= $_SESSION['current_page'] ?> </h3>
                <p class="d-flex justify-content-center text-center mt-5 mb-3  h2"><?= $row['question'] ?></p><br>
            
                <div class="h-100 mb-5">

        <?php
                for ($i = 0; $i < count($optionDecoded); $i++) {
                    $checked = '';
                    if (isset($_SESSION['answersubmit'][$question_id]) && $_SESSION['answersubmit'][$question_id] === $optionDecoded[$i]) {
                        $checked = 'checked';
                    }
        ?>
                    <p class="d-flex justify-content-center text-start"><input type="radio" class="mx-2" name="opt" value="<?= $optionDecoded[$i]?>" <?= $checked ?> /><?= $optionDecoded[$i] ?></p>
        <?php
                }
        ?>

                </div>

        <?php
                // FOR PAGINATION
                $limit_per_page = 1;

                $records = $this->query->selectQuery('questions' , '*');
                $total_record = mysqli_num_rows($records);
                $total_pages = ceil($total_record / $limit_per_page);
        
                // Include Next and Previous buttons
        ?>
                <div id="pagination" class="my-5 d-flex justify-content-center">
        <?php
                if ($_SESSION['current_page'] == 1) {
        ?>
                    <button class=" btn btn-dark mx-2" id="prev_btn" disabled>Previous</button>
        <?php
                }
                if ($_SESSION['current_page'] > 1) {
        ?>
                    <button class=" btn btn-dark mx-2" id="prev_btn" 
                    onclick="submitAnswer(<?= $question_id ?> , '<?= htmlspecialchars($row['correct'], ENT_QUOTES)?>')">Previous</button>
        <?php
                }
                if ($_SESSION['current_page'] < $total_pages) {
        ?>
                    <button class="btn btn-dark mx-2" 
                    onclick="submitAnswer(<?= $question_id ?> , '<?= htmlspecialchars($row['correct'], ENT_QUOTES)?>')" id="next_btn">Next</button>
        <?php
                }
                if ($_SESSION['current_page'] == $total_pages) {
        ?>
                    <button class="btn btn-dark mx-2" id="next_btn" disabled>Next</button>
                    <button type="submit" onclick="submitAnswer(<?= $question_id ?> , '<?= htmlspecialchars($row['correct'], ENT_QUOTES)?>')"  
                    class="btn btn-dark mx-2" id="submit">Submit</button>
        <?php
                }
                $data .= '</div>';
            }
        }
        return $data;
    }

    // FINAL SCORE CALCULATE
    public function calculatescore(){
        $selctedOption = isset($_REQUEST['selectedOptions']) ? $_REQUEST['selectedOptions'] : '';

        $data = 0;
        for ($i = 0; $i < count($selctedOption); $i++) {
            if ($selctedOption[$i]['isCorrect'] == 'true') {
                $data++;
            }
        }
        $this->saveScore($data);

        return $data;
    }

    // SAVING SCORE IN DATABASE 
    public function saveScore($score){
        $this->query->insertQuery('quizHistory' , ['name','score'] , [$_SESSION['name'] ,$score]);
    }

    public function preserveRadio() {
        $questionId = isset($_REQUEST['questionId']) ? $_REQUEST['questionId'] : '';
        $selectedValue = isset($_REQUEST['selectedValue']) ? $_REQUEST['selectedValue'] : '';
        $_SESSION['answersubmit'][$questionId] = $selectedValue;
    }

    // DISPLAYING SCORE ON HOMEPAGE 
    public function quizhistory(){
        $result = $this->query->selectQuery('quizHistory' , '*' , NULL , 'date');

        ob_start(); ?>
        <div style="overflow: auto;height:300px;width:100%;border:1px solid green;border-radius:20px">
        <table class="table table-striped table-bordered">
            <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Player</th>
                <th class="text-center">Score</th>
                <th class="text-center">Timestamp</th>
            </tr>

            <?php

            if (mysqli_num_rows($result) > 0) {
                $number = 1;

                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $number ?> </td>
                        <td class="text-center"><?= $row['name'] ?></td>
                        <td class="text-center"><?= $row['score'] ?></td>
                        <td class="text-center"><?= $row['date'] ?> </td>
                    </tr>
                    <?php
                    $number++;
                }
                ?>
        </table>
        </div>
                <?php
            }
            $data = ob_get_clean(); // End output buffering and capture the content
            return $data;
    }


    // DELETE QUESTION
    public function deletequestion(){
    $id = isset($_GET['deleteid']) ? $_GET['deleteid'] : '';
    $this->query->deleteQuery('questions' , "id=$id");
    }

    public function homeRedirect() {
        unset($_SESSION['all_question_ids']);
        $_SESSION['answersubmit'] = [];
        $name = urlencode($_SESSION['name']);
        return "home.php?name=$name";
    }      

}

// CLASS OBJECT
$questionObject = new Question();



