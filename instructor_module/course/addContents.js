function onChange()
{
    
    var selectedContent = document.getElementById("chooseContents").value;
    var inputDiv = document.getElementById("inputDiv");
    switch (selectedContent)
    {
        case "Tutorial":
        case "Textbook":
        {
            inputDiv.innerHTML = "";
            //create a form in inputDiv and provide a button for submit.
            //Note: if have enough time, finish this
            var submitForm = document.createElement("form");
            submitForm.setAttribute("id","submitForm");
            submitForm.setAttribute("method","post");
            submitForm.setAttribute("action","addContents2.php");

            var input1 = document.createElement("input");
            input1.setAttribute("id","contentType");
            input1.setAttribute("name","contentType");
            input1.setAttribute("type","hidden");
            input1.setAttribute("value","Tutoial");
            
            var input2 = document.createElement("input");
            input2.setAttribute("id","courseID");
            input2.setAttribute("name","courseID");
            input2.setAttribute("type","hidden");
            input2.setAttribute("value",document.getElementById("hiddencourseCode").value);

            var submitBtn = document.createElement("input");
            submitBtn.setAttribute("id","submitBtn");
            submitBtn.setAttribute("name","submitBtn");
            submitBtn.setAttribute("type","submit");
            submitBtn.setAttribute("value","Create a new "+selectedContent);

            submitForm.appendChild(input1);
            submitForm.appendChild(input2);
            submitForm.appendChild(submitBtn);
            inputDiv.appendChild(submitForm);
        }
        break;
        case "Exam":
        {
            inputDiv.innerHTML = "";
            var submitForm = document.createElement("form");
            submitForm.setAttribute("id","submitForm");
            submitForm.setAttribute("method","post");
            submitForm.setAttribute("action","/eie4432/project/exam/addExam.php"); //to be changed when implementation!!!

            var input1 = document.createElement("input");
            input1.setAttribute("id","contentType");
            input1.setAttribute("name","contentType");
            input1.setAttribute("type","hidden");
            input1.setAttribute("value","Exam");
            
            var input2 = document.createElement("input");
            input2.setAttribute("id","courseID");
            input2.setAttribute("name","courseID");
            input2.setAttribute("type","hidden");
            input2.setAttribute("value",document.getElementById("courseInput").value);

            var submitBtn = document.createElement("input");
            submitBtn.setAttribute("id","submitBtn");
            submitBtn.setAttribute("name","submitBtn");
            submitBtn.setAttribute("type","submit");
            submitBtn.setAttribute("value","Create a new "+selectedContent);

            submitForm.appendChild(input1);
            submitForm.appendChild(input2);
            submitForm.appendChild(submitBtn);
            inputDiv.appendChild(submitForm);
        }
        break;
        default:
        {
            //Select....
            //erase all elements in the div
            inputDiv.innerHTML = "";
        }
        break;
    }
}