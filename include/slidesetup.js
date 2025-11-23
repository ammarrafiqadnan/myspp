 //Javascript Slide Show: copyright 2001 Kitty Munson Cooper  kitty@kittymunson.com
 //the right to copy and use is hereby granted for non-profit usage
 //shareware download at http://www.kittymunson.com/slideshow.html
 //
 // build list of images for slide show
   var piclist = new Array(); // will hold the URL of jpeg to display
   var namlist = new Array();  // for the photo name which will be window title
   var i=0;  // index variables
   var j=0;
   for (var i = 0; i < document.links.length; i++) {  
          a = document.links[i].href;     // next link to check
          var strarray = a.split("/");    // separate by the slashes
	        var name = strarray[strarray.length-1].split("."); // last piece is name and type
          var ext = name[1].toUpperCase();  
          if (ext == "JPG"){
                 namlist[j] = name[0];  // store name and URL of each jpeg
                 piclist[j++] = a;
              }
      }
   i=0; // reset index variable
   