var m_request;
var m_overrideRequestMimeType = false;
var m_container;
var m_contentContainer;
var m_header;
var m_title;
var m_busyIcon;
var hoverovertime = 1300;
var m_containerTimeout = 500;
var m_hideMethodId;
var m_contentContainerDefault;
var m_opacityIdx = 10;
var m_fadeMethodId;
var m_prevRequestUrl;
var myTimer;
var mouseoverBol = 0
var ttip_responseCollection = new Object();
var bmouseover=0
var delayOnHide = 0



$(window).bind ( 'load', InitToolTips);

function InitToolTips()
{
    if ( typeof( m_ttipAutoDetect ) != "undefined" )
    {
    setTimeout ( AttachTooltips, 100 );
    }
    else
    {
    InitGlossaryTips();
    }
}
function InitGlossaryTips()
{

   $("span[@glid]")
    .livequery(function(){ 
    var gdeco = $(this).attr("glnodeco");

    if ( typeof(gdeco) == "undefined" )
    {
     $(this).addClass('glossaryitem'); 
    }
    else
    {
     $(this).addClass('glossaryitem_nodecoration'); 
    }
    hasTooltips = true;
    
    if ( hasTooltips )
    {
   
    var container = "<div><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" id=\"glcontainer\" class=\"glossarycontainer\">";
    container += "<tr><td id=\"glheader\" class=\"rowsolid glheader\"><h2 class=\"titlestylesolid\"><span id=\"gltitle\" style=\"float:left\"></span><span><a class='closeglossaryitem' href='javascript:TTHide();'>" + m_popClose + "</a></span></h2></td></tr>";
    container += "<tr><td id=\"glcontent\" class=\"glossarycontent\"><div id=\"glbusyicon\" style=\"text-align:center\">";
    container += "<img src=\"" + m_imgPfx + "/images/global/brand/icons/busyicon.gif\" class=\"busyicon\" /><br />Loading</div></div></td></tr></table></div>";
   
    $(container).appendTo('body');

    m_container = $("#glcontainer" );
    m_busyIcon = $("#glbusyicon" );
    m_contentContainer = $("#glcontent" );
    m_header = $("#glheader" );
    m_title = $("#gltitle" );
    m_contentContainerDefault = m_contentContainer.html();
    
    m_container.bind('mouseout', HideGlossaryTip);
    m_container.bind('blur', HideGlossaryTip);
    m_container.bind('mouseover', LockTimer);
    m_contentContainer.bind('mouseover', LockTimer);

    }
    

    //bind a mouseover and mouseout event 
        $(this) 
            .hover(function(e) { 
            OnMouseOver(this,e);
            }, function() { 
               OnMouseOut()
            }); 
    }, function() { 
        // unbind the mouseover and mouseout events 
        $(this) 
            .unbind('mouseover') 
            .unbind('mouseout'); 
    }); 

}



function OnMouseOver(src, e)
{
bmouseover=1;
var eventarg = new Array();
var mouseX = null;
var mouseY = null;
if ( e )
{
mouseX = e.clientX
mouseY = e.clientY
}
else if (window.event )
{
mouseX = window.event.x;
mouseY = window.event.y;
}

eventarg["clientX"] = mouseX;
eventarg["clientY"] = mouseY;
myTimer = setTimeout(function(){ pauseforShowGlossaryTip( src, eventarg );}, hoverovertime);
}

function pauseforShowGlossaryTip(src,e){

if (bmouseover== 1)
{
bmouseover = 0;
ShowGlossaryTip(src,e);
}
}

function OnMouseOut()
{
bmouseover=0 
window.clearTimeout(myTimer);
HideGlossaryTip();
}


function ShowGlossaryTip( src, e )
{
var mouseX = null;
if ( e )
{
mouseX = e.clientX
}
else if (window.event )
{
mouseX = window.event.x;
}

if( m_container != null )
{
if( m_hideMethodId != null )
{
window.clearTimeout( m_hideMethodId );
}

m_contentContainer.html(m_contentContainerDefault);
m_container.css('opacity',1.0);



if ( src.attributes.glwidth )
{
m_container.width(src.attributes.glwidth.value);

}
else
{
m_container.width("342px");
}
if ( src.attributes.gltitle )
{
m_title.html(src.attributes.gltitle.value);
}
m_container.css('display','block');

if ( ttip_responseCollection[src.attributes.glid.value] )
{
ttipresponsetemp = ttip_responseCollection[src.attributes.glid.value];
if ( typeof( ttipresponsetemp["title"] ) != "undefined" && ttipresponsetemp["title"] != "" )
{
m_title.html(ttipresponsetemp["title"]);
}
var responseText = ttipresponsetemp["content"];
var moredetailscont = ttipresponsetemp["moredetails"];
if ( typeof( moredetailscont ) != "undefined" && moredetailscont != "" )
{
responseText += "<div style=\"float:right; padding-right:20px;\">";
responseText += moredetailscont;
responseText += "</div>";
}
m_contentContainer.html(responseText);
m_busyIcon.css('display','none');
PositionContainer(src, mouseX);
}
else
{
m_busyIcon.css('display','block');
PositionContainer ( src, mouseX );
GetLexiconTerm( src, mouseX );
}
}
}
function truebody()
{
return ( document.compatMode && document.compatMode!="BackCompat" )? document.documentElement : document.body
}

function getQueryVariable(variable)
{
var query = window.location.search.substring(1);
var vars = query.split("&");
for (var i=0;i<vars.length;i++)
{
var pair = vars[i].split("=");
if (pair[0] == variable)
{
return pair[1];
}
}
}
function PositionContainer (src, mouseX)
{
var scrollTop = (document.all)? ( truebody().scrollTop) : window.pageYOffset;
var scrollLeft = (document.all)? ( truebody().scrollLeft) : window.pageXOffset;
var clientHeight = (document.all)? ( truebody().clientHeight) : document.body.clientHeight;
var clientWidth = (document.all)? ( truebody().clientWidth) : document.body.clientWidth;
var m_pointer = $('#glpointer' );
var left=0, top=0;
var parent = src;
while ( parent )
{

left += parent.offsetLeft;
top += parent.offsetTop;
parent = parent.offsetParent;
}

if ( m_pointer )
{
m_pointer.css("display","block");

}

var conWidth = m_container.width();

var conHeight = m_container.height();

if ( top - 2 - conHeight > scrollTop )
{
if ( m_pointer )
{
conHeight -= m_pointer.height();
m_pointer.css("display","none");
}
m_container.css("top",top - 2 - conHeight + "px");

}
else
{
m_container.css("top",top + src.offsetHeight + 7 + "px");

}

if(m_isRtl)
{
if ( mouseX )
{
var scrollWidth = document.body.scrollWidth;
// magic number 22 is scrollWidth - scrollLeft, possibly due to the scrollbar on left side

left = scrollLeft + mouseX;
left -= document.body.scrollWidth - clientWidth;

if ( isIE4 )
{
left -= 44;
}
var x = scrollLeft - (scrollWidth - clientWidth	) - 22;
if ( left - conWidth >= x )
{
left -= conWidth;
}
else if ( left + conWidth > clientWidth )
{
left -= (conWidth);
}
m_container.css("left",left);

}
else
{
m_container.css("display","none");

}
}
else
{
if ( (left + (10) + conWidth > scrollLeft + clientWidth)
&& ( (left + src.offsetWidth) - (10) - conWidth > scrollLeft ) )
{
m_container.css("left",(left + src.offsetWidth) - (10) - conWidth + "px");
if ( m_pointer )
{
m_pointer.css("display","none");
}
}
else
{
m_container.css("left", left + (10) + "px");
}
}
}
function HideGlossaryTip()
{
m_hideMethodId = window.setTimeout( TTHide, m_containerTimeout );
}
function LockTimer()
{
window.clearTimeout( m_hideMethodId );
}
function TTHide()
{
if( m_container != null )
{
m_container.css("display", "none");
window.clearTimeout( m_hideMethodId );
m_contentContainer.innerHTML = m_contentContainerDefault;
m_hideMethodId = null;
}
}



function GetUrl(src)
{

var requestUrl = m_requestURLBase + "&~ttid=" + escape( src.attributes.glid.value );
if ( src.attributes.glmoredetails )
{
var ref = src.attributes.glmoredetails.value;
ref = ref.replace ( /:/g, "~" );
requestUrl += "&~ttref=" + ref;
}
return requestUrl;
}


function GetLexiconTerm( src, mouseX )
{

var requestUrl = GetUrl ( src );
try
{
    $.get(requestUrl,
      function(data){
        eval ( data );
    
    if ( typeof(ttipresponse) != "undefined" )
    {

    var responseText = ttipresponse["content"];
    var moredetailscont = ttipresponse["moredetails"];
    if ( typeof( moredetailscont ) != "undefined" && moredetailscont != "" )
    {
    responseText += "<div style=\"float:right; padding-right:20px;\">";
    responseText += moredetailscont;
    responseText += "</div>";
    }

    if ( typeof( ttipresponse["title"] ) != "undefined" && ttipresponse["title"] != "" )
    {
    
    m_title.html(ttipresponse["title"]);
    }
    m_contentContainer.html(responseText);
    m_busyIcon.css("display","none");
    PositionContainer(src, mouseX);
    ttip_responseCollection[src.attributes.glid.value] = ttipresponse;
    }

    });
}
catch ( ex )
{
    if ( !m_production )
    {
    alert ( "Exception occured in [GetLexiconTerm]: \n" + ex.message );
    }
    src.className="";
    src.onmouseover=null;
    src.onmouseout=null;
    m_prevRequestUrl=null;
    TTHide();
}



}
var m_ttregex;
var m_ttkeys;
function AttachTooltips ()
{
if ( typeof(TTRegEx) != "undefined" )
{
m_ttregex = new RegExp ( TTRegEx, "g" );
m_ttkeys = TTKeys;
SearchReplaceInDOM ( document.body, 0 );
TTipBindEvents();
}
}
function SearchReplaceInDOM( obj )
{
for (var i=0; i<obj.childNodes.length; i++)
{
var childObj = obj.childNodes[i];
if ( childObj.nodeName == "#text" )
{
nodeVal = childObj.nodeValue;
var matches = m_ttregex.exec ( nodeVal );
var prevmatch = 0;
var ttid;
var found = false;
var ttipHolderSpan;
while ( matches != null )
{
found = true;
ttid = m_ttkeys[matches[0]];
ttipHolderSpan = document.createElement("span");
var ttipSpan = document.createElement("span");
ttipSpan.setAttribute("glid", ttid);
var ttipText = document.createTextNode ( matches[0] );
var beforeText = document.createTextNode ( nodeVal.substring (prevmatch, matches.index) );
ttipSpan.appendChild ( ttipText );
ttipHolderSpan.appendChild ( beforeText );
ttipHolderSpan.appendChild ( ttipSpan );
prevmatch = matches.index + matches[0].length;
matches = m_ttregex.exec ( nodeVal );
}
if ( found )
{
if ( prevmatch < nodeVal.length )
{
var afterText = document.createTextNode ( nodeVal.substring ( prevmatch, nodeVal.length +1) );
ttipHolderSpan.appendChild ( afterText );
}
obj.insertBefore ( ttipHolderSpan, childObj );
obj.removeChild ( childObj );
continue;
}
}
SearchReplaceInDOM(childObj );
}
}
