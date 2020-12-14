var exam_name = "";
var startTime = "";
var deadline = "";
var userid = "";
var userName = "";

var questions = [];
 


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
    
}


function extractCookies()