function isOpen(hour, minute){
    return hour > 16 || hour < 8 ? false : (weekDayNr == 5 ? (hour > 14 ? false : true) : true);
  }
  
  function activate(id) {
    const minute = dateObject.getMinutes();
    // const hour = dateObject.getHours();
    const hour = 12;


    weekDayNr == 6 || weekDayNr == 0 
      ? alert('Store is closed today! Please visit us on a week day.') 
      : (isOpen(hour, minute) ? document.getElementById(id).className += " active" : alert('We\'re closed for the day.'));
  }

  const daysClosed = [6, 0];
  let dateObject = new Date();
  let weekDayNr = dateObject.getDay();
  //alert("Week day nr: " + weekDayNr);
  if (weekDayNr == 6 || weekDayNr == 0) // Sat = 6, Sun = 0
  {
    activate("open-weekend");
  } else if (weekDayNr == 5) // Friday = 5
  {
    activate("open-friday");
  } else { // Other days
    activate("open-weekday");
  }