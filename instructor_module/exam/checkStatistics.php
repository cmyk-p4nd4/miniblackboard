<?php require_once "../../admin_module/access.php"?>
<!DOCTYPE html>
<html>
<head>
        <title>Welcome, <?php echo $welcomeMsg; ?> - MiniBlackboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta charset="utf-8">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<!-- <link rel="stylesheet" type="text/css" href="registerExam.css"/> -->
	<!-- <script src="checkStatistics.js"></script> -->
</head>
<body>
    <?php
        require_once "../inst-navbar.php";
        
        $examID = $_POST['refExamID'];
        $examPrefix = $_POST['refExamPrefix'];
        
    ?>
    <div id="overallDiv">
        <p id='refExamID' hidden><?php echo $_POST['refExamID'];?></p>
        <p id='refExamPrefix' hidden><?php echo $_POST['refExamPrefix'];?></p>
        <p>Overall statistics: </p>
    </div>
    <div class="float-right">
        <form id='returnForm' method='post' action='/miniblackboard/wrap/mainhub.php'>
        <input type='submit' class='btn btn-danger' id='submitBtn' name='submitBtn' value='Return to course menu'>
        </form>
    </div>
    <?php 
        global $conn;
        $results = $conn->query("SELECT questionanswers, student_answer, marking, totalmarks, studentid from exam_records where examid =".$_POST['refExamID']);
        $question_list = [];
        $question_type = [];
        $temp_ans = [];
        $student_marking = [];
        $student_ans = [];
        $student_id =[];
        $total = $results->num_rows;
        while($row = $results->fetch_array()) {
            $question_list = json_decode($row[0])[0];
            $question_type = json_decode($row[0])[1];
            $temp_ans = json_decode($row[0])[3];
            array_push($student_ans, json_decode($row[1]));
            array_push($student_marking, json_decode($row[2]));
            array_push($student_id, $row[4]);
        }
        $correct_ans = [];
        foreach ($temp_ans as $key => $value) {
            if (is_array($value)) {
                array_push($correct_ans, 'Choice '.(array_search(1,$value)+1));
            } else {
                array_push($correct_ans, $value);
            }
        }
    ?>
    <div id="questionDiv">
        <h3 id='questionDivH2'>Statistics of each Question</h2>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Question</th>
                <th scope="col">Type</th>
                <th scope="col">Correct Answer</th>
                <th scope="col">Correct %</th>
                <th scope="col">Average Score</th>
            </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($question_list as $key => $value) {
                        echo "<tr>";
                        echo "<td>".$value."</td>";
                        echo "<td>".$question_type[$key]."</td>";
                        echo "<td>".$correct_ans[$key]."</td>";
                        $percentage = 0;
                        $avg_mark = 0;
                        for ($i=0; $i < $total ; $i++) { 
                            if ($student_marking[$i][$key] > 0) {
                                $percentage += 1;
                                $avg_mark += $student_marking[$i][$key];
                            }
                        }
                        echo "<td>". $percentage / $total * 100 ."</td>";
                        echo "<td>". $avg_mark / 3 ."</td>";
                        echo "</tr>";
                    }
                    unset($key,$value);
                ?>
            </tbody>
        </table>
        <h3 id='questionDivH2'>Statistics of each Student</h2>
        <?php 
            foreach ($student_id as $stdid=>$value) {
        ?>
        <span>Student <i class="fa fa-hashtag" aria-hidden="true"></i><?php echo $value;?></span>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Question</th>
                    <th scope="col">Type</th>
                    <th scope="col">Correct Answer</th>
                    <th scope="col">Student Answer</th>
                    <th scope="col">Correctness</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($question_list as $qkey => $value) {
                        echo "<tr>";
                        echo "<td>".$value."</td>";
                        echo "<td>".$question_type[$qkey]."</td>";
                        echo "<td>".$correct_ans[$qkey]."</td>";
                        echo "<td>".$student_ans[$stdid][$qkey]."</td>";
                        if ($student_marking[$stdid][$qkey] > 0 ) {
                            echo '<td><i class="fa fa-check fa-2x" aria-hidden="true" style="color: green"></i></td>';
                        } else {
                            echo '<td><i class="fa fa-times fa-2x" aria-hidden="true" style="color: red"></i></td>';
                        }
                        echo "</tr>";
                    }
                    unset($key,$value);
                ?>
            </tbody>
        </table>
        <?php } unset($key,$value);?>
    </div>
</body>
</html>
