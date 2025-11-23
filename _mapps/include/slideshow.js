 //Javascript Slide Show: copyright 2001 Kitty Munson Cooper kitty@kittymunson.com
 //the right to copy and use is hereby granted for non-profit usage
 //shareware download at http://www.kittymunson.com/slideshow.html
 //
 // requires this code at the top, which has two functions - startshow - which starts the
 // slide show and newslide which displays the next picture, as well as 
 //a piece of code at the bottom to initiatize the global picture lists, 
 // finallly to be invoked it can be called from form buttons on your web page
 //
 //define global variables for the slide show
   var interval=4000;
   var intervalID=0;
   var newwin="";

// function that creates the slide show window and schedules showing of slides by newslide
function startshow() {
    clearInterval(intervalID); // reset, in case one was already running
    newwin = window.open("","SlideShow","width=650,height=650,status=yes,resizable=yes,scrollbars=yes");
    newwin.document.writeln("<head><title>Slide Show</title></head><body bgcolor=gray><center><h1>Loading, please wait</h1></body>");
    newwin.document.close();   // close the document
    newwin.moveTo(20,20);      // put new window in top left
    if (interval == 0) interval =500;
    intervalID = window.setInterval('newslide()', interval);  // set up the periodic new pic
    newslide();  // display the first slide
}
// function that displays the next slide
function newslide() {
    // If the user closed the window, stop the show.
    if (newwin.closed) {
        clearInterval(intervalID);
        return;
    }
//  use the list of images created at end of document  
        if (i == piclist.length) i = 0;   // go back to beginning when at end
        newwin.document.write('<head><title>' +  namlist[i]); //title= image name ...
        newwin.document.write(' - ' + document.title + '</title></head>'); // and document name
        newwin.document.write('<body bgcolor=black><center>');
        newwin.document.write('<img src="' + piclist[i++] + '"></center></body>'); //display image
        newwin.document.close();  
}