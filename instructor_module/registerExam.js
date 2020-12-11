function check()
{
	var examName = document.getElementById("examName").value;
	var examDate = document.getElementById("examDate").value;
	var examTime = document.getElementById("examTime").value;
	var examDurationHrs = document.getElementById("examDurationHrs").value;
	var examDurationMinutes = document.getElementById("examDurationMinutes").value;
	//var examDurationSeconds = document.getElementById("examDurationSeconds").value;
	
	var valid = true;
	var errorText = "The following items are missing:\n";
	if (examName == "")
	{
		valid = false;
		errorText += "Name of exam\n";
	}
	if (examDate == "")
	{
		valid = false;
		errorText += "Start date of the exam\n";
	}
	if (examTime == "")
	{
		valid = false;
		errorText += "Start time of the exam\n";
	}
	if (examDurationHrs == 0 && examDurationMinutes == 0)
	{
		valid = false;
		errorText += "The duration of exam should have at least 1 minute!";
	} else if (examDurationHrs == "Hours" || examDurationMinutes == "Minute")
	{
		valid = false;
		errorText += "Duration of the exam\n";
	}
	if (valid)
	{
		document.getElementById("registerForm").submit();
	}
	else
	{
		alert(errorText);
	}
	
}

function initElements()
{
	//set up select for hours
	var hrs = document.getElementById("examDurationHrs");
	var mins = document.getElementById("examDurationMinutes");
	
	
	var title = document.createElement("option");
	title.text = "Hours";
	hrs.add(title);
	title = document.createElement("option");
	title.text = "Minute";
	mins.add(title);

	for (var i=0; i <= 12; i++)
	{
		//set up hours options
		var hrString = "hour"+i.toString();
		title = document.createElement("option");
		title.text = i.toString();
		hrs.add(title);
	}
	
	for (i = 0; i<= 60; i++)
	{
		//set up minutes and seconds options
		var minString = "minutes"+i.toString();
		title = document.createElement("option");
		title.text = i.toString();
		mins.add(title);
	}
}