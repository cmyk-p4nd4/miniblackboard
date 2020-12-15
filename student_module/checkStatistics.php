<?php require_once "../admin_module/access.php" ?>

<body>
    <?php
        $conn = new mysqli(DB_HOST,DB_USER,DB_TOKEN,DB_TARGET);
        $results = $conn->query("SELECT * FROM exam_records where studentid=".$_COOKIE['userid']);
        $exam_item = [];
        $timestamp_list = [];
        $question_list = [];
        $question_type = [];
        $temp_ans = [];
        $student_marking = [];
        $student_ans = [];
        $fullmark_list = [];
        $totalmark_list = [];
        while ($row = $results->fetch_array()) {
            array_push($exam_item, json_decode($row[0]));
            array_push($timestamp_list, json_decode($row[2]));
            array_push($question_list, json_decode($row[3])[0]);
            array_push($question_type, json_decode($row[3])[1]);
            array_push($temp_ans, json_decode($row[3])[3]);
            array_push($fullmark_list, json_decode($row[3])[4]);
            array_push($student_ans, json_decode($row[4]));
            array_push($student_marking, json_decode($row[5]));
            array_push($totalmark_list, json_decode($row[5]));
        }
        //print_r($exam_item);
        $results->free();
        //print_r($temp_ans);
        
        array_map(function($value) {return floor($value / 100000);}, $exam_item);
        
    ?>
    <div class="tab-pane fade" id="grade-list">
        <div class="alert alert-dark" role="alert">Exams List Result:</div>
        <?php 
            foreach ($exam_item as $ekey => $evalue) {
                $correct_ans = [];
                foreach ($temp_ans[$ekey] as $ckey => $cvalue) {
                    if (is_array($cvalue)) {
                        array_push($correct_ans, 'Choice '.(array_search(1,$cvalue)+1));
                    } else {
                        array_push($correct_ans, $cvalue);
                    }
                }
                unset($ckey, $cvalue);
        ?>
            <h4>Subject ID: <?php echo $evalue;?></h4>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Question</th>
                        <th scope="col">Correct Answer</th>
                        <th scope="col">Your Answer</th>
                        <th scope="col">Correctness</th>
                        <th scope="col">Marks</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($question_list[$ekey] as $qkey => $qvalue) {
                        echo "<tr>";
                        echo "<td>".$qvalue."</td>";
                        echo "<td>".$correct_ans[$qkey]."</td>";
                        echo "<td>".$student_ans[$ekey][$qkey]."</td>";
                        if ($student_marking[$ekey][$qkey] > 0) {
                            echo '<td><i class="fa fa-check fa-2x" aria-hidden="true" style="color: green"></i></td>';
                        } else {
                            echo '<td><i class="fa fa-times fa-2x" aria-hidden="true" style="color: red"></i></td>';
                        }
                        echo "<td>".$totalmark_list[$ekey][$qkey]."</td>";
                        echo "</tr>";
                    }
                    unset($key,$value);
                ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th scope="col">Total Marks</th>
                    <td><?php echo array_sum($totalmark_list[$ekey])."/".array_sum($fullmark_list[$ekey]);?></td>
                </tr>
            </tbody>
            </table>
        <?php }unset($key,$value); ?>
    </div>
</body>
</html>