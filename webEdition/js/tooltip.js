/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   we
 * @package    we_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

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
