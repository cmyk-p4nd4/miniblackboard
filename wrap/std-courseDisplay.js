function onCourseClicked(starttime,duration,examid)
{
    //three tasks
    //1. get necessary elements and contents
    //2. check if it is the time to do exam, if not prompt error
    //3. if yes, then navigate to the exam page.
    

    //2. parse start time and end time
    var startTime = new Date(starttime);
    var startTimeUTC = startTime.toUTCString();

    //extract the duration to seconds
    var durationSec = 0;
    var durationArray = duration.split(";");
    var hours = durationArray[0];
    var index = hours.indexOf('h');
    hours = hours.substring(0,index);
    hours = parseInt(hours);

    durationSec = hours * 3600 * 1000;
    
    var minutes = durationArray[1];
    index = minutes.indexOf('m');
    minutes = minutes.substring(0,index);
    minutes = parseInt(minutes);

    durationSec += minutes * 60 * 1000;

    var seconds = durationArray[2];
    index = seconds.indexOf('s');
    seconds = seconds.substring(0,index);
    seconds = parseInt(seconds);

    durationSec += seconds * 1000;

    //set duration date object
    var deadline = new Date();
    deadline.setTime(startTime.getTime() + durationSec);
    
    
    var isdebug = true;
    var canStart = true;
    //check if the time is correct.
    if (!isdebug)
    {
        var currentTime = new Date();
        if (currentTime < startTime)
        {
            canStart = false;
            alert("The exam has not started!");
        }

        if (currentTime > deadline)
        {
            canStart = false;
            alert("The exam has been ended!");
        }
    }
    

    if (canStart)
    {
        //set cookie
        var expireTime = new Date();
        expireTime.setTime(expireTime.getTime()+36000*1000);
        var expireString = "expires="+expireTime.toUTCString();
        document.cookie += "exam_name = "+examid+";"+"start_time = "+startTimeUTC+";"
        +"deadline = "+deadline+";"+expireString+";path=/";
        alert(document.cookie);
        window.location.href = "https://web-miniblackboard.herokuapp.com/student_module/take_exam.php";

    }
}
