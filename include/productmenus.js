function initProdMenus ()
{
var divs = document.getElementsByTagName("DIV");
for ( i=0;i < divs.length ; i ++ )
{
if ( divs[i].className == "pmContainer")
{
var pmContainer = divs[i];
var nodes = pmContainer.childNodes;
for ( j =0;j< nodes.length ; j ++)
{
if ( nodes[j].className == "pmShadow")
{
pmContainer.pmShadow = nodes[j];
continue;
}
if ( nodes[j].className == "pmMenu")
{
pmContainer.pmMenu = nodes[j];
var menuItems = pmContainer.pmMenu.getElementsByTagName("DIV");
for ( k=0;k<menuItems.length;k++)
{
var menuItem = menuItems[k];
if ( menuItem.className =="pmMenuItem")
{
menuItem.onclick = function(){ pbRowClick( this );};
menuItem.onmouseout=function(){ this.style.backgroundImage=this.origBG};
menuItem.onmouseover=function(){this.origBG=this.style.backgroundImage ; this.style.backgroundImage="url('" + m_imgPfx + "/images/global/buttons/homepage/drk_menumask_96x28.png')";};
}
}
continue;
}
if ( nodes[j].className == "pmPrimaryLinkContainer")
{
pmContainer.pmPrimaryLinkContainer = nodes[j];
var anchors = nodes[j].getElementsByTagName( "A");
if ( anchors != null && anchors.length > 0 )
{
pmContainer.pmPrimaryLink = anchors[0];
var subDivs =pmContainer.pmPrimaryLink .getElementsByTagName("DIV");
if ( subDivs != null && subDivs.length > 0)
{
pmContainer.pmPrimaryImageHolder= subDivs[0];
var imgs = pmContainer.pmPrimaryImageHolder.getElementsByTagName( "IMG");
if ( imgs != null && imgs.length > 0 )
{
pmContainer.pmImage = imgs[0];
}
}
}
}
}
pmContainer.onmouseover = function (){m_pmIsOverLink = true;pmOver ( this );};
pmContainer.onmouseout = function (){m_pmIsOverLink = false;setTimeout('pmTimer()',2000);};
pmContainer.pmShadow.style.width=pmContainer.style.width;
if ( pmContainer.pmImage != null )
{
if ( isIE6 )
{
pmContainer.pmPrimaryImageHolder.style.filter="progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + pmContainer.pmImage.src + "', sizingMethod='scale')";
pmContainer.pmImage.style.display = "none";
}
}
}
}
}
function pbRowClick ( row )
{
for ( i=0 ; i <row.childNodes.length; i++ )
{
if ( row.childNodes[i].tagName == "A")
{
var href= row.childNodes[i].href;
if( window.event != null && window.event.srcElement != null && window.event.srcElement.tagName == "A")
{
return;
}
else
{
row.childNodes[i].href="javascript:void(0);";
}
document.location.href= href;
}
}
}
m_pmIsOverLink=false;
m_pmOld=false;
function pmTimer ()
{
if (!m_pmIsOverLink && m_pmOld )
{
pmOff(m_pmOld);
}
}
function pmOff ( container )
{
container.style.border = "1px solid #ffffff";
container.style.backgroundImage= "";
container.style.backgroundColor ="#ffffff";
container.pmShadow.style.display="none";
container.pmMenu.style.display = "none";
if(!m_isRtl)
{
container.style.zIndex = 1;
}
}
function pmOn ( container )
{
container.style.border = "1px solid #d7d7d7";
container.style.backgroundColor ="#dddddd";
container.style.backgroundImage= "url('" + m_imgPfx + "/images/global/buttons/homepage/mask_96x120.png')";
container.pmMenu.style.display = "block";
container.pmShadow.style.display="block";
container.pmShadow.style.top=container.offsetHeight -1;
if(!m_isRtl)
{
container.pmMenu.style.top = -container.pmMenu.offsetHeight+2;
container.style.zIndex = 2;
}
else
{
container.pmMenu.style.top = -container.pmMenu.offsetHeight-1;
}
if( getLeftOffset ( container.pmMenu) < 0 )
{
container.pmMenu.style.left=0;
}
}
function pmOver ( container )
{
if ( m_pmOld && m_pmOld != container )
{
pmOff( m_pmOld );
}
m_pmOld = container;
pmOn ( container );
}
function getLeftOffset(obj) {
var x = obj.offsetLeft
while (obj = obj.offsetParent) x += obj.offsetLeft
return x
}
