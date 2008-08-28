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

function sizeof(arr){
	var len=arr.length?--arr.length:-1;
	for(var k in arr){
		len++;
	}
	return len;
}

function in_array(arr,val){
	for(var i=0;i<arr.length;i++){
		if(arr[i]===val){
			return(i);
		}
	}
	return(-1);
}

function findInArray(arrayToSearch,searchValue,optionalMatchFn){
	var retVal=-1;
	for(var i=0;i<arrayToSearch.length;i++){
		if(optionalMatchFn!=null){
			if(optionalMatchFn(arrayToSearch[i],searchValue)){
				retVal=i;
				break;
			}
		}else{
			if(arrayToSearch[i]==searchValue){
				retVal=i;
				break;
			}
		}
	}
	return retVal;
}

function strip_tags(str){
	return str.replace(/(<([^>]+)>)/ig,'');
}

function utf16to8(str){
	var out,i,j,len,c,c2;
	out=[];
	len=str.length;
	for(i=0,j=0;i<len;i++,j++){
		c=str.charCodeAt(i);
		if(c<=0x7f){
			out[j]=str.charAt(i);
		}else if(c<=0x7ff){
			out[j]=String.fromCharCode(0xc0|(c>>>6),0x80|(c&0x3f));
		}else if(c<0xd800||c>0xdfff){
			out[j]=String.fromCharCode(0xe0|(c>>>12),0x80|((c>>>6)&0x3f),0x80|(c&0x3f));
		}else{
			if(++i<len){
				c2=str.charCodeAt(i);
				if(c<=0xdbff&&0xdc00<=c2&&c2<=0xdfff){
					c=((c&0x03ff)<<10|(c2&0x03ff))+0x010000;
					if(0x010000<=c&&c<=0x10ffff){
						out[j]=String.fromCharCode(0xf0|((c>>>18)&0x3f),0x80|((c>>>12)&0x3f),0x80|((c>>>6)&0x3f),0x80|(c&0x3f));
					}else{
						out[j]='?';
					}
				}else{
					i--;
					out[j]='?';
				}
			}else{
				i--;
				out[j]='?';
			}
		}
	}
	return out.join('');
}

function utf8to16(str){
	var out,i,j,len,c,c2,c3,c4,s;
	out=[];
	len=str.length;
	i=j=0;
	while(i<len){
		c=str.charCodeAt(i++);
		switch(c>>4){ 
			case 0: case 1: case 2: case 3: case 4: case 5: case 6: case 7:
				out[j++]=str.charAt(i-1);
				break;
			case 12: case 13:
				c2=str.charCodeAt(i++);
				out[j++]=String.fromCharCode(((c&0x1f)<<6)|(c2&0x3f));
				break;
			case 14:
				c2=str.charCodeAt(i++);
				c3=str.charCodeAt(i++);
				out[j++]=String.fromCharCode(((c&0x0f)<<12)|((c2&0x3f)<<6)|(c3&0x3f));
				break;
			case 15:
				switch(c&0xf){
					case 0: case 1: case 2: case 3: case 4: case 5: case 6: case 7:
						c2=str.charCodeAt(i++);
						c3=str.charCodeAt(i++);
						c4=str.charCodeAt(i++);
						s=((c &0x07)<<18)|((c2&0x3f)<<12)|((c3&0x3f)<<6)|(c4&0x3f)-0x10000;
						if(0<=s&&s<=0xfffff){
							out[j]=String.fromCharCode(((s>>>10)&0x03ff)|0xd800,(s&0x03ff)|0xdc00);
						}else{
							out[j]='?';
						}
						break;
					case 8: case 9: case 10: case 11:
						i+=4;
						out[j]='?';
						break;
					case 12: case 13:
						i+=5;
						out[j]='?';
						break;
				}
		}
		j++;
	}
	return out.join('');
}

function serialize(o){
	var p=0,sb=[],ht=[],hv=1;
	function classname(o){
		if(typeof(o)=='undefined'||typeof(o.constructor)=='undefined') return '';
		var c=o.constructor.toString();
		c=utf16to8(c.substr(0,c.indexOf('(')).replace(/(^\s*function\s*)|(\s*$)/ig,''));
		return ((c=='')?'Object':c);
	}
	function is_int(n){
		var s=n.toString(),l=s.length;
		if(l>11) return false;
		for(var i=(s.charAt(0)=='-')?1:0;i<l;i++){
			switch (s.charAt(i)){
				case '0': case '1': case '2': case '3': case '4': case '5': case '6': case '7': case '8': case '9':
					break;
				default : return false;
			}
		}
		return !(n<-2147483648||n>2147483647);
	}
	function in_ht(o){
		for(k in ht) if(ht[k]===o) return k;
		return false;
	}
	function ser_null(){
		sb[p++]='N;';
	}
	function ser_boolean(b){
		sb[p++]=(b?'b:1;':'b:0;');
	}
	function ser_integer(i){
		sb[p++]='i:'+i+';';
	}
	function ser_double(d){
		if(isNaN(d)) d='NAN';
		else if(d==Number.POSITIVE_INFINITY) d='INF';
		else if(d==Number.NEGATIVE_INFINITY) d='-INF';
		sb[p++]='d:'+d+';';
	}
	function ser_string(s){
		var utf8=utf16to8(s);
		sb[p++]='s:'+utf8.length+':"';
		sb[p++]=utf8;
		sb[p++]='";';
	}
	function ser_array(a){
		sb[p++]='a:';
		var lp=p;
		sb[p++]=0;
		sb[p++]=':{';
		for(var k in a){
			if(typeof(a[k])!='function'){
				is_int(k)?ser_integer(k):ser_string(k);
				__serialize(a[k]);
				sb[lp]++;
			}
		}
		sb[p++]='}';
	}
	function ser_object(o){
		var cn=classname(o);
		if(cn=='') ser_null();
		else if(typeof(o.serialize)!='function'){
			sb[p++]='O:'+cn.length+':"';
			sb[p++]=cn;
			sb[p++]='":';
			var lp=p;
			sb[p++]=0;
			sb[p++]=':{';
			if(typeof(o.__sleep)=='function'){
				var a=o.__sleep();
				for(var kk in a){
					ser_string(a[kk]);
					__serialize(o[a[kk]]);
					sb[lp]++;
				}
			}else{
				for(var k in o){
					if(typeof(o[k])!='function'){
						ser_string(k);
						__serialize(o[k]);
						sb[lp]++;
					}
				}
			}
			sb[p++]='}';
		}else{
			var cs=o.serialize();
			sb[p++]='C:'+cn.length+':"';
			sb[p++]=cn;
			sb[p++]='":'+cs.length+':{';
			sb[p++]=cs;
			sb[p++]="}";
		}
	}
	function ser_pointref(R){
		sb[p++]="R:"+R+";";
	}
	function ser_ref(r){
		sb[p++]="r:"+r+";";
	}
	function __serialize(o){
		if(o==null||o.constructor==Function){
			hv++;
			ser_null();
		}
		else switch(o.constructor){
			case Boolean:{
				hv++;
				ser_boolean(o);
				break;
			}
			case Number:{
				hv++;
				is_int(o)?ser_integer(o):ser_double(o);
				break;
			}
			case String:{
				hv++;
				ser_string(o);
				break;
			}
			case Array:{
				var r=in_ht(o);
				if(r){
					ser_pointref(r);
				}else{
					ht[hv++]=o;
					ser_array(o);
				}
				break;
			}
			default:{
				var r=in_ht(o);
				if(r){
					hv++;
					ser_ref(r);
				}else{
					ht[hv++]=o;
					ser_object(o);
				}
				break;
			}
		}
	}
	__serialize(o);
	return sb.join('');
}

function unserialize(ss){
	var p=0,ht=[],hv=1;r=null;
	function unser_null(){
		p++;
		return null;
	}
	function unser_boolean(){
		p++;
		var b=(ss.charAt(p++)=='1');
		p++;
		return b;
	}
	function unser_integer(){
		p++;
		var i=parseInt(ss.substring(p,p=ss.indexOf(';',p)));
		p++;
		return i;
	}
	function unser_double(){
		p++;
		var d=ss.substring(p,p=ss.indexOf(';',p));
		switch(d){
			case 'NAN': d=NaN; break;
			case 'INF': d=Number.POSITIVE_INFINITY; break;
			case '-INF': d=Number.NEGATIVE_INFINITY; break;
			default: d=parseFloat(d);
		}
		p++;
		return d;
	}
	function unser_string(){
		p++;
		var l=parseInt(ss.substring(p,p=ss.indexOf(':',p)));
		p+=2;
		var s=utf8to16(ss.substring(p,p+=l));
		p+=2;
		return s;
	}
	function unser_array(){
		p++;
		var n=parseInt(ss.substring(p,p=ss.indexOf(':',p)));
		p+=2;
		var a=[];
		ht[hv++]=a;
		for(var i=0;i<n;i++){
			var k;
			switch(ss.charAt(p++)){
				case 'i': k=unser_integer(); break;
				case 's': k=unser_string(); break;
				case 'U': k=unser_unicode_string(); break;
				default: return false;
			}
			a[k]=__unserialize();
		}
		p++;
		return a;
	}
	function unser_object(){
		p++;
		var l=parseInt(ss.substring(p,p=ss.indexOf(':',p)));
		p+=2;
		var cn=utf8to16(ss.substring(p,p+=l));
		p+=2;
		var n=parseInt(ss.substring(p,p=ss.indexOf(':',p)));
		p+=2;
		if(eval(['typeof(',cn,')=="undefined"'].join(''))){
			eval(['function ',cn,'(){}'].join(''));
		}
		var o=eval(['new ',cn,'()'].join(''));
		ht[hv++]=o;
		for(var i=0;i<n;i++){
			var k;
			switch(ss.charAt(p++)){
				case 's': k=unser_string(); break;
				case 'U': k=unser_unicode_string(); break;
				default: return false;
			}
			if(k.charAt(0)=='\0'){
				k=k.substring(k.indexOf('\0',1)+1,k.length);
			}
			o[k]=__unserialize();
		}
		p++;
		if(typeof(o.__wakeup)=='function') o.__wakeup();
		return o;
	}
	function unser_custom_object(){
		p++;
		var l=parseInt(ss.substring(p,p=ss.indexOf(':',p)));
		p+=2;
		var cn=utf8to16(ss.substring(p,p+=l));
		p+=2;
		var n=parseInt(ss.substring(p,p=ss.indexOf(':',p)));
		p+=2;
		if(eval(['typeof(',cn,')=="undefined"'].join(''))){
			eval(['function ',cn,'(){}'].join(''));
		}
		var o=eval(['new ',cn,'()'].join(''));
		ht[hv++]=o;
		if(typeof(o.unserialize)!='function') p+=n;
		else o.unserialize(ss.substring(p,p+=n));
		p++;
		return o;
	}
	function unser_unicode_string(){
		p++;
		var l=parseInt(ss.substring(p,p=ss.indexOf(':',p)));
		p+=2;
		var sb=[];
		for(var i=0;i<l;i++){
			if((sb[i]=ss.charAt(p++))=='\\'){
				sb[i]=String.fromCharCode(parseInt(ss.substring(p,p+=4),16));
			}
		}
		p+=2;
		return sb.join('');
	}
	function unser_ref(){
		p++;
		var r=parseInt(ss.substring(p,p=ss.indexOf(';',p)));
		p++;
		return ht[r];
	}
	function __unserialize(){
		switch(ss.charAt(p++)){
			case 'N': return ht[hv++]=unser_null();
			case 'b': return ht[hv++]=unser_boolean();
			case 'i': return ht[hv++]=unser_integer();
			case 'd': return ht[hv++]=unser_double();
			case 's': return ht[hv++]=unser_string();
			case 'U': return ht[hv++]=unser_unicode_string();
			case 'r': return ht[hv++]=unser_ref();
			case 'a': return unser_array();
			case 'O': return unser_object();
			case 'C': return unser_custom_object();
			case 'R': return unser_ref();
			default: return false;
		}
	}
	return __unserialize();
}

var base64EncodeChars="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
var base64DecodeChars=new Array(
	-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,
	-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,
	-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,62,-1,-1,-1,63,
	52,53,54,55,56,57,58,59,60,61,-1,-1,-1,-1,-1,-1,
	-1,0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,
	15,16,17,18,19,20,21,22,23,24,25,-1,-1,-1,-1,-1,
	-1,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,
	41,42,43,44,45,46,47,48,49,50,51,-1,-1,-1,-1,-1);

function base64_encode(str){
	var out,i,len;
	var c1,c2,c3;
	len=str.length;
	i=0;
	out='';
	while(i<len){
		c1=str.charCodeAt(i++)&0xff;
		if(i==len){
			out+=base64EncodeChars.charAt(c1>>2);
			out+=base64EncodeChars.charAt((c1&0x3)<<4);
			out+="==";
			break;
		}
		c2=str.charCodeAt(i++);
		if(i==len){
			out+=base64EncodeChars.charAt(c1>>2);
			out+=base64EncodeChars.charAt(((c1&0x3)<<4)|((c2&0xF0)>>4));
			out+=base64EncodeChars.charAt((c2&0xF)<<2);
			out+="=";
			break;
		}
		c3=str.charCodeAt(i++);
		out+=base64EncodeChars.charAt(c1>>2);
		out+=base64EncodeChars.charAt(((c1&0x3)<<4)|((c2&0xF0)>>4));
		out+=base64EncodeChars.charAt(((c2&0xF)<<2)|((c3&0xC0)>>6));
		out+=base64EncodeChars.charAt(c3&0x3F);
	}
	return out;
}

function base64_decode(str){
	var c1,c2,c3,c4;
	var i,len,out;
	len=str.length;
	i=0;
	out='';
	while(i<len){
		do{
			c1=base64DecodeChars[str.charCodeAt(i++)&0xff];
		}while(i<len&&c1==-1);
		if(c1==-1) break;
		do{
			c2=base64DecodeChars[str.charCodeAt(i++)&0xff];
		}while(i<len&&c2==-1);
		if(c2==-1) break;
		out+=String.fromCharCode((c1<<2)|((c2&0x30)>>4));
		do{
			c3=str.charCodeAt(i++)&0xff;
			if(c3==61) return out;
			c3=base64DecodeChars[c3];
		}while(i<len&&c3==-1);
		if(c3==-1) break;
		out+=String.fromCharCode(((c2&0XF)<<4)|((c3&0x3C)>>2));
		do{
			c4=str.charCodeAt(i++)&0xff;
			if(c4==61) return out;
			c4=base64DecodeChars[c4];
		}while(i<len&&c4==-1);
		if(c4==-1) break;
		out+=String.fromCharCode(((c3&0x03)<<6)|c4);
	}
	return out;
}