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
			console.log(this.status);
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
	} else {
		input.dataset.state = 'invalid';
		return;
	}

	const hash = md5(trimmed);
	const obj = new Object();
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
		console.log('test 105');
		xhr.onreadystatechange = function() {
			console.log(this.readyState + this.status);
			if (this.readyState == 4 && this.status == 200) {
				const jsonResponse = JSON.parse(xhr.responseText);

				if (jsonResponse.error != '') {
					document.getElementById('registerResult').innerHTML = 'The user with the given username already exists';
					return;
				}

				userId = jsonResponse.uid;
				firstName = first;
				lastName = last;

				saveCookie();
				window.location.href = 'contacts.html';
			}
		};

		xhr.send(jsonPayload);
	} catch (err) {
		document.getElementById('registerResult').innerHTML = err.message;
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
		const contactsUserName = document.getElementById('contactsUserName');

		contactsUserName.innerHTML = firstName + ' ' + lastName;
		contactsUserName.classList.add("navlink");
		contactsUserName.dataset.indexNumber = userId;
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
	const uid = document.getElementById('contactsUserName').dataset.indexNumber;
	const contactFirstName = document.getElementById('contactAddFirstName').value;
	const contactLastName = document.getElementById('contactAddLastName').value;
	const phone = document.getElementById('contactAddPhone').value;
	const email = document.getElementById('contactAddEmail').value;
	const address = document.getElementById('contactAddAddress').value;
	const city = document.getElementById('contactAddCity').value;
	const state = document.getElementById('contactAddState').value;
	const zipCode = document.getElementById('contactAddZip').value;

	const obj = new Object();
	obj.uid = uid;
	obj.firstName = contactFirstName;
	obj.lastName = contactLastName;
	obj.phone = phone;
	obj.email = email;
	obj.address = address;
	obj.city = city;
	obj.state = state;
	obj.zip = zipCode;

	const jsonPayload = JSON.stringify(obj);
	const url = urlBase + '/create' + extension;
	console.log(jsonPayload);

	const xhr = new XMLHttpRequest();
	xhr.open('POST', url, true);
	xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8');

	try {
		xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById('createContactResult').innerHTML = 'A new contact has been added!';
				deleteContactsFromTable();
				retrieveContacts();
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
	const cid = document.getElementById('editedFirstName').dataset.indexNumber;

	const obj = new Object();
	obj.cid = cid;
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

	try {
		xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById('contactDeleteStatus').innerHTML = 'The contact was updated succesfully';
				deleteContactsFromTable();
				retrieveContacts();
			}
			
			xhr.send(jsonPayload);
		}
	} catch (err) {
		document.getElementById('contactDeleteStatus').innerHTML = 'The contact update was unsuccessful';
	}
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
	const uid = document.getElementById('contactsUserName').dataset.indexNumber;
	document.getElementById('contactSearchResult').innerHTML = '';

	let contactList = '';

	const obj = new Object();
	obj.search = srch;
	obj.uid = uid;

	const jsonPayload = JSON.stringify(obj);
	const url = urlBase + '/search' + extension;

	const xhr = new XMLHttpRequest();
	xhr.open('POST', url, true);
	xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8');

	try {
		xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById('contactSearchResult').innerHTML = 'Contact(s) has been retrieved';
				const jsonArray = JSON.parse(xhr.responseText);

				for (let i = 0; i < jsonArray.length; i++) {
					contactList += jsonArray[i];

					if (i < jsonArray.length - 1) {
						contactList += '<br />\r\n';
					}
				}

				document.getElementsByTagName('contactList').innerHTML = contactList;
			}
		};
		xhr.send(jsonPayload);
	} catch (err) {
		document.getElementById('contactSearchResult').innerHTML = err.message;
	}
}

// retrieves the contacts from the retrieve.php and puts them in a table
function retrieveContacts() {
	const uid = document.getElementById('contactsUserName').dataset.indexNumber;
	let contactID = 0;

	const obj = new Object();
	obj.uid = uid;

	const jsonPayload = JSON.stringify(obj);
	const url = urlBase + '/retrieve' + extension;

	const xhr = new XMLHttpRequest();
	xhr.open('POST', url, true);
	xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8');

	console.log('outside retrieve');
	try {
		xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				const JSONArray = JSON.parse(xhr.responseText);

				console.log('inside retrieve');

				for (let i = 0; i < JSONArray.length; i++) {
					// gets the contact id
					contactID = JSONArray[i].cid;

					const table = document.getElementById('userTable');

					const row = document.createElement('tr');
					const firstNameField = document.createElement('td');
					const lastNameField = document.createElement('td');
					const buttonField = document.createElement('td');
					const manageButton = document.createElement('button');

					row.dataset.indexNumber = JSONArray[i].cid;

					firstNameField.innerHTML = JSONArray[i].firstName;
					lastNameField.innerHTML = JSONArray[i].lastName;

					manageButton.type = 'button';
					manageButton.classList.add('btn btn-primary');
					manageButton.onclick = manageContact(JSONArray[i]);
					manageButton.innerHTML = 'Manage';

					buttonField.append(manageButton);
					row.append(firstNameField);
					row.append(lastNameField);
					row.append(buttonField);
					table.append(row);
				}
			}
		};

		xhr.send(jsonPayload);
	} catch (err) {
		const errorField = document.createElement('td');
		errorField.innerHTML = err.message;

		document.getElementById('userTable').append(errorField);
	}
}

// deletes contacts from the table when required
function deleteContactsFromTable() {
	const parent = document.getElementById('userTable');

	while (parent.firstChild) {
		parent.firstChild.remove();
	}
}

// this function reads the data of the selected json and those become the elements in the update form
function manageContact(selectedJSON) {
	document.getElementById('editedFirstName').dataset.indexNumber = selectedJSON.cid;
	document.getElementById('editedFirstName').placeholder = selectedJSON.firstName;
	document.getElementById('editedLastName').placeholder = selectedJSON.lastName;
	document.getElementById('editedEmail').placeholder = selectedJSON.email;
	document.getElementById('editedPhone').placeholder = selectedJSON.phone;
	document.getElementById('editedAddress').placeholder = selectedJSON.address;
	document.getElementById('editedCity').placeholder = selectedJSON.city;
	document.getElementById('editedState').placeholder = selectedJSON.state;
	document.getElementById('editedZip').placeholder = selectedJSON.zip;
}

// is supposed to filter search the table of contacts
function searchTable(value, contactsArray) {
	const filteredData = [];

	for (let i = 0; i < contactsArray.length; i++) {
		value = value.toLowerCase();
		const first = contactsArray[i].firstName.toLowerCase();

		if (first.includes(value)) {
	  filteredData.push(contactsArray[i]);
		}
	}

	return filteredData;
}
