function processCourse(course)
{
    //you have the course, then create a new form to store the course and then submit
    var courseForm = document.createElement("form");
    courseForm.setAttribute("method","post");
    courseForm.setAttribute("action","courseContents.php");

    var courseInput = document.createElement("input");
    courseInput.setAttribute("type","hidden");
    courseInput.setAttribute("name","courseInput");
    courseInput.setAttribute("id","courseInput");
    courseInput.setAttribute("value",course);

    courseForm.appendChild(courseInput);
    document.body.appendChild(courseForm);
    courseForm.submit();
}