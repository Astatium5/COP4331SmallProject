var mysql = require('mysql');
var path = require('path');
var express = require('express');
const { rootCertificates } = require('tls');

var connection = mysql.createConnection({
    host : 'cop4331team21.live',
    user : rootCertificates,
    password : '',
    database : 'USERS'
});

const urlBase = 'http://cop4331team21.live/LAMPAPI'
const extension = 'php'

var userID = 0;
var firstName = "";
var lastName = "";

// users logs in to an account
function doLogin() {
    userId = 0;
	firstName = "";
    lastName = "";
    
    
    var login = document.getElementById("login").value;
    var password = document.getElementById("password").value;
    var hash = md5( password );

    document.getElementById("loginResult").innerHTML = "";

    var jsonPayload = '{"login" : "' + login + '", "password" : "' + hash + '"}';
    // var jsonPayload = {"login": login.value, "password": hash.value};
    var url = urlBase + '/login.' + extension;

	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try
	{
		xhr.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				// the json that is recovered is converted to a js object
				var jsonObject = JSON.parse( xhr.responseText );
				
				// gets the user id of the user that is logged in
				userId = jsonObject.id;
		
				if( userId < 1 )
				{
					document.getElementById("loginResult").innerHTML = "User/Password combination incorrect";
					return;
				}
				 
				// gets teh first and last name of the user that is logged in
				firstName = jsonObject.firstName;
				lastName = jsonObject.lastName;

				saveCookie();
				
				// goes to the contacts page once logged in
				window.location.href = "contacts.html";
			}
		};
		
		// sends the login info to the API
		xhr.send(jsonPayload);
	}
	catch(err)
	{
		document.getElementById("loginResult").innerHTML = err.message;
	}
}

// user registers an account
function doRegister() {	
	let login = document.getElementById("registerName").value;
    let password = document.getElementById("registerPassword").value;
    let first = document.getElementById("registerFirst").value;
    let last = document.getElementById("registerLast").value;
	let hash = md5( password );

	// creates a json and converts the JSON data to a string
	let jsonPay = {login: login.value, password: hash.value, firstName: first.value, lastName: last.value};
	let jsonString = JSON.stringify(jsonPay);
	
	// creates a xhr object
	let url = urlBase + '/register.' + extension;
	let xhr = new XMLHttpRequest();

	// opens a connection
	xhr.open("POST", url, true);

	// sets the request header (what type of content we are sending)
	xhr.setRequestHeader("Content-type", "application/json");


	// creates a state change callback
	xhr.onreadystatechange = function() 
	{
		if (xhr.readyState == 4 && xhr.status == 200) 
	    {
			// goes to the home page if successful
            window.location.href = "index.html"; 
		}
	};
		
	// sends the json string to the server with the request
	xhr.send(jsonString);
}

function displayContacts()
{
	const entry = document.getElementById('contactsList')
	var url = urlBase + '/search.' + extension;
	// creates a new XMLHttpRequest object
	var request = new XMLHttpRequest();

	request.open('GET', url, true);

	request.onload = function(){
	  // access JSON data here
	  var data = JSON.parse(this.response);
	  if (request.status == 200 && request.readyState == 4)
	  {
		  data.forEach((contact) => {
			  // creates a div with a person class
			  const person = document.createElement('div');
			  person.setAttribute('class', 'person');
			  
			  // create an h1 and set the text content to the contact's name
			  const h1 = document.createElement('h1');
			  h1.textContent = contact.firstName;
			  
			  // append the person to the container element
			  container.appendChild(person);

			  // each person contains an h1 with the contact's name
			  person.appendChild(h1);
		  })
	  }
	  else{
		  const errorMsg = document.createElement('marquee');
		  errorMsg.textContent = 'No contacts listed';
		  entry.appendChild(errorMsg);

	  }
	}
	request.send();
}

// user adds a contact
function addContact()
{
    var firstName = document.getElementById("contactFirstName").value;
	var lastName = document.getElementById("contactLastName").value;
	var phone = document.getElementById("phone").value;
	var email = document.getElementById("email").value;
	var address = document.getElementById("address").value;
	var city = document.getElementById("city").value;
	var state = document.getElementById("state").value;
	var zipCode = document.getElementById("zip").value;

	// document.getElementById("userAddResult").innerHTML = "";
	
	// var jsonPayload = '{"uid" : ' + userId + '", "firstName" : "' + firstName + '", "lastName" : "' + lastName
	// 				   + '", "phone" : "' + phone + '", "email" : "' + email + '", "address" : "' + address
	// 				   + '", "city": "' + city + '", "state" : "' + state + '", "zip" : "' + zipCode + '"}';
	
	// creates a json object to send to the server
	let jsonPay = {firstName: firstName.value, lastName: lastName.value, phone: phone.value, email: email.value, address: address.value
				   , city: city.value, state: state.value, zip: zipCode.value};
	
	//converts the json object to a string
    let jsonString = JSON.stringify(jsonPay);

	var url = urlBase + '/create.' + extension;
	
	// creates new request
	var xhr = new XMLHttpRequest();

	// opens connection to the server 
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json");
	try
	{
		xhr.onreadystatechange = function() 
		{
			// if successful, we will be notified that a new contact was added
			if (this.readyState == 4 && this.status == 200) 
			{
				document.getElementById("userAddResult").innerHTML = "A new contact has been added!";
			}
		};

		// sends the json string with the request
		xhr.send(jsonString);
	}
	catch(err)
	{
		document.getElementById("userAddResult").innerHTML = err.message;
	}

}

// user searches for a contact
function searchContact()
{
	// the search that the user makes in the UI
    var srch = document.getElementById("searchText").value;
	// The result of the search (success or failure)
	document.getElementById("contactSearchResult").innerHTML = "";
	
	var contactList = "";

	// creates the search json that we want to send to the server
	var jsonPayload = '{"search" : "' + srch + '","userId" : ' + userId + '}';
	
	// creates the url link of the server
	var url = urlBase + '/search.' + extension;
	
	// creates the request to link to server
	var xhr = new XMLHttpRequest();
	
	// opens a connection to the server
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try
	{
		xhr.onreadystatechange = function() 
		{
			if (xhr.readyState == 4 && xhr.status == 200) 
			{   
				// if a success, we gwet msg that the contacts are found
				document.getElementById("contactSearchResult").innerHTML = "Contact(s) has been retrieved";
				
				// turns the json string retrieved into a js object
				var jsonObject = JSON.parse( xhr.responseText );
				
				for( var i=0; i<jsonObject.results.length; i++ )
				{
					contactList += jsonObject.results[i];
					if( i < jsonObject.results.length - 1 )
					{
						contactList += "<br />\r\n";
					}
				}
				
				document.getElementsByTagName("p")[0].innerHTML = contactList;
			}
		};
		xhr.send(jsonPayload);
	}
	catch(err)
	{
		document.getElementById("contactSearchResult").innerHTML = err.message;
	}

}

function editContact()
{
	
    var firstName = document.getElementById("fullName").value;
	var lastName = document.getElementById("fullName").value;
	var phone = document.getElementById("phone").value;
	var email = document.getElementById("eMail").value;
	var address = document.getElementById("Street").value;
	var city = document.getElementById("ciTy").value;
	var state = document.getElementById("sTate").value;
	var zipCode = document.getElementById("zIp").value;

	document.getElementById("updatedContactInfo").innerHTML = "";
	
	// let jsonPay = JSON.stringify({firstName:firstName.value, lastName:lastName.value, phone:phone.value, email:email.value, address:address.value
					            // ,city:city.value, state:state.value, zip:zipCode.value});

	
	var jsonPayload = '{"firstName" : "' + firstName + '", "lastName" : "' + lastName
						+ '", "phone" : "' + phone + '", "email" : "' + email + '", "address" : "' + address
						+ '", "city": "' + city + '", "state" : "' + state + '", "zip" : "' + zipCode + '"}';
							
	var url = urlBase + '/update.' + extension;
	
	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try
	{
		xhr.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				// the json object is retrieved and converted to a js object
				document.getElementById("updatedContactInfo").innerHTML = "Your contact has been updated!";
			}
		};
		xhr.send(jsonPay);
	}
	catch(err)
	{
		document.getElementById("updatedContactInfo").innerHTML = err.message;
	}

}

function deleteContact()
{
	
}

function isLoggedIn () {
    // ...
    const { token, user } = response.body
    localStorage.setItem('user', user)
}

function logout () {
    localStorage.removeItem('token')
	localStorage.removeItem('user')
	
	userId = 0;
	firstName = "";
	lastName = "";
	document.cookie = "firstName= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
	window.location.href = "index.html";
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

