var studentID = [];
var submitTime = [];
var questionAnswers = []; //should be common for all student in a test
var studentAnswers = [];
var marking = [];
var totalmarks = [];

//questions and corresponding data for this exam
var examQuestion = [];
var examQType = [];
var examAvailableAnswers = [];
var examCorrectAnswers = [];
var examMarksAttainable = [];
var currentQuestionNum = 0;
function retrieveStudentID(examID)
{
    var stdInfDiv = document.getElementById("stdInfDiv");
    var requestStd = new XMLHttpRequest();
    requestStd.open("POST","getExamRecords.php");
    requestStd.setRequestHeader('content-type','application/x-www-form-urlencoded; charset=UTF-8');

    var isRetrieved = false;


    requestStd.onload = function()
    {
        //process JSON output from the askExamInf.php
        var responseResult = requestStd.responseText;
        if (responseResult != "No record found.")
        {
            var records = JSON.parse(responseResult);

            //records store student's record row by row.
            for (var i = 0; i < records.length; i++)
            {
            var stdRec = records[i];
            //single student record
            //discard the know examid
            studentID[i] = stdRec['studentid'];
            submitTime[i] = stdRec['submit_time'];
            questionAnswers = stdRec['questionanswers'];
            studentAnswers[i] = stdRec['student_answer'];
            marking[i] = stdRec['marking'];
            totalmarks[i] = stdRec['totalmarks'];
            }

            questionAnsArray = JSON.parse(questionAnswers);
            examQuestion = questionAnsArray[0];
            examQType = questionAnsArray[1];
            examAvailableAnswers = questionAnsArray[2];
            examCorrectAnswers = questionAnsArray[3];
            examMarksAttainable = questionAnsArray[4];

            //finish retrieving the result, print the drop-down list items
            var chooseStd = document.getElementById("chooseStd");
            var newOption = document.createElement("option");
            newOption.setAttribute('value','Select...');
            newOption.innerHTML = "Select...";
            chooseStd.appendChild(newOption);

            for (var i = 0; i < studentID.length; i++)
            {
                newOption = document.createElement("option");
                newOption.setAttribute('value',studentID[i]);
                newOption.innerHTML = studentID[i];
                chooseStd.appendChild(newOption);
            }
        }
        


    };
    
    requestStd.send("examid="+examID);
}

function displayStdRecord()
{
    //extract chosen record first
    document.getElementById("stdInfDiv").innerHTML="";
    document.getElementById("stdQuestionDiv").innerHTML="";
    var chosenID = document.getElementById("chooseStd").value;
    if (chosenID == "Select...")
    {
        //nothing chosen
        document.getElementById("stdInfDiv").innerHTML = "";
        document.getElementById("stdQuestionDiv").innerHTML = "";
    }
    else
    {
        //get the index of studentID array
        var foundID = false;
        var index = 0;
        //assume the student's record must be found
        while ((!foundID))
        {
            if (studentID[index] == chosenID)
                foundID = true;
            else
                index++;
        }
        
        //index found, then retrieve student's data
        var oneSubmitTime = submitTime[index];
        var oneStudentAnswer = studentAnswers[index];
        //parse student's answer back to array
        oneStudentAnswer = JSON.parse(oneStudentAnswer);
        var oneMarking = marking[index];
        oneMarking = JSON.parse(oneMarking);

        //student's data retrieved, display student information first
        var stdInfDiv = document.getElementById("stdInfDiv");
        var stdIdDisp = document.createElement("p");
        stdIdDisp.setAttribute("id","stdIdDisp");
        stdIdDisp.innerHTML="Student ID is: " + studentID[index];
        stdInfDiv.appendChild(stdIdDisp);

        var submitTimeDisp = document.createElement("p");
        submitTimeDisp.setAttribute("id","submitTimeDisp");
        submitTimeDisp.innerHTML="Date and time of submit: "+oneSubmitTime;
        stdInfDiv.appendChild(submitTimeDisp);



        //display questions
        //student information retrieved, display the  question
        //display question number
        var stdQuestionDiv = document.getElementById('stdQuestionDiv');
        var questionNumDisp = document.createElement("p");
        questionNumDisp.setAttribute("id","questionNumDisp");
        questionNumDisp.innerHTML = "Question #"+ (currentQuestionNum+1);
        stdQuestionDiv.appendChild(questionNumDisp);

        //display the question 
        var questionDisp = document.createElement("p");
        questionDisp.setAttribute("id","questionDisp");
        questionDisp.innerHTML = "Question: "+examQuestion[currentQuestionNum];
        stdQuestionDiv.appendChild(questionDisp);

        //display student's answer
        var studentAnswerDisp = document.createElement("p");
        studentAnswerDisp.setAttribute("id","studentAnswerDisp");
        studentAnswerDisp.innerHTML = "Student answered: "+oneStudentAnswer[currentQuestionNum];
        stdQuestionDiv.appendChild(studentAnswerDisp);

        //display correct answer.
        //before display, check the question type first
        switch (examQType[currentQuestionNum])
        {
            case "MCQ":
            {
                var correctAnswerArray = examCorrectAnswers[currentQuestionNum];
                //suppose only one correct answer
                var currentAnswers = examAvailableAnswers[currentQuestionNum];
                var correctAnswerIndex = 0; 
                for (var i = 0 ; i < correctAnswerArray.length; i++)
                    if (correctAnswerArray[i] == 1)
                    {
                        correctAnswerIndex = i;
                        break;
                    }
                //correct answer location catched, now display the correct Answer
                var correctAnswerDisp = document.createElement("p");
                correctAnswerDisp.setAttribute("id","correctAnswerDisp");
                correctAnswerDisp.innerHTML = "Correct Answer is: "+ currentAnswers[correctAnswerIndex];
                stdQuestionDiv.appendChild(correctAnswerDisp);

                //display the marks attained
                var markAcqDisp = document.createElement("p");
                markAcqDisp.setAttribute("id","markAcqDisp");
                markAcqDisp.innerHTML = "This MC question weights for " + examMarksAttainable[currentQuestionNum] + " marks, student got "+oneMarking[currentQuestionNum]+" mark(s).";
                stdQuestionDiv.appendChild(markAcqDisp);
            }
            break;
            case "SQ":
            {
                 //correct answer location catched, now display the correct Answer
                 var correctAnswerDisp = document.createElement("p");
                 correctAnswerDisp.setAttribute("id","correctAnswerDisp");
                 correctAnswerDisp.innerHTML = "Correct Answer is: "+ examCorrectAnswers[currentQuestionNum];
                 stdQuestionDiv.appendChild(correctAnswerDisp);
 
                 //display the marks input sections
                 var markAcqDisp = document.createElement("p");
                 markAcqDisp.setAttribute("id","markAcqDisp");
                 stdQuestionDiv.appendChild(markAcqDisp);

                 //display the mark input box
                 var markAcqBox = document.createElement("input");
                 markAcqBox.setAttribute("id","markAcqBox");
                 markAcqBox.setAttribute("name","marksGiven");
                 markAcqBox.setAttribute("type","number");
                 markAcqDisp.innerHTML = "This short question weights for " + examMarksAttainable[currentQuestionNum] +" marks, student's mark: ";
                 markAcqDisp.appendChild(markAcqBox);

                
            }
            break;
            case "FB":
            {
                 //correct answer location catched, now display the correct Answer
                 var correctAnswerDisp = document.createElement("p");
                 correctAnswerDisp.setAttribute("id","correctAnswerDisp");
                 correctAnswerDisp.innerHTML = "Correct Answer is: "+ examCorrectAnswers[currentQuestionNum];
                 stdQuestionDiv.appendChild(correctAnswerDisp);
 
                  //display the marks input sections
                 var markAcqDisp = document.createElement("p");
                 markAcqDisp.setAttribute("id","markAcqDisp");
                 stdQuestionDiv.appendChild(markAcqDisp);

                 //display the mark input box
                 var markAcqBox = document.createElement("input");
                 markAcqBox.setAttribute("id","markAcqBox");
                 markAcqBox.setAttribute("name","marksGiven");
                 markAcqBox.setAttribute("type","number");
                 markAcqDisp.innerHTML = "This fill in the blanks question weights for " + examMarksAttainable[currentQuestionNum] +" marks, student's mark: ";
                 markAcqDisp.appendChild(markAcqBox);

                
            }
            break;
        }

        //display four buttons: previous, next, finished and back
        var buttonsArray = document.createElement("p");
        buttonsArray.setAttribute("id","buttonsArray");
        buttonsArray.setAttribute("align","center");
        stdQuestionDiv.appendChild(buttonsArray);

        var previousBtn = document.createElement("input");
        previousBtn.setAttribute("type","button");
        previousBtn.setAttribute("id","previousBtn");
        previousBtn.setAttribute("name","previousBtn");
        previousBtn.setAttribute("onclick","onPreviousClicked();");
        previousBtn.setAttribute("value","Previous Question");
        if (currentQuestionNum <= 0)
            previousBtn.setAttribute("disabled","true");
        buttonsArray.appendChild(previousBtn);

        var nextBtn = document.createElement("input");
        nextBtn.setAttribute("type","button");
        nextBtn.setAttribute("id","nextBtn");
        nextBtn.setAttribute("name","nextBtn");
        nextBtn.setAttribute("onclick","onNextClicked();");
        nextBtn.setAttribute("value","Next Question");
        buttonsArray.appendChild(nextBtn);

        var finishBtn = document.createElement("input");
        finishBtn.setAttribute("type","button");
        finishBtn.setAttribute("id","finishBtn");
        finishBtn.setAttribute("name","finishBtn");
        finishBtn.setAttribute("onclick","onFinish();");
        finishBtn.setAttribute("value","Submit marking for this student");
        buttonsArray.appendChild(finishBtn);

        var backBtn = document.createElement("input");
        backBtn.setAttribute("type","button");
        backBtn.setAttribute("id","backBtn");
        backBtn.setAttribute("name","backBtn");
        backBtn.setAttribute("onclick","onBackPressed();");
        backBtn.setAttribute("value","Return to exam detail");
        buttonsArray.appendChild(backBtn);
        //var correctAnswerDisp = document.createElement("p");
        //correctAnswerDisp.setAttribute("id","correctAnswerDisp");
        //correctAnswerDisp.innerHTML = "The correct answer is: "+ examCorrectAnswers[currentQuestionNum];
        //stdQuestionDiv.appendChild(correctAnswerDisp);

    }
}

function onPreviousClicked()
{
    var chosenID = document.getElementById("chooseStd").value;
    //get the index of studentID array
    var foundID = false;
    var index = 0;
    //assume the student's record must be found
    while ((!foundID))
    {
        if (studentID[index] == chosenID)
            foundID = true;
        else
            index++;
    }
    
    //index found, then retrieve student's data
    var oneSubmitTime = submitTime[index];
    var oneStudentAnswer = studentAnswers[index];
    //parse student's answer back to array
    oneStudentAnswer = JSON.parse(oneStudentAnswer);
    var oneMarking = marking[index];
    oneMarking = JSON.parse(oneMarking);

    //check the questionType
    if (examQType[currentQuestionNum] == "SQ" || examQType[currentQuestionNum] == "FB")
    {
        //SQ and FB, record the score
        //alert(marking);
        oneMarking[currentQuestionNum] = parseInt(document.getElementById("markAcqBox").value);
        marking[index] = JSON.stringify(oneMarking);
        //alert(marking);
    }


    //redraw the UI
    document.getElementById("stdQuestionDiv").innerHTML="";
    currentQuestionNum--;

    //display questions
        //student information retrieved, display the  question
        //display question number
        var stdQuestionDiv = document.getElementById('stdQuestionDiv');
        var questionNumDisp = document.createElement("p");
        questionNumDisp.setAttribute("id","questionNumDisp");
        questionNumDisp.innerHTML = "Question #"+ (currentQuestionNum+1);
        stdQuestionDiv.appendChild(questionNumDisp);

        //display the question 
        var questionDisp = document.createElement("p");
        questionDisp.setAttribute("id","questionDisp");
        questionDisp.innerHTML = "Question: "+examQuestion[currentQuestionNum];
        stdQuestionDiv.appendChild(questionDisp);

        //display student's answer
        var studentAnswerDisp = document.createElement("p");
        studentAnswerDisp.setAttribute("id","studentAnswerDisp");
        studentAnswerDisp.innerHTML = "Student answered: "+oneStudentAnswer[currentQuestionNum];
        stdQuestionDiv.appendChild(studentAnswerDisp);

        //display correct answer.
        //before display, check the question type first
        switch (examQType[currentQuestionNum])
        {
            case "MCQ":
            {
                var correctAnswerArray = examCorrectAnswers[currentQuestionNum];
                //suppose only one correct answer
                var currentAnswers = examAvailableAnswers[currentQuestionNum];
                var correctAnswerIndex = 0; 
                for (var i = 0 ; i < correctAnswerArray.length; i++)
                    if (correctAnswerArray[i] == 1)
                    {
                        correctAnswerIndex = i;
                        break;
                    }
                //correct answer location catched, now display the correct Answer
                var correctAnswerDisp = document.createElement("p");
                correctAnswerDisp.setAttribute("id","correctAnswerDisp");
                correctAnswerDisp.innerHTML = "Correct Answer is: "+ currentAnswers[correctAnswerIndex];
                stdQuestionDiv.appendChild(correctAnswerDisp);

                //display the marks attained
                var markAcqDisp = document.createElement("p");
                markAcqDisp.setAttribute("id","markAcqDisp");
                markAcqDisp.innerHTML = "This MC question weights for " + examMarksAttainable[currentQuestionNum] + " marks, student got "+oneMarking[currentQuestionNum]+" mark(s).";
                stdQuestionDiv.appendChild(markAcqDisp);
            }
            break;
            case "SQ":
            {
                 //correct answer location catched, now display the correct Answer
                 var correctAnswerDisp = document.createElement("p");
                 correctAnswerDisp.setAttribute("id","correctAnswerDisp");
                 correctAnswerDisp.innerHTML = "Correct Answer is: "+ examCorrectAnswers[currentQuestionNum];
                 stdQuestionDiv.appendChild(correctAnswerDisp);
 
                 //display the marks input sections
                 var markAcqDisp = document.createElement("p");
                 markAcqDisp.setAttribute("id","markAcqDisp");
                 stdQuestionDiv.appendChild(markAcqDisp);

                 //display the mark input box
                 var markAcqBox = document.createElement("input");
                 markAcqBox.setAttribute("id","markAcqBox");
                 markAcqBox.setAttribute("name","marksGiven");
                 markAcqBox.setAttribute("type","number");

                 if ((oneMarking[currentQuestionNum] != "") ||(oneMarking[currentQuestionNum] != "?"))
                    markAcqBox.setAttribute("value",oneMarking[currentQuestionNum]);


                 markAcqDisp.innerHTML = "This short question weights for " + examMarksAttainable[currentQuestionNum] +" marks, student's mark: ";
                 markAcqDisp.appendChild(markAcqBox);

                 
            }
            break;
            case "FB":
            {
                 //correct answer location catched, now display the correct Answer
                 var correctAnswerDisp = document.createElement("p");
                 correctAnswerDisp.setAttribute("id","correctAnswerDisp");
                 correctAnswerDisp.innerHTML = "Correct Answer is: "+ examCorrectAnswers[currentQuestionNum];
                 stdQuestionDiv.appendChild(correctAnswerDisp);
 
                  //display the marks input sections
                 var markAcqDisp = document.createElement("p");
                 markAcqDisp.setAttribute("id","markAcqDisp");
                 stdQuestionDiv.appendChild(markAcqDisp);

                 //display the mark input box
                 var markAcqBox = document.createElement("input");
                 markAcqBox.setAttribute("id","markAcqBox");
                 markAcqBox.setAttribute("name","marksGiven");
                 markAcqBox.setAttribute("type","number");

                 if ((oneMarking[currentQuestionNum] != "") ||(oneMarking[currentQuestionNum] != "?"))
                    markAcqBox.setAttribute("value",oneMarking[currentQuestionNum]);

                 markAcqDisp.innerHTML = "This fill in the blanks question weights for " + examMarksAttainable[currentQuestionNum] +" marks, student's mark: ";
                 markAcqDisp.appendChild(markAcqBox);

            }
            break;
        }

        //display four buttons: previous, next, finished and back
        var buttonsArray = document.createElement("p");
        buttonsArray.setAttribute("id","buttonsArray");
        buttonsArray.setAttribute("align","center");
        stdQuestionDiv.appendChild(buttonsArray);

        var previousBtn = document.createElement("input");
        previousBtn.setAttribute("type","button");
        previousBtn.setAttribute("id","previousBtn");
        previousBtn.setAttribute("name","previousBtn");
        previousBtn.setAttribute("onclick","onPreviousClicked();");
        previousBtn.setAttribute("value","Previous Question");
        if (currentQuestionNum <= 0)
            previousBtn.setAttribute("disabled","true");
        buttonsArray.appendChild(previousBtn);

        var nextBtn = document.createElement("input");
        nextBtn.setAttribute("type","button");
        nextBtn.setAttribute("id","nextBtn");
        nextBtn.setAttribute("name","nextBtn");
        nextBtn.setAttribute("onclick","onNextClicked();");
        nextBtn.setAttribute("value","Next Question");
        buttonsArray.appendChild(nextBtn);

        var finishBtn = document.createElement("input");
        finishBtn.setAttribute("type","button");
        finishBtn.setAttribute("id","finishBtn");
        finishBtn.setAttribute("name","finishBtn");
        finishBtn.setAttribute("onclick","onFinish();");
        finishBtn.setAttribute("value","Submit marking for this student");
        buttonsArray.appendChild(finishBtn);

        var backBtn = document.createElement("input");
        backBtn.setAttribute("type","button");
        backBtn.setAttribute("id","backBtn");
        backBtn.setAttribute("name","backBtn");
        backBtn.setAttribute("onclick","onBackPressed();");
        backBtn.setAttribute("value","Return to exam detail");
        buttonsArray.appendChild(backBtn);
}

function onNextClicked()
{
    var chosenID = document.getElementById("chooseStd").value;
    //get the index of studentID array
    var foundID = false;
    var index = 0;
    //assume the student's record must be found
    while ((!foundID))
    {
        if (studentID[index] == chosenID)
            foundID = true;
        else
            index++;
    }
    
    //index found, then retrieve student's data
    var oneSubmitTime = submitTime[index];
    var oneStudentAnswer = studentAnswers[index];
    //parse student's answer back to array
    oneStudentAnswer = JSON.parse(oneStudentAnswer);
    var oneMarking = marking[index];
    oneMarking = JSON.parse(oneMarking);

    //check the questionType
    if (examQType[currentQuestionNum] == "SQ" || examQType[currentQuestionNum] == "FB")
    {
        //SQ and FB, record the score
        //alert(marking);
        oneMarking[currentQuestionNum] = parseInt(document.getElementById("markAcqBox").value);
        marking[index] = JSON.stringify(oneMarking);
        //alert(marking);
    }

    document.getElementById("stdQuestionDiv").innerHTML="";
    currentQuestionNum++;
    
    //display questions
    //student information retrieved, display the  question
    //display question number
    var stdQuestionDiv = document.getElementById('stdQuestionDiv');
    var questionNumDisp = document.createElement("p");
    questionNumDisp.setAttribute("id","questionNumDisp");
    questionNumDisp.innerHTML = "Question #"+ (currentQuestionNum+1);
    stdQuestionDiv.appendChild(questionNumDisp);

    //display the question 
    var questionDisp = document.createElement("p");
    questionDisp.setAttribute("id","questionDisp");
    questionDisp.innerHTML = "Question: "+examQuestion[currentQuestionNum];
    stdQuestionDiv.appendChild(questionDisp);

    
        //display student's answer
        var studentAnswerDisp = document.createElement("p");
        studentAnswerDisp.setAttribute("id","studentAnswerDisp");
        studentAnswerDisp.innerHTML = "Student answered: "+oneStudentAnswer[currentQuestionNum];
        stdQuestionDiv.appendChild(studentAnswerDisp);

        //display correct answer.
        //before display, check the question type first
        switch (examQType[currentQuestionNum])
        {
            case "MCQ":
            {
                var correctAnswerArray = examCorrectAnswers[currentQuestionNum];
                //suppose only one correct answer
                var currentAnswers = examAvailableAnswers[currentQuestionNum];
                var correctAnswerIndex = 0; 
                for (var i = 0 ; i < correctAnswerArray.length; i++)
                    if (correctAnswerArray[i] == 1)
                    {
                        correctAnswerIndex = i;
                        break;
                    }
                //correct answer location catched, now display the correct Answer
                var correctAnswerDisp = document.createElement("p");
                correctAnswerDisp.setAttribute("id","correctAnswerDisp");
                correctAnswerDisp.innerHTML = "Correct Answer is: "+ currentAnswers[correctAnswerIndex];
                stdQuestionDiv.appendChild(correctAnswerDisp);

                //display the marks attained
                var markAcqDisp = document.createElement("p");
                markAcqDisp.setAttribute("id","markAcqDisp");
                markAcqDisp.innerHTML = "This MC question weights for " + examMarksAttainable[currentQuestionNum] + " marks, student got "+oneMarking[currentQuestionNum]+" mark(s).";
                stdQuestionDiv.appendChild(markAcqDisp);
            }
            break;
            case "SQ":
            {
                 //correct answer location catched, now display the correct Answer
                 var correctAnswerDisp = document.createElement("p");
                 correctAnswerDisp.setAttribute("id","correctAnswerDisp");
                 correctAnswerDisp.innerHTML = "Correct Answer is: "+ examCorrectAnswers[currentQuestionNum];
                 stdQuestionDiv.appendChild(correctAnswerDisp);
 
                 //display the marks input sections
                 var markAcqDisp = document.createElement("p");
                 markAcqDisp.setAttribute("id","markAcqDisp");
                 stdQuestionDiv.appendChild(markAcqDisp);

                 //display the mark input box
                 var markAcqBox = document.createElement("input");
                 markAcqBox.setAttribute("id","markAcqBox");
                 markAcqBox.setAttribute("name","marksGiven");
                 markAcqBox.setAttribute("type","number");
                 if ((oneMarking[currentQuestionNum] != "") ||(oneMarking[currentQuestionNum] != "?"))
                    markAcqBox.setAttribute("value",oneMarking[currentQuestionNum]);
                 markAcqDisp.innerHTML = "This short question weights for " + examMarksAttainable[currentQuestionNum] +" marks, student's mark: ";
                 markAcqDisp.appendChild(markAcqBox);

            }
            break;
            case "FB":
            {
                 //correct answer location catched, now display the correct Answer
                 var correctAnswerDisp = document.createElement("p");
                 correctAnswerDisp.setAttribute("id","correctAnswerDisp");
                 correctAnswerDisp.innerHTML = "Correct Answer is: "+ examCorrectAnswers[currentQuestionNum];
                 stdQuestionDiv.appendChild(correctAnswerDisp);
 
                  //display the marks input sections
                 var markAcqDisp = document.createElement("p");
                 markAcqDisp.setAttribute("id","markAcqDisp");
                 stdQuestionDiv.appendChild(markAcqDisp);

                 //display the mark input box
                 var markAcqBox = document.createElement("input");
                 markAcqBox.setAttribute("id","markAcqBox");
                 markAcqBox.setAttribute("name","marksGiven");
                 markAcqBox.setAttribute("type","number");
                 if ((oneMarking[currentQuestionNum] != "") ||(oneMarking[currentQuestionNum] != "?"))
                    markAcqBox.setAttribute("value",oneMarking[currentQuestionNum]);
                 markAcqDisp.innerHTML = "This fill in the blanks question weights for " + examMarksAttainable[currentQuestionNum] +" marks, student's mark: ";
                 markAcqDisp.appendChild(markAcqBox);
            }
            break;
        }

        //display four buttons: previous, next, finished and back
        var buttonsArray = document.createElement("p");
        buttonsArray.setAttribute("id","buttonsArray");
        buttonsArray.setAttribute("align","center");
        stdQuestionDiv.appendChild(buttonsArray);

        var previousBtn = document.createElement("input");
        previousBtn.setAttribute("type","button");
        previousBtn.setAttribute("id","previousBtn");
        previousBtn.setAttribute("name","previousBtn");
        previousBtn.setAttribute("onclick","onPreviousClicked();");
        previousBtn.setAttribute("value","Previous Question");
        if (currentQuestionNum <= 0)
            previousBtn.setAttribute("disabled","true");
        buttonsArray.appendChild(previousBtn);

        var nextBtn = document.createElement("input");
        nextBtn.setAttribute("type","button");
        nextBtn.setAttribute("id","nextBtn");
        nextBtn.setAttribute("name","nextBtn");
        nextBtn.setAttribute("onclick","onNextClicked();");
        nextBtn.setAttribute("value","Next Question");
        if (currentQuestionNum >= examQuestion.length - 1)
        {
            if (examQType[currentQuestionNum] == "MCQ")
                nextBtn.setAttribute("disabled","true");
            else
            {
                nextBtn.setAttribute("value","Save this question's mark");
                nextBtn.setAttribute("onclick", "saveCurrentScore("+index+");");
            }
                
        }
            
        buttonsArray.appendChild(nextBtn);

        var finishBtn = document.createElement("input");
        finishBtn.setAttribute("type","button");
        finishBtn.setAttribute("id","finishBtn");
        finishBtn.setAttribute("name","finishBtn");
        finishBtn.setAttribute("onclick","onFinish();");
        finishBtn.setAttribute("value","Submit marking for this student");
        buttonsArray.appendChild(finishBtn);

        var backBtn = document.createElement("input");
        backBtn.setAttribute("type","button");
        backBtn.setAttribute("id","backBtn");
        backBtn.setAttribute("name","backBtn");
        backBtn.setAttribute("onclick","onBackPressed();");
        backBtn.setAttribute("value","Return to exam detail");
        buttonsArray.appendChild(backBtn);
}

function saveCurrentScore(studentIndex)
{
    //for last question's marking use
    var studentMarkingList = marking[studentIndex];
    studentMarkingList = JSON.parse(studentMarkingList);
    studentMarkingList[studentMarkingList.length - 1] = parseInt(document.getElementById("markAcqBox").value);
    studentMarkingList = JSON.stringify(studentMarkingList);
    marking[studentIndex] = studentMarkingList;
}

function onFinish()
{
    var isValid = true;
    //get the student first
    var currentStudentID = document.getElementById("chooseStd").value;
    //get the index of student in the array
    var currentStudentIndex = 0;
    for (var i = 0; i < studentID.length; i++)
    {
        if (studentID[i] == currentStudentID)
        {
            currentStudentIndex = i;
            break;
        }
    }
    //do a loop to see all the questions of the student have been marked
    var currentStudentMarks = marking[currentStudentIndex];
    //try to store the 
    //alert(marking[currentStudentIndex]);
    for (var j = 0; j < currentStudentMarks.length; j++)
    {
        if ((currentStudentMarks[j] == "") || (currentStudentMarks[j] == "?") || (currentStudentMarks[j] == null))
        {
            isValid = false;
            alert("Marking is not completed");
            break;
        }
    }

    if (isValid)
    {
        //all questions saved, send ajax request to update the student's record
        //var JSONmarking = JSON.stringify(marking[currentStudentIndex]);
        //alert(JSONmarking);
        if (confirm("Are you sure to update?"))
        {
            var requestUpdate = new XMLHttpRequest();
            requestUpdate.open("POST","/eie4432/project/exam/updateResults.php");
            requestUpdate.setRequestHeader('content-type','application/x-www-form-urlencoded; charset=UTF-8');
            requestUpdate.onload = function()
            {
                //for debugging
                var response= requestUpdate.responseText;
                if (response == "Success")
                    alert("Update success!");
                else if (response == "No effect")
                {
                    alert("Seems there is no change to the record.");
                }
                else
                {
                    alert("Unable to update");
                }
        }
            //alert("marking = "+marking[currentStudentIndex]+"\n"+"examid = "+parseInt(document.getElementById("examidRef").innerHTML)+"\nstudentid = "+currentStudentID);
            requestUpdate.send("marking="+marking[currentStudentIndex]+"&examid="+parseInt(document.getElementById("examidRef").innerHTML)+"&studentid="+currentStudentID);
        }
        
    }




}

function onBackPressed()
{
    if (confirm("Are you sure to return to exam detail?"))
    {
        var leaveForm = document.createElement("form")
        leaveForm.setAttribute("action",'/eie4432/project/course/viewContent.php');
        leaveForm.setAttribute("method","post");
        document.body.appendChild(leaveForm);

        var examidSubmit = document.createElement("input");
        examidSubmit.setAttribute("type","hidden");
        examidSubmit.setAttribute("name","contentID");
        examidSubmit.setAttribute("value",document.getElementById("examidRef").innerHTML);
        leaveForm.appendChild(examidSubmit);

        leaveForm.submit();
    }
}