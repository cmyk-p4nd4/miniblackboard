var exam_name = "";
var startTime = "";
var deadline = "";
var userid = "";
var userName = "";
var studentAns = [];

var originalQuestionTxt = "";
var backupQuestionTxt = "";
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
    var debugging = false;

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
    document.getElementById("basicInfo").appendChild(examNameDisp);

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
    backupQuestionTxt = originalQuestionTxt;
    document.write(originalQuestionTxt);
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

    //display the first question
    displayQuestion(currentQNum);

}

function displayQuestion(qNum)
{
    //clear the questionDiv first
    document.getElementById("questionDiv").innerHTML = "";
    //detect questionType
    switch (questionType[qNum])
    {
        case "MCQ":
        {
            var questionNoDisp = document.createElement("p");
            questionNoDisp.setAttribute("id","questionNoTxt");
            questionNoDisp.innerHTML = "Question "+(qNum + 1);
            document.getElementById("questionDiv").appendChild(questionNoDisp);

            var questionDisp = document.createElement("p");
            questionDisp.setAttribute("id","questionDisp");
            questionDisp.innerHTML = "Question: " + questions[qNum];
            document.getElementById("questionDiv").appendChild(questionDisp);

            var thisAnswers = JSON.parse(answers[qNum]);

            for (var i = 0; i < thisAnswers.length; i++)
            {
                var answerRadio = document.createElement("input");
                answerRadio.setAttribute("type","radio");
                answerRadio.setAttribute("id","answer"+i);
                answerRadio.setAttribute("name","answer");
                answerRadio.setAttribute("value",thisAnswers[i]);
            }


        }
        break;
        case "SQ":
        case "FB":
        {
            var questionNoDisp = document.createElement("p");
            questionNoDisp.setAttribute("id","questionNoTxt");
            questionNoDisp.innerHTML = "Question "+(qNum + 1);
            document.getElementById("questionDiv").appendChild(questionNoDisp);

            var questionDisp = document.createElement("p");
            questionDisp.setAttribute("id","questionDisp");
            questionDisp.innerHTML = "Question: " + questions[qNum];
            document.getElementById("questionDiv").appendChild(questionDisp);

            var answerDisp = document.createElement("p");
            answerDisp.setAttribute("id","answerDisp");
            answerDisp.innerHTML = "Answer: ";
            document.getElementById("answerDisp").appendChild(answerDisp);

            var answerInput = document.createElement("input");
            answerInput.setAttribute("type","text");
            answerInput.setAttribute("id","answer");
            answerInput.setAttribute("name","answer");
            answerDisp.appendChild(answerInput);
        }
        break;
    }
}

function saveQuestion(qNum)
{
    switch (questionType[qNum])
    {
        case "MCQ":
        {
            var radioGroup = document.getElementsByName("answer");
            for (var i = 0; i < radioGroup.length; i++)
            {
                if (radioGroup[i].checked)
                {
                    //record into studentAns
                    studentAns[qNum] = radioGroup[i].value;
                    break;
                }
            }
        }
        break;
        case "SQ":
        case "FB":
        {
            var answerBox = document.getElementById("answer");
            studentAns[qNum] = answerBox.value;
        }
        break;
    }
}

function displayButtons(qNum)
{
    document.getElementBtId("buttonList").innerHTML="";
    var prevBtn = document.createElement("button");
    prevBtn.setAttribute("id","prevBtn");
    prevBtn.setAttribute("onclick","prevQuestion();");
    prevBtn.innerHTML = "Previous Question";
    if (qNum <= 0)
        prevBtn.setAttribute("disabled","true");
    else
        prevBtn.setAttribute("disabled","false");
    document.getElementById("buttonList").appendChild(prevBtn);

    var nextBtn = document.createElement("button");
    nextBtn.setAttribute("id","nextBtn");
    nextBtn.setAttribute("onclick","nextQuestion();");
    nextBtn.innerHTML = "Next Question";
    if (qNum >= questions.length - 1)
        nextBtn.setAttribute("disabled","true");
    else
        nextBtn.setAttribute("disabled","false");
    document.getElementById("buttonList").appendChild(nextBtn);

    var submitBtn = document.createElement("button");
    submitBtn.setAttribute("id","submitBtn");
    submitBtn.setAttribute("onclick","submitWork();");
    submitBtn.innerHTML = "Submit exam";
    document.getElementById("buttonList").appendChild(submitBtn);
}

function prevQuestion()
{
    saveQuestion(currentQNum);
    currentQNum--;
    displayQuestion(currentQNum);
    displayButtons(currentQNum);
}

function nextQuestion()
{
    saveQuestion(currentQNum);
    currentQNum++;
    displayQuestion(currentQNum);
    displayButtons(currentQNum);
}

function submitWork()
{
    //check if student has answered all questions
    //to deal with clicking the submit button after finishing the last question,
    //saveQuestion for once first
    saveQuestion(currentQNum);

    var properlyFilled = true;

    //check if the student has completed all answer
    if (studentAns.length < questions.length)
    {
        properlyFilled = false;
    } else
    {
        //check if the answer has any empty. if empty found, then also !properlyFilled
        for (var i = 0; i < studentAns.length; i++)
        {
            if (studentAns[i] == 'undefined')
                properlyFilled = false;
            else if (studentAns[i] == "")
                properFilled = false;
            if (!properFilled)
                break;
        }
    }

    var toSubmit = false;
    if (!properlyFilled)
    {
        if (confirm("You still have some questions not finished, confirm to submit?"))
            toSubmit = true;
    }
    else
    {
        toSubmit = true;
    }

    if (toSubmit)
    {
        //find if there is any empty answer
        for (var i = 0; i < questions.length; i++)
        {
            if (studentAns[i] == 'undefined')
            {
                studentAns[i] == "";
            }
        }

        //check MC question answer, and put "?" to FB, SQs
        var marking = [];
        var totalMarks = 0;
        for (var j = 0; j < questions.length; j++)
        {
            //one question
            //fetch the mark of this question
            var thisQuestionScore = marksAvailable[j]
            switch (questionType[j])
            {
                case "MCQ":    
                {
                    //get which answer is correct
                    var correctAnsArray = JSON.parse(correctAnswers[j]);
                    var AnsArray = JSON.parse(answers[j]);
                    var correctAnsPos = 0;
                    for (var t = 0; t < correctAnsArray.length; t++)
                    {
                        if (correctAnsArray[t] == 1)
                            correctAnsPos = t;
                    }
                    if (studentAns[j] == AnsArray[t])
                    {
                        totalMarks += thisQuestionScore;
                        marking[j] = thisQuestionScore;
                    }
                }
                break;
                case "SQ":
                case "FB":
                {
                    //SQ and FB no need to grade
                    marking[j] = "?";
                    totalMarks += 0;
                }
                break;
            }
        }

        //encode student's answers and marking
        var JSONstdAnswer = JSON.stringify(studentAns);
        var JSONmarking = JSON.stringify(marking);

        //generate the submittion date
        var submitDate = new Date();
        var submitDateStr = submitDate.getFullYear()+"-"+(submitDate.getMonth()+1)+"-"+(submitDate.getDate()+1)
        +" "+(submitDate.getHours())+":"+(submitDate.getMinutes())+":"+(submitDate.getSeconds());
        

        //send stdAnswer, studentid, time of submit, backup...(original text), marking and totalmarks
        //do an SQL query to get the questions
        var requestQuestion = new XMLHttpRequest();
        requestQuestion.open("POST","submit_exam.php");
        requestQuestion.setRequestHeader('content-type','application/x-www-form-urlencoded; charset=UTF-8');
        requestQuestion.onload=function()
        {
            var response = requestQuestion.responseText;
            switch (response)
            {
                case "FailConnection":
                {
                    alert("Fail to connect with server!");
                    //window.href.location="https://web-miniblackboard.herokuapp.com/wrap/std-courseDisplay.php";
                }
                break;
                case "FailQuery":
                {
                    alert("Fail to insert your record!");
                    //window.href.location="https://web-miniblackboard.herokuapp.com/wrap/std-courseDisplay.php";
                }
                break;
                default:
                {
                    var posResponse = response;
                    if (posResponse == "Added")
                    {
                        alert("Submit successful!");
                        window.href.location="https://web-miniblackboard.herokuapp.com/wrap/std-courseDisplay.php";
                    } else if (posResponse == "NoEffects")
                    {
                        alert("Seems you have attempted this test before!");
                        window.href.location="https://web-miniblackboard.herokuapp.com/wrap/std-courseDisplay.php";
                    }
                }
                break;
        }
        };
        //
        requestQuestion.send("exam_name="+exam_name+"&userid="+userid+"&submit_time="+submitDateStr+
        "&questionanswers="+backupQuestionTxt+"&student_answer="+JSONstdAnswer+"&marking="+JSONmarking+
        "&totalmarks="+totalMarks);
    }

}