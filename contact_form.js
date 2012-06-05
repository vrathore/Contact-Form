
var http_req = false;
var str="";
function CFPOSTRequest(url, parameters) {
	http_req = false;
	if (window.XMLHttpRequest) { // Mozilla, Safari,...
		http_req = new XMLHttpRequest();
		if (http_req.overrideMimeType) {
			http_req.overrideMimeType('text/html');
	 	}
	}
	else if (window.ActiveXObject) { // IE
		try {
			http_req = new ActiveXObject("Msxml2.XMLHTTP");
		} 
		catch (e) {
			try {
				http_req = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e) {}
		}
	}
	if (!http_req) {
		alert('Cannot create XMLHTTP instance');
		return false;
	}

	http_req.onreadystatechange = CFContents;
	http_req.open('POST', url, true);
	http_req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http_req.setRequestHeader("Content-length", parameters.length);
	http_req.setRequestHeader("Connection", "close");
	http_req.send(parameters);
}

function CFContents() 
{

	if (http_req.readyState == 4) {
		if (http_req.status == 200) {
			if(http_req.responseText == "Invalid security code."){
				//alert(http_req.responseText);
				result = http_req.responseText;
				document.getElementById('CF_alertmessage').innerHTML = result;
				document.getElementById("CF_captcha").value = "";
			}
			else {
				alert(http_req.responseText);
				result = http_req.responseText;
				document.getElementById('CF_alertmessage').innerHTML = result;   
				document.getElementById("CF_email").value = "";
				document.getElementById("CF_name").value = "";
				document.getElementById("CF_subject").value = "";
				document.getElementById("CF_message").value = "";
				document.getElementById("CF_captcha").value = "";
			}
		} 
		else {
			alert('There was a problem with the request.');
		}
	}
}

/* CF_submit function is doing the validation part for the front end form and on clear validation, it sends the data to mail.php */
function CF_submit(obj,url) 
{
	if(document.getElementById("CF_email")){
		_e=document.getElementById("CF_email");
		str= str + "&CF_email=" + encodeURI( document.getElementById("CF_email").value ) 
	}
	if(document.getElementById("CF_name")){
		_n=document.getElementById("CF_name");
		str= str + "&CF_name=" + encodeURI( document.getElementById("CF_name").value ) 
	}
	if(document.getElementById("CF_message")){
		_m=document.getElementById("CF_message");
		str= str + "&CF_message=" + encodeURI( document.getElementById("CF_message").value ) 
	}
	if(document.getElementById("CF_subject")){
		_s=document.getElementById("CF_subject");
		str= str + "&CF_subject=" + encodeURI( document.getElementById("CF_subject").value ) 
	}
	if(document.getElementById("CF_captcha")){
		_c=document.getElementById("CF_captcha");
		str= str + "&CF_captcha=" + encodeURI( document.getElementById("CF_captcha").value ) 
	}
	
	/* Validation */
	if(document.getElementById("CF_name") && _n.value=="")
	{
		alert("Please enter the name.");
		_n.focus();
		return false;    
	}
	else if(document.getElementById("CF_email") && _e.value=="")
	{
		alert("Please enter the email address.");
		_e.focus();
		return false;    
	}
	else if(document.getElementById("CF_email") && _e.value!="" && (_e.value.indexOf("@",0)==-1 || _e.value.indexOf(".",0)==-1))
	{
		alert("Please enter valid email.")
		_e.focus();
		_e.select();
		return false;
	} 
	else if(document.getElementById("CF_subject") && _s.value=="")
	{
		alert("Please enter your subject.");
		_s.focus();
		return false;    
	}
	else if(document.getElementById("CF_message") && _m.value=="")
	{
		alert("Please enter your message.");
		_m.focus();
		return false;    
	}
	else if(document.getElementById("CF_captcha") && _c.value=="")
	{
		alert("Please enter enter below security code.");
		_c.focus();
		return false;    
	}


	document.getElementById('CF_alertmessage').innerHTML = "Sending...";

	/* Redirecting the values to mail.php */
	CFPOSTRequest(url+'mail.php', str);
}