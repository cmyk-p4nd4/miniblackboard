



function loading(contentID)
{
    var modifyContent = document.getElementById("modifyContent");
    //do an AJAX query to retrieve exam information
    var request = new XMLHttpRequest();
    request.open("POST","askExamInf.php");
    request.setRequestHeader('content-type','application/x-www-form-urlencoded; charset=UTF-8');
    request.onload = function()
    {
        //process JSON output from the askExamInf.php
        var responseResult = request.responseText;
        var examData = JSON.parse(responseResult);
        
        //separate into different items 
        var examID = examData.examid;
        var exam_name = examData.exam_name;
        var startdate = examData.startdate;
        var full_duration = examData.duration;
        var questions_array = examData.questions; 
        //relevant subject is for reference.


    }
    request.send('contentID='+contentID);
    
}

function onDeleteQuestionBtnClicked()
{

}

function onAddAnswerBtnClicked()
{

}

function onRemoveAnswerBtnClicked()
{

}

function onSaveButtonClicked()
{

}