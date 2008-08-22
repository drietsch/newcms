/* 
 * JavaScript-Klasse fŸr Datum-Handling
 *
 * Die Formatangabe ist MySQL-Konform.
 *
 * Umgesetzte Funktion:
 *   - Umwandlung eines Datums in einen Unix-Timestemp. 
 *   - Umwandlung eines Unix-Timestemps in ein formatiertes Datum.
 */
weDate = function(dateFormat) {
	this.dateFormat = dateFormat || "%d.%m.%Y";
	this.dateOnly   = (dateFormat == null || dateFormat=="" || dateFormat.indexOf('%') > -1) ? true : false;
	this.date       = new Date();
	this.timestemp  = Math.floor(this.date.getTime()/1000);
	this.formatedDate;
	this.debug = "debug: " + this.timestemp + "\n";

	this.dateToTimestemp = function(formDate) {
		var strDate = formDate || null;
		if(strDate) {
			var dateParts = strDate.split(/\W+/);
			var partsFormat = this.dateFormat.match(/%./g);
			for(var i=0; i< dateParts.length; i++) {
				switch(partsFormat[i]) {
					case "%d" :
					case "%j" :
						this.intDayOfMonth = parseInt(dateParts[i], 10);
						break;
					case "%m" :
					case "%n" :
						this.intMonth = parseInt(dateParts[i], 10)-1;
						break;
					case "%Y":
					case "%y":
						this.intYear = parseInt(dateParts[i], 10);
						(this.intYear < 100) && (this.intYear += (this.intYear > 29) ? 1900 : 2000);
						break;

				}
			}
			this.date = new Date(this.intYear, this.intMonth, this.intDayOfMonth,00,00,00,00);
			this.timestemp = Math.floor(this.date.getTime()/1000);
		}
		
		return this.timestemp;
	};
	
	this.timestempToDate = function(timestemp) {
		var intTimestemp = timestemp || null;
		if(intTimestemp) {
			this.date.setTime(parseInt(intTimestemp)*1000);
		}
		var partsFormat = this.dateFormat.match(/%./g);
		var strDate = this.dateFormat;
		for(var i=0; i< partsFormat.length; i++) {
			switch(partsFormat[i]) {
				case "%d" :
				case "%j" :
					tmp = this.date.getDate();
					tmp = (tmp<10 ? "0" : "") + tmp.toString();
					strDate = strDate.replace("%d",tmp);
					strDate = strDate.replace("%j",tmp);
					break;
				case "%m" :
				case "%n" :
					tmp = this.date.getMonth()+1;
					tmp = (tmp<10 ? "0" : "") + tmp.toString();
					strDate = strDate.replace("%m",tmp);
					strDate = strDate.replace("%n",tmp);
					break;
				case "%Y":
				case "%y":
					tmp = this.date.getFullYear();
					tmp = tmp.toString();
					strDate = strDate.replace("%Y",tmp);
					strDate = strDate.replace("%y",tmp);
					break;
			}
		}
		this.formatedDate = strDate;
		return strDate;			
	}
}
