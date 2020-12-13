<head>
	<script src="../instructor_module/course/courseMenu.js"></script>
</head>
<body>
    <?php 
        require_once dirname(__FILE__)."/../../admin_module/connection.php";
        //retrieve all instructor's courses
        $stmt = $conn->prepare("SELECT course_prefix, coursename FROM courses WHERE instructorid = ?");
        $stmt->bind_param("i", $_COOKIE["userid"]);
        $stmt->execute();
        $result = $stmt->get_result();
        $list = $result->fetch_all();
    ?>
    <div class="tab-pane fade show active" id="course-list">
        <div class="list-group" id="list-div">
            <div class="alert alert-dark" role="alert">
                Course currently teaching:
            </div>
        <?php
            foreach ($list as $idx => $row) {
        ?>      
                <a style="cursor:pointer"class="list-group-item list-group-item-action" <?php echo "id='courseBtn".$idx."' name='".$idx."' onclick='processCourse(\"".$row[0]."\")'";?>>
                    <?php 
                        $courseInf = $row[0]." ".$row[1];
                        echo $courseInf;
                    ?>
                </a>
        <?php
            }
        ?>
        </div>
        </div>
</body>