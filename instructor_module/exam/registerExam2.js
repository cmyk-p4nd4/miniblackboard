//For registerExam.php
var question = [];
var questionType = [];
//questionType: MCQ, SQ, FB
var answers = [];
var correctAnswer=[]; //0 or 1. 0 = incorrect, 1 = correct
var marksOfQuestion=[];
var currentQuestionNum = 1;
var nthAns = 0;
var rowNum = 0;
var currentType = null;
function init()
{
	//at the beginning, disable the previous question button.
	document.getElementById("prev").disabled = true;
	document.getElementById("questionNumber").innerHTML= "Question #" + currentQuestionNum;
}

function onAddAnswer()
{
	var removeBtn = document.getElementById("deleteansbtn");
	//enable the removeBtn.
	removeBtn.disabled = false;
	var questionDiv = document.getElementById("question");
	var questionTable = document.getElementById("questionTable");
	rowNum++;
	var row = questionTable.insertRow(rowNum);
	var cell = row.insertCell(0);
	nthAns++;
	var content = "<p>Answer"+" "+nthAns+":  <input type='text' id='Ans"+
			nthAns+"' name=''Ans"+ nthAns+"'>" + " <input type='checkbox' id='correctbox"+nthAns +"' name='correctbox"+nthAns+"'>"+
			"<label for='correctbox"+nthAns+"'>Correct Answer?</label>"+"</p>";
	cell.innerHTML = content;
}

function onRemoveAnswer()
{
	var removeBtn = document.getElementById("deleteansbtn");
	var questionDiv = document.getElementById("question");
	var questionTable = document.getElementById("questionTable");
	questionTable.deleteRow(rowNum);
	rowNum--;
	nthAns--;
	if (nthAns <= 2)
		//disable the removeBtn if there are only 2 or less answers.
		removeBtn.disabled = true;
}

function checkQuestionValid()
{
	//get question type
	var questiontype = document.getElementById("questiontype").value;
	var isvalid = true;
	switch (questiontype)
	{
		case "MC Questions":
		{
			//get question
			var givenQuestion = document.getElementById("inquestion").value;
			var errorText = "The following fields has error: \n";
			if (givenQuestion.length == 0)
			{
				isvalid = false;
				errorText += "Question\n";
			}	
			var givenAnswer = [];
			var givenCorrectAnswer = [];//0 = incorrect, 1 = correct
			var hasCorrectAns = false; //at least one correct answer detected? 
			//get answers and correct answers
			for (var i = 1; i<= nthAns; i++)
			{
				var obtainedAns = document.getElementById("Ans"+i).value;
				if (obtainedAns.length == 0)
				{
					isvalid = false;
					errorText += "Answer "+i+"\n";
				}
				else
				{
					givenAnswer.push(document.getElementById("Ans"+i).value);
				}
				if (document.getElementById("correctbox"+i).checked == true)
				{
					givenCorrectAnswer.push(1);
					hasCorrectAns = true;
				}
				else
				{
					givenCorrectAnswer.push(0);
				}
			}
			if (!hasCorrectAns)
			{
				isvalid = false;
				errorText += "No correct answer was given\n";
			}

			//detect marks for this question
			var marksGiven = Number(document.getElementById('marks').value);
			if (isNaN(marksGiven))
			{
				isvalid = false;
				errorText += "The given marks is not a number!\n";
			}
			else
			{
				if (marksGiven == "")
				{
					isvalid = false;
					errorText += "Marks given is empty!\n";
				}
				else if (marksGiven < 0)
				{
					isvalid = false;
					errorText += "Marks should be at least 0!\n";
				}
			}


			if (!isvalid)
			{
				alert(errorText);
			}
			else
			{
				//if valid, put into the record array
				question[currentQuestionNum-1] = givenQuestion;
				answers[currentQuestionNum-1] = givenAnswer;
				correctAnswer[currentQuestionNum-1] = givenCorrectAnswer;
				questionType[currentQuestionNum-1] = "MCQ";
				marksOfQuestion[currentQuestionNum - 1] = marksGiven;
			}
		}
		break;
		case "Short Questions":
		{
			var errorText = "The following item are empty: \n";
			var inquestion = document.getElementById("inquestion").value;
			var textAns = document.getElementById("textAns").value;
			if (inquestion.length == 0)
			{
				isvalid = false;
				errorText += "question\n";
			}
			if (textAns.length == 0)
			{
				isvalid = false;
				errorText += "answer\n";
			}

			//detect marks for this question
			var marksGiven = Number(document.getElementById('marks').value);
			if (isNaN(marksGiven))
			{
				isvalid = false;
				errorText += "The given marks is not a number!\n";
			}
			else
			{
				if (marksGiven == "")
				{
					isvalid = false;
					errorText += "Marks given is empty!\n";
				}
				else if (marksGiven < 0)
				{
					isvalid = false;
					errorText += "Marks should be at least 0!\n";
				}
			}

			if (!isvalid)
				alert(errorText);
			else
			{
				question[currentQuestionNum-1] = inquestion;
				var dummyAnswer = "SQ";
				answers[currentQuestionNum-1] = dummyAnswer;
				correctAnswer[currentQuestionNum-1] = textAns;
				questionType[currentQuestionNum-1] = dummyAnswer;
				marksOfQuestion[currentQuestionNum - 1] = marksGiven;
			}
		}
		break;
		case "Fill in the blanks":
		{
			var errorText = "The following item are empty: \n";
			var inquestion = document.getElementById("inquestion").value;
			var textAns = document.getElementById("textAns").value;
			if (inquestion.length == 0)
			{
				isvalid = false;
				errorText += "question\n";
			}
			if (textAns.length == 0)
			{
				isvalid = false;
				errorText += "answer\n";
			}
			//detect marks for this question
			var marksGiven = Number(document.getElementById('marks').value);
			if (isNaN(marksGiven))
			{
				isvalid = false;
				errorText += "marks is not a number\n";
			}
			else
			{
				if (marksGiven == "")
				{
					isvalid = false;
					errorText += "Marks given\n";
				}
				else if (marksGiven < 0)
				{
					isvalid = false;
					errorText += "Marks should be at least 0\n";
				}
			}
			if (!isvalid)
				alert(errorText);
			else
			{
				question[currentQuestionNum-1] = inquestion;
				var dummyAnswer = "FB";
				answers[currentQuestionNum-1] = dummyAnswer;
				correctAnswer[currentQuestionNum-1] = textAns;
				questionType[currentQuestionNum-1] = "FB";
				marksOfQuestion[currentQuestionNum - 1] = marksGiven;
			}
		}
		break;
		default:
		{
			//just for safety issues.
			alert("You should select a question type first!");
			isvalid = false;
		}
		break;
	}
	
	return isvalid;
}

function onNextQuestionClicked()
{
	var questionDiv = document.getElementById("question");
	var previousQuestionBtn = document.getElementById("prev");
	if (checkQuestionValid(currentType))
	{
		//user's inputs are valid
		currentQuestionNum++;
		//check if "currentQuestionNum" th element already exist
		if ((typeof(question[currentQuestionNum - 1]) == "undefined") || (question[currentQuestionNum - 1] == null))
		{
			//not exist
			//toggle the previous question button.
			if (currentQuestionNum > 1)
			{
				previousQuestionBtn.disabled = false;	
			}
			else
			{
				previousQuestionBtn.disabled = true;
			}
			//delete the question table
			nthAns = 0;
			rowNum = 0;
			document.getElementById("questionTable").remove();
			document.getElementById("questiontype").value = "Select....";
			document.getElementById("questionNumber").innerHTML = "Question #"+currentQuestionNum;
		}
		else
		{
			//exists
			//retrieve the question
			var questionDiv = document.getElementById("question");
			if (currentQuestionNum > 1)
				previousQuestionBtn.disabled = false;
			else
				previousQuestionBtn.disabled = true;

			var questionTable = document.getElementById("questionTable");
			if (!(typeof(questionTable) == "undefined" || questionTable == null))
			{
				//questionTable exists, delete it first
				//questionDiv.removeChild("questionTable");
				questionTable.remove();
			}
			//recreate the questionTable according to question type.
			nthAns = 0;
			rowNum = 0;
			var questionTable = document.createElement("table");
			questionTable.setAttribute('id','questionTable');

			switch(questionType[currentQuestionNum - 1])
			{
				case "MCQ":
				{
					document.getElementById("questiontype").value = "MC Questions";
			
					//retrieve previous question.
					var answerList = answers[currentQuestionNum-1];
					var correctAnswerList = correctAnswer[currentQuestionNum-1];
					var currentQuestion = question[currentQuestionNum-1];

					var testString = "Question: "+currentQuestion+"\n" + "answers: "+answerList+"\ncorrect answers: "+correctAnswerList+"\n";
					//insert the question row
					var row = questionTable.insertRow(rowNum);
					//questioninput
					var cell = row.insertCell(0);
					var content = "<p>Question: <input type='text' id='inquestion' name='inquestion'>"+
					"  <input type='button' id='addansbtn' name='addansbtn' onclick='onAddAnswer();' value='Add an answer' />  <input type='button' id='deleteansbtn' onclick='onRemoveAnswer();' value='Remove an answer' disabled='true'> "+
					"Marks for this question: <input type='number' id='marks' name='marks'>"
					+"</p>";
					cell.innerHTML = content;
					
					//document.getElementById("inquestion").value = currentQuestion;
					
					//see if need to enable the remove answer button
					
					//create answer fields and fill in the fields
					for (var i = 0; i < answerList.length; i++)
					{
						rowNum++;
						row = questionTable.insertRow(rowNum);
						var cell = row.insertCell(0);
						nthAns = i + 1;
						var content = "<p>Answer"+" "+nthAns+":  <input type='text' id='Ans"+
						nthAns+"' name=''Ans"+ nthAns+"'>" + " <input type='checkbox' id='correctbox"+nthAns +"' name='correctbox"+nthAns+"'>"+
						"<label for='correctbox"+nthAns+"'>Correct Answer?</label>"+"</p>";
						cell.innerHTML = content;
					}
					
					questionDiv.appendChild(questionTable);
					document.getElementById("inquestion").value = currentQuestion;
					for (var i = 0; i < answerList.length; i++)
					{
						if (correctAnswerList[i] == 1)
							document.getElementById("correctbox"+(i+1)).checked = true;
						else 
							document.getElementById("correctbox"+(i+1)).checked = false;

						document.getElementById("Ans"+(i+1)).value = answerList[i];
					}
					if (answerList.length > 2)
						document.getElementById("deleteansbtn").disabled = false;
					else 
						document.getElementById("deleteansbtn").disabled = true;
					currentType = "MC Questions";
				}
				break;
				case "SQ":
				{
					document.getElementById("questiontype").value = "Short Questions";
					//retrieve previous question.
					var answerList = answers[currentQuestionNum-1];
					var correctAnswerList = correctAnswer[currentQuestionNum-1];
					var currentQuestion = question[currentQuestionNum-1];
					var row = questionTable.insertRow(rowNum);
					//questioninput
					var cell = row.insertCell(0);
					var content = "<p>Question: <input type='text' id='inquestion' name='inquestion' size='60' height = '30'>"+
					"Marks for this question: <input type='number' id='marks' name='marks'></p>";
					cell.innerHTML = content;
					
					rowNum++;
					row = questionTable.insertRow(rowNum);
					var cell = row.insertCell(0);
					nthAns++;
					var content = "<p> (Suggested) Answer: <input type='text' id='textAns' name='textAns' size='60' height ='30'></p>";
					cell.innerHTML = content;
					
					questionDiv.appendChild(questionTable);
					document.getElementById("inquestion").value = currentQuestion;
					document.getElementById("textAns").value = correctAnswerList;
					//finished
					currentType = "Short Questions";
				}
				break;
				case "FB":
				{
					document.getElementById("questiontype").value = "Fill in the blanks";
					//retrieve previous question.
					var answerList = answers[currentQuestionNum-1];
					var correctAnswerList = correctAnswer[currentQuestionNum-1];
					var currentQuestion = question[currentQuestionNum-1];

					var row = questionTable.insertRow(rowNum);
					//questioninput
					var cell = row.insertCell(0);
					var content = "<p>Question: <input type='text' id='inquestion' name='inquestion' size='60'>"+
					"Marks for this question: <input type='number' id='marks' name='marks'></p>";
					cell.innerHTML = content;
					
					//Row 2
					rowNum++;
					row = questionTable.insertRow(rowNum);
					var cell = row.insertCell(0);
					nthAns++;
					var content = "<p>Answer: <input type='text' id='textAns' name='textAns' size='60'></p>";
					cell.innerHTML = content;

					questionDiv.appendChild(questionTable);
					document.getElementById("inquestion").value = currentQuestion;
					document.getElementById("textAns").value = correctAnswerList;

					//finished
					currentType = "Fill in the blanks";
				}
				break;
			}
			document.getElementById("questionNumber").innerHTML = "Question #"+currentQuestionNum;
		}
	}
	//if not valid, do nothing

}

function onPrevQuestionClicked()
{
	var questionDiv = document.getElementById("question");
	currentQuestionNum--;
	//toggle the previous question button.
	var previousQuestionBtn = document.getElementById("prev");
	if (currentQuestionNum > 1)
		previousQuestionBtn.disabled = false;
	else
		previousQuestionBtn.disabled = true;

	
	//check if questionTable exists
	var questionTable = document.getElementById("questionTable");
	if (!(typeof(questionTable) == "undefined" || questionTable == null))
	{
		//questionTable exists, delete it first
		//questionDiv.removeChild("questionTable");
		questionTable.remove();
	}

	//recreate the questionTable according to question type.
	nthAns = 0;
	rowNum = 0;
	var questionTable = document.createElement("table");
	questionTable.setAttribute('id','questionTable');
	switch (questionType[currentQuestionNum-1])
	{
		//redisplay the previous question
		case "MCQ":
		{
			document.getElementById("questiontype").value = "MC Questions";
			
			//retrieve previous question.
			var answerList = answers[currentQuestionNum-1];
			var correctAnswerList = correctAnswer[currentQuestionNum-1];
			var currentQuestion = question[currentQuestionNum-1];
			var currentMarks = marksOfQuestion[currentQuestionNum-1];
			var testString = "Question: "+currentQuestion+"\n" + "answers: "+answerList+"\ncorrect answers: "+correctAnswerList+"\n";
			//insert the question row
			var row = questionTable.insertRow(rowNum);
			//questioninput
			var cell = row.insertCell(0);
			var content = "<p>Question: <input type='text' id='inquestion' name='inquestion'>"+
			"  <input type='button' id='addansbtn' name='addansbtn' onclick='onAddAnswer();' value='Add an answer' />  <input type='button' id='deleteansbtn' onclick='onRemoveAnswer();' value='Remove an answer' disabled='true'> "
			+"Marks for this question: <input type='number' id='marks' name='marks' value='"+currentMarks+"'>"
			+"</p>";
			cell.innerHTML = content;
			
			//document.getElementById("inquestion").value = currentQuestion;
			
			//see if need to enable the remove answer button
			
			//create answer fields and fill in the fields
			for (var i = 0; i < answerList.length; i++)
			{
				rowNum++;
				row = questionTable.insertRow(rowNum);
				var cell = row.insertCell(0);
				nthAns = i + 1;
				var content = "<p>Answer"+" "+nthAns+":  <input type='text' id='Ans"+
				nthAns+"' name=''Ans"+ nthAns+"'>" + " <input type='checkbox' id='correctbox"+nthAns +"' name='correctbox"+nthAns+"'>"+
				"<label for='correctbox"+nthAns+"'>Correct Answer?</label>"+"</p>";
				cell.innerHTML = content;
			}
			
			questionDiv.appendChild(questionTable);
			document.getElementById("inquestion").value = currentQuestion;
			for (var i = 0; i < answerList.length; i++)
			{
				if (correctAnswerList[i] == 1)
					document.getElementById("correctbox"+(i+1)).checked = true;
				else 
					document.getElementById("correctbox"+(i+1)).checked = false;

				document.getElementById("Ans"+(i+1)).value = answerList[i];
			}
			if (answerList.length > 2)
				document.getElementById("deleteansbtn").disabled = false;
			else 
				document.getElementById("deleteansbtn").disabled = true;
			currentType = "MC Questions";
		}
		break;
		case "SQ":
		{
			document.getElementById("questiontype").value = "Short Questions";
			
			
			//retrieve previous question.
			var answerList = answers[currentQuestionNum-1];
			var correctAnswerList = correctAnswer[currentQuestionNum-1];
			var currentQuestion = question[currentQuestionNum-1];
			var currentMarks = marksOfQuestion[currentQuestionNum-1];
			var row = questionTable.insertRow(rowNum);
			//questioninput
			var cell = row.insertCell(0);
			var content = "<p>Question: <input type='text' id='inquestion' name='inquestion' size='60' height = '30'>"+
			"Marks for this question: <input type='number' id='marks' name='marks' value='"+currentMarks+"'>"
			+"</p>";
			cell.innerHTML = content;
			
			rowNum++;
			row = questionTable.insertRow(rowNum);
			var cell = row.insertCell(0);
			nthAns++;
			var content = "<p> (Suggested) Answer: <input type='text' id='textAns' name='textAns' size='60' height ='30'></p>";
			cell.innerHTML = content;
			
			questionDiv.appendChild(questionTable);
			document.getElementById("inquestion").value = currentQuestion;
			document.getElementById("textAns").value = correctAnswerList;
			//finished
			currentType = "Short Questions";

		}
		break;
		case "FB":
		{
			document.getElementById("questiontype").value = "Fill in the blanks";
			//retrieve previous question.
			var answerList = answers[currentQuestionNum-1];
			var correctAnswerList = correctAnswer[currentQuestionNum-1];
			var currentQuestion = question[currentQuestionNum-1];
			var currentMarks = marksOfQuestion[currentQuestionNum-1];
			var row = questionTable.insertRow(rowNum);
			//questioninput
			var cell = row.insertCell(0);
			var content = "<p>Question: <input type='text' id='inquestion' name='inquestion' size='60'>"+
			"Marks for this question: <input type='number' id='marks' name='marks' value='"+currentMarks+"'>"
			+"</p>";
			cell.innerHTML = content;
			
			//Row 2
			rowNum++;
			row = questionTable.insertRow(rowNum);
			var cell = row.insertCell(0);
			nthAns++;
			var content = "<p>Answer: <input type='text' id='textAns' name='textAns' size='60'></p>";
			cell.innerHTML = content;

			questionDiv.appendChild(questionTable);
			document.getElementById("inquestion").value = currentQuestion;
			document.getElementById("textAns").value = correctAnswerList;

			//finished
			currentType = "Fill in the blanks";


		}
		break;
	}
	document.getElementById("questionNumber").innerHTML = "Question #"+currentQuestionNum;
}

function onTypeChange()
{
	var choice = document.getElementById("questiontype").value;
	//check question type
	switch (choice)
	{
		case "MC Questions":
		{
			if (currentType != null)
			{
				//check if the currentType is MCQ.
				if (currentType != "MC Questions")
				{
					//if no, then clear all elements in div
					document.getElementById("question").innerHTML = "";
					nthAns = 0;
					rowNum = 0;
				}
			}
			//onclick='onAddAnswer();'	
			//alert("MC question is selected!");
			var questionDiv = document.getElementById("question");
			//Add one question box and AT LEAST 2 answers in the div, each answer has a box of "correct answer".
			var questionTable = document.createElement("table");
			questionTable.setAttribute('id','questionTable');
			//first, insert three rows.
			//Row 1: question input and add/detete answer buttons
			
			var row = questionTable.insertRow(rowNum);
			//questioninput
			var cell = row.insertCell(0);
			var content = "<p>Question: <input type='text' id='inquestion' name='inquestion'>"+
			"  <input type='button' id='addansbtn' name='addansbtn' onclick='onAddAnswer();' value='Add an answer' />  <input type='button' id='deleteansbtn' onclick='onRemoveAnswer();' value='Remove an answer' disabled='true'> "+
			"Marks for this question: <input type='number' id='marks' name='marks'>"
			+"</p>";
			cell.innerHTML = content;
			//add/delete answer buttons
			
			
			
			//Row 2-3: answers
			rowNum++;
			row = questionTable.insertRow(rowNum);
			var cell = row.insertCell(0);
			nthAns++;
			var content = "<p>Answer"+" "+nthAns+":  <input type='text' id='Ans"+
			rowNum+"' name=''Ans"+ rowNum+"'>" + " <input type='checkbox' id='correctbox"+nthAns +"' name='correctbox"+nthAns+"'>"+
			"<label for='correctbox"+nthAns+"'>Correct Answer?</label>"+"</p>";
			cell.innerHTML = content;
			
			//row 3
			rowNum++;
			row = questionTable.insertRow(rowNum);
			cell = row.insertCell(0);
			nthAns++;
			content = "<p>Answer"+" "+nthAns+":  <input type='text' id='Ans"+
			rowNum+"' name=''Ans"+ rowNum+"'>" + " <input type='checkbox' id='correctbox"+nthAns +"' name='correctbox"+nthAns+"'>"+
			"<label for='correctbox"+nthAns+"'>Correct Answer?</label>"+"</p>";
			cell.innerHTML = content;
			
			
			//finished
			questionDiv.appendChild(questionTable);
			currentType = "MC Questions";
		}
		break;
		
		case "Short Questions":
		{
			
			if (currentType != null)
			{
				//check if the currentType is short questions.
				if (currentType != "Short Questions")
				{
					//if no, then clear all elements in div
					document.getElementById("question").innerHTML = "";
					nthAns = 0;
					rowNum = 0;
				}
			}
			//alert("Short Questions is selected!");
			var questionDiv = document.getElementById("question");
			//Add one question box and suggested answer box
			var questionTable = document.createElement("table");
			questionTable.setAttribute('id','questionTable');
			//first, insert two rows.
			//Row 1: question input 
			
			var row = questionTable.insertRow(rowNum);
			//questioninput
			var cell = row.insertCell(0);
			var content = "<p>Question: <input type='text' id='inquestion' name='inquestion' size='60' height = '30'>"+" Marks for this question: <input type='number' id='marks' name='marks'></p>";
			cell.innerHTML = content;
			
			//Row 2
			rowNum++;
			row = questionTable.insertRow(rowNum);
			var cell = row.insertCell(0);
			nthAns++;
			var content = "<p> (Suggested) Answer: <input type='text' id='textAns' name='textAns' size='60' height ='30'></p>";
			cell.innerHTML = content;
			
			
			//finished
			questionDiv.appendChild(questionTable);
			currentType = "Short Questions";
		}
		break;
		
		case "Fill in the blanks":
		{
			if (currentType != null)
			{
				//check if the currentType is fill in the blanks.
				if (currentType != "Fill in the blanks")
				{
					//if no, then clear all elements in div
					document.getElementById("question").innerHTML = "";
					nthAns = 0;
					rowNum = 0;
				}
			}
			//alert("Fill in the blanks question is selected!");
			var questionDiv = document.getElementById("question");
			//Add one question box and suggested answer box
			var questionTable = document.createElement("table");
			questionTable.setAttribute('id','questionTable');
			//first, insert two rows.
			//Row 1: question input 
			
			var row = questionTable.insertRow(rowNum);
			//questioninput
			var cell = row.insertCell(0);
			var content = "<p>Question: <input type='text' id='inquestion' name='inquestion' size='60'>"+ " Marks for this question: <input type='number' id='marks' name='marks'></p>";
			cell.innerHTML = content;
			
			//Row 2
			rowNum++;
			row = questionTable.insertRow(rowNum);
			var cell = row.insertCell(0);
			nthAns++;
			var content = "<p>Answer: <input type='text' id='textAns' name='textAns' size='60'></p>";
			cell.innerHTML = content;
			//finished
			questionDiv.appendChild(questionTable);
			currentType = "Fill in the blanks";
		}
		break;
		
		default:
		{
			//if no, then clear all elements in div
			nthAns = 0;
			rowNum = 0;
			document.getElementById("question").innerHTML = "";
		}
		break;
	}
}

function onFinishClick()
{
	var iForm = document.getElementById("inputForm");
	//check if user's input on current question is correct.
	//only submit when user's input on currrent question is valid.
	var questionCount = question.length;
	var confirmText = "Are you sure to submit?\n";
	if (confirm(confirmText))
	{
		if (checkQuestionValid())
		{
			//JSON.stringify([question,questionType,answers,correctAnswer])
			var jsonSubmitText = JSON.stringify([question,questionType,answers,correctAnswer,marksOfQuestion]);
			//alert(jsonSubmitText);
			var questionCount = question.length;
			document.getElementById("questionCnt").value = questionCount;
			document.getElementById("questionAnswers").value = jsonSubmitText;
			
			//since the input of questions are finished, erase the input form
			var questionTable = document.getElementById("questionTable");
			if (typeof(questionTable) != "undefined")
			{
				questionTable.remove();
				document.getElementById("questionNumber").remove();
			}
			//submit the form
			window.history.forward(1); //test
			iForm.submit();
		}
	}
}


