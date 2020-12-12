function checkCourseInputCorrect()
{
    var prefix = document.getElementById("course_prefix").value;
    var courseName = document.getElementById("course_name").value;

    if ((prefix.length <= 0) || (courseName.length<=0))
    {
        alert("Course prefix or course name is empty!");
    }
    else
    {
        if(confirm("Confirm to add this course?")) //dummy for debug
        {
            document.getElementById("subject_input_form").submit();
        }
    }
}