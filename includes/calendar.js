// Title: Tigra Calendar
// URL: http://www.softcomplex.com/products/tigra_calendar/
// Version: 3.2 (ISO date format)
// Date: 10/14/2002 (mm/dd/yyyy)
// Feedback: feedback@softcomplex.com (specify product title in the subject)
// Note: Permission given to use this script in ANY kind of applications if
//    header lines are left unchanged.
// Note: Script consists of two files: calendar?.js and calendar.html
// About us: Our company provides offshore IT consulting services.
//    Contact us at sales@softcomplex.com if you have any programming task you
//    want to be handled by professionals. Our typical hourly rate is $20.

// Adaptations by mikespub for Xaraya :
// - rename functions to avoid potential conflicts with other javascripts
// - find the calendar.html file starting from a base URI
// - use the ISO date format for "generic" date formatting
// TODO: support theme-dependent versions of calendar.html and images

// if two digit year input dates after this year considered 20 century.
var NUM_CENTYEAR = 30;
// is time input control required by default
var BUL_TIMECOMPONENT = false;
// are year scrolling buttons required by default
var BUL_YEARSCROLL = true;

var calendars = [];
var RE_NUM = /^\-?\d+$/;

// URL of the calendar.html file
var STR_HTMLPATH = './';

function xar_base_calendar(obj_target, base_url) {

	// assing methods
	this.gen_date = xar_base_calendar_gen_date;
	this.gen_time = xar_base_calendar_gen_time;
	this.gen_tsmp = xar_base_calendar_gen_tsmp;
	this.prs_date = xar_base_calendar_prs_date;
	this.prs_time = xar_base_calendar_prs_time;
	this.prs_tsmp = xar_base_calendar_prs_tsmp;
	this.popup    = xar_base_calendar_popup;

	// validate input parameters
	if (!obj_target)
		return xar_base_calendar_error("Error calling the calendar: no target control specified");
	if (obj_target.value == null)
		return xar_base_calendar_error("Error calling the calendar: parameter specified is not valid tardet control");
	this.target = obj_target;
	this.time_comp = BUL_TIMECOMPONENT;
	this.year_scroll = BUL_YEARSCROLL;
	this.base_url = base_url + '/' + STR_HTMLPATH;
	
	// register in global collections
	this.id = calendars.length;
	calendars[this.id] = this;
}

function xar_base_calendar_popup (str_datetime) {
	this.dt_current = this.prs_tsmp(str_datetime ? str_datetime : this.target.value);
	if (!this.dt_current) return;

	var obj_calwindow = window.open(
		this.base_url.valueOf() + 'calendar.html?datetime=' + this.dt_current.valueOf()+ '&id=' + this.id,
		'Calendar', 'width=200,height='+(this.time_comp ? 215 : 190)+
		',status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes'
	);
	obj_calwindow.opener = window;
	obj_calwindow.focus();
}

// timestamp generating function
function xar_base_calendar_gen_tsmp (dt_datetime) {
	return(this.gen_date(dt_datetime) + ' ' + this.gen_time(dt_datetime));
}

// date generating function
function xar_base_calendar_gen_date (dt_datetime) {
	return (
		dt_datetime.getFullYear() + "-"
		+ (dt_datetime.getMonth() < 9 ? '0' : '') + (dt_datetime.getMonth() + 1) + "-"
		+ (dt_datetime.getDate() < 10 ? '0' : '') + dt_datetime.getDate()
	);
}
// time generating function
function xar_base_calendar_gen_time (dt_datetime) {
	return (
		(dt_datetime.getHours() < 10 ? '0' : '') + dt_datetime.getHours() + ":"
		+ (dt_datetime.getMinutes() < 10 ? '0' : '') + (dt_datetime.getMinutes()) + ":"
		+ (dt_datetime.getSeconds() < 10 ? '0' : '') + (dt_datetime.getSeconds())
	);
}

// timestamp parsing function
function xar_base_calendar_prs_tsmp (str_datetime) {
	// if no parameter specified return current timestamp
	if (!str_datetime)
		return (new Date());

	// if positive integer treat as milliseconds from epoch
	if (RE_NUM.exec(str_datetime))
		return new Date(str_datetime);
		
	// else treat as date in string format
	var arr_datetime = str_datetime.split(' ');
	return this.prs_time(arr_datetime[1], this.prs_date(arr_datetime[0]));
}

// date parsing function
function xar_base_calendar_prs_date (str_date) {

	var arr_date = str_date.split('-');

	if (arr_date.length != 3) return xar_base_calendar_error ("Invalid date format: '" + str_date + "'.\nFormat accepted is yyyy-mm-dd.");
	if (!arr_date[0]) return xar_base_calendar_error ("Invalid date format: '" + str_date + "'.\nNo year value can be found.");
	if (!RE_NUM.exec(arr_date[0])) return xar_base_calendar_error ("Invalid year value: '" + arr_date[2] + "'.\nAllowed values are unsigned integers.");
	if (!arr_date[1]) return xar_base_calendar_error ("Invalid date format: '" + str_date + "'.\nNo month value can be found.");
	if (!RE_NUM.exec(arr_date[1])) return xar_base_calendar_error ("Invalid month value: '" + arr_date[1] + "'.\nAllowed values are unsigned integers.");
	if (!arr_date[2]) return xar_base_calendar_error ("Invalid date format: '" + str_date + "'.\nNo day of month value can be found.");
	if (!RE_NUM.exec(arr_date[2])) return xar_base_calendar_error ("Invalid day of month value: '" + arr_date[0] + "'.\nAllowed values are unsigned integers.");

	var dt_date = new Date();
	dt_date.setDate(1);

	if (arr_date[1] < 1 || arr_date[1] > 12) return xar_base_calendar_error ("Invalid month value: '" + arr_date[1] + "'.\nAllowed range is 01-12.");
	dt_date.setMonth(arr_date[1]-1);
	 
	if (arr_date[0] < 100) arr_date[0] = Number(arr_date[0]) + (arr_date[0] < NUM_CENTYEAR ? 2000 : 1900);
	dt_date.setFullYear(arr_date[0]);

	var dt_numdays = new Date(arr_date[0], arr_date[1], 0);
	dt_date.setDate(arr_date[2]);
	if (dt_date.getMonth() != (arr_date[1]-1)) return xar_base_calendar_error ("Invalid day of month value: '" + arr_date[2] + "'.\nAllowed range is 01-"+dt_numdays.getDate()+".");

	return (dt_date)
}

// time parsing function
function xar_base_calendar_prs_time (str_time, dt_date) {

	if (!dt_date) return null;
	var arr_time = String(str_time ? str_time : '').split(':');

	if (!arr_time[0]) dt_date.setHours(0);
	else if (RE_NUM.exec(arr_time[0])) 
		if (arr_time[0] < 24) dt_date.setHours(arr_time[0]);
		else return xar_base_calendar_error ("Invalid hours value: '" + arr_time[0] + "'.\nAllowed range is 00-23.");
	else return xar_base_calendar_error ("Invalid hours value: '" + arr_time[0] + "'.\nAllowed values are unsigned integers.");
	
	if (!arr_time[1]) dt_date.setMinutes(0);
	else if (RE_NUM.exec(arr_time[1]))
		if (arr_time[1] < 60) dt_date.setMinutes(arr_time[1]);
		else return xar_base_calendar_error ("Invalid minutes value: '" + arr_time[1] + "'.\nAllowed range is 00-59.");
	else return xar_base_calendar_error ("Invalid minutes value: '" + arr_time[1] + "'.\nAllowed values are unsigned integers.");

	if (!arr_time[2]) dt_date.setSeconds(0);
	else if (RE_NUM.exec(arr_time[2]))
		if (arr_time[2] < 60) dt_date.setSeconds(arr_time[2]);
		else return xar_base_calendar_error ("Invalid seconds value: '" + arr_time[2] + "'.\nAllowed range is 00-59.");
	else return xar_base_calendar_error ("Invalid seconds value: '" + arr_time[2] + "'.\nAllowed values are unsigned integers.");

	dt_date.setMilliseconds(0);
	return dt_date;
}

function xar_base_calendar_error (str_message) {
	alert (str_message);
	return null;
}
