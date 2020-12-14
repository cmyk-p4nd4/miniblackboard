<body>
    <?php 
        require_once dirname(__FILE__)."/../admin_module/connection.php";
        //retrieve all instructor's courses
        $stmt = $conn->prepare("SELECT courses.course_prefix, courses.coursename, courses.courseid FROM courses, student_course WHERE courses.courseid=student_course.courseid AND student_course.studentid = ?");
        $stmt->bind_param("i", $_COOKIE["userid"]);
        $stmt->execute();
        $result = $stmt->get_result();
        $list = $result->fetch_all();
    ?>
    <div class="tab-pane fade show active" id="course-list">
        <div class="list-group" id="list-div">
            <div class="alert alert-dark" role="alert">
                Course currently taking:
            </div>
        <?php
            foreach ($list as $idx => $row) {
        ?>      
                <a style="cursor:pointer"class="list-group-item list-group-item-action" <?php echo "id='courseBtn".$idx."' name='".$idx."'";?>><?php 
                        $courseInf = $row[0]." ".$row[1];
                        echo $courseInf;
                    ?></a>
                <input type="hidden" value="<?php echo $row[2]?>">
        <?php
            }
            $stmt->close();
            $conn->close();
        ?>
        </div>
    </div>
    <div id>

    </div>
    <script>
        $(function() {
            $("a[id*='courseBtn']").each(function() {
                $(this).click(function(){
                    var d = new Date();
                    d.setTime(d.getTime() + 3600*1000);
                    var expires = "expires="+d.toUTCString();
                    document.cookie = "course_prefix" + "=" + $(this).html() + ";" + expires + ";path=/wrap";
                    document.cookie = "courseid" + "=" + $(this).next("input[type='hidden']").first().val() + ";" + expires + ";path=/wrap";
                    location.assign("..\\wrap\\std-courseDisplay.php");
                });
            });
        });
    </script>
</body>