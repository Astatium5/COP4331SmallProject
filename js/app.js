const urlBase = 'http://cop4331team21.live/LAMPAPI';
const extension = '.php';

let userId = 0;
let firstName = '';
let lastName = '';

// login
function doLogin() {
	userId = 0;
	firstName = '';
	lastName = '';

	const login = document.getElementById('login').value;
	const password = document.getElementById('password').value;
	const hash = md5(password);

	const obj = new Object();
	obj.login = login;
	obj.password = hash;

	const jsonPayload = JSON.stringify(obj);
	console.log(jsonPayload);
	const url = urlBase + '/login' + extension;

	const xhr = new XMLHttpRequest();
	xhr.open('POST', url, true);
	xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8');

	try {
		console.log('test 31');
		xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				const jsonObject = JSON.parse(xhr.responseText);

				userId = jsonObject.uid;

				if (userId < 1) {
					document.getElementById('loginResult').innerHTML = 'User/Password combination incorrect';
					return;
				}

				console.log(jsonObject);

				firstName = jsonObject.firstName;
				lastName = jsonObject.lastName;

				saveCookie();

				window.location.href = 'contacts.html';
			}
		};

		xhr.send(jsonPayload);
	} catch (err) {
		document.getElementById('loginResult').innerHTML = err.message;
	}
}

// register
function doRegister() {
	userId = 0;
	firstName = '';
	lastName = '';

	const login = document.getElementById('registerName').value;
	const password = document.getElementById('registerPassword').value;
	const first = document.getElementById('registerFirst').value;
	const last = document.getElementById('registerLast').value;
	const input = document.querySelector('div.form-label-group input');

	if (!password) {
		input.dataset.state = '';
		return;
	}

	const trimmed = password.trim();

	if (trimmed) {
		input.dataset.state = 'valid';
	}

	else {
		input.dataset.state = 'invalid';
		return;
	}

	const hash = md5(trimmed);
	let obj = new Object();
	obj.login = login;
	obj.password = hash;
	obj.firstName = first;
	obj.lastName = last;

	const jsonPayload = JSON.stringify(obj);
	const url = urlBase + '/register' + extension;
	console.log(jsonPayload);
	
	const xhr = new XMLHttpRequest();
	xhr.open('POST', url, true);
	xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8');

	try {
		xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				window.location.href = 'contacts.html';
			}
		};

		xhr.send(jsonPayload);
	} catch (err) {
		document.getElementById('registerContactResult').innerHTML = err.message;
	}
}

function saveCookie() {
	const minutes = 20;
	const date = new Date();
	date.setTime(date.getTime()+(minutes*60*1000));
	document.cookie = 'firstName=' + firstName + ',lastName=' + lastName + ',userId=' + userId + ';expires=' + date.toGMTString();
}

function readCookie() {
	userId = -1;
	const data = document.cookie;
	const splits = data.split(',');

	for (let i = 0; i < splits.length; i++) {
		const thisOne = splits[i].trim();
		const tokens = thisOne.split('=');

		if (tokens[0] == 'firstName') {
			firstName = tokens[1];
		} else if (tokens[0] == 'lastName') {
			lastName = tokens[1];
		} else if (tokens[0] == 'userId') {
			userId = parseInt(tokens[1].trim());
		}
	}

	if (userId < 0) {
		window.location.href = 'index.html';
	} else {
		document.getElementById('userName').innerHTML = 'Logged in as ' + firstName + ' ' + lastName;
	}
}

// logout
function doLogout() {
	userId = 0;
	firstName = '';
	lastName = '';
	document.cookie = 'firstName= ; expires = Thu, 01 Jan 1970 00:00:00 GMT';
	window.location.href = 'index.html';
}

// add a contact
function addContact() {
	const firstName = document.getElementById('contactFirstName').value;
	const lastName = document.getElementById('contactLastName').value;
	const phone = document.getElementById('phone').value;
	const email = document.getElementById('email').value;
	const address = document.getElementById('address').value;
	const city = document.getElementById('city').value;
	const state = document.getElementById('state').value;
	const zipCode = document.getElementById('zip').value;

	const obj = new Object();
	obj.uid = userId;
	obj.firstName = firstName;
	obj.lastName = lastName;
	obj.phone = phone;
	obj.email = email;
	obj.address = address;
	obj.city = city;
	obj.state = state;
	obj.zip = zipCode;

	const jsonPayload = JSON.stringify(obj);
	const url = urlBase + '/create' + extension;

	const xhr = new XMLHttpRequest();
	xhr.open('POST', url, true);
	xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8');

	try {
		xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				// document.getElementById('createContactResult').innerHTML = 'A new contact has been added!';
			}
		};
		xhr.send(jsonPayload);
	} catch (err) {
		document.getElementById('createContactResult').innerHTML = err.message;
	}
}

// update contact
function updateContact() {
	const firstName = document.getElementById('editedFirstName').value;
	const lastName = document.getElementById('editedLastName').value;
	const phone = document.getElementById('editedPhone').value;
	const email = document.getElementById('editedEmail').value;
	const address = document.getElementById('editedAddress').value;
	const city = document.getElementById('editedCity').value;
	const state = document.getElementById('editedState').value;
	const zip = document.getElementById('editedZip').value;
	// const cid; // must be added from the data attribute from html

	const obj = new Object();
	// obj.cid = cid;
	obj.firstName = firstName;
	obj.lastName = lastName;
	obj.phone = phone;
	obj.email = email;
	obj.address = address;
	obj.city = city;
	obj.state = state;
	obj.zip = zip;

	const jsonPayload = JSON.stringify(obj);
	const url = urlBase + '/update' + extension;

	const xhr = new XMLHttpRequest();
	xhr.open('POST', url, true);
	xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8');
}

// delete contact
function deleteContact() {
	// const cid; // must be added from the data attribute from html

	const obj = new Object();
	// obj.cid = cid;

	const jsonPayload = JSON.stringify(obj);
	const url = urlBase + '/delete' + extension;

	const xhr = new XMLHttpRequest();
	xhr.open('DELETE', url, true);
	xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8');

	try {
		xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				// should have "updated successfuly somewhere in html"
			}
		};

		xhr.send(jsonPayload);
	} catch (err) {

	}
}

// search for a contact
function searchContact() {
	const srch = document.getElementById('searchText').value;
	document.getElementById('contactSearchResult').innerHTML = '';

	let contactList = '';

	const jsonPayload = '{"search" : "' + srch + '","uid" : ' + userId + '}';
	const url = urlBase + '/search' + extension;

	const xhr = new XMLHttpRequest();
	xhr.open('POST', url, true);
	xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8');

	try {
		xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById('contactSearchResult').innerHTML = 'Contact(s) has been retrieved';
				const jsonObject = JSON.parse(xhr.responseText);

				for (let i = 0; i < jsonObject.results.length; i++) {
					contactList += jsonObject.results[i];

					if (i < jsonObject.results.length - 1) {
						contactList += '<br />\r\n';
					}
				}

				document.getElementsByTagName('p')[0].innerHTML = contactList;
			}
		};
		xhr.send(jsonPayload);
	} catch (err) {
		document.getElementById('contactSearchResult').innerHTML = err.message;
	}
}
