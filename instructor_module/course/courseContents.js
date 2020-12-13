function onViewChosen(contentid)
{
    //create an hidden form at courseContents.php and then pass the contentid to viewContent.php
    var contentidForm = document.createElement("form");
    contentidForm.setAttribute("id","contentidForm");
    contentidForm.setAttribute("name","contentidForm");
    contentidForm.setAttribute("method","post");
    contentidForm.setAttribute("action","viewContent.php");

    var contentidInput = document.createElement("input");
    contentidInput.setAttribute("id","contentidInput");
    contentidInput.setAttribute("name","contentID");
    contentidInput.setAttribute("value",contentid);
    contentidInput.setAttribute("type","hidden");

    contentidForm.appendChild(contentidInput);
    document.body.appendChild(contentidForm);
    contentidForm.submit();
}

function onModifyChosen(contentid)
{
    //create an hidden form at courseContents.php and then pass the contentid to viewContent.php
    var contentidForm = document.createElement("form");
    contentidForm.setAttribute("id","contentidForm");
    contentidForm.setAttribute("name","contentidForm");
    contentidForm.setAttribute("method","post");
    contentidForm.setAttribute("action","/eie4432/project/exam/modifyExam.php");

    var contentidInput = document.createElement("input");
    contentidInput.setAttribute("id","contentidInput");
    contentidInput.setAttribute("name","modifyExamID");
    contentidInput.setAttribute("value",contentid);
    contentidInput.setAttribute("type","hidden");

    contentidForm.appendChild(contentidInput);
    document.body.appendChild(contentidForm);
    contentidForm.submit();
}

function onDeleteChosen()
{

}