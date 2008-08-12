<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


	class we_codeConvertor{

		function we_codeConvertor(){
		}

		function toUnicode($cp,$code){
			switch($cp){
				case "1251": return we_codeConvertor::cp1251_to_unicode($code); break;
				case "1252": return we_codeConvertor::cp1252_to_unicode($code); break;
				case "10000":
				case "10029": return we_codeConvertor::cp10029_to_unicode($code); break;
			}
		}

		function cp10029_to_unicode($code){

			switch($code){

				case "00": return "0000"; break; #NULL
				case "01": return "0001"; break; #START OF HEADING
				case "02": return "0002"; break; #START OF TEXT
				case "03": return "0003"; break; #END OF TEXT
				case "04": return "0004"; break; #END OF TRANSMISSION
				case "05": return "0005"; break; #ENQUIRY
				case "06": return "0006"; break; #ACKNOWLEDGE
				case "07": return "0007"; break; #BELL
				case "08": return "0008"; break; #BACKSPACE
				case "09": return "0009"; break; #HORIZONTAL TABULATION
				case "0A": return "000A"; break; #LINE FEED
				case "0B": return "000B"; break; #VERTICAL TABULATION
				case "0C": return "000C"; break; #FORM FEED
				case "0D": return "000D"; break; #CARRIAGE RETURN
				case "0E": return "000E"; break; #SHIFT OUT
				case "0F": return "000F"; break; #SHIFT IN
				case "10": return "0010"; break; #DATA LINK ESCAPE
				case "11": return "0011"; break; #DEVICE CONTROL ONE
				case "12": return "0012"; break; #DEVICE CONTROL TWO
				case "13": return "0013"; break; #DEVICE CONTROL THREE
				case "14": return "0014"; break; #DEVICE CONTROL FOUR
				case "15": return "0015"; break; #NEGATIVE ACKNOWLEDGE
				case "16": return "0016"; break; #SYNCHRONOUS IDLE
				case "17": return "0017"; break; #END OF TRANSMISSION BLOCK
				case "18": return "0018"; break; #CANCEL
				case "19": return "0019"; break; #END OF MEDIUM
				case "1A": return "001A"; break; #SUBSTITUTE
				case "1B": return "001B"; break; #ESCAPE
				case "1C": return "001C"; break; #FILE SEPARATOR
				case "1D": return "001D"; break; #GROUP SEPARATOR
				case "1E": return "001E"; break; #RECORD SEPARATOR
				case "1F": return "001F"; break; #UNIT SEPARATOR
				case "20": return "0020"; break; #SPACE
				case "21": return "0021"; break; #EXCLAMATION MARK
				case "22": return "0022"; break; #QUOTATION MARK
				case "23": return "0023"; break; #NUMBER SIGN
				case "24": return "0024"; break; #DOLLAR SIGN
				case "25": return "0025"; break; #PERCENT SIGN
				case "26": return "0026"; break; #AMPERSAND
				case "27": return "0027"; break; #APOSTROPHE
				case "28": return "0028"; break; #LEFT PARENTHESIS
				case "29": return "0029"; break; #RIGHT PARENTHESIS
				case "2A": return "002A"; break; #ASTERISK
				case "2B": return "002B"; break; #PLUS SIGN
				case "2C": return "002C"; break; #COMMA
				case "2D": return "002D"; break; #HYPHEN-MINUS
				case "2E": return "002E"; break; #FULL STOP
				case "2F": return "002F"; break; #SOLIDUS
				case "30": return "0030"; break; #DIGIT ZERO
				case "31": return "0031"; break; #DIGIT ONE
				case "32": return "0032"; break; #DIGIT TWO
				case "33": return "0033"; break; #DIGIT THREE
				case "34": return "0034"; break; #DIGIT FOUR
				case "35": return "0035"; break; #DIGIT FIVE
				case "36": return "0036"; break; #DIGIT SIX
				case "37": return "0037"; break; #DIGIT SEVEN
				case "38": return "0038"; break; #DIGIT EIGHT
				case "39": return "0039"; break; #DIGIT NINE
				case "3A": return "003A"; break; #COLON
				case "3B": return "003B"; break; #SEMICOLON
				case "3C": return "003C"; break; #LESS-THAN SIGN
				case "3D": return "003D"; break; #EQUALS SIGN
				case "3E": return "003E"; break; #GREATER-THAN SIGN
				case "3F": return "003F"; break; #QUESTION MARK
				case "40": return "0040"; break; #COMMERCIAL AT
				case "41": return "0041"; break; #LATIN CAPITAL LETTER A
				case "42": return "0042"; break; #LATIN CAPITAL LETTER B
				case "43": return "0043"; break; #LATIN CAPITAL LETTER C
				case "44": return "0044"; break; #LATIN CAPITAL LETTER D
				case "45": return "0045"; break; #LATIN CAPITAL LETTER E
				case "46": return "0046"; break; #LATIN CAPITAL LETTER F
				case "47": return "0047"; break; #LATIN CAPITAL LETTER G
				case "48": return "0048"; break; #LATIN CAPITAL LETTER H
				case "49": return "0049"; break; #LATIN CAPITAL LETTER I
				case "4A": return "004A"; break; #LATIN CAPITAL LETTER J
				case "4B": return "004B"; break; #LATIN CAPITAL LETTER K
				case "4C": return "004C"; break; #LATIN CAPITAL LETTER L
				case "4D": return "004D"; break; #LATIN CAPITAL LETTER M
				case "4E": return "004E"; break; #LATIN CAPITAL LETTER N
				case "4F": return "004F"; break; #LATIN CAPITAL LETTER O
				case "50": return "0050"; break; #LATIN CAPITAL LETTER P
				case "51": return "0051"; break; #LATIN CAPITAL LETTER Q
				case "52": return "0052"; break; #LATIN CAPITAL LETTER R
				case "53": return "0053"; break; #LATIN CAPITAL LETTER S
				case "54": return "0054"; break; #LATIN CAPITAL LETTER T
				case "55": return "0055"; break; #LATIN CAPITAL LETTER U
				case "56": return "0056"; break; #LATIN CAPITAL LETTER V
				case "57": return "0057"; break; #LATIN CAPITAL LETTER W
				case "58": return "0058"; break; #LATIN CAPITAL LETTER X
				case "59": return "0059"; break; #LATIN CAPITAL LETTER Y
				case "5A": return "005A"; break; #LATIN CAPITAL LETTER Z
				case "5B": return "005B"; break; #LEFT SQUARE BRACKET
				case "5C": return "005C"; break; #REVERSE SOLIDUS
				case "5D": return "005D"; break; #RIGHT SQUARE BRACKET
				case "5E": return "005E"; break; #CIRCUMFLEX ACCENT
				case "5F": return "005F"; break; #LOW LINE
				case "60": return "0060"; break; #GRAVE ACCENT
				case "61": return "0061"; break; #LATIN SMALL LETTER A
				case "62": return "0062"; break; #LATIN SMALL LETTER B
				case "63": return "0063"; break; #LATIN SMALL LETTER C
				case "64": return "0064"; break; #LATIN SMALL LETTER D
				case "65": return "0065"; break; #LATIN SMALL LETTER E
				case "66": return "0066"; break; #LATIN SMALL LETTER F
				case "67": return "0067"; break; #LATIN SMALL LETTER G
				case "68": return "0068"; break; #LATIN SMALL LETTER H
				case "69": return "0069"; break; #LATIN SMALL LETTER I
				case "6A": return "006A"; break; #LATIN SMALL LETTER J
				case "6B": return "006B"; break; #LATIN SMALL LETTER K
				case "6C": return "006C"; break; #LATIN SMALL LETTER L
				case "6D": return "006D"; break; #LATIN SMALL LETTER M
				case "6E": return "006E"; break; #LATIN SMALL LETTER N
				case "6F": return "006F"; break; #LATIN SMALL LETTER O
				case "70": return "0070"; break; #LATIN SMALL LETTER P
				case "71": return "0071"; break; #LATIN SMALL LETTER Q
				case "72": return "0072"; break; #LATIN SMALL LETTER R
				case "73": return "0073"; break; #LATIN SMALL LETTER S
				case "74": return "0074"; break; #LATIN SMALL LETTER T
				case "75": return "0075"; break; #LATIN SMALL LETTER U
				case "76": return "0076"; break; #LATIN SMALL LETTER V
				case "77": return "0077"; break; #LATIN SMALL LETTER W
				case "78": return "0078"; break; #LATIN SMALL LETTER X
				case "79": return "0079"; break; #LATIN SMALL LETTER Y
				case "7A": return "007A"; break; #LATIN SMALL LETTER Z
				case "7B": return "007B"; break; #LEFT CURLY BRACKET
				case "7C": return "007C"; break; #VERTICAL LINE
				case "7D": return "007D"; break; #RIGHT CURLY BRACKET
				case "7E": return "007E"; break; #TILDE
				case "7F": return "007F"; break; #DELETE
				case "80": return "00C4"; break; #LATIN CAPITAL LETTER A WITH DIAERESIS
				case "81": return "0100"; break; #LATIN CAPITAL LETTER A WITH MACRON
				case "82": return "0101"; break; #LATIN SMALL LETTER A WITH MACRON
				case "83": return "00C9"; break; #LATIN CAPITAL LETTER E WITH ACUTE
				case "84": return "0104"; break; #LATIN CAPITAL LETTER A WITH OGONEK
				case "85": return "00D6"; break; #LATIN CAPITAL LETTER O WITH DIAERESIS
				case "86": return "00DC"; break; #LATIN CAPITAL LETTER U WITH DIAERESIS
				case "87": return "00E1"; break; #LATIN SMALL LETTER A WITH ACUTE
				case "88": return "0105"; break; #LATIN SMALL LETTER A WITH OGONEK
				case "89": return "010C"; break; #LATIN CAPITAL LETTER C WITH CARON
				case "8A": return "00E4"; break; #LATIN SMALL LETTER A WITH DIAERESIS
				case "8B": return "010D"; break; #LATIN SMALL LETTER C WITH CARON
				case "8C": return "0106"; break; #LATIN CAPITAL LETTER C WITH ACUTE
				case "8D": return "0107"; break; #LATIN SMALL LETTER C WITH ACUTE
				case "8E": return "00E9"; break; #LATIN SMALL LETTER E WITH ACUTE
				case "8F": return "0179"; break; #LATIN CAPITAL LETTER Z WITH ACUTE
				case "90": return "017A"; break; #LATIN SMALL LETTER Z WITH ACUTE
				case "91": return "010E"; break; #LATIN CAPITAL LETTER D WITH CARON
				case "92": return "00ED"; break; #LATIN SMALL LETTER I WITH ACUTE
				case "93": return "010F"; break; #LATIN SMALL LETTER D WITH CARON
				case "94": return "0112"; break; #LATIN CAPITAL LETTER E WITH MACRON
				case "95": return "0113"; break; #LATIN SMALL LETTER E WITH MACRON
				case "96": return "0116"; break; #LATIN CAPITAL LETTER E WITH DOT ABOVE
				case "97": return "00F3"; break; #LATIN SMALL LETTER O WITH ACUTE
				case "98": return "0117"; break; #LATIN SMALL LETTER E WITH DOT ABOVE
				case "99": return "00F4"; break; #LATIN SMALL LETTER O WITH CIRCUMFLEX
				case "9A": return "00F6"; break; #LATIN SMALL LETTER O WITH DIAERESIS
				case "9B": return "00F5"; break; #LATIN SMALL LETTER O WITH TILDE
				case "9C": return "00FA"; break; #LATIN SMALL LETTER U WITH ACUTE
				case "9D": return "011A"; break; #LATIN CAPITAL LETTER E WITH CARON
				case "9E": return "011B"; break; #LATIN SMALL LETTER E WITH CARON
				case "9F": return "00FC"; break; #LATIN SMALL LETTER U WITH DIAERESIS
				case "A0": return "2020"; break; #DAGGER
				case "A1": return "00B0"; break; #DEGREE SIGN
				case "A2": return "0118"; break; #LATIN CAPITAL LETTER E WITH OGONEK
				case "A3": return "00A3"; break; #POUND SIGN
				case "A4": return "00A7"; break; #SECTION SIGN
				case "A5": return "2022"; break; #BULLET
				case "A6": return "00B6"; break; #PILCROW SIGN
				case "A7": return "00DF"; break; #LATIN SMALL LETTER SHARP S
				case "A8": return "00AE"; break; #REGISTERED SIGN
				case "A9": return "00A9"; break; #COPYRIGHT SIGN
				case "AA": return "2122"; break; #TRADE MARK SIGN
				case "AB": return "0119"; break; #LATIN SMALL LETTER E WITH OGONEK
				case "AC": return "00A8"; break; #DIAERESIS
				case "AD": return "2260"; break; #NOT EQUAL TO
				case "AE": return "0123"; break; #LATIN SMALL LETTER G WITH CEDILLA
				case "AF": return "012E"; break; #LATIN CAPITAL LETTER I WITH OGONEK
				case "B0": return "012F"; break; #LATIN SMALL LETTER I WITH OGONEK
				case "B1": return "012A"; break; #LATIN CAPITAL LETTER I WITH MACRON
				case "B2": return "2264"; break; #LESS-THAN OR EQUAL TO
				case "B3": return "2265"; break; #GREATER-THAN OR EQUAL TO
				case "B4": return "012B"; break; #LATIN SMALL LETTER I WITH MACRON
				case "B5": return "0136"; break; #LATIN CAPITAL LETTER K WITH CEDILLA
				case "B6": return "2202"; break; #PARTIAL DIFFERENTIAL
				case "B7": return "2211"; break; #N-ARY SUMMATION
				case "B8": return "0142"; break; #LATIN SMALL LETTER L WITH STROKE
				case "B9": return "013B"; break; #LATIN CAPITAL LETTER L WITH CEDILLA
				case "BA": return "013C"; break; #LATIN SMALL LETTER L WITH CEDILLA
				case "BB": return "013D"; break; #LATIN CAPITAL LETTER L WITH CARON
				case "BC": return "013E"; break; #LATIN SMALL LETTER L WITH CARON
				case "BD": return "0139"; break; #LATIN CAPITAL LETTER L WITH ACUTE
				case "BE": return "013A"; break; #LATIN SMALL LETTER L WITH ACUTE
				case "BF": return "0145"; break; #LATIN CAPITAL LETTER N WITH CEDILLA
				case "C0": return "0146"; break; #LATIN SMALL LETTER N WITH CEDILLA
				case "C1": return "0143"; break; #LATIN CAPITAL LETTER N WITH ACUTE
				case "C2": return "00AC"; break; #NOT SIGN
				case "C3": return "221A"; break; #SQUARE ROOT
				case "C4": return "0144"; break; #LATIN SMALL LETTER N WITH ACUTE
				case "C5": return "0147"; break; #LATIN CAPITAL LETTER N WITH CARON
				case "C6": return "2206"; break; #INCREMENT
				case "C7": return "00AB"; break; #LEFT-POINTING DOUBLE ANGLE QUOTATION MARK
				case "C8": return "00BB"; break; #RIGHT-POINTING DOUBLE ANGLE QUOTATION MARK
				case "C9": return "2026"; break; #HORIZONTAL ELLIPSIS
				case "CA": return "00A0"; break; #NO-BREAK SPACE
				case "CB": return "0148"; break; #LATIN SMALL LETTER N WITH CARON
				case "CC": return "0150"; break; #LATIN CAPITAL LETTER O WITH DOUBLE ACUTE
				case "CD": return "00D5"; break; #LATIN CAPITAL LETTER O WITH TILDE
				case "CE": return "0151"; break; #LATIN SMALL LETTER O WITH DOUBLE ACUTE
				case "CF": return "014C"; break; #LATIN CAPITAL LETTER O WITH MACRON
				case "D0": return "2013"; break; #EN DASH
				case "D1": return "2014"; break; #EM DASH
				case "D2": return "201C"; break; #LEFT DOUBLE QUOTATION MARK
				case "D3": return "201D"; break; #RIGHT DOUBLE QUOTATION MARK
				case "D4": return "2018"; break; #LEFT SINGLE QUOTATION MARK
				case "D5": return "2019"; break; #RIGHT SINGLE QUOTATION MARK
				case "D6": return "00F7"; break; #DIVISION SIGN
				case "D7": return "25CA"; break; #LOZENGE
				case "D8": return "014D"; break; #LATIN SMALL LETTER O WITH MACRON
				case "D9": return "0154"; break; #LATIN CAPITAL LETTER R WITH ACUTE
				case "DA": return "0155"; break; #LATIN SMALL LETTER R WITH ACUTE
				case "DB": return "0158"; break; #LATIN CAPITAL LETTER R WITH CARON
				case "DC": return "2039"; break; #SINGLE LEFT-POINTING ANGLE QUOTATION MARK
				case "DD": return "203A"; break; #SINGLE RIGHT-POINTING ANGLE QUOTATION MARK
				case "DE": return "0159"; break; #LATIN SMALL LETTER R WITH CARON
				case "DF": return "0156"; break; #LATIN CAPITAL LETTER R WITH CEDILLA
				case "E0": return "0157"; break; #LATIN SMALL LETTER R WITH CEDILLA
				case "E1": return "0160"; break; #LATIN CAPITAL LETTER S WITH CARON
				case "E2": return "201A"; break; #SINGLE LOW-9 QUOTATION MARK
				case "E3": return "201E"; break; #DOUBLE LOW-9 QUOTATION MARK
				case "E4": return "0161"; break; #LATIN SMALL LETTER S WITH CARON
				case "E5": return "015A"; break; #LATIN CAPITAL LETTER S WITH ACUTE
				case "E6": return "015B"; break; #LATIN SMALL LETTER S WITH ACUTE
				case "E7": return "00C1"; break; #LATIN CAPITAL LETTER A WITH ACUTE
				case "E8": return "0164"; break; #LATIN CAPITAL LETTER T WITH CARON
				case "E9": return "0165"; break; #LATIN SMALL LETTER T WITH CARON
				case "EA": return "00CD"; break; #LATIN CAPITAL LETTER I WITH ACUTE
				case "EB": return "017D"; break; #LATIN CAPITAL LETTER Z WITH CARON
				case "EC": return "017E"; break; #LATIN SMALL LETTER Z WITH CARON
				case "ED": return "016A"; break; #LATIN CAPITAL LETTER U WITH MACRON
				case "EE": return "00D3"; break; #LATIN CAPITAL LETTER O WITH ACUTE
				case "EF": return "00D4"; break; #LATIN CAPITAL LETTER O WITH CIRCUMFLEX
				case "F0": return "016B"; break; #LATIN SMALL LETTER U WITH MACRON
				case "F1": return "016E"; break; #LATIN CAPITAL LETTER U WITH RING ABOVE
				case "F2": return "00DA"; break; #LATIN CAPITAL LETTER U WITH ACUTE
				case "F3": return "016F"; break; #LATIN SMALL LETTER U WITH RING ABOVE
				case "F4": return "0170"; break; #LATIN CAPITAL LETTER U WITH DOUBLE ACUTE
				case "F5": return "0171"; break; #LATIN SMALL LETTER U WITH DOUBLE ACUTE
				case "F6": return "0172"; break; #LATIN CAPITAL LETTER U WITH OGONEK
				case "F7": return "0173"; break; #LATIN SMALL LETTER U WITH OGONEK
				case "F8": return "00DD"; break; #LATIN CAPITAL LETTER Y WITH ACUTE
				case "F9": return "00FD"; break; #LATIN SMALL LETTER Y WITH ACUTE
				case "FA": return "0137"; break; #LATIN SMALL LETTER K WITH CEDILLA
				case "FB": return "017B"; break; #LATIN CAPITAL LETTER Z WITH DOT ABOVE
				case "FC": return "0141"; break; #LATIN CAPITAL LETTER L WITH STROKE
				case "FD": return "017C"; break; #LATIN SMALL LETTER Z WITH DOT ABOVE
				case "FE": return "0122"; break; #LATIN CAPITAL LETTER G WITH CEDILLA
				case "FF": return "02C7"; break; #CARON

			}


		}


		#    Name:     cp1251 to Unicode table
		function cp1251_to_unicode($code){

			switch($code){
				case "00" : return "0000";break;	#NULL
				case "01" : return "0001";break;	#START OF HEADING
				case "02" : return "0002";break;	#START OF TEXT
				case "03" : return "0003";break;	#END OF TEXT
				case "04" : return "0004";break;	#END OF TRANSMISSION
				case "05" : return "0005";break;	#ENQUIRY
				case "06" : return "0006";break;	#ACKNOWLEDGE
				case "07" : return "0007";break;	#BELL
				case "08" : return "0008";break;	#BACKSPACE
				case "09" : return "0009";break;	#HORIZONTAL TABULATION
				case "0A" : return "000A";break;	#LINE FEED
				case "0B" : return "000B";break;	#VERTICAL TABULATION
				case "0C" : return "000C";break;	#FORM FEED
				case "0D" : return "000D";break;	#CARRIAGE RETURN
				case "0E" : return "000E";break;	#SHIFT OUT
				case "0F" : return "000F";break;	#SHIFT IN
				case "10" : return "0010";break;	#DATA LINK ESCAPE
				case "11" : return "0011";break;	#DEVICE CONTROL ONE
				case "12" : return "0012";break;	#DEVICE CONTROL TWO
				case "13" : return "0013";break;	#DEVICE CONTROL THREE
				case "14" : return "0014";break;	#DEVICE CONTROL FOUR
				case "15" : return "0015";break;	#NEGATIVE ACKNOWLEDGE
				case "16" : return "0016";break;	#SYNCHRONOUS IDLE
				case "17" : return "0017";break;	#END OF TRANSMISSION BLOCK
				case "18" : return "0018";break;	#CANCEL
				case "19" : return "0019";break;	#END OF MEDIUM
				case "1A" : return "001A";break;	#SUBSTITUTE
				case "1B" : return "001B";break;	#ESCAPE
				case "1C" : return "001C";break;	#FILE SEPARATOR
				case "1D" : return "001D";break;	#GROUP SEPARATOR
				case "1E" : return "001E";break;	#RECORD SEPARATOR
				case "1F" : return "001F";break;	#UNIT SEPARATOR
				case "20" : return "0020";break;	#SPACE
				case "21" : return "0021";break;	#EXCLAMATION MARK
				case "22" : return "0022";break;	#QUOTATION MARK
				case "23" : return "0023";break;	#NUMBER SIGN
				case "24" : return "0024";break;	#DOLLAR SIGN
				case "25" : return "0025";break;	#PERCENT SIGN
				case "26" : return "0026";break;	#AMPERSAND
				case "27" : return "0027";break;	#APOSTROPHE
				case "28" : return "0028";break;	#LEFT PARENTHESIS
				case "29" : return "0029";break;	#RIGHT PARENTHESIS
				case "2A" : return "002A";break;	#ASTERISK
				case "2B" : return "002B";break;	#PLUS SIGN
				case "2C" : return "002C";break;	#COMMA
				case "2D" : return "002D";break;	#HYPHEN-MINUS
				case "2E" : return "002E";break;	#FULL STOP
				case "2F" : return "002F";break;	#SOLIDUS
				case "30" : return "0030";break;	#DIGIT ZERO
				case "31" : return "0031";break;	#DIGIT ONE
				case "32" : return "0032";break;	#DIGIT TWO
				case "33" : return "0033";break;	#DIGIT THREE
				case "34" : return "0034";break;	#DIGIT FOUR
				case "35" : return "0035";break;	#DIGIT FIVE
				case "36" : return "0036";break;	#DIGIT SIX
				case "37" : return "0037";break;	#DIGIT SEVEN
				case "38" : return "0038";break;	#DIGIT EIGHT
				case "39" : return "0039";break;	#DIGIT NINE
				case "3A" : return "003A";break;	#COLON
				case "3B" : return "003B";break;	#SEMICOLON
				case "3C" : return "003C";break;	#LESS-THAN SIGN
				case "3D" : return "003D";break;	#EQUALS SIGN
				case "3E" : return "003E";break;	#GREATER-THAN SIGN
				case "3F" : return "003F";break;	#QUESTION MARK
				case "40" : return "0040";break;	#COMMERCIAL AT
				case "41" : return "0041";break;	#LATIN CAPITAL LETTER A
				case "42" : return "0042";break;	#LATIN CAPITAL LETTER B
				case "43" : return "0043";break;	#LATIN CAPITAL LETTER C
				case "44" : return "0044";break;	#LATIN CAPITAL LETTER D
				case "45" : return "0045";break;	#LATIN CAPITAL LETTER E
				case "46" : return "0046";break;	#LATIN CAPITAL LETTER F
				case "47" : return "0047";break;	#LATIN CAPITAL LETTER G
				case "48" : return "0048";break;	#LATIN CAPITAL LETTER H
				case "49" : return "0049";break;	#LATIN CAPITAL LETTER I
				case "4A" : return "004A";break;	#LATIN CAPITAL LETTER J
				case "4B" : return "004B";break;	#LATIN CAPITAL LETTER K
				case "4C" : return "004C";break;	#LATIN CAPITAL LETTER L
				case "4D" : return "004D";break;	#LATIN CAPITAL LETTER M
				case "4E" : return "004E";break;	#LATIN CAPITAL LETTER N
				case "4F" : return "004F";break;	#LATIN CAPITAL LETTER O
				case "50" : return "0050";break;	#LATIN CAPITAL LETTER P
				case "51" : return "0051";break;	#LATIN CAPITAL LETTER Q
				case "52" : return "0052";break;	#LATIN CAPITAL LETTER R
				case "53" : return "0053";break;	#LATIN CAPITAL LETTER S
				case "54" : return "0054";break;	#LATIN CAPITAL LETTER T
				case "55" : return "0055";break;	#LATIN CAPITAL LETTER U
				case "56" : return "0056";break;	#LATIN CAPITAL LETTER V
				case "57" : return "0057";break;	#LATIN CAPITAL LETTER W
				case "58" : return "0058";break;	#LATIN CAPITAL LETTER X
				case "59" : return "0059";break;	#LATIN CAPITAL LETTER Y
				case "5A" : return "005A";break;	#LATIN CAPITAL LETTER Z
				case "5B" : return "005B";break;	#LEFT SQUARE BRACKET
				case "5C" : return "005C";break;	#REVERSE SOLIDUS
				case "5D" : return "005D";break;	#RIGHT SQUARE BRACKET
				case "5E" : return "005E";break;	#CIRCUMFLEX ACCENT
				case "5F" : return "005F";break;	#LOW LINE
				case "60" : return "0060";break;	#GRAVE ACCENT
				case "61" : return "0061";break;	#LATIN SMALL LETTER A
				case "62" : return "0062";break;	#LATIN SMALL LETTER B
				case "63" : return "0063";break;	#LATIN SMALL LETTER C
				case "64" : return "0064";break;	#LATIN SMALL LETTER D
				case "65" : return "0065";break;	#LATIN SMALL LETTER E
				case "66" : return "0066";break;	#LATIN SMALL LETTER F
				case "67" : return "0067";break;	#LATIN SMALL LETTER G
				case "68" : return "0068";break;	#LATIN SMALL LETTER H
				case "69" : return "0069";break;	#LATIN SMALL LETTER I
				case "6A" : return "006A";break;	#LATIN SMALL LETTER J
				case "6B" : return "006B";break;	#LATIN SMALL LETTER K
				case "6C" : return "006C";break;	#LATIN SMALL LETTER L
				case "6D" : return "006D";break;	#LATIN SMALL LETTER M
				case "6E" : return "006E";break;	#LATIN SMALL LETTER N
				case "6F" : return "006F";break;	#LATIN SMALL LETTER O
				case "70" : return "0070";break;	#LATIN SMALL LETTER P
				case "71" : return "0071";break;	#LATIN SMALL LETTER Q
				case "72" : return "0072";break;	#LATIN SMALL LETTER R
				case "73" : return "0073";break;	#LATIN SMALL LETTER S
				case "74" : return "0074";break;	#LATIN SMALL LETTER T
				case "75" : return "0075";break;	#LATIN SMALL LETTER U
				case "76" : return "0076";break;	#LATIN SMALL LETTER V
				case "77" : return "0077";break;	#LATIN SMALL LETTER W
				case "78" : return "0078";break;	#LATIN SMALL LETTER X
				case "79" : return "0079";break;	#LATIN SMALL LETTER Y
				case "7A" : return "007A";break;	#LATIN SMALL LETTER Z
				case "7B" : return "007B";break;	#LEFT CURLY BRACKET
				case "7C" : return "007C";break;	#VERTICAL LINE
				case "7D" : return "007D";break;	#RIGHT CURLY BRACKET
				case "7E" : return "007E";break;	#TILDE
				case "7F" : return "007F";break;	#DELETE
				case "80" : return "0402";break;	#CYRILLIC CAPITAL LETTER DJE
				case "81" : return "0403";break;	#CYRILLIC CAPITAL LETTER GJE
				case "82" : return "201A";break;	#SINGLE LOW-9 QUOTATION MARK
				case "83" : return "0453";break;	#CYRILLIC SMALL LETTER GJE
				case "84" : return "201E";break;	#DOUBLE LOW-9 QUOTATION MARK
				case "85" : return "2026";break;	#HORIZONTAL ELLIPSIS
				case "86" : return "2020";break;	#DAGGER
				case "87" : return "2021";break;	#DOUBLE DAGGER
				case "88" : return "20AC";break;	#EURO SIGN
				case "89" : return "2030";break;	#PER MILLE SIGN
				case "8A" : return "0409";break;	#CYRILLIC CAPITAL LETTER LJE
				case "8B" : return "2039";break;	#SINGLE LEFT-POINTING ANGLE QUOTATION MARK
				case "8C" : return "040A";break;	#CYRILLIC CAPITAL LETTER NJE
				case "8D" : return "040C";break;	#CYRILLIC CAPITAL LETTER KJE
				case "8E" : return "040B";break;	#CYRILLIC CAPITAL LETTER TSHE
				case "8F" : return "040F";break;	#CYRILLIC CAPITAL LETTER DZHE
				case "90" : return "0452";break;	#CYRILLIC SMALL LETTER DJE
				case "91" : return "2018";break;	#LEFT SINGLE QUOTATION MARK
				case "92" : return "2019";break;	#RIGHT SINGLE QUOTATION MARK
				case "93" : return "201C";break;	#LEFT DOUBLE QUOTATION MARK
				case "94" : return "201D";break;	#RIGHT DOUBLE QUOTATION MARK
				case "95" : return "2022";break;	#BULLET
				case "96" : return "2013";break;	#EN DASH
				case "97" : return "2014";break;	#EM DASH
				case "98" : return "      ";break;	#UNDEFINED
				case "99" : return "2122";break;	#TRADE MARK SIGN
				case "9A" : return "0459";break;	#CYRILLIC SMALL LETTER LJE
				case "9B" : return "203A";break;	#SINGLE RIGHT-POINTING ANGLE QUOTATION MARK
				case "9C" : return "045A";break;	#CYRILLIC SMALL LETTER NJE
				case "9D" : return "045C";break;	#CYRILLIC SMALL LETTER KJE
				case "9E" : return "045B";break;	#CYRILLIC SMALL LETTER TSHE
				case "9F" : return "045F";break;	#CYRILLIC SMALL LETTER DZHE
				case "A0" : return "00A0";break;	#NO-BREAK SPACE
				case "A1" : return "040E";break;	#CYRILLIC CAPITAL LETTER SHORT U
				case "A2" : return "045E";break;	#CYRILLIC SMALL LETTER SHORT U
				case "A3" : return "0408";break;	#CYRILLIC CAPITAL LETTER JE
				case "A4" : return "00A4";break;	#CURRENCY SIGN
				case "A5" : return "0490";break;	#CYRILLIC CAPITAL LETTER GHE WITH UPTURN
				case "A6" : return "00A6";break;	#BROKEN BAR
				case "A7" : return "00A7";break;	#SECTION SIGN
				case "A8" : return "0401";break;	#CYRILLIC CAPITAL LETTER IO
				case "A9" : return "00A9";break;	#COPYRIGHT SIGN
				case "AA" : return "0404";break;	#CYRILLIC CAPITAL LETTER UKRAINIAN IE
				case "AB" : return "00AB";break;	#LEFT-POINTING DOUBLE ANGLE QUOTATION MARK
				case "AC" : return "00AC";break;	#NOT SIGN
				case "AD" : return "00AD";break;	#SOFT HYPHEN
				case "AE" : return "00AE";break;	#REGISTERED SIGN
				case "AF" : return "0407";break;	#CYRILLIC CAPITAL LETTER YI
				case "B0" : return "00B0";break;	#DEGREE SIGN
				case "B1" : return "00B1";break;	#PLUS-MINUS SIGN
				case "B2" : return "0406";break;	#CYRILLIC CAPITAL LETTER BYELORUSSIAN-UKRAINIAN I
				case "B3" : return "0456";break;	#CYRILLIC SMALL LETTER BYELORUSSIAN-UKRAINIAN I
				case "B4" : return "0491";break;	#CYRILLIC SMALL LETTER GHE WITH UPTURN
				case "B5" : return "00B5";break;	#MICRO SIGN
				case "B6" : return "00B6";break;	#PILCROW SIGN
				case "B7" : return "00B7";break;	#MIDDLE DOT
				case "B8" : return "0451";break;	#CYRILLIC SMALL LETTER IO
				case "B9" : return "2116";break;	#NUMERO SIGN
				case "BA" : return "0454";break;	#CYRILLIC SMALL LETTER UKRAINIAN IE
				case "BB" : return "00BB";break;	#RIGHT-POINTING DOUBLE ANGLE QUOTATION MARK
				case "BC" : return "0458";break;	#CYRILLIC SMALL LETTER JE
				case "BD" : return "0405";break;	#CYRILLIC CAPITAL LETTER DZE
				case "BE" : return "0455";break;	#CYRILLIC SMALL LETTER DZE
				case "BF" : return "0457";break;	#CYRILLIC SMALL LETTER YI
				case "C0" : return "0410";break;	#CYRILLIC CAPITAL LETTER A
				case "C1" : return "0411";break;	#CYRILLIC CAPITAL LETTER BE
				case "C2" : return "0412";break;	#CYRILLIC CAPITAL LETTER VE
				case "C3" : return "0413";break;	#CYRILLIC CAPITAL LETTER GHE
				case "C4" : return "0414";break;	#CYRILLIC CAPITAL LETTER DE
				case "C5" : return "0415";break;	#CYRILLIC CAPITAL LETTER IE
				case "C6" : return "0416";break;	#CYRILLIC CAPITAL LETTER ZHE
				case "C7" : return "0417";break;	#CYRILLIC CAPITAL LETTER ZE
				case "C8" : return "0418";break;	#CYRILLIC CAPITAL LETTER I
				case "C9" : return "0419";break;	#CYRILLIC CAPITAL LETTER SHORT I
				case "CA" : return "041A";break;	#CYRILLIC CAPITAL LETTER KA
				case "CB" : return "041B";break;	#CYRILLIC CAPITAL LETTER EL
				case "CC" : return "041C";break;	#CYRILLIC CAPITAL LETTER EM
				case "CD" : return "041D";break;	#CYRILLIC CAPITAL LETTER EN
				case "CE" : return "041E";break;	#CYRILLIC CAPITAL LETTER O
				case "CF" : return "041F";break;	#CYRILLIC CAPITAL LETTER PE
				case "D0" : return "0420";break;	#CYRILLIC CAPITAL LETTER ER
				case "D1" : return "0421";break;	#CYRILLIC CAPITAL LETTER ES
				case "D2" : return "0422";break;	#CYRILLIC CAPITAL LETTER TE
				case "D3" : return "0423";break;	#CYRILLIC CAPITAL LETTER U
				case "D4" : return "0424";break;	#CYRILLIC CAPITAL LETTER EF
				case "D5" : return "0425";break;	#CYRILLIC CAPITAL LETTER HA
				case "D6" : return "0426";break;	#CYRILLIC CAPITAL LETTER TSE
				case "D7" : return "0427";break;	#CYRILLIC CAPITAL LETTER CHE
				case "D8" : return "0428";break;	#CYRILLIC CAPITAL LETTER SHA
				case "D9" : return "0429";break;	#CYRILLIC CAPITAL LETTER SHCHA
				case "DA" : return "042A";break;	#CYRILLIC CAPITAL LETTER HARD SIGN
				case "DB" : return "042B";break;	#CYRILLIC CAPITAL LETTER YERU
				case "DC" : return "042C";break;	#CYRILLIC CAPITAL LETTER SOFT SIGN
				case "DD" : return "042D";break;	#CYRILLIC CAPITAL LETTER E
				case "DE" : return "042E";break;	#CYRILLIC CAPITAL LETTER YU
				case "DF" : return "042F";break;	#CYRILLIC CAPITAL LETTER YA
				case "E0" : return "0430";break;	#CYRILLIC SMALL LETTER A
				case "E1" : return "0431";break;	#CYRILLIC SMALL LETTER BE
				case "E2" : return "0432";break;	#CYRILLIC SMALL LETTER VE
				case "E3" : return "0433";break;	#CYRILLIC SMALL LETTER GHE
				case "E4" : return "0434";break;	#CYRILLIC SMALL LETTER DE
				case "E5" : return "0435";break;	#CYRILLIC SMALL LETTER IE
				case "E6" : return "0436";break;	#CYRILLIC SMALL LETTER ZHE
				case "E7" : return "0437";break;	#CYRILLIC SMALL LETTER ZE
				case "E8" : return "0438";break;	#CYRILLIC SMALL LETTER I
				case "E9" : return "0439";break;	#CYRILLIC SMALL LETTER SHORT I
				case "EA" : return "043A";break;	#CYRILLIC SMALL LETTER KA
				case "EB" : return "043B";break;	#CYRILLIC SMALL LETTER EL
				case "EC" : return "043C";break;	#CYRILLIC SMALL LETTER EM
				case "ED" : return "043D";break;	#CYRILLIC SMALL LETTER EN
				case "EE" : return "043E";break;	#CYRILLIC SMALL LETTER O
				case "EF" : return "043F";break;	#CYRILLIC SMALL LETTER PE
				case "F0" : return "0440";break;	#CYRILLIC SMALL LETTER ER
				case "F1" : return "0441";break;	#CYRILLIC SMALL LETTER ES
				case "F2" : return "0442";break;	#CYRILLIC SMALL LETTER TE
				case "F3" : return "0443";break;	#CYRILLIC SMALL LETTER U
				case "F4" : return "0444";break;	#CYRILLIC SMALL LETTER EF
				case "F5" : return "0445";break;	#CYRILLIC SMALL LETTER HA
				case "F6" : return "0446";break;	#CYRILLIC SMALL LETTER TSE
				case "F7" : return "0447";break;	#CYRILLIC SMALL LETTER CHE
				case "F8" : return "0448";break;	#CYRILLIC SMALL LETTER SHA
				case "F9" : return "0449";break;	#CYRILLIC SMALL LETTER SHCHA
				case "FA" : return "044A";break;	#CYRILLIC SMALL LETTER HARD SIGN
				case "FB" : return "044B";break;	#CYRILLIC SMALL LETTER YERU
				case "FC" : return "044C";break;	#CYRILLIC SMALL LETTER SOFT SIGN
				case "FD" : return "044D";break;	#CYRILLIC SMALL LETTER E
				case "FE" : return "044E";break;	#CYRILLIC SMALL LETTER YU
				case "FF" : return "044F";break;	#CYRILLIC SMALL LETTER YA
		}
	}

		function cp1252_to_unicode($code){
			switch($code){
				case "00": return "0000"; break; #NULL
				case "01": return "0001"; break; #START OF HEADING
				case "02": return "0002"; break; #START OF TEXT
				case "03": return "0003"; break; #END OF TEXT
				case "04": return "0004"; break; #END OF TRANSMISSION
				case "05": return "0005"; break; #ENQUIRY
				case "06": return "0006"; break; #ACKNOWLEDGE
				case "07": return "0007"; break; #BELL
				case "08": return "0008"; break; #BACKSPACE
				case "09": return "0009"; break; #HORIZONTAL TABULATION
				case "0A": return "000A"; break; #LINE FEED
				case "0B": return "000B"; break; #VERTICAL TABULATION
				case "0C": return "000C"; break; #FORM FEED
				case "0D": return "000D"; break; #CARRIAGE RETURN
				case "0E": return "000E"; break; #SHIFT OUT
				case "0F": return "000F"; break; #SHIFT IN
				case "10": return "0010"; break; #DATA LINK ESCAPE
				case "11": return "0011"; break; #DEVICE CONTROL ONE
				case "12": return "0012"; break; #DEVICE CONTROL TWO
				case "13": return "0013"; break; #DEVICE CONTROL THREE
				case "14": return "0014"; break; #DEVICE CONTROL FOUR
				case "15": return "0015"; break; #NEGATIVE ACKNOWLEDGE
				case "16": return "0016"; break; #SYNCHRONOUS IDLE
				case "17": return "0017"; break; #END OF TRANSMISSION BLOCK
				case "18": return "0018"; break; #CANCEL
				case "19": return "0019"; break; #END OF MEDIUM
				case "1A": return "001A"; break; #SUBSTITUTE
				case "1B": return "001B"; break; #ESCAPE
				case "1C": return "001C"; break; #FILE SEPARATOR
				case "1D": return "001D"; break; #GROUP SEPARATOR
				case "1E": return "001E"; break; #RECORD SEPARATOR
				case "1F": return "001F"; break; #UNIT SEPARATOR
				case "20": return "0020"; break; #SPACE
				case "21": return "0021"; break; #EXCLAMATION MARK
				case "22": return "0022"; break; #QUOTATION MARK
				case "23": return "0023"; break; #NUMBER SIGN
				case "24": return "0024"; break; #DOLLAR SIGN
				case "25": return "0025"; break; #PERCENT SIGN
				case "26": return "0026"; break; #AMPERSAND
				case "27": return "0027"; break; #APOSTROPHE
				case "28": return "0028"; break; #LEFT PARENTHESIS
				case "29": return "0029"; break; #RIGHT PARENTHESIS
				case "2A": return "002A"; break; #ASTERISK
				case "2B": return "002B"; break; #PLUS SIGN
				case "2C": return "002C"; break; #COMMA
				case "2D": return "002D"; break; #HYPHEN-MINUS
				case "2E": return "002E"; break; #FULL STOP
				case "2F": return "002F"; break; #SOLIDUS
				case "30": return "0030"; break; #DIGIT ZERO
				case "31": return "0031"; break; #DIGIT ONE
				case "32": return "0032"; break; #DIGIT TWO
				case "33": return "0033"; break; #DIGIT THREE
				case "34": return "0034"; break; #DIGIT FOUR
				case "35": return "0035"; break; #DIGIT FIVE
				case "36": return "0036"; break; #DIGIT SIX
				case "37": return "0037"; break; #DIGIT SEVEN
				case "38": return "0038"; break; #DIGIT EIGHT
				case "39": return "0039"; break; #DIGIT NINE
				case "3A": return "003A"; break; #COLON
				case "3B": return "003B"; break; #SEMICOLON
				case "3C": return "003C"; break; #LESS-THAN SIGN
				case "3D": return "003D"; break; #EQUALS SIGN
				case "3E": return "003E"; break; #GREATER-THAN SIGN
				case "3F": return "003F"; break; #QUESTION MARK
				case "40": return "0040"; break; #COMMERCIAL AT
				case "41": return "0041"; break; #LATIN CAPITAL LETTER A
				case "42": return "0042"; break; #LATIN CAPITAL LETTER B
				case "43": return "0043"; break; #LATIN CAPITAL LETTER C
				case "44": return "0044"; break; #LATIN CAPITAL LETTER D
				case "45": return "0045"; break; #LATIN CAPITAL LETTER E
				case "46": return "0046"; break; #LATIN CAPITAL LETTER F
				case "47": return "0047"; break; #LATIN CAPITAL LETTER G
				case "48": return "0048"; break; #LATIN CAPITAL LETTER H
				case "49": return "0049"; break; #LATIN CAPITAL LETTER I
				case "4A": return "004A"; break; #LATIN CAPITAL LETTER J
				case "4B": return "004B"; break; #LATIN CAPITAL LETTER K
				case "4C": return "004C"; break; #LATIN CAPITAL LETTER L
				case "4D": return "004D"; break; #LATIN CAPITAL LETTER M
				case "4E": return "004E"; break; #LATIN CAPITAL LETTER N
				case "4F": return "004F"; break; #LATIN CAPITAL LETTER O
				case "50": return "0050"; break; #LATIN CAPITAL LETTER P
				case "51": return "0051"; break; #LATIN CAPITAL LETTER Q
				case "52": return "0052"; break; #LATIN CAPITAL LETTER R
				case "53": return "0053"; break; #LATIN CAPITAL LETTER S
				case "54": return "0054"; break; #LATIN CAPITAL LETTER T
				case "55": return "0055"; break; #LATIN CAPITAL LETTER U
				case "56": return "0056"; break; #LATIN CAPITAL LETTER V
				case "57": return "0057"; break; #LATIN CAPITAL LETTER W
				case "58": return "0058"; break; #LATIN CAPITAL LETTER X
				case "59": return "0059"; break; #LATIN CAPITAL LETTER Y
				case "5A": return "005A"; break; #LATIN CAPITAL LETTER Z
				case "5B": return "005B"; break; #LEFT SQUARE BRACKET
				case "5C": return "005C"; break; #REVERSE SOLIDUS
				case "5D": return "005D"; break; #RIGHT SQUARE BRACKET
				case "5E": return "005E"; break; #CIRCUMFLEX ACCENT
				case "5F": return "005F"; break; #LOW LINE
				case "60": return "0060"; break; #GRAVE ACCENT
				case "61": return "0061"; break; #LATIN SMALL LETTER A
				case "62": return "0062"; break; #LATIN SMALL LETTER B
				case "63": return "0063"; break; #LATIN SMALL LETTER C
				case "64": return "0064"; break; #LATIN SMALL LETTER D
				case "65": return "0065"; break; #LATIN SMALL LETTER E
				case "66": return "0066"; break; #LATIN SMALL LETTER F
				case "67": return "0067"; break; #LATIN SMALL LETTER G
				case "68": return "0068"; break; #LATIN SMALL LETTER H
				case "69": return "0069"; break; #LATIN SMALL LETTER I
				case "6A": return "006A"; break; #LATIN SMALL LETTER J
				case "6B": return "006B"; break; #LATIN SMALL LETTER K
				case "6C": return "006C"; break; #LATIN SMALL LETTER L
				case "6D": return "006D"; break; #LATIN SMALL LETTER M
				case "6E": return "006E"; break; #LATIN SMALL LETTER N
				case "6F": return "006F"; break; #LATIN SMALL LETTER O
				case "70": return "0070"; break; #LATIN SMALL LETTER P
				case "71": return "0071"; break; #LATIN SMALL LETTER Q
				case "72": return "0072"; break; #LATIN SMALL LETTER R
				case "73": return "0073"; break; #LATIN SMALL LETTER S
				case "74": return "0074"; break; #LATIN SMALL LETTER T
				case "75": return "0075"; break; #LATIN SMALL LETTER U
				case "76": return "0076"; break; #LATIN SMALL LETTER V
				case "77": return "0077"; break; #LATIN SMALL LETTER W
				case "78": return "0078"; break; #LATIN SMALL LETTER X
				case "79": return "0079"; break; #LATIN SMALL LETTER Y
				case "7A": return "007A"; break; #LATIN SMALL LETTER Z
				case "7B": return "007B"; break; #LEFT CURLY BRACKET
				case "7C": return "007C"; break; #VERTICAL LINE
				case "7D": return "007D"; break; #RIGHT CURLY BRACKET
				case "7E": return "007E"; break; #TILDE
				case "7F": return "007F"; break; #DELETE
				case "80": return "20AC"; break; #EURO SIGN
				case "81": return "      "; break; #UNDEFINED
				case "82": return "201A"; break; #SINGLE LOW-9 QUOTATION MARK
				case "83": return "0192"; break; #LATIN SMALL LETTER F WITH HOOK
				case "84": return "201E"; break; #DOUBLE LOW-9 QUOTATION MARK
				case "85": return "2026"; break; #HORIZONTAL ELLIPSIS
				case "86": return "2020"; break; #DAGGER
				case "87": return "2021"; break; #DOUBLE DAGGER
				case "88": return "02C6"; break; #MODIFIER LETTER CIRCUMFLEX ACCENT
				case "89": return "2030"; break; #PER MILLE SIGN
				case "8A": return "0160"; break; #LATIN CAPITAL LETTER S WITH CARON
				case "8B": return "2039"; break; #SINGLE LEFT-POINTING ANGLE QUOTATION MARK
				case "8C": return "0152"; break; #LATIN CAPITAL LIGATURE OE
				case "8D": return "      "; break; #UNDEFINED
				case "8E": return "017D"; break; #LATIN CAPITAL LETTER Z WITH CARON
				case "8F": return "      "; break; #UNDEFINED
				case "90": return "      "; break; #UNDEFINED
				case "91": return "2018"; break; #LEFT SINGLE QUOTATION MARK
				case "92": return "2019"; break; #RIGHT SINGLE QUOTATION MARK
				case "93": return "201C"; break; #LEFT DOUBLE QUOTATION MARK
				case "94": return "201D"; break; #RIGHT DOUBLE QUOTATION MARK
				case "95": return "2022"; break; #BULLET
				case "96": return "2013"; break; #EN DASH
				case "97": return "2014"; break; #EM DASH
				case "98": return "02DC"; break; #SMALL TILDE
				case "99": return "2122"; break; #TRADE MARK SIGN
				case "9A": return "0161"; break; #LATIN SMALL LETTER S WITH CARON
				case "9B": return "203A"; break; #SINGLE RIGHT-POINTING ANGLE QUOTATION MARK
				case "9C": return "0153"; break; #LATIN SMALL LIGATURE OE
				case "9D": return "      "; break; #UNDEFINED
				case "9E": return "017E"; break; #LATIN SMALL LETTER Z WITH CARON
				case "9F": return "0178"; break; #LATIN CAPITAL LETTER Y WITH DIAERESIS
				case "A0": return "00A0"; break; #NO-BREAK SPACE
				case "A1": return "00A1"; break; #INVERTED EXCLAMATION MARK
				case "A2": return "00A2"; break; #CENT SIGN
				case "A3": return "00A3"; break; #POUND SIGN
				case "A4": return "00A4"; break; #CURRENCY SIGN
				case "A5": return "00A5"; break; #YEN SIGN
				case "A6": return "00A6"; break; #BROKEN BAR
				case "A7": return "00A7"; break; #SECTION SIGN
				case "A8": return "00A8"; break; #DIAERESIS
				case "A9": return "00A9"; break; #COPYRIGHT SIGN
				case "AA": return "00AA"; break; #FEMININE ORDINAL INDICATOR
				case "AB": return "00AB"; break; #LEFT-POINTING DOUBLE ANGLE QUOTATION MARK
				case "AC": return "00AC"; break; #NOT SIGN
				case "AD": return "00AD"; break; #SOFT HYPHEN
				case "AE": return "00AE"; break; #REGISTERED SIGN
				case "AF": return "00AF"; break; #MACRON
				case "B0": return "00B0"; break; #DEGREE SIGN
				case "B1": return "00B1"; break; #PLUS-MINUS SIGN
				case "B2": return "00B2"; break; #SUPERSCRIPT TWO
				case "B3": return "00B3"; break; #SUPERSCRIPT THREE
				case "B4": return "00B4"; break; #ACUTE ACCENT
				case "B5": return "00B5"; break; #MICRO SIGN
				case "B6": return "00B6"; break; #PILCROW SIGN
				case "B7": return "00B7"; break; #MIDDLE DOT
				case "B8": return "00B8"; break; #CEDILLA
				case "B9": return "00B9"; break; #SUPERSCRIPT ONE
				case "BA": return "00BA"; break; #MASCULINE ORDINAL INDICATOR
				case "BB": return "00BB"; break; #RIGHT-POINTING DOUBLE ANGLE QUOTATION MARK
				case "BC": return "00BC"; break; #VULGAR FRACTION ONE QUARTER
				case "BD": return "00BD"; break; #VULGAR FRACTION ONE HALF
				case "BE": return "00BE"; break; #VULGAR FRACTION THREE QUARTERS
				case "BF": return "00BF"; break; #INVERTED QUESTION MARK
				case "C0": return "00C0"; break; #LATIN CAPITAL LETTER A WITH GRAVE
				case "C1": return "00C1"; break; #LATIN CAPITAL LETTER A WITH ACUTE
				case "C2": return "00C2"; break; #LATIN CAPITAL LETTER A WITH CIRCUMFLEX
				case "C3": return "00C3"; break; #LATIN CAPITAL LETTER A WITH TILDE
				case "C4": return "00C4"; break; #LATIN CAPITAL LETTER A WITH DIAERESIS
				case "C5": return "00C5"; break; #LATIN CAPITAL LETTER A WITH RING ABOVE
				case "C6": return "00C6"; break; #LATIN CAPITAL LETTER AE
				case "C7": return "00C7"; break; #LATIN CAPITAL LETTER C WITH CEDILLA
				case "C8": return "00C8"; break; #LATIN CAPITAL LETTER E WITH GRAVE
				case "C9": return "00C9"; break; #LATIN CAPITAL LETTER E WITH ACUTE
				case "CA": return "00CA"; break; #LATIN CAPITAL LETTER E WITH CIRCUMFLEX
				case "CB": return "00CB"; break; #LATIN CAPITAL LETTER E WITH DIAERESIS
				case "CC": return "00CC"; break; #LATIN CAPITAL LETTER I WITH GRAVE
				case "CD": return "00CD"; break; #LATIN CAPITAL LETTER I WITH ACUTE
				case "CE": return "00CE"; break; #LATIN CAPITAL LETTER I WITH CIRCUMFLEX
				case "CF": return "00CF"; break; #LATIN CAPITAL LETTER I WITH DIAERESIS
				case "D0": return "00D0"; break; #LATIN CAPITAL LETTER ETH
				case "D1": return "00D1"; break; #LATIN CAPITAL LETTER N WITH TILDE
				case "D2": return "00D2"; break; #LATIN CAPITAL LETTER O WITH GRAVE
				case "D3": return "00D3"; break; #LATIN CAPITAL LETTER O WITH ACUTE
				case "D4": return "00D4"; break; #LATIN CAPITAL LETTER O WITH CIRCUMFLEX
				case "D5": return "00D5"; break; #LATIN CAPITAL LETTER O WITH TILDE
				case "D6": return "00D6"; break; #LATIN CAPITAL LETTER O WITH DIAERESIS
				case "D7": return "00D7"; break; #MULTIPLICATION SIGN
				case "D8": return "00D8"; break; #LATIN CAPITAL LETTER O WITH STROKE
				case "D9": return "00D9"; break; #LATIN CAPITAL LETTER U WITH GRAVE
				case "DA": return "00DA"; break; #LATIN CAPITAL LETTER U WITH ACUTE
				case "DB": return "00DB"; break; #LATIN CAPITAL LETTER U WITH CIRCUMFLEX
				case "DC": return "00DC"; break; #LATIN CAPITAL LETTER U WITH DIAERESIS
				case "DD": return "00DD"; break; #LATIN CAPITAL LETTER Y WITH ACUTE
				case "DE": return "00DE"; break; #LATIN CAPITAL LETTER THORN
				case "DF": return "00DF"; break; #LATIN SMALL LETTER SHARP S
				case "E0": return "00E0"; break; #LATIN SMALL LETTER A WITH GRAVE
				case "E1": return "00E1"; break; #LATIN SMALL LETTER A WITH ACUTE
				case "E2": return "00E2"; break; #LATIN SMALL LETTER A WITH CIRCUMFLEX
				case "E3": return "00E3"; break; #LATIN SMALL LETTER A WITH TILDE
				case "E4": return "00E4"; break; #LATIN SMALL LETTER A WITH DIAERESIS
				case "E5": return "00E5"; break; #LATIN SMALL LETTER A WITH RING ABOVE
				case "E6": return "00E6"; break; #LATIN SMALL LETTER AE
				case "E7": return "00E7"; break; #LATIN SMALL LETTER C WITH CEDILLA
				case "E8": return "00E8"; break; #LATIN SMALL LETTER E WITH GRAVE
				case "E9": return "00E9"; break; #LATIN SMALL LETTER E WITH ACUTE
				case "EA": return "00EA"; break; #LATIN SMALL LETTER E WITH CIRCUMFLEX
				case "EB": return "00EB"; break; #LATIN SMALL LETTER E WITH DIAERESIS
				case "EC": return "00EC"; break; #LATIN SMALL LETTER I WITH GRAVE
				case "ED": return "00ED"; break; #LATIN SMALL LETTER I WITH ACUTE
				case "EE": return "00EE"; break; #LATIN SMALL LETTER I WITH CIRCUMFLEX
				case "EF": return "00EF"; break; #LATIN SMALL LETTER I WITH DIAERESIS
				case "F0": return "00F0"; break; #LATIN SMALL LETTER ETH
				case "F1": return "00F1"; break; #LATIN SMALL LETTER N WITH TILDE
				case "F2": return "00F2"; break; #LATIN SMALL LETTER O WITH GRAVE
				case "F3": return "00F3"; break; #LATIN SMALL LETTER O WITH ACUTE
				case "F4": return "00F4"; break; #LATIN SMALL LETTER O WITH CIRCUMFLEX
				case "F5": return "00F5"; break; #LATIN SMALL LETTER O WITH TILDE
				case "F6": return "00F6"; break; #LATIN SMALL LETTER O WITH DIAERESIS
				case "F7": return "00F7"; break; #DIVISION SIGN
				case "F8": return "00F8"; break; #LATIN SMALL LETTER O WITH STROKE
				case "F9": return "00F9"; break; #LATIN SMALL LETTER U WITH GRAVE
				case "FA": return "00FA"; break; #LATIN SMALL LETTER U WITH ACUTE
				case "FB": return "00FB"; break; #LATIN SMALL LETTER U WITH CIRCUMFLEX
				case "FC": return "00FC"; break; #LATIN SMALL LETTER U WITH DIAERESIS
				case "FD": return "00FD"; break; #LATIN SMALL LETTER Y WITH ACUTE
				case "FE": return "00FE"; break; #LATIN SMALL LETTER THORN
				case "FF": return "00FF"; break; #LATIN SMALL LETTER Y WITH DIAERESIS
			}

		}


}