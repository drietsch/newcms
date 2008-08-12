// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//
// $Id: tooltip.js,v 1.6 2007/05/23 15:39:31 holger.meyer Exp $

function showtip(current,e,text)
{
   if (!document.layers)
   {
      thetitle=text.split('<br>')
      if (thetitle.length > 1)
      {
        thetitles=""
        for (i=0; i<thetitle.length; i++)
           thetitles += thetitle[i] + "\r\n"
        current.title = thetitles
      }
      else current.title = text
   }

   else
   {
       document.tooltip.document.write( 
           '<layer bgColor="#FFFFE7" style="border:1px ' +
           'solid black; font-size:12px;color:#000000;">' + text + '</layer>')
       document.tooltip.document.close()
       document.tooltip.left=e.pageX+5
       document.tooltip.top=e.pageY+5
       document.tooltip.visibility="show"
   }
}

function hidetip()
{
    if (document.layers)
        document.tooltip.visibility="hidden"
}
