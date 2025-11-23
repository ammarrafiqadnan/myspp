<!--
 // inslideshow.js  by Kitty Cooper, OpenSkyWebDesign.com
 //    you need an image on your page with a name="slide" in the image statement. All the images 
 //    need to be named slideN.jpg (where N is a number starting at 1)
 //
 //    if you want to have a larger version of the image appear in a new window on clicking
 //      set var large=1 
 //    change the height and width in photowin below if you wish
 //      have the images large1.jpg through largeN.jpg
 //      and see slideshow.html for the <a href tags to add there
 //
 function photowin(URL) {
pwin = window.open(URL, 'lphoto', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=644,height=484,left = 50,top = 100');
pwin.window.focus();
}
 //
 //define global variables for the slide show - change the following  if you need to
   var large = 1;   // set this to 1 in order to make the slide show images clickable, 0 if not
   var interval=4000;    // how long between slides in microseconds
	 var numslides = 5;    // number of slides
	 var folder = "images/"; // set this to the relative folder where the images are
//    
// don't change anything else ...
   var intervalID=0;
 // build list of images for slide show
   var piclist = new Array(); // will hold the URL of jpeg to display
	 var lrglist = new Array(); // will hold the URL of jpeg to display
   for (var i = 1; i < numslides+1; i++) {  
        piclist[i] = folder + "slide" + i + ".jpg"; // s URL of each jpeg
				if (large) {
				    lrglist[i] = folder + "large" + i + ".jpg"; // s URL of each large jpeg


				    }
        }
   i=1; // reset index variable
   
	startshow();
	
// function that creates the slide show window and schedules showing of slides by newslide
function startshow() { 
    clearInterval(intervalID); // reset, in case one was already running
    if (interval == 0) interval =500;
    intervalID = window.setInterval('newslide()', interval);  // set up the periodic new pic
    newslide();  // display the first slide
}
// function that displays the next slide
function newslide() {

//  use the list of images created at end of document  
        if (i == piclist.length) i = 1;   // go back to beginning when at end
				   if (large) {
				      document.links[0].href = lrglist[i];

							}
           document.images['slide'].src = piclist[i++];
}
