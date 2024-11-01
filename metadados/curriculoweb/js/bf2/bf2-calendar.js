bf2.Calendar = {
	
	EIS_FIX_EI1: function(where2fixit) {
		with (bf2.Calendar) {
			if (!iframeObj2) 
				return;
			iframeObj2.style.display = 'block';
			iframeObj2.style.height = document.getElementById(where2fixit).offsetHeight +1;
			iframeObj2.style.width = document.getElementById(where2fixit).offsetWidth;
			iframeObj2.style.left = getLeftPos(document.getElementById(where2fixit)) +1 -
				calendar_offsetLeft;
			iframeObj2.style.top = getTopPos(document.getElementById(where2fixit)) - 
				document.getElementById(where2fixit).offsetHeight -calendar_offsetTop;
		}
	},
	
	EIS_Hide_Frame: function() {
		with (bf2.Calendar) {
			if (iframeObj2) 
				iframeObj2.style.display = 'none';	
		}
	},
	
	highlightMonthYear: function() {
		with (bf2.Calendar) {
			if (activeSelectBoxMonth)
				activeSelectBoxMonth.className = '';
			activeSelectBox = this;
		
			if (this.className == 'monthYearActive')
				this.className='';
			else {
				this.className = 'monthYearActive';
				activeSelectBoxMonth = this;
			}
		
			if (this.innerHTML.indexOf('-') >= 0 || this.innerHTML.indexOf('+') >= 0) {
				if (this.className == 'monthYearActive')
					selectBoxMovementInProgress = true;
				else selectBoxMovementInProgress = false;
				if (this.innerHTML.indexOf('-') >= 0)
					activeSelectBoxDirection = -1; 
				else activeSelectBoxDirection = 1;
			} else selectBoxMovementInProgress = false;
		}
	},
	
	selectMonth: function() {
		with (bf2.Calendar) {
		  	document.getElementById('calendar_month_txt').innerHTML = this.innerHTML;
		  	currentMonth = this.id.replace(/[^\d]/g, '');
		  	
		  	document.getElementById('monthDropDown').style.display = 'none';
		  	//// fix for EI frame problem on time dropdowns 09/30/2006
				EIS_Hide_Frame();
			for (var no = 0; no < monthArray.length; no++) 
				document.getElementById('monthDiv_' + no).style.color = '';
			this.style.color = selectBoxHighlightColor;
			activeSelectBoxMonth = this;
			writeCalendarContent();
		}
	},
	
	selectYear: function() {
		with (bf2.Calendar) {
			document.getElementById('calendar_year_txt').innerHTML = this.innerHTML;
			currentYear = this.innerHTML.replace(/[^\d]/g,'');
			document.getElementById('yearDropDown').style.display='none';
			//// fix for EI frame problem on time dropdowns 09/30/2006
				EIS_Hide_Frame();
			if (activeSelectBoxYear)
				activeSelectBoxYear.style.color = '';
			activeSelectBoxYear = this;
			this.style.color = selectBoxHighlightColor;
			writeCalendarContent();
		}
	},
	
	switchMonth: function() {
		with (bf2.Calendar) {
			if (this.src.indexOf('left') >= 0) {
				currentMonth = currentMonth -1;
				if (currentMonth < 0) {
					currentMonth = 11;
					currentYear = currentYear -1;
				}
			} else {
				currentMonth = currentMonth +1;
				if (currentMonth > 11) {
					currentMonth=0;
					currentYear = currentYear /1 +1;
				}
			}
			writeCalendarContent();
		}
	},
	
	changeSelectBoxYear: function(e,inputObj) {
		with (bf2.Calendar) {
			if (!inputObj)
				inputObj = this;
			var yearItems = inputObj.parentNode.getElementsByTagName('DIV');
			if (inputObj.innerHTML.indexOf('-') >= 0) {
				var startYear = yearItems[1].innerHTML/1 -1;
				if (activeSelectBoxYear)
					activeSelectBoxYear.style.color='';
			} else {
				var startYear = yearItems[1].innerHTML/1 +1;
				if (activeSelectBoxYear)
					activeSelectBoxYear.style.color='';
			}

			for (var no=1; no < yearItems.length-1; no++) {
				yearItems[no].innerHTML = startYear+no-1;
				yearItems[no].id = 'yearDiv' + (startYear/1+no/1-1);
			}
			if (activeSelectBoxYear) {
				activeSelectBoxYear.style.color='';
				if (document.getElementById('yearDiv' +currentYear)) {
					activeSelectBoxYear = document.getElementById('yearDiv' +currentYear);
					activeSelectBoxYear.style.color = selectBoxHighlightColor;;
				}
			}
		}
	},
	
	highlightSelect: function() {
		with (bf2.Calendar) {
			if (this.className == 'selectBoxTime') {
				this.className = 'selectBoxTimeOver';
				this.getElementsByTagName('IMG')[0].src = pathToImages +'down_time_over.gif';
			} else if (this.className == 'selectBoxTimeOver') {
				this.className = 'selectBoxTime';
				this.getElementsByTagName('IMG')[0].src = pathToImages +'down_time.gif';
			}
		
			if (this.className=='selectBox') {
				this.className = 'selectBoxOver';
				this.getElementsByTagName('IMG')[0].src = pathToImages +'down_over.gif';
			} else if (this.className == 'selectBoxOver') {
				this.className = 'selectBox';
				this.getElementsByTagName('IMG')[0].src = pathToImages +'down.gif';
			}
		}
	},

	highlightArrow: function() {
		with (bf2.Calendar) {
			if (this.src.indexOf('over') >= 0) {
				if (this.src.indexOf('left') >= 0)
					this.src = pathToImages +'left.gif';
				if (this.src.indexOf('right') >= 0)
					this.src = pathToImages +'right.gif';
			} else {
				if (this.src.indexOf('left') >= 0)
					this.src = pathToImages +'left_over.gif';
				if (this.src.indexOf('right') >= 0)
					this.src = pathToImages +'right_over.gif';
			}
		}
	},
	
	highlightClose: function() {
		with (bf2.Calendar) {
			if (this.src.indexOf('over') >= 0)
				this.src = pathToImages +'close.gif';
			else this.src = pathToImages +'close_over.gif';
		}
	},
	
	pickDate: function(e) {
		with (bf2.Calendar) {
			var month = currentMonth/1 +1;
			if (month < 10)
				month = '0' +month;
			
			var day = this.innerHTML /1; 
			if (day < 10)
				day = '0' +day;
				
		  	if (returnFormat) {
		  		returnFormat = returnFormat.replace('dd', day);
		  		returnFormat = returnFormat.replace('mm', month);
		  		returnFormat = returnFormat.replace('yyyy', currentYear);
		  		returnFormat = returnFormat.replace('d', day / 1);
		  		returnFormat = returnFormat.replace('m', month / 1);
		  		
		  		returnDateTo.value = returnFormat;
		  		try {
		  			returnDateTo.onchange();
		  		} catch (e) {}
		  	} else {
		  		for (var no = 0; no < returnDateToYear.options.length; no++) {
		  			if (returnDateToYear.options[no].value == currentYear) {
		  				returnDateToYear.selectedIndex = no;
		  				break;
		  			}
		  		}
		  		for (var no = 0; no < returnDateToMonth.options.length; no++) {
		  			if (returnDateToMonth.options[no].value == parseInt(month)) {
		  				returnDateToMonth.selectedIndex = no;
		  				break;
		  			}
		  		}
		  		for (var no = 0; no < returnDateToDay.options.length; no++) {
		  			if (returnDateToDay.options[no].value == parseInt(day)) {
		  				returnDateToDay.selectedIndex = no;
		  				break;
		  			}
		  		}
		  	}
			closeCalendar();
		}
	},
	
	slideCalendarSelectBox: function(){
		with (bf2.Calendar) {
			if (selectBoxMovementInProgress) {
				if (activeSelectBox.parentNode.id == 'yearDropDown') 
					changeSelectBoxYear(false, activeSelectBox);
			}
			setTimeout('bf2.Calendar.slideCalendarSelectBox()', 200);
		}
	},
	
	closeCalendar: function(){
		with (bf2.Calendar) {
			document.getElementById('yearDropDown').style.display = 'none';
			document.getElementById('monthDropDown').style.display = 'none';
			
			calendarDiv.style.display = 'none';
			if (iframeObj) {
				iframeObj.style.display = 'none';
				//// //// fix for EI frame problem on time dropdowns 09/30/2006
					EIS_Hide_Frame();
			}
			if (activeSelectBoxMonth) 
				activeSelectBoxMonth.className = '';
			if (activeSelectBoxYear) 
				activeSelectBoxYear.className = '';
		}
	},
	
	cancelCalendarEvent: function() {
		return false;
	},
	
	isLeapYear: function(inputYear) {
		if (inputYear % 400 == 0 || (inputYear % 4 == 0 && inputYear % 100 != 0)) 
			return true;
		return false;
	},
	
	showMonthDropDown: function() {
		with (bf2.Calendar) {
			if (document.getElementById('monthDropDown').style.display == 'block') {
				document.getElementById('monthDropDown').style.display = 'none';
				//// fix for EI frame problem on time dropdowns 09/30/2006
					EIS_Hide_Frame();
			} else {
				document.getElementById('monthDropDown').style.display = 'block';
				document.getElementById('yearDropDown').style.display = 'none';
				if (bf2.Browser.IE) 
					EIS_FIX_EI1('monthDropDown');
				//// fix for EI frame problem on time dropdowns 09/30/2006
			}
		}
	},
	
	showYearDropDown: function() {
		with (bf2.Calendar) {
			if (document.getElementById('yearDropDown').style.display == 'block') {
				document.getElementById('yearDropDown').style.display = 'none';
				//// fix for EI frame problem on time dropdowns 09/30/2006
					EIS_Hide_Frame();
			} else {
				document.getElementById('yearDropDown').style.display = 'block';
				document.getElementById('monthDropDown').style.display = 'none';
				if (bf2.Browser.IE) 
					EIS_FIX_EI1('yearDropDown')
				//// fix for EI frame problem on time dropdowns 09/30/2006
			}
		}
	},
	
	createMonthDiv: function() {
		with (bf2.Calendar) {
			var div = document.createElement('DIV');
			div.className = 'monthYearPicker';
			div.id = 'monthPicker';
			
			for (var no = 0; no < monthArray.length; no++) {
				var subDiv = document.createElement('DIV');
				subDiv.innerHTML = monthArray[no];
				subDiv.onmouseover = highlightMonthYear;
				subDiv.onmouseout = highlightMonthYear;
				subDiv.onclick = selectMonth;
				subDiv.id = 'monthDiv_' + no;
				subDiv.style.width = '56px';
				subDiv.onselectstart = cancelCalendarEvent;
				div.appendChild(subDiv);
				if (currentMonth && currentMonth == no) {
					subDiv.style.color = selectBoxHighlightColor;
					activeSelectBoxMonth = subDiv;
				}
			}
		}
		return div;
	},

	updateYearDiv: function() {
		with (bf2.Calendar) {
			var yearSpan = 5;
			var div = document.getElementById('yearDropDown');
			var yearItems = div.getElementsByTagName('DIV');
			for (var no = 1; no < yearItems.length -1; no++) {
				yearItems[no].innerHTML = currentYear /1 - yearSpan + no;
				if (currentYear == (currentYear /1 -yearSpan +no)) {
					yearItems[no].style.color = selectBoxHighlightColor;
					activeSelectBoxYear = yearItems[no];
				} else yearItems[no].style.color = '';
			}
		}
	},
	
	updateMonthDiv: function() {
		with (bf2.Calendar) {
			for (no = 0; no < 12; no++) 
				document.getElementById('monthDiv_' +no).style.color = '';
			document.getElementById('monthDiv_' +currentMonth).style.color = selectBoxHighlightColor;
			activeSelectBoxMonth = document.getElementById('monthDiv_' +bf2.Calendar.currentMonth);
		}
	},
	
	createYearDiv: function() {
		with (bf2.Calendar) {
			if (!document.getElementById('yearDropDown')) {
				var div = document.createElement('DIV');
				div.className = 'monthYearPicker';
			} else {
				var div = document.getElementById('yearDropDown');
				var subDivs = div.getElementsByTagName('DIV');
				for (var no = 0; no < subDivs.length; no++) 
					subDivs[no].parentNode.removeChild(subDivs[no]);
			}
			
			var d = new Date();
			if (currentYear) 
				d.setFullYear(currentYear);
			
			var startYear = d.getFullYear() /1 -5;
			
			var yearSpan = 10;
			var subDiv = document.createElement('DIV');
			subDiv.innerHTML = '&nbsp;&nbsp;- ';
			subDiv.onclick = changeSelectBoxYear;
			subDiv.onmouseover = highlightMonthYear;
			subDiv.onmouseout = function() {
				selectBoxMovementInProgress = false;
			};
			subDiv.onselectstart = cancelCalendarEvent;
			div.appendChild(subDiv);
			
			for (var no = startYear; no < (startYear +yearSpan); no++) {
				var subDiv = document.createElement('DIV');
				subDiv.innerHTML = no;
				subDiv.onmouseover = highlightMonthYear;
				subDiv.onmouseout = highlightMonthYear;
				subDiv.onclick = selectYear;
				subDiv.id = 'yearDiv' + no;
				subDiv.onselectstart = cancelCalendarEvent;
				div.appendChild(subDiv);
				if (currentYear && currentYear == no) {
					subDiv.style.color = selectBoxHighlightColor;
					activeSelectBoxYear = subDiv;
				}
			}
			var subDiv = document.createElement('DIV');
			subDiv.innerHTML = '&nbsp;&nbsp;+ ';
			subDiv.onclick = changeSelectBoxYear;
			subDiv.onmouseover = highlightMonthYear;
			subDiv.onmouseout = function() {
				selectBoxMovementInProgress = false;
			};
			subDiv.onselectstart = cancelCalendarEvent;
			div.appendChild(subDiv);
		}
		return div;
	},
	
	writeTopBar: function() {
		with (bf2.Calendar) {
			var topBar = document.createElement('DIV');
			topBar.className = 'topBar';
			topBar.id = 'topBar';
			calendarDiv.appendChild(topBar);
			
			// Left arrow
			var leftDiv = document.createElement('DIV');
			leftDiv.style.marginRight = '1px';
			var img = document.createElement('IMG');
			img.src = pathToImages +'left.gif';
			img.onmouseover = highlightArrow;
			img.onclick = switchMonth;
			img.onmouseout = highlightArrow;
			leftDiv.appendChild(img);
			topBar.appendChild(leftDiv);
			if (bf2.Browser.Opera) 
				leftDiv.style.width = '16px';
			
			// Right arrow
			var rightDiv = document.createElement('DIV');
			rightDiv.style.marginRight = '1px';
			var img = document.createElement('IMG');
			img.src = pathToImages +'right.gif';
			img.onclick = switchMonth;
			img.onmouseover = highlightArrow;
			img.onmouseout = highlightArrow;
			rightDiv.appendChild(img);
			if (bf2.Browser.Opera) 
				rightDiv.style.width = '16px';
			topBar.appendChild(rightDiv);
			
			// Month selector
			var monthDiv = document.createElement('DIV');
			monthDiv.id = 'monthSelect';
			monthDiv.onmouseover = highlightSelect;
			monthDiv.onmouseout = highlightSelect;
			monthDiv.onclick = showMonthDropDown;
			var span = document.createElement('SPAN');
			span.innerHTML = monthArray[currentMonth];
			span.id = 'calendar_month_txt';
			monthDiv.appendChild(span);
			
			var img = document.createElement('IMG');
			img.src = pathToImages +'down.gif';
			img.style.position = 'absolute';
			img.style.right = '0px';
			monthDiv.appendChild(img);
			monthDiv.className = 'selectBox';
			if (bf2.Browser.Opera) {
				img.style.cssText = 'float:right;position:relative';
				img.style.position = 'relative';
				img.style.styleFloat = 'right';
			}
			topBar.appendChild(monthDiv);
			
			var monthPicker = createMonthDiv();
			monthPicker.style.left = '37px';
			monthPicker.style.top = monthDiv.offsetTop + monthDiv.offsetHeight + 1 + 'px';
			monthPicker.style.width = '60px';
			monthPicker.id = 'monthDropDown';
			
			calendarDiv.appendChild(monthPicker);
			
			// Year selector
			var yearDiv = document.createElement('DIV');
			yearDiv.onmouseover = highlightSelect;
			yearDiv.onmouseout = highlightSelect;
			yearDiv.onclick = showYearDropDown;
			var span = document.createElement('SPAN');
			span.innerHTML = currentYear;
			span.id = 'calendar_year_txt';
			yearDiv.appendChild(span);
			topBar.appendChild(yearDiv);
			
			var img = document.createElement('IMG');
			img.src = pathToImages +'down.gif';
			yearDiv.appendChild(img);
			yearDiv.className = 'selectBox';
			
			if (bf2.Browser.Opera) {
				yearDiv.style.width = '50px';
				img.style.cssText = 'float:right';
				img.style.position = 'relative';
				img.style.styleFloat = 'right';
			}
			
			var yearPicker = createYearDiv();
			yearPicker.style.left = '113px';
			yearPicker.style.top = monthDiv.offsetTop +monthDiv.offsetHeight +1 +'px';
			yearPicker.style.width = '35px';
			yearPicker.id = 'yearDropDown';
			calendarDiv.appendChild(yearPicker);
			
			var img = document.createElement('IMG');
			img.src = pathToImages +'close.gif';
			img.style.styleFloat = 'right';
			img.onmouseover = highlightClose;
			img.onmouseout = highlightClose;
			img.onclick = closeCalendar;
			topBar.appendChild(img);
			if (!document.all) {
				img.style.position = 'absolute';
				img.style.right = '2px';
			}
		}
	},
	
	writeCalendarContent: function() {
		with (bf2.Calendar) {
			var calendarContentDivExists = true;
			if (!calendarContentDiv) {
				calendarContentDiv = document.createElement('DIV');
				calendarDiv.appendChild(calendarContentDiv);
				calendarContentDivExists = false;
			}
			currentMonth = currentMonth /1;
			var d = new Date();
			
			d.setFullYear(currentYear);
			d.setDate(1);
			d.setMonth(currentMonth);
			
			var dayStartOfMonth = d.getDay();
			
			document.getElementById('calendar_year_txt').innerHTML = currentYear;
			document.getElementById('calendar_month_txt').innerHTML = monthArray[currentMonth];
			
			var existingTable = calendarContentDiv.getElementsByTagName('TABLE');
			if (existingTable.length > 0) 
				calendarContentDiv.removeChild(existingTable[0]);
			
			var calTable = document.createElement('TABLE');
			calTable.width = '100%';
			calTable.cellSpacing = '0';
			calendarContentDiv.appendChild(calTable);
			
			var calTBody = document.createElement('TBODY');
			calTable.appendChild(calTBody);
			var row = calTBody.insertRow(-1);
			row.className = 'calendar_week_row';
			if (showWeekNumber) {
				var cell = row.insertCell(-1);
				cell.innerHTML = weekString;
				cell.className = 'calendar_week_column';
				cell.style.backgroundColor = selectBoxRolloverBgColor;
			}
			
			for (var no = 0; no < dayArray.length; no++) {
				var cell = row.insertCell(-1);
				cell.innerHTML = dayArray[no];
			}
			
			var row = calTBody.insertRow(-1);
			
			if (showWeekNumber) {
				var cell = row.insertCell(-1);
				cell.className = 'calendar_week_column';
				cell.style.backgroundColor = selectBoxRolloverBgColor;
				var week = getWeek(currentYear, currentMonth, 1);
				cell.innerHTML = week; // Week
			}
			for (var no = 0; no < dayStartOfMonth; no++) {
				var cell = row.insertCell(-1);
				cell.innerHTML = '&nbsp;';
			}
			
			var colCounter = dayStartOfMonth;
			var daysInMonth = daysInMonthArray[currentMonth];
			if (daysInMonth == 28) {
				if (isLeapYear(currentYear)) 
					daysInMonth = 29;
			}
			
			for (var no = 1; no <= daysInMonth; no++) {
				d.setDate(no - 1);
				if (colCounter > 0 && colCounter % 7 == 0) {
					var row = calTBody.insertRow(-1);
					if (showWeekNumber) {
						var cell = row.insertCell(-1);
						cell.className = 'calendar_week_column';
						var week = getWeek(currentYear, currentMonth, no);
						cell.innerHTML = week; // Week
						cell.style.backgroundColor = selectBoxRolloverBgColor;
					}
				}
				var cell = row.insertCell(-1);
				if (currentYear == inputYear && currentMonth == inputMonth && no == inputDay) 
					cell.className = 'activeDay';
				cell.innerHTML = no;
				cell.onclick = pickDate;
				colCounter++;
			}
			
			if (!document.all) {
				if (calendarContentDiv.offsetHeight) 
					document.getElementById('topBar').style.top = calendarContentDiv.offsetHeight + document.getElementById('topBar').offsetHeight - 1 + 'px';
				else {
					document.getElementById('topBar').style.top = '';
					document.getElementById('topBar').style.bottom = '0px';
				}
			}
			
			if (iframeObj) {
				if (!calendarContentDivExists) 
					setTimeout('bf2.Calendar.resizeIframe()', 350);
				else setTimeout('bf2.Calendar.resizeIframe()', 10);
			}
		}
	},
	
	resizeIframe: function() {
		bf2.Calendar.iframeObj.style.width = bf2.Calendar.calendarDiv.offsetWidth + 'px';
		bf2.Calendar.iframeObj.style.height = bf2.Calendar.calendarDiv.offsetHeight + 'px';
	},
	
	// Only changed the month add
	getWeek: function(year, month, day) {
		with (bf2.Calendar) {
			day = (day /1) +1;
			
			year = year /1;
			month = month /1 +1; //use 1-12
			var a = Math.floor((14 -month) /12);
			var y = year +4800 -a;
			var m = month +(12 *a) -3;
			var jd = day + Math.floor(((153 *m) +2) /5) +(365 *y) +
				Math.floor(y /4) -Math.floor(y /100) +
				Math.floor(y /400) -32045; // (gregorian calendar)
			var d4 = (jd +31741 -(jd %7)) %146097 %36524 %1461;
			var L = Math.floor(d4 /1460);
			var d1 = ((d4 -L) %365) +L;
			NumberOfWeek = Math.floor(d1 /7) +1;
		}
		return NumberOfWeek;
	},
	
	getTopPos: function(inputObj) {
		var returnValue = inputObj.offsetTop +inputObj.offsetHeight;
		while ((inputObj = inputObj.offsetParent) != null) 
			returnValue += inputObj.offsetTop;
		return returnValue +bf2.Calendar.calendar_offsetTop;
	},
	
	getLeftPos: function(inputObj) {
		var returnValue = inputObj.offsetLeft;
		while ((inputObj = inputObj.offsetParent) != null) 
			returnValue += inputObj.offsetLeft;
		return returnValue +bf2.Calendar.calendar_offsetLeft;
	},
	
	positionCalendar: function(inputObj) {
		with (bf2.Calendar) {
			calendarDiv.style.left = getLeftPos(inputObj) +'px';
			calendarDiv.style.top = getTopPos(inputObj) +'px';
			if (iframeObj) {
				iframeObj.style.left = calendarDiv.style.left;
				iframeObj.style.top = calendarDiv.style.top;
				//// fix for EI frame problem on time dropdowns 09/30/2006
				iframeObj2.style.left = calendarDiv.style.left;
				iframeObj2.style.top = calendarDiv.style.top;
			}
		}
	},
	
	initCalendar: function() {
		with (bf2.Calendar) {
			if (bf2.Browser.IE) {
				iframeObj = document.createElement('IFRAME');
				iframeObj.style.filter = 'alpha(opacity=0)';
				iframeObj.style.position = 'absolute';
				iframeObj.border = '0px';
				iframeObj.style.border = '0px';
				iframeObj.style.backgroundColor = '#FF0000';
				//// fix for EI frame problem on time dropdowns 09/30/2006
				iframeObj2 = document.createElement('IFRAME');
				iframeObj2.style.position = 'absolute';
				iframeObj2.border = '0px';
				iframeObj2.style.border = '0px';
				iframeObj2.style.height = '1px';
				iframeObj2.style.width = '1px';
				//// fix for EI frame problem on time dropdowns 09/30/2006
				// Added fixed for HTTPS
				iframeObj2.src = 'blank.html';
				iframeObj.src = 'blank.html';
				document.body.appendChild(iframeObj2); // gfb move this down AFTER the .src is set
				document.body.appendChild(iframeObj);
			}
			
			calendarDiv = document.createElement('DIV');
			calendarDiv.id = 'calendarDiv';
			calendarDiv.style.zIndex = 1000;
			slideCalendarSelectBox();
			
			document.body.appendChild(calendarDiv);
			writeTopBar();
			
			if (!currentYear) {
				var d = new Date();
				currentMonth = d.getMonth();
				currentYear = d.getFullYear();
			}
			writeCalendarContent();
		}
	},
	
	calendarSortItems: function(a, b) {
		return a /1 -b /1;
	},
	
	displayCalendar: function(inputField, format) {
		with (bf2.Calendar) {
			try {
				closeCalendar();
			} catch (e) {}
			reset();
				
			calendarDisplayTime = false;
			if (inputField.value.length > 0) {
				if (!format.match(/^[0-9]*?$/gi)) {
					var items = inputField.value.split(/[^0-9]/gi);
					var positionArray = new Array();
					positionArray['m'] = format.indexOf('mm');
					if (positionArray['m'] == -1) 
						positionArray['m'] = format.indexOf('m');
					positionArray['d'] = format.indexOf('dd');
					if (positionArray['d'] == -1) 
						positionArray['d'] = format.indexOf('d');
					positionArray['y'] = format.indexOf('yyyy');
					positionArray['h'] = format.indexOf('hh');
					positionArray['i'] = format.indexOf('ii');
					
					var positionArrayNumeric = Array();
					positionArrayNumeric[0] = positionArray['m'];
					positionArrayNumeric[1] = positionArray['d'];
					positionArrayNumeric[2] = positionArray['y'];
					positionArrayNumeric[3] = positionArray['h'];
					positionArrayNumeric[4] = positionArray['i'];
	
					positionArrayNumeric = positionArrayNumeric.sort(calendarSortItems);
					var itemIndex = -1;
					for (var no = 0; no < positionArrayNumeric.length; no++) {
						if (positionArrayNumeric[no] == -1) 
							continue;
						itemIndex++;
						if (positionArrayNumeric[no] == positionArray['m']) {
							currentMonth = items[itemIndex] - 1;
							continue;
						}
						if (positionArrayNumeric[no] == positionArray['y']) {
							currentYear = items[itemIndex];
							continue;
						}
						if (positionArrayNumeric[no] == positionArray['d']) {
							tmpDay = items[itemIndex];
							continue;
						}
					}
	
					currentMonth = currentMonth / 1;
					tmpDay = tmpDay / 1;
				} else {
					var monthPos = format.indexOf('mm');
					currentMonth = inputField.value.substr(monthPos, 2) / 1 - 1;
					var yearPos = format.indexOf('yyyy');
					currentYear = inputField.value.substr(yearPos, 4);
					var dayPos = format.indexOf('dd');
					tmpDay = inputField.value.substr(dayPos, 2);
				}
			} else {
				var d = new Date();
				currentMonth = d.getMonth();
				currentYear = d.getFullYear();
				tmpDay = d.getDate();
			}
			
			inputYear = currentYear;
			inputMonth = currentMonth;
			inputDay = tmpDay / 1;
	
			if (!calendarDiv)
				initCalendar();
			else {
				if (calendarDiv.style.display == 'block') {
					closeCalendar();
					return false;
				}
				writeCalendarContent();
			}
	
			returnFormat = format;
			returnDateTo = inputField;
			positionCalendar(inputField);
			calendarDiv.style.visibility = 'visible';
			calendarDiv.style.display = 'block';
			if (iframeObj) {
				iframeObj.style.display = '';
				iframeObj.style.height = '140px';
				iframeObj.style.width = '195px';
				iframeObj2.style.display = '';
				iframeObj2.style.height = '140px';
				iframeObj2.style.width = '195px';
			}
			updateYearDiv();
			updateMonthDiv();
		}
	},
	
	displayCalendarSelectBox: function(yearInput, monthInput, dayInput, buttonObj) {
		with (bf2.Calendar) {
			try {
				closeCalendar();
			} catch (e) {}
			reset();
			
			if (!hourInput) 
				calendarDisplayTime = false;
			else calendarDisplayTime = true;
			
			currentMonth = monthInput.options[monthInput.selectedIndex].value /1 -1;
			currentYear = yearInput.options[yearInput.selectedIndex].value;
			
			inputYear = yearInput.options[yearInput.selectedIndex].value;
			inputMonth = monthInput.options[monthInput.selectedIndex].value /1 -1;
			inputDay = dayInput.options[dayInput.selectedIndex].value /1;
			
			if (!calendarDiv) 
				initCalendar();
			else writeCalendarContent();
			
			returnDateToYear = yearInput;
			returnDateToMonth = monthInput;
			returnDateToDay = dayInput;
			
			returnFormat = false;
			returnDateTo = false;
			positionCalendar(buttonObj);
			calendarDiv.style.visibility = 'visible';
			calendarDiv.style.display = 'block';
			if (iframeObj) {
				iframeObj.style.display = '';
				iframeObj.style.height = calendarDiv.offsetHeight + 'px';
				iframeObj.style.width = calendarDiv.offsetWidth + 'px';
				//// fix for EI frame problem on time dropdowns 09/30/2006
				iframeObj2.style.display = '';
				iframeObj2.style.height = calendarDiv.offsetHeight + 'px';
				iframeObj2.style.width = calendarDiv.offsetWidth + 'px'
			}
			setTimeProperties();
			updateYearDiv();
			updateMonthDiv();
		}
	},
	
	reset: function() {
		bf2.Calendar.showWeekNumber = true; // true = show week number,  false = do not show week number
		bf2.Calendar.calendar_offsetTop = 0; // Offset - calendar placement - You probably have to modify this value if you're not using a strict doctype
		bf2.Calendar.calendar_offsetLeft = 0; // Offset - calendar placement - You probably have to modify this value if you're not using a strict doctype
		bf2.Calendar.calendarDiv = false;
		
		bf2.Calendar.pathToImages = bf2.baseUrl +'images/bf2-calendar/'; // Relative to your HTML file
		bf2.Calendar.selectBoxMovementInProgress = false;
	
		bf2.Calendar.currentMonth = null;
		bf2.Calendar.currentYear = null;
		bf2.Calendar.returnFormat = null;
		
		bf2.Calendar.returnDateTo = null;
		bf2.Calendar.iframeObj = false;
		//// fix for EI frame problem on time dropdowns 09/30/2006
		bf2.Calendar.iframeObj2 = false;
		bf2.Calendar.activeSelectBoxMonth = null;
		bf2.Calendar.activeSelectBoxYear = null;
	
		bf2.Calendar.selectBoxHighlightColor = '#D60808'; // Highlight color of select boxes
		bf2.Calendar.selectBoxRolloverBgColor = '#E2EBED'; // Background color on drop down lists(rollover)
		
		bf2.Calendar.monthArray = 
			['Janeiro', 'Fevereiro', 'Mar&ccedil;o', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 
			 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
		bf2.Calendar.monthArrayShort = 
			['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
		bf2.Calendar.dayArray = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'S&aacute;b'];
		bf2.Calendar.weekString = 'Sem.';
		bf2.Calendar.todayString = 'Hoje &eacute;';	
		bf2.Calendar.daysInMonthArray = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
		bf2.Calendar.calendarContentDiv = null;
		
		//// fix for EI frame problem on time dropdowns 09/30/2006
		bf2.Calendar.returnDateToYear = null;
		bf2.Calendar.returnDateToMonth = null;
		bf2.Calendar.returnDateToDay = null;
		
		bf2.Calendar.inputYear = null;
		bf2.Calendar.inputMonth = null;
		bf2.Calendar.inputDay = null;
		bf2.Calendar.calendarDisplayTime = false;
		
		bf2.Calendar.activeSelectBox = false;
		
		bf2.Calendar.activeSelectBoxMonth = false;
		bf2.Calendar.activeSelectBoxDirection = false;
	}
}