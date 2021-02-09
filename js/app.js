const urlBase = 'http://cop4331team21.live/LAMPAPI'
const extension = '.php';

let userId = 0;
let firstName = "";
let lastName = "";

// login
function doLogin() {
	userId = 0;
	firstName = "";
	lastName = "";
	
	const login = document.getElementById("loginName").value;
	const password = document.getElementById("loginPassword").value;
	const hash = md5(password);
	
	document.getElementById("loginResult").innerHTML = "";

	let obj = new Object();
	obj.login = login;
	obj.password = hash;

	const jsonPayload = JSON.stringify(obj);
	const url = urlBase + '/login' + extension;

	let xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

	try {
		xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				const jsonObject = JSON.parse(xhr.responseText);
		
				userId = jsonObject.id;
		
				if (userId < 1) {
					document.getElementById("loginResult").innerHTML = "User/Password combination incorrect";
					return;
				}
		
				firstName = jsonObject.firstName;
				lastName = jsonObject.lastName;

				saveCookie();
	
				window.location.href = "contacts.html";
			}
		};
		
		xhr.send(jsonPayload);
	} catch(err) {
		document.getElementById("colorAddResult").innerHTML = err.message;
	}
	
}

// register
function doRegister() {
	userId = 0;
	firstName = "";
	lastName = "";
	
	const login = document.getElementById("registerName").value;
    const password = document.getElementById("registerPassword").value;
    const first = document.getElementById("registerFirst").value;
    const last = document.getElementById("registerLast").value;
	const hash = md5(password);
	
	document.getElementById("loginResult").innerHTML = "";

	let obj = new Object();
	obj.login = login;
	obj.password = hash;
	obj.firstName = first;
	obj.lastName = last;

	const jsonPayload = JSON.stringify(obj);
	const url = urlBase + '/register' + extension;

	let xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

	try {
		xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
                window.location.href = "contacts.html";
            }
		};
		
		xhr.send(jsonPayload);
	} catch(err) {
		document.getElementById("colorAddResult").innerHTML = err.message;
	}
	
}

function saveCookie()
{
	var minutes = 20;
	var date = new Date();
	date.setTime(date.getTime()+(minutes*60*1000));	
	document.cookie = "firstName=" + firstName + ",lastName=" + lastName + ",userId=" + userId + ";expires=" + date.toGMTString();
}

function readCookie()
{
	userId = -1;
	var data = document.cookie;
	var splits = data.split(",");
	for(var i = 0; i < splits.length; i++) 
	{
		var thisOne = splits[i].trim();
		var tokens = thisOne.split("=");
		if( tokens[0] == "firstName" )
		{
			firstName = tokens[1];
		}
		else if( tokens[0] == "lastName" )
		{
			lastName = tokens[1];
		}
		else if( tokens[0] == "userId" )
		{
			userId = parseInt( tokens[1].trim() );
		}
	}
	
	if( userId < 0 )
	{
		window.location.href = "index.html";
	}
	else
	{
		document.getElementById("userName").innerHTML = "Logged in as " + firstName + " " + lastName;
	}
}

// logout
function doLogout()
{
	userId = 0;
	firstName = "";
	lastName = "";
	document.cookie = "firstName= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
	window.location.href = "index.html";
}

// add a contact 
function addContact()
{
	const firstName = document.getElementById("contactFirstName").value;
	const lastName = document.getElementById("contactLastName").value;
	const phone = document.getElementById("phone").value;
	const email = document.getElementById("email").value;
	const address = document.getElementById("address").value;
	const city = document.getElementById("city").value;
	const state = document.getElementById("state").value;
	const zipCode = document.getElementById("zip").value;

	document.getElementById("userAddResult").innerHTML = "";
	
	let obj = new Object();
	obj.uid = userId;
	obj.firstName = firstName;
	obj.lastName = lastName;
	obj.phone = phone;
	obj.email = email;
	obj.address = address;
	obj.city = city;
	obj.state = state;
	obj.zipCode = zip;

	const jsonPayload = JSON.stringify(obj);
	const url = urlBase + '/AddContact' + extension;
	
	let xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

	try {
		xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("userAddResult").innerHTML = "A new contact has been added!";
			}
		};
		xhr.send(jsonPayload);
	} catch(err) {
		document.getElementById("colorAddResult").innerHTML = err.message;
	}
	
}

function updateContact() {
	
}

// search for a contact
function searchContact()
{
	const srch = document.getElementById("searchText").value;
	document.getElementById("contactSearchResult").innerHTML = "";
	
	let contactList = "";
	
	const jsonPayload = '{"search" : "' + srch + '","uid" : ' + userId + '}';
	const url = urlBase + '/search' + extension;
	
	let xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

	try {
		xhr.onreadystatechange = function()  {
			if (this.readyState == 4 && this.status == 200)  {
				document.getElementById("contactSearchResult").innerHTML = "Contact(s) has been retrieved";
				let jsonObject = JSON.parse(xhr.responseText);
				
				for(let i = 0; i < jsonObject.results.length; i++) {
					colorList += jsonObject.results[i];

					if(i < jsonObject.results.length - 1){
						contactList += "<br />\r\n";
					}
				}
				
				document.getElementsByTagName("p")[0].innerHTML = contactList;
			}
		};
		xhr.send(jsonPayload);
	} catch(err) {
		document.getElementById("contactSearchResult").innerHTML = err.message;
	}

}