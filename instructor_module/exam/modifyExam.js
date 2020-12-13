var questions = [];
var questionType = [];
var answers = [];
var correctAnswers = [];
var marks_of_question = [];
var currentQuestionNum = 0;
var MCQ_currentNumAns = 0;
var questionCount = 0;
var isInit = true;

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
        //var examID = examData.examid;
        var exam_name = examData.exam_name;
        var startdate = examData.startdate;
        var full_duration = examData.duration;
        var questions_JSON = examData.questions; 
        //relevant subject is for reference.

        //separate start date into date and time
        startdate = startdate.split(" ");
        //separate duration to xxh xxm xxs
        full_duration = full_duration.split(";");
        //further split questions_JSON to arrays
        var questionArr = JSON.parse(questions_JSON);
        questions = questionArr[0];
        questionType = questionArr[1];
        answers = questionArr[2];
        correctAnswers = questionArr[3];
        marks_of_question = questionArr[4];
        questionCount = questions.length;

        //extraction completed, now display the data
        var loadingLabel = document.getElementById("loadingLabel");
        modifyContent.removeChild(loadingLabel);

        //form for submitting the exam information
        var examEditForm = document.createElement("form");
        examEditForm.setAttribute("id","examEditForm");
        examEditForm.setAttribute("name","examEditForm");
        examEditForm.setAttribute("method","post");
        examEditForm.setAttribute("action","submitModify.php");

        //add the current exam message
        var courseMessage = document.createElement("p");
        courseMessage.setAttribute("id","courseMessage");
        courseMessage.setAttribute("name","courseMessage");
        courseMessage.innerHTML = "You are currently editing exam \""+exam_name+"\".";
        examEditForm.appendChild(courseMessage);

        //Exam name change
        var examNameLabel = document.createElement("p");
        examNameLabel.setAttribute("id","examNameLabel");
        examNameLabel.setAttribute("name","examNameLabel");
        examNameLabel.innerHTML = "Exam name: ";
        examEditForm.appendChild(examNameLabel);
        //exam name input box
        var examNameInputBox = document.createElement("input");
        examNameInputBox.setAttribute("type","text");
        examNameInputBox.setAttribute("id","examNameInputBox");
        examNameInputBox.setAttribute("name","examNameInputBox");
        examNameInputBox.setAttribute("value",questions[currentQuestionNum]);
        examEditForm.appendChild(examNameInputBox);

        //date label
        var startDateLabel = document.createElement("p");
        startDateLabel.setAttribute("id","startDateLabel");
        startDateLabel.setAttribute("name","startDateLabel");
        startDateLabel.innerHTML = "Start date: ";
        examEditForm.appendChild(startDateLabel);
        //start date input box
        var startDateInputBox = document.createElement("input");
        startDateInputBox.setAttribute("id","startDateInputBox");
        startDateInputBox.setAttribute("name","startDateInputBox");
        startDateInputBox.setAttribute("type","date");
        startDateInputBox.setAttribute("value",startdate[0]);
        examEditForm.appendChild(startDateInputBox);

        //time label
        var startTimeLabel = document.createElement("p");
        startTimeLabel.setAttribute("id","startTimeLabel");
        startTimeLabel.setAttribute("name","startTimeLabel");
        startTimeLabel.innerHTML = "Start Time: ";
        examEditForm.appendChild(startTimeLabel);
        //time box
        var startTimeInputBox_Hr = document.createElement("input");
        startTimeInputBox_Hr.setAttribute("id","startTimeInputBox");
        startTimeInputBox_Hr.setAttribute("name","startTimeInputBox");
        startTimeInputBox_Hr.setAttribute("type","time");
        startTimeInputBox_Hr.setAttribute("value",startdate[1]);
        examEditForm.appendChild(startTimeInputBox_Hr);

        //separate the duration to hours, minutes
        var hours = full_duration[0];
        var temp = hours.indexOf("h");
        hours = hours.substring(0,temp);
        var minutes = full_duration[1];
        temp = minutes.indexOf("m");
        minutes = minutes.substring(0,temp);

        //create a label and two textboxes for hours and minutes
        //label
        var durationLabel = document.createElement("p");
        durationLabel.setAttribute("id","durationLabel");
        durationLabel.setAttribute("name","durationLabel");
        durationLabel.innerHTML = "Duration (hours, minutes): ";
        examEditForm.appendChild(durationLabel);
        var durationHours = document.createElement("input");
        durationHours.setAttribute("id","durationHours");
        durationHours.setAttribute("name","durationHours");
        durationHours.setAttribute("type","number");
        durationHours.setAttribute("value",hours);
        var durationMinutes = document.createElement("input");
        durationMinutes.setAttribute("id","durationMinutes");
        durationMinutes.setAttribute("name","durationMinutes");
        durationMinutes.setAttribute("type","number");
        durationMinutes.setAttribute("value",minutes);
        examEditForm.appendChild(durationHours);
        examEditForm.appendChild(durationMinutes);

        //add select question number droplist
        var questionNumberLabel = document.createElement("p");
        questionNumberLabel.setAttribute("id","questionNumberLabel");
        questionNumberLabel.innerHTML="Question Number: ";
        examEditForm.appendChild(questionNumberLabel);

        var questionNumberDroplist = document.createElement("select");
        questionNumberDroplist.setAttribute("id","questionNumberDroplist");
        questionNumberDroplist.setAttribute("onchange","onQuestionNumberSelected();");
        questionNumberLabel.appendChild(questionNumberDroplist);

        //Exam information finished, show the fields for questions
        var questionDiv = document.createElement("div");
        questionDiv.setAttribute("id","questionDiv");

        //add the input form to the interface
        modifyContent.appendChild(examEditForm);
        modifyContent.appendChild(questionDiv);
        
        isInit = false;
        
        //set up the droplist choices
        var opt = document.createElement("option");
        opt.setAttribute("value","Select...");
        opt.innerHTML = "Select...";
        questionNumberDroplist.appendChild(opt);

        for (var i = 0; i < questionCount; i++)
        {
            opt = document.createElement("option");
            opt.setAttribute("value",(i+1));
            opt.innerHTML = i+1;
            questionNumberDroplist.appendChild(opt);
        }

        //add back button and save changes button

    }
    request.send('contentID='+contentID);
    
}

function onQuestionNumberSelected()
{
    //var currentQuestionNum = 0;
    /*
        questions = questionArr[0];
        questionType = questionArr[1];
        answers = questionArr[2];
        correctAnswers = questionArr[3];
        marks_of_question = questionArr[4];
    */
    //set up questionDiv according to currentQuestionNum
    var questionNumber = document.getElementById("questionNumberDroplist").value;
    var questionDiv = document.getElementById("questionDiv");
    MCQ_currentNumAns = 0;
    //alert("You selected question #"+(questionNumber));
    //check the questionNumber first.
    if (questionNumber == "Select...")
    {
        //alert("Clear the HTML now");
        //clear the question Div.
        
        questionDiv.innerHTML = "";
    } else
    {
        //find out the questionType first , NOTE: question in array should -1!
        questionDiv.innerHTML = "";
        var questionNumberArr = questionNumber - 1;
        switch (questionType[questionNumberArr])
        {
            case "MCQ":
            {
                //alert("This is a MCQ");
                var questionTypeLbl = document.createElement("p");
                questionTypeLbl.setAttribute("id","questionTypeLbl");
                questionTypeLbl.innerHTML = "Question Type: ";
                questionDiv.appendChild(questionTypeLbl);

                var questionTypeBox = document.createElement("select");
                questionTypeBox.setAttribute("id","questionTypeBox");
                questionTypeBox.setAttribute("name","questionTypeBox");
                questionTypeBox.setAttribute("onchange","requestQTChange();");
                questionTypeLbl.appendChild(questionTypeBox);

                 //set up the droplist choices
                var opt = document.createElement("option");
                opt.setAttribute("value","Select...");
                opt.innerHTML = "Select...";
                questionTypeBox.appendChild(opt);

                opt = document.createElement("option");
                opt.setAttribute("value","MC Questions");
                opt.innerHTML = "MC Questions";
                questionTypeBox.appendChild(opt);

                opt = document.createElement("option");
                opt.setAttribute("value","Short Question");
                opt.innerHTML = "Short Question";
                questionTypeBox.appendChild(opt);

                opt = document.createElement("option");
                opt.setAttribute("value","Fill in the blanks");
                opt.innerHTML = "Fill in the blanks";
                questionTypeBox.appendChild(opt);

                questionTypeBox.value = "MC Questions";

                //display the question and corresponding buttons
                var questionDisp = document.createElement("p");
                questionDisp.setAttribute("id","questionDisp");
                questionDisp.innerHTML = "Question:  ";
                questionDiv.appendChild(questionDisp);

                
                var questionBox = document.createElement("input");
                questionBox.setAttribute("id","questionDisp");
                questionBox.setAttribute("name","questionDisp");
                questionBox.setAttribute("type","text");
                questionBox.setAttribute("value",questions[questionNumberArr]);
                questionDisp.appendChild(questionBox);

                var addAnswerBtn = document.createElement("button");
                addAnswerBtn.setAttribute("id","addAnswerBtn");
                addAnswerBtn.setAttribute("name","addAnswerBtn");
                addAnswerBtn.innerHTML="Add an answer";
                addAnswerBtn.setAttribute("onclick","onAddAnswerBtnClicked();");
                questionDisp.appendChild(addAnswerBtn);

                var deleteAnswerBtn = document.createElement("button");
                deleteAnswerBtn.setAttribute("id","deleteAnswerBtn");
                deleteAnswerBtn.setAttribute("name","deleteAnswerBtn");
                deleteAnswerBtn.innerHTML = "Delete an answer";
                deleteAnswerBtn.setAttribute("onclick","onRemoveAnswerBtnClicked()");
                questionDisp.appendChild(deleteAnswerBtn);

                //display the marks for the question
                var markDisp = document.createElement("p");
                markDisp.setAttribute("id","markDisp");
                markDisp.innerHTML = "Marks for this question: ";
                questionDiv.appendChild(markDisp);

                var markBox = document.createElement("input");
                markBox.setAttribute("id","markBox");
                markBox.setAttribute("name","markBox");
                markBox.setAttribute("type","number");
                markBox.setAttribute("value",marks_of_question[questionNumberArr]);
                markDisp.appendChild(markBox);

                //draw answers and correct answers checkboxes

                //since dealing with MC questions, acquire answers and correct answers
                var answerThisQuestion = answers[questionNumberArr];
                var correctAnsThisQuestion = correctAnswers[questionNumberArr];
                for (var qc = 0; qc < answerThisQuestion.length; qc++)
                {
                    var answerDisp = document.createElement("p");
                    answerDisp.setAttribute("id","answerDisp"+(qc+1));
                    answerDisp.innerHTML = "Answer #"+(qc+1)+": ";
                    questionDiv.appendChild(answerDisp);

                    var answerBox = document.createElement("input");
                    answerBox.setAttribute("type","text");
                    answerBox.setAttribute("id","answer"+(qc+1));
                    answerBox.setAttribute("name","answer"+(qc+1));
                    answerBox.setAttribute("value",answerThisQuestion[qc]);
                    answerDisp.appendChild(answerBox);
                    MCQ_currentNumAns++;

                    answerDisp.innerHTML += " Correct Answer? ";

                    var correctAnsBox = document.createElement("input");
                    correctAnsBox.setAttribute("type","checkbox");
                    correctAnsBox.setAttribute("id","correctAnsBox"+(qc+1));
                    if (correctAnsThisQuestion[qc] == 1)
                        correctAnsBox.checked = true;
                    answerDisp.appendChild(correctAnsBox);
                }
                //Three-button group
                var buttons = document.createElement("p");
                buttons.setAttribute('id','buttons');
                //Add a question button
                questionDiv.appendChild(buttons);
                var addQuestionBtn = document.createElement("button");
                addQuestionBtn.setAttribute("id","addQuestionBtn");
                addQuestionBtn.setAttribute("name","addQuestionBtn");
                addQuestionBtn.setAttribute("value","Add a question");
                addQuestionBtn.setAttribute("onclick","onAddQuestionBtnClicked();");
                addQuestionBtn.innerHTML="Add a question";
                buttons.appendChild(addQuestionBtn);

                //Delete this question button
                var deleteQuestionBtn = document.createElement("button");
                deleteQuestionBtn.setAttribute("id","deleteQuestionBtn");
                deleteQuestionBtn.setAttribute("name","deleteQuestionBtn");
                deleteQuestionBtn.setAttribute("value","Delete this question");
                deleteQuestionBtn.setAttribute("onclick","onDeleteQuestionBtnClicked();");
                deleteQuestionBtn.innerHTML = "Delete this question";
                buttons.appendChild(deleteQuestionBtn);

                var saveQuestionBtn = document.createElement("button");
                saveQuestionBtn.setAttribute("id","saveQuestionBtn");
                saveQuestionBtn.setAttribute("name","saveQuestionBtn");
                saveQuestionBtn.setAttribute("value","Save this question");
                saveQuestionBtn.setAttribute("onclick","onSaveQuestionBtnClicked();");
                saveQuestionBtn.innerHTML = "Save this question";
                buttons.appendChild(saveQuestionBtn);

            }
            break;
            case "SQ":
            {
                var questionTypeLbl = document.createElement("p");
                questionTypeLbl.setAttribute("id","questionTypeLbl");
                questionTypeLbl.innerHTML = "Question Type: ";
                questionDiv.appendChild(questionTypeLbl);

                var questionTypeBox = document.createElement("select");
                questionTypeBox.setAttribute("id","questionTypeBox");
                questionTypeBox.setAttribute("name","questionTypeBox");
                questionTypeBox.setAttribute("onchange","requestQTChange();");
                questionTypeLbl.appendChild(questionTypeBox);

                 //set up the droplist choices
                var opt = document.createElement("option");
                opt.setAttribute("value","Select...");
                opt.innerHTML = "Select...";
                questionTypeBox.appendChild(opt);

                opt = document.createElement("option");
                opt.setAttribute("value","MC Questions");
                opt.innerHTML = "MC Questions";
                questionTypeBox.appendChild(opt);

                opt = document.createElement("option");
                opt.setAttribute("value","Short Question");
                opt.innerHTML = "Short Question";
                questionTypeBox.appendChild(opt);

                opt = document.createElement("option");
                opt.setAttribute("value","Fill in the blanks");
                opt.innerHTML = "Fill in the blanks";
                questionTypeBox.appendChild(opt);

                questionTypeBox.value = "Short Question";

                //alert("This is a short question");
                var questionDisp = document.createElement("p");
                questionDisp.setAttribute("id","questionDisp");
                questionDisp.innerHTML = "Question: ";
                questionDiv.appendChild(questionDisp);

                var questionBox = document.createElement("input");
                questionBox.setAttribute("id","questionDisp");
                questionBox.setAttribute("name","questionDisp");
                questionBox.setAttribute("type","text");
                questionBox.setAttribute("value",questions[questionNumberArr]);
                questionDisp.appendChild(questionBox);

                //display the marks for the question
                var markDisp = document.createElement("p");
                markDisp.setAttribute("id","markDisp");
                markDisp.innerHTML = "Marks for this question: ";
                questionDisp.appendChild(markDisp);

                var markBox = document.createElement("input");
                markBox.setAttribute("id","markBox");
                markBox.setAttribute("name","markBox");
                markBox.setAttribute("type","number");
                markBox.setAttribute("value",marks_of_question[questionNumberArr]);
                markDisp.appendChild(markBox);

                var correctAnsThisQuestion = correctAnswers[questionNumberArr];
                var correctAnsLbl = document.createElement("p");
                correctAnsLbl.setAttribute("id","correctAnsLbl");
                correctAnsLbl.innerHTML="(Suggested) Answer: ";
                questionDiv.appendChild(correctAnsLbl);

                var correctAnsBox = document.createElement("input");
                correctAnsBox.setAttribute("id","correctAnsBox");
                correctAnsBox.setAttribute("name","correctAnsBox");
                correctAnsBox.setAttribute("type","text");
                correctAnsBox.setAttribute("value",correctAnsThisQuestion);
                correctAnsLbl.appendChild(correctAnsBox);

                //Three-button group
                var buttons = document.createElement("p");
                buttons.setAttribute('id','buttons');
                //Add a question button
                questionDiv.appendChild(buttons);
                var addQuestionBtn = document.createElement("button");
                addQuestionBtn.setAttribute("id","addQuestionBtn");
                addQuestionBtn.setAttribute("name","addQuestionBtn");
                addQuestionBtn.setAttribute("value","Add a question");
                addQuestionBtn.setAttribute("onclick","onAddQuestionBtnClicked();");
                addQuestionBtn.innerHTML="Add a question";
                buttons.appendChild(addQuestionBtn);

                //Delete this question button
                var deleteQuestionBtn = document.createElement("button");
                deleteQuestionBtn.setAttribute("id","deleteQuestionBtn");
                deleteQuestionBtn.setAttribute("name","deleteQuestionBtn");
                deleteQuestionBtn.setAttribute("value","Delete this question");
                deleteQuestionBtn.setAttribute("onclick","onDeleteQuestionBtnClicked();");
                deleteQuestionBtn.innerHTML = "Delete this question";
                buttons.appendChild(deleteQuestionBtn);

                var saveQuestionBtn = document.createElement("button");
                saveQuestionBtn.setAttribute("id","saveQuestionBtn");
                saveQuestionBtn.setAttribute("name","saveQuestionBtn");
                saveQuestionBtn.setAttribute("value","Save this question");
                saveQuestionBtn.setAttribute("onclick","onSaveQuestionBtnClicked();");
                saveQuestionBtn.innerHTML = "Save this question";
                buttons.appendChild(saveQuestionBtn);
            }
            break;
            case "FB":
            {
                //alert("This is a fill in a blank question");
                var questionTypeLbl = document.createElement("p");
                questionTypeLbl.setAttribute("id","questionTypeLbl");
                questionTypeLbl.innerHTML = "Question Type: ";
                questionDiv.appendChild(questionTypeLbl);

                var questionTypeBox = document.createElement("select");
                questionTypeBox.setAttribute("id","questionTypeBox");
                questionTypeBox.setAttribute("name","questionTypeBox");
                questionTypeBox.setAttribute("onchange","requestQTChange();");
                questionTypeLbl.appendChild(questionTypeBox);

                 //set up the droplist choices
                var opt = document.createElement("option");
                opt.setAttribute("value","Select...");
                opt.innerHTML = "Select...";
                questionTypeBox.appendChild(opt);

                opt = document.createElement("option");
                opt.setAttribute("value","MC Questions");
                opt.innerHTML = "MC Questions";
                questionTypeBox.appendChild(opt);

                opt = document.createElement("option");
                opt.setAttribute("value","Short Question");
                opt.innerHTML = "Short Question";
                questionTypeBox.appendChild(opt);

                opt = document.createElement("option");
                opt.setAttribute("value","Fill in the blanks");
                opt.innerHTML = "Fill in the blanks";
                questionTypeBox.appendChild(opt);

                questionTypeBox.value = "Fill in the blanks";

                var questionDisp = document.createElement("p");
                questionDisp.setAttribute("id","questionDisp");
                questionDisp.innerHTML = "Question:";
                questionDiv.appendChild(questionDisp);

                var questionBox = document.createElement("input");
                questionBox.setAttribute("id","questionDisp");
                questionBox.setAttribute("name","questionDisp");
                questionBox.setAttribute("type","text");
                questionBox.setAttribute("value",questions[questionNumberArr]);
                questionDisp.appendChild(questionBox);

                //display the marks for the question
                var markDisp = document.createElement("p");
                markDisp.setAttribute("id","markDisp");
                markDisp.innerHTML = "Marks for this question: ";
                questionDisp.appendChild(markDisp);

                var markBox = document.createElement("input");
                markBox.setAttribute("id","markBox");
                markBox.setAttribute("name","markBox");
                markBox.setAttribute("type","number");
                markBox.setAttribute("value",marks_of_question[questionNumberArr]);
                markDisp.appendChild(markBox);

                var correctAnsThisQuestion = correctAnswers[questionNumberArr];
                var correctAnsLbl = document.createElement("p");
                correctAnsLbl.setAttribute("id","correctAnsLbl");
                correctAnsLbl.innerHTML="Answer: ";
                questionDiv.appendChild(correctAnsLbl);

                var correctAnsBox = document.createElement("input");
                correctAnsBox.setAttribute("id","correctAnsBox");
                correctAnsBox.setAttribute("name","correctAnsBox");
                correctAnsBox.setAttribute("type","text");
                correctAnsBox.setAttribute("value",correctAnsThisQuestion);
                correctAnsLbl.appendChild(correctAnsBox);

                //Three-button group
                var buttons = document.createElement("p");
                buttons.setAttribute('id','buttons');
                //Add a question button
                questionDiv.appendChild(buttons);
                var addQuestionBtn = document.createElement("button");
                addQuestionBtn.setAttribute("id","addQuestionBtn");
                addQuestionBtn.setAttribute("name","addQuestionBtn");
                addQuestionBtn.setAttribute("value","Add a question");
                addQuestionBtn.setAttribute("onclick","onAddQuestionBtnClicked();");
                addQuestionBtn.innerHTML="Add a question";
                buttons.appendChild(addQuestionBtn);

                //Delete this question button
                var deleteQuestionBtn = document.createElement("button");
                deleteQuestionBtn.setAttribute("id","deleteQuestionBtn");
                deleteQuestionBtn.setAttribute("name","deleteQuestionBtn");
                deleteQuestionBtn.setAttribute("value","Delete this question");
                deleteQuestionBtn.setAttribute("onclick","onDeleteQuestionBtnClicked();");
                deleteQuestionBtn.innerHTML = "Delete this question";
                buttons.appendChild(deleteQuestionBtn);

                var saveQuestionBtn = document.createElement("button");
                saveQuestionBtn.setAttribute("id","saveQuestionBtn");
                saveQuestionBtn.setAttribute("name","saveQuestionBtn");
                saveQuestionBtn.setAttribute("value","Save this question");
                saveQuestionBtn.setAttribute("onclick","onSaveQuestionBtnClicked();");
                saveQuestionBtn.innerHTML = "Save this question";
                buttons.appendChild(saveQuestionBtn);
            }
            break;
        }
    }
}

function eraseQuestionAnswers(qDiv)
{
    qDiv.innerHTML = "";
}

function onAddQuestionBtnClicked()
{
    
}

function requestQTChange()
{
     var newQuestionType = document.getElementById("questionTypeBox").value;
     var oldQuestionType = document.getElementById("questionNumberDroplist").value - 1;
     oldQuestionType = questionType[oldQuestionType];
     switch (oldQuestionType)
     {
         case "MCQ":
             oldQuestionType = "MC Questions";
             break;
         case "SQ":
            oldQuestionType = "Short Question";
            break;
         case "FB":
             oldQuestionType = "Fill in the blanks";
             break;
     }
     if (newQuestionType != oldQuestionType)
     {
         document.getElementById("questionDiv").innerHTML = "";
         switch (newQuestionType)
         {
             case "MC Questions":
             {
                    MCQ_currentNumAns = 0;
                    var questionTypeLbl = document.createElement("p");
                    questionTypeLbl.setAttribute("id","questionTypeLbl");
                    questionTypeLbl.innerHTML = "Question Type: ";
                    questionDiv.appendChild(questionTypeLbl);

                    var questionTypeBox = document.createElement("select");
                    questionTypeBox.setAttribute("id","questionTypeBox");
                    questionTypeBox.setAttribute("name","questionTypeBox");
                    questionTypeBox.setAttribute("onchange","requestQTChange();");
                    questionTypeLbl.appendChild(questionTypeBox);

                    //set up the droplist choices
                    var opt = document.createElement("option");
                    opt.setAttribute("value","Select...");
                    opt.innerHTML = "Select...";
                    questionTypeBox.appendChild(opt);

                    opt = document.createElement("option");
                    opt.setAttribute("value","MC Questions");
                    opt.innerHTML = "MC Questions";
                    questionTypeBox.appendChild(opt);

                    opt = document.createElement("option");
                    opt.setAttribute("value","Short Question");
                    opt.innerHTML = "Short Question";
                    questionTypeBox.appendChild(opt);

                    opt = document.createElement("option");
                    opt.setAttribute("value","Fill in the blanks");
                    opt.innerHTML = "Fill in the blanks";
                    questionTypeBox.appendChild(opt);

                    questionTypeBox.value = "MC Questions";

                    //display the question and corresponding buttons
                    var questionDisp = document.createElement("p");
                    questionDisp.setAttribute("id","questionDisp");
                    questionDisp.innerHTML = "Question:  ";
                    questionDiv.appendChild(questionDisp);

                    var questionBox = document.createElement("input");
                    questionBox.setAttribute("id","questionDisp");
                    questionBox.setAttribute("name","questionDisp");
                    questionBox.setAttribute("type","text");
                    questionBox.setAttribute("value","");
                    questionDisp.appendChild(questionBox);

                    var addAnswerBtn = document.createElement("button");
                    addAnswerBtn.setAttribute("id","addAnswerBtn");
                    addAnswerBtn.setAttribute("name","addAnswerBtn");
                    addAnswerBtn.innerHTML="Add an answer";
                    addAnswerBtn.setAttribute("onclick","onAddAnswerBtnClicked();");
                    questionDisp.appendChild(addAnswerBtn);

                    var deleteAnswerBtn = document.createElement("button");
                    deleteAnswerBtn.setAttribute("id","deleteAnswerBtn");
                    deleteAnswerBtn.setAttribute("name","deleteAnswerBtn");
                    deleteAnswerBtn.innerHTML = "Delete an answer";
                    deleteAnswerBtn.setAttribute("onclick","onRemoveAnswerBtnClicked()");
                    questionDisp.appendChild(deleteAnswerBtn);

                    //display the marks for the question
                    var markDisp = document.createElement("p");
                    markDisp.setAttribute("id","markDisp");
                    markDisp.innerHTML = "Marks for this question: ";
                    questionDiv.appendChild(markDisp);

                    var markBox = document.createElement("input");
                    markBox.setAttribute("id","markBox");
                    markBox.setAttribute("name","markBox");
                    markBox.setAttribute("type","number");
                    markBox.setAttribute("value","");
                    markDisp.appendChild(markBox);

                    //draw answers and correct answers checkboxes
                    //MCQ_currentNumAns = 0;
                    var answerDisp = document.createElement("p");
                    answerDisp.setAttribute("id","answerDisp"+(MCQ_currentNumAns+1));
                    answerDisp.innerHTML = "Answer #"+(MCQ_currentNumAns+1)+": ";
                    questionDiv.appendChild(answerDisp);

                    var answerBox = document.createElement("input");
                    answerBox.setAttribute("type","text");
                    answerBox.setAttribute("id","answer"+(MCQ_currentNumAns+1));
                    answerBox.setAttribute("name","answer"+(MCQ_currentNumAns+1));
                    answerBox.setAttribute("value","");
                    answerDisp.appendChild(answerBox);

                    answerDisp.innerHTML += " Correct Answer? ";

                    var correctAnsBox = document.createElement("input");
                    correctAnsBox.setAttribute("type","checkbox");
                    correctAnsBox.setAttribute("id","correctAnsBox"+(MCQ_currentNumAns+1));
                    answerDisp.appendChild(correctAnsBox);
                    MCQ_currentNumAns++;

                    var answerDisp = document.createElement("p");
                    answerDisp.setAttribute("id","answerDisp"+(MCQ_currentNumAns+1));
                    answerDisp.innerHTML = "Answer #"+(MCQ_currentNumAns+1)+": ";
                    questionDiv.appendChild(answerDisp);

                    var answerBox = document.createElement("input");
                    answerBox.setAttribute("type","text");
                    answerBox.setAttribute("id","answer"+(MCQ_currentNumAns+1));
                    answerBox.setAttribute("name","answer"+(MCQ_currentNumAns+1));
                    answerBox.setAttribute("value","");
                    answerDisp.appendChild(answerBox);

                    answerDisp.innerHTML += " Correct Answer? ";

                    var correctAnsBox = document.createElement("input");
                    correctAnsBox.setAttribute("type","checkbox");
                    correctAnsBox.setAttribute("id","correctAnsBox"+(MCQ_currentNumAns+1));
                    answerDisp.appendChild(correctAnsBox);

                    //Three-button group
                    var buttons = document.createElement("p");
                    buttons.setAttribute('id','buttons');
                    //Add a question button
                    questionDiv.appendChild(buttons);
                    var addQuestionBtn = document.createElement("button");
                    addQuestionBtn.setAttribute("id","addQuestionBtn");
                    addQuestionBtn.setAttribute("name","addQuestionBtn");
                    addQuestionBtn.setAttribute("value","Add a question");
                    addQuestionBtn.setAttribute("onclick","onAddQuestionBtnClicked();");
                    addQuestionBtn.innerHTML="Add a question";
                    buttons.appendChild(addQuestionBtn);

                    //Delete this question button
                    var deleteQuestionBtn = document.createElement("button");
                    deleteQuestionBtn.setAttribute("id","deleteQuestionBtn");
                    deleteQuestionBtn.setAttribute("name","deleteQuestionBtn");
                    deleteQuestionBtn.setAttribute("value","Delete this question");
                    deleteQuestionBtn.setAttribute("onclick","onDeleteQuestionBtnClicked();");
                    deleteQuestionBtn.innerHTML = "Delete this question";
                    buttons.appendChild(deleteQuestionBtn);

                    var saveQuestionBtn = document.createElement("button");
                    saveQuestionBtn.setAttribute("id","saveQuestionBtn");
                    saveQuestionBtn.setAttribute("name","saveQuestionBtn");
                    saveQuestionBtn.setAttribute("value","Save this question");
                    saveQuestionBtn.setAttribute("onclick","onSaveQuestionBtnClicked();");
                    saveQuestionBtn.innerHTML = "Save this question";
                    buttons.appendChild(saveQuestionBtn);
             }
             break;
             case "Short Question":
             {
                var questionTypeLbl = document.createElement("p");
                questionTypeLbl.setAttribute("id","questionTypeLbl");
                questionTypeLbl.innerHTML = "Question Type: ";
                questionDiv.appendChild(questionTypeLbl);

                var questionTypeBox = document.createElement("select");
                questionTypeBox.setAttribute("id","questionTypeBox");
                questionTypeBox.setAttribute("name","questionTypeBox");
                questionTypeBox.setAttribute("onchange","requestQTChange();");
                questionTypeLbl.appendChild(questionTypeBox);

                 //set up the droplist choices
                var opt = document.createElement("option");
                opt.setAttribute("value","Select...");
                opt.innerHTML = "Select...";
                questionTypeBox.appendChild(opt);

                opt = document.createElement("option");
                opt.setAttribute("value","MC Questions");
                opt.innerHTML = "MC Questions";
                questionTypeBox.appendChild(opt);

                opt = document.createElement("option");
                opt.setAttribute("value","Short Question");
                opt.innerHTML = "Short Question";
                questionTypeBox.appendChild(opt);

                opt = document.createElement("option");
                opt.setAttribute("value","Fill in the blanks");
                opt.innerHTML = "Fill in the blanks";
                questionTypeBox.appendChild(opt);

                questionTypeBox.value = "Short Question";

                //alert("This is a short question");
                var questionDisp = document.createElement("p");
                questionDisp.setAttribute("id","questionDisp");
                questionDisp.innerHTML = "Question: ";
                questionDiv.appendChild(questionDisp);

                var questionBox = document.createElement("input");
                questionBox.setAttribute("id","questionDisp");
                questionBox.setAttribute("name","questionDisp");
                questionBox.setAttribute("type","text");
                questionBox.setAttribute("value","");
                questionDisp.appendChild(questionBox);

                //display the marks for the question
                var markDisp = document.createElement("p");
                markDisp.setAttribute("id","markDisp");
                markDisp.innerHTML = "Marks for this question: ";
                questionDisp.appendChild(markDisp);

                var markBox = document.createElement("input");
                markBox.setAttribute("id","markBox");
                markBox.setAttribute("name","markBox");
                markBox.setAttribute("type","number");
                markBox.setAttribute("value","");
                markDisp.appendChild(markBox);

                var correctAnsLbl = document.createElement("p");
                correctAnsLbl.setAttribute("id","correctAnsLbl");
                correctAnsLbl.innerHTML="(Suggested) Answer: ";
                questionDiv.appendChild(correctAnsLbl);

                var correctAnsBox = document.createElement("input");
                correctAnsBox.setAttribute("id","correctAnsBox");
                correctAnsBox.setAttribute("name","correctAnsBox");
                correctAnsBox.setAttribute("type","text");
                correctAnsBox.setAttribute("value","");
                correctAnsLbl.appendChild(correctAnsBox);

                //Three-button group
                var buttons = document.createElement("p");
                buttons.setAttribute('id','buttons');
                //Add a question button
                questionDiv.appendChild(buttons);
                var addQuestionBtn = document.createElement("button");
                addQuestionBtn.setAttribute("id","addQuestionBtn");
                addQuestionBtn.setAttribute("name","addQuestionBtn");
                addQuestionBtn.setAttribute("value","Add a question");
                addQuestionBtn.setAttribute("onclick","onAddQuestionBtnClicked();");
                addQuestionBtn.innerHTML="Add a question";
                buttons.appendChild(addQuestionBtn);

                //Delete this question button
                var deleteQuestionBtn = document.createElement("button");
                deleteQuestionBtn.setAttribute("id","deleteQuestionBtn");
                deleteQuestionBtn.setAttribute("name","deleteQuestionBtn");
                deleteQuestionBtn.setAttribute("value","Delete this question");
                deleteQuestionBtn.setAttribute("onclick","onDeleteQuestionBtnClicked();");
                deleteQuestionBtn.innerHTML = "Delete this question";
                buttons.appendChild(deleteQuestionBtn);

                var saveQuestionBtn = document.createElement("button");
                saveQuestionBtn.setAttribute("id","saveQuestionBtn");
                saveQuestionBtn.setAttribute("name","saveQuestionBtn");
                saveQuestionBtn.setAttribute("value","Save this question");
                saveQuestionBtn.setAttribute("onclick","onSaveQuestionBtnClicked();");
                saveQuestionBtn.innerHTML = "Save this question";
                buttons.appendChild(saveQuestionBtn);
             }
             break;
             case "Fill in the blanks":
             {
                var questionTypeLbl = document.createElement("p");
                questionTypeLbl.setAttribute("id","questionTypeLbl");
                questionTypeLbl.innerHTML = "Question Type: ";
                questionDiv.appendChild(questionTypeLbl);

                var questionTypeBox = document.createElement("select");
                questionTypeBox.setAttribute("id","questionTypeBox");
                questionTypeBox.setAttribute("name","questionTypeBox");
                questionTypeBox.setAttribute("onchange","requestQTChange();");
                questionTypeLbl.appendChild(questionTypeBox);

                 //set up the droplist choices
                var opt = document.createElement("option");
                opt.setAttribute("value","Select...");
                opt.innerHTML = "Select...";
                questionTypeBox.appendChild(opt);

                opt = document.createElement("option");
                opt.setAttribute("value","MC Questions");
                opt.innerHTML = "MC Questions";
                questionTypeBox.appendChild(opt);

                opt = document.createElement("option");
                opt.setAttribute("value","Short Question");
                opt.innerHTML = "Short Question";
                questionTypeBox.appendChild(opt);

                opt = document.createElement("option");
                opt.setAttribute("value","Fill in the blanks");
                opt.innerHTML = "Fill in the blanks";
                questionTypeBox.appendChild(opt);

                questionTypeBox.value = "Fill in the blanks";

                var questionDisp = document.createElement("p");
                questionDisp.setAttribute("id","questionDisp");
                questionDisp.innerHTML = "Question:";
                questionDiv.appendChild(questionDisp);

                var questionBox = document.createElement("input");
                questionBox.setAttribute("id","questionDisp");
                questionBox.setAttribute("name","questionDisp");
                questionBox.setAttribute("type","text");
                questionBox.setAttribute("value","");
                questionDisp.appendChild(questionBox);

                //display the marks for the question
                var markDisp = document.createElement("p");
                markDisp.setAttribute("id","markDisp");
                markDisp.innerHTML = "Marks for this question: ";
                questionDisp.appendChild(markDisp);

                var markBox = document.createElement("input");
                markBox.setAttribute("id","markBox");
                markBox.setAttribute("name","markBox");
                markBox.setAttribute("type","number");
                markBox.setAttribute("value","");
                markDisp.appendChild(markBox);

                var correctAnsLbl = document.createElement("p");
                correctAnsLbl.setAttribute("id","correctAnsLbl");
                correctAnsLbl.innerHTML="Answer: ";
                questionDiv.appendChild(correctAnsLbl);

                var correctAnsBox = document.createElement("input");
                correctAnsBox.setAttribute("id","correctAnsBox");
                correctAnsBox.setAttribute("name","correctAnsBox");
                correctAnsBox.setAttribute("type","text");
                correctAnsBox.setAttribute("value","");
                correctAnsLbl.appendChild(correctAnsBox);

                //Three-button group
                var buttons = document.createElement("p");
                buttons.setAttribute('id','buttons');
                //Add a question button
                questionDiv.appendChild(buttons);
                var addQuestionBtn = document.createElement("button");
                addQuestionBtn.setAttribute("id","addQuestionBtn");
                addQuestionBtn.setAttribute("name","addQuestionBtn");
                addQuestionBtn.setAttribute("value","Add a question");
                addQuestionBtn.setAttribute("onclick","onAddQuestionBtnClicked();");
                addQuestionBtn.innerHTML="Add a question";
                buttons.appendChild(addQuestionBtn);

                //Delete this question button
                var deleteQuestionBtn = document.createElement("button");
                deleteQuestionBtn.setAttribute("id","deleteQuestionBtn");
                deleteQuestionBtn.setAttribute("name","deleteQuestionBtn");
                deleteQuestionBtn.setAttribute("value","Delete this question");
                deleteQuestionBtn.setAttribute("onclick","onDeleteQuestionBtnClicked();");
                deleteQuestionBtn.innerHTML = "Delete this question";
                buttons.appendChild(deleteQuestionBtn);

                var saveQuestionBtn = document.createElement("button");
                saveQuestionBtn.setAttribute("id","saveQuestionBtn");
                saveQuestionBtn.setAttribute("name","saveQuestionBtn");
                saveQuestionBtn.setAttribute("value","Save this question");
                saveQuestionBtn.setAttribute("onclick","onSaveQuestionBtnClicked();");
                saveQuestionBtn.innerHTML = "Save this question";
                buttons.appendChild(saveQuestionBtn);
             }
             break;
         }
     }
}


function onDeleteQuestionBtnClicked()
{
    alert("Under Construction!");
}

function onSaveQuestionBtnClicked()
{

}

function onAddAnswerBtnClicked()
{
    alert("Under Construction!");
}

function onRemoveAnswerBtnClicked()
{
    alert("Under construction");
}

function onSaveButtonClicked()
{
    alert("Under construction");
}

function onSaveChangeButtonClicked()
{

}