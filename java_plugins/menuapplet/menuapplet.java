import java.applet.*;
import java.awt.*;
import java.net.*;
import java.awt.event.*;
import java.io.*;
import java.util.*;
//import javax.swing.*;


public class menuapplet extends Applet{

	/**
	 * 
	 */
	private static final long serialVersionUID = 0L;
	
	String	SERVER_NAME;
	Image 	imageBackground;
	String php_ext;
	String cmdTarget;
	String cmdURL;

	public void init(){
		
		enableEvents(AWTEvent.MOUSE_EVENT_MASK | AWTEvent.MOUSE_MOTION_EVENT_MASK | AWTEvent.ACTION_EVENT_MASK);
            
		Vector me;		
		MenuEntry m2;
		MenuItem item;
		me = new Vector();
		int pid;
		int id;
		PopupMenu p;
		Menu mm;
		Menu mm2;
		MenuButton b;
		int x = 2;
		String cmd;
		String text;
		Graphics g = getGraphics();
		Hashtable mainmenus = new Hashtable();
		Hashtable submenus = new Hashtable();
		int i = 0;
		int w;
		int z = 0;
		String value=null;
		StringTokenizer st;
		String[] par = new String[5];
		int enabled = 0;
		
		String oldtext;
		String newtext;

		// getting Parameters
		int count=0;

		while ((value = getParameter("entry" + i)) != null) {
			i++;
			st = new StringTokenizer(value,",");
			z = 0;
			while (st.hasMoreTokens()) {
				par[z] = st.nextToken();
				par[z] = par[z].equals("#") ? "" : par[z];
				z++;
			} 
			Character ch;
			int umlPos = par[3].indexOf("%auml%");
			if(umlPos > -1){
				if(System.getProperty("os.name").indexOf("Mac OS X") > -1){
					ch = new Character((char)228);
					par[3] = replaceAll(par[3], "%auml%",ch.toString());
				}else{
					par[3] = replaceAll(par[3], "%auml%","‰");
				}
			}
			umlPos = par[3].indexOf("%uuml%");
			if(umlPos > -1){
				if(System.getProperty("os.name").indexOf("Mac OS X") > -1){
					ch = new Character((char)252);
					par[3] = replaceAll(par[3], "%uuml%",ch.toString());
				}else{
					par[3] = replaceAll(par[3], "%uuml%","¸");
				}
			}
			umlPos = par[3].indexOf("%ouml%");
			if(umlPos > -1){
				if(System.getProperty("os.name").indexOf("Mac OS X") > -1){
					ch = new Character((char)246);
					par[3] = replaceAll(par[3], "%ouml%",ch.toString());
				}else{
					par[3] = replaceAll(par[3], "%ouml%","ˆ");
				}
			}
		   umlPos = par[3].indexOf("%Auml%");
			if(umlPos > -1){
				if(System.getProperty("os.name").indexOf("Mac OS X") > -1){
					ch = new Character((char)196);
					par[3] = replaceAll(par[3], "%Auml%",ch.toString());
				}else{
					par[3] = replaceAll(par[3], "%Auml%","ƒ");
				}
			}
			umlPos = par[3].indexOf("%Uuml%");
			if(umlPos > -1){
				if(System.getProperty("os.name").indexOf("Mac OS X") > -1){
					ch = new Character((char)220);
					par[3] = replaceAll(par[3], "%Uuml%",ch.toString());
				}else{
					par[3] = replaceAll(par[3], "%Uuml%","‹");
				}
			}
			umlPos = par[3].indexOf("%Ouml%");
			if(umlPos > -1){
				if(System.getProperty("os.name").indexOf("Mac OS X") > -1){
					ch = new Character((char)214);
					par[3] = replaceAll(par[3], "%Ouml%",ch.toString());
				}else{
					par[3] = replaceAll(par[3], "%Ouml%","÷");
				}
			}
			umlPos = par[3].indexOf("%szlig%");
			if(umlPos > -1){
				if(System.getProperty("os.name").indexOf("Mac OS X") > -1){
					ch = new Character((char)223);
					par[3] = replaceAll(par[3], "%szlig%",ch.toString());
				}else{
					par[3] = replaceAll(par[3], "%szlig%","ﬂ");
				}
			}

			oldtext="";
			newtext="";
			
			count++;

			try {
				newtext = new String(oldtext.getBytes(),"Cp1251");
				
			} catch (UnsupportedEncodingException e) {
				e.printStackTrace();
			}			
			me.addElement(new MenuEntry(Integer.parseInt(par[0]),Integer.parseInt(par[1]),par[2],par[3],Integer.parseInt(par[4])));
		} 
		

		// creating Action Listener		
		ActionListener al = new ActionListener() {
			public void actionPerformed(ActionEvent e){
				String command = e.getActionCommand();
				menuapplet.this.doCmd(command);
			};
		};


		// get FontMetrics for calculating width of the Menubutton


		g.setFont(new Font("verdana",Font.BOLD,12));		
		FontMetrics fm = g.getFontMetrics();                	

		//adding menus to the applet
		for(i=0;i<me.size();i++){
			m2 = (MenuEntry) me.elementAt(i);
			pid = m2.getParentID();
			id = m2.getID();
			cmd = m2.getCmd();
			text = m2.getText();
			enabled = m2.getEnabled();
			
			if(pid == 0){
				p = new PopupMenu();
				add(p);
				p.addActionListener(al);
				b = new MenuButton(this,p,text);
				w = fm.stringWidth(text) + 20;				
								b.setLocation(new Point(x, 4));                                
				b.setSize(new Dimension(w, 20));
				x += w;
				b.setVisible(true);
				add(b);
				mainmenus.put(new Integer(id),p);
			}else if(cmd.length() == 0 && text.length() > 0){
				mm = new Menu();
				mm.setLabel(text);
				p = (PopupMenu) mainmenus.get(new Integer(pid));
				if(p != null){
					p.add(mm);
				}else{
					mm2 = (Menu) submenus.get(new Integer(pid));
					if(mm2 != null){
						mm2.add(mm);
					}
				}

				//mm.addActionListener(al);
				mm.addActionListener( new ActionListener(){
					public void actionPerformed(ActionEvent e){

					}
				});
				submenus.put(new Integer(id),mm);
			}else if(text.length() > 0){
				  item = new MenuItem(text);
				  if(enabled == 0){
					item.setEnabled(false);
								item.setActionCommand("");
				  }
							  else item.setActionCommand(cmd);
				item.addActionListener(al);
				p = (PopupMenu) mainmenus.get(new Integer(pid));
				if(p != null){
					p.add(item);
				}else{
					mm = (Menu) submenus.get(new Integer(pid));
					if(mm != null){
						mm.add(item);
					}
				}


			}else{
				p = (PopupMenu) mainmenus.get(new Integer(pid));
				if(p != null){
					p.addSeparator();
				}else{
					mm = (Menu) submenus.get(new Integer(pid));
					if(mm != null){						
												mm.addSeparator();

					}
				}
			
			}
		}
		
            
		php_ext=getParameter("phpext");
		if(php_ext==null) php_ext=".php";
            
		cmdTarget=getParameter("cmdTarget");
		if(cmdTarget==null) cmdTarget="load";
            
		cmdURL=getParameter("cmdURL");
		if(cmdURL==null) cmdURL="/webEdition/we_lcmd"+php_ext+"?wecmd0=";
		
		URL codeBase = getCodeBase();
		SERVER_NAME = codeBase.getHost();
		int port=(getDocumentBase()).getPort();
		String protocol=(getDocumentBase()).getProtocol();
				
		try{
			URL backgroundURL = new URL(protocol, SERVER_NAME, port, "/webEdition/images/java_menu/background.gif");
			imageBackground = getImage(backgroundURL,"background.gif"); 
		}catch(MalformedURLException ex){
					System.err.println(ex);
		}
			
		setLocation(new java.awt.Point(0, 0));
		setLayout(new FlowLayout(FlowLayout.LEFT,4,4));                                
                

	}  

	public void start() {
		repaint();
	}

	public Image getBgImage(){
		return imageBackground;
	}

	public void doCmd(String cmd)   {
		String url="";
		int port;
				
		try{			
			port=(getDocumentBase()).getPort();
			String protocol=(getDocumentBase()).getProtocol();

			if((System.getProperty("os.name").indexOf("Mac OS") > -1) && (cmd=="") ) return;
						if(port!=-1)
							url = protocol+"://"+SERVER_NAME+":"+port+cmdURL+cmd;
						else
							url = protocol+"://"+SERVER_NAME+cmdURL+cmd;                                                
                        
			getAppletContext().showDocument(new URL(url),cmdTarget);
		}catch(MalformedURLException ex){
			System.err.println(ex);
		}

	}      

	public void paint(Graphics g) {
		g.drawImage(imageBackground,0,0,this);
	}

	public static String replaceAll(String source, String search,String replace) {
		if(search.equals(replace)) {
			return source; //kann ja sein, dass wir nichts tun müssen
		}

		StringBuffer result = new StringBuffer();
		int len = search.length();
		if(len == 0) {
			return source; //verhindert Endlosschleife bei search.equals("");
		}

		int pos = 0; //position
		int nPos;    //next position
		do {
			nPos = source.indexOf(search, pos);
			if(nPos != -1) { //gefunden
				result.append(source.substring(pos, nPos));
				result.append(replace);
				pos = nPos+len;
			} else { //nicht gefunden
			result.append(source.substring(pos)); //letzter abschnitt
		}
		} while(nPos!= -1);

		return result.toString();
	}
    
 }

 class MenuEntry {

	private int ID;
	private int Enabled;
	private int	ParentID;
	private String Cmd;
	private String Text;

	
	public MenuEntry(int ID, int ParentID, String Cmd, String Text,int Enabled){
		this.ID=ID;
		this.ParentID = ParentID;
		this.Cmd = Cmd;
		this.Text = Text;
		this.Enabled = Enabled;
	}

	public void setID(int ID){
		this.ID = ID;
	}

	public void setParentID(int ParentID){
		this.ParentID = ParentID;
	}

	public void setCmd(String Cmd){
		this.Cmd = Cmd;
	}

	public void setText(String Text){
		this.Text = Text;
	}	
	
	public void setEnabled(int Enabled){
		this.Enabled = Enabled;
	}	

	public int getID(){
		return this.ID;
	}

	public int getParentID(){
		return this.ParentID;
	}

	public String getCmd(){
		return this.Cmd;
	}

	public String getText(){
		return this.Text;
	}

	public int getEnabled(){
		return this.Enabled;
	}

 }


 class MenuButton extends Canvas{
     
    
	/**
	 * 
	 */
	private static final long serialVersionUID = 1585446351088778635L;
	
	private PopupMenu	_popup; 
	private int 	_state		=	0;
	private Applet	_applet		=	null;
	private String	_text		=	"My Button";
	private Font 	_font;
	Image 	imageBackground;
		Image   offscreen;
		Graphics buffG;
        
	public MenuButton(Applet applet, PopupMenu popup,String text){
		super();
		
		URL codeBase = applet.getCodeBase();
		String SERVER_NAME = codeBase.getHost();
		int port=(applet.getDocumentBase()).getPort();
		String protocol=(applet.getDocumentBase()).getProtocol();
		try{
			URL backgroundURL = new URL(protocol, SERVER_NAME, port, "/webEdition/images/java_menu/background.gif");
			imageBackground = applet.getImage(backgroundURL,"background.gif"); 
		}catch(MalformedURLException ex){
					System.err.println(ex);
		}		
		
		try {
			_text = text;
			_font = new Font("verdana",Font.BOLD,12);
			
			_popup = popup;
			_applet = applet;
			addMouseListener( new Clicked() );
			//imageBackground = _applet.getImage(_applet.getCodeBase(),"bg.gif");
					
			//disableEvents( AWTEvent.FOCUS_EVENT_MASK);
			//disableEvents( AWTEvent.KEY_EVENT_MASK);

			RefreshThread refresht=new RefreshThread(this);
			refresht.start();

		}catch (Exception e) {
			e.printStackTrace();
		}
	}
    
	public void setState(int state){
		_state = state;
	}

	public void paint(Graphics g) {
		
		Dimension dim=getSize();
		offscreen = createImage(dim.width,dim.height);
		buffG = offscreen.getGraphics(); 

		Rectangle r;
		buffG.drawImage(imageBackground,0,0,this);
		r = g.getClipBounds();
		if(_state==1){
			paintThinBorder(buffG,r.x+1,r.y+1,r.width-2,r.height-2,true);
		}else if(_state==2){
			paintThinBorder(buffG,r.x+1,r.y+1,r.width-2,r.height-2,false);
		}
		buffG.setFont(_font);
		buffG.setColor(Color.black);
		FontMetrics fm = g.getFontMetrics();
		
		//int x = (r.width - fm.stringWidth(_text)) / 2;
		//int y = r.height - ((r.height - (fm.getHeight() - 5)) / 2);
		int x = 10;
		int y = r.height - ((r.height - (fm.getHeight() - 5)) / 2);
			
				
		
		buffG.drawString(_text,x + ((_state==2) ? 1 : 0),y + ((_state==2) ? 1 : 0));
		g.drawImage(offscreen,0,0,this);

	}
        
	public void update(Graphics g){ 
		  paint(g);
	}
 
	private void paintThinBorder(Graphics g, int x,int y,int w,int h,boolean raised) {
		paint3dRect(g, x, y, w, h, Color.white, Color.gray, raised);
	}

	private void paint3dRect(Graphics g, int x, int y, int w, int h, Color C1, Color C2, boolean raised) {
		if (!raised) {
			Color Tmp = C1;
			C1 = C2;
			C2 = Tmp;
		}
		g.setColor(C1);
		g.drawLine(x,y,x+w,y);
		g.drawLine(x,y,x,y+h);
		g.setColor(C2);
		g.drawLine(x+w,y,x+w,y+h+1);
		g.drawLine(x,y+h,x+w,y+h);
	}

	private void clearRect(Graphics g, int x, int y, int w, int h, Color C1) {
		g.setColor(C1);
		g.drawLine(x,y,x+w,y);
		g.drawLine(x,y,x,y+h);
		g.drawLine(x+w,y,x+w,y+h+1);
		g.drawLine(x,y+h,x+w,y+h);
	}

	public void showMenu(){
		Rectangle r;
		r = getBounds();
		if(_state==1) _popup.show(this,0,r.height);
	}

		class Clicked extends MouseAdapter {
		public void mousePressed(MouseEvent e){
			showMenu(); 
		}

		public void mouseEntered(MouseEvent e) {
			_state = 1;
			repaint();
		}
		public void mouseExited(MouseEvent e) {
			_state = 0;
			repaint();

		}
	}



}

class RefreshThread extends Thread{
	MenuButton refbutt;
	RefreshThread(MenuButton butt){
		this.refbutt=butt;
	}
	public void run(){
		   while(true){
					this.refbutt.repaint();
					try {
						Thread.sleep(3000);
					}
					catch (InterruptedException ex) {}
			}
	}
}
