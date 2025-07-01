const apiurl = 'http://127.0.0.1:5000'; // Ensure this URL is correct for your Flask API

// Function to get all users
function getallusers() {
    alert('Getting all users');
    fetch(`${apiurl}/GetAllUsers`, { method: 'GET' })
    .then(response => response.json())
    .then(data => displayresponse(data))
    .catch(error => console.error('Error:', error));
}

// Function to get a user by ID
function getuser() {
    alert('Getting user');
    const userid = document.getElementById('getuserid').value;
    fetch(`${apiurl}/GetUser?id=${userid}`, { method: 'GET' })
    .then(response => response.json())
    .then(data => displayresponse(data))
    .catch(error => console.error('Error:', error));
}

// Function to insert a new user
function insertuser() {
    // Retrieve the values from the form
    const email = document.getElementById('addemail').value;
    const password = document.getElementById('addpassword').value;
    
    const myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");

    const raw = JSON.stringify({
        "email": email, // Now dynamically taking values from the input fields
        "password": password
    });

    const requestOptions = {
        method: "POST",
        headers: myHeaders,
        body: raw,
        redirect: "follow"
    };

    fetch("http://127.0.0.1:5000/InsertUser", requestOptions)
    .then((response) => response.text())
    .then((result) => console.log(result))
    .catch((error) => console.error(error));
}

// Function to update a user by ID
function updateuser() {
    alert('Updating user');
    const userid = document.getElementById('updateuserid').value;
    const email = document.getElementById('updateemail').value;
    const password = document.getElementById('updatepassword').value;
    const user = { email, password };
    fetch(`${apiurl}/UpdateUser?id=${userid}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(user)
    })
    .then(response => response.json())
    .then(data => displayresponse(data))
    .catch(error => console.error('Error:', error));
}

// Function to delete a user by ID
function deleteuser() {
    alert('Deleting user');
    const userid = document.getElementById('deleteuserid').value;
    fetch(`${apiurl}/DeleteUser?id=${userid}`, { method: 'DELETE' })
    .then(response => response.json())
    .then(data => displayresponse(data))
    .catch(error => console.error('Error:', error));
}

// Function to display response data on the webpage
function displayresponse(data) {
    const responseDiv = document.getElementById('response');
    responseDiv.innerHTML = `<pre>${JSON.stringify(data, null, 2)}</pre>`;
}
