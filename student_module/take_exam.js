var exam_name = "";
var startTime = "";
var deadline = "";
var userid = "";
var userName = "";

var originalQuestionTxt = "";
var questions = [];
var questionType = [];
var answers = [];
var correctAnswers = [];
var marksAvailable = [];
var currentQNum = 0;

function loadExam()
{
    //retrieve the cookies first
    //exam_name, start_time, deadline, userid 
    var existingCookies = document.cookie;
    existingCookies = decodeURIComponent(existingCookies);
    existingCookies = existingCookies.split(";");

    userid = existingCookies['userid'];
    deadline = existingCookies['deadline'];
    startTime = existingCookies['start_time'];
    exam_name = existingCookies['exam_name'];
    userName = existingCookies['alias'];
    
    //display all Basic information
    var aliasDisp = document.createElement("p");
    aliasDisp.setAttribute("id","aliasDisp");
    aliasDisp.innerHTML = "Your name: "+userName;
    document.getElementById("basicInfo").appendChild(aliasDisp);

    var idDisp = document.createElement("p");
    idDisp.setAttribute("id","idDisp");
    idDisp.innerHTML = "Your student id: "+userid;
    document.getElementById("basicInfo").appendChild(idDisp);

    var examNameDisp = document.createElement("p");
    examNameDisp.setAttribute("id","examNameDisp");
    examNameDisp.innerHTML = "Exam name: "+exam_name;
    document.getElementById("examNameDisp").appendChild(examNameDisp);

    var startTimeDisp = document.createElement("p");
    startTimeDisp.setAttribute("id","startTimeDisp");
    startTimeDisp.innerHTML = "Start Time: "+startTime;
    document.getElementById("basicInfo").appendChild(startTimeDisp);

    var endTimeDisp = document.createElement("p");
    endTimeDisp.setAttribute("id","endTimeDisp");
    endTimeDisp.innerHTML = "End Time: "+deadline;
    document.getElementById("basicInfo").appendChild(endTimeDisp);

    //do an SQL query to get the questions
    var requestQuestion = new XMLHttpRequest();
    requestQuestion.open("POST","get_exam.php");
    requestQuestion.setRequestHeader('content-type','application/x-www-form-urlencoded; charset=UTF-8');
    requestQuestion.onload=function()
    {
        var response = requestQuestion.responseText;
        switch (response)
        {
            case "FailConnection":
            {
                alert("Fail to connect with server!");
                window.href.location="https://web-miniblackboard.herokuapp.com/wrap/std-courseDisplay.php";
            }
            break;
            case "FailQuery":
            {
                alert("Fail to acquire questions!");
                window.href.location="https://web-miniblackboard.herokuapp.com/wrap/std-courseDisplay.php";
            }
            break;
            default:
            {
                originalQuestionTxt = response;
            }
            break;
        }
    };
    requestQuestion.send("userid="+userid+"&exam_name="+exam_name);

    //suppose all failure response has been redirected.
    originalQuestionTxt = JSON.parse(originalQuestionTxt);
    questions = JSON.parse(originalQuestionTxt[0]);
    questionType = JSON.parse(originalQuestionTxt[1]);
    answers = JSON.parse(originalQuestionTxt[2]);
    correctAnswers = JSON.parse(originalQuestionTxt[3]);
    marksAvailable = JSON.parse(originalQuestionTxt[4]);

    var questionCntDisp = document.createElement("p");
    questionCntDisp.setAttribute("id","questionCntDisp");
    questionCntDisp.innerHTML = "There are a total of "+questions.length+" questions.";
    document.getElementById("basicInfo").appendChild(questionCntDisp);

    //display the first questions


}

function displayQuestion(qNum)
{
    
}