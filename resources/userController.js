var userXhr = new XMLHttpRequest();
var users = [];
userXhr.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
        users = JSON.parse(this.responseText)['message'];
        refreshUsers();
    }
    if (this.readyState === 4 && this.status !== 200) {

    }
};

function clearUsers() {
    var table = document.getElementById("user");
    while (table.rows.length > 0) {
        table.deleteRow(0);
    }
}

function refreshUsers() {
    clearUsers();
    var table = document.getElementById("user");
    var row = table.insertRow();
    row.insertCell(0).innerHTML = 'Id';
    row.insertCell(1).innerHTML = 'Name';
    row.insertCell(2).innerHTML = 'Email';
    row.insertCell(3).innerHTML = 'Action'
    for (i = 0; i < users.length; i++) {
        row = table.insertRow(i + 1);
        row.insertCell(0).innerHTML = users[i].id;
        row.insertCell(1).innerHTML = users[i].name;
        row.insertCell(2).innerHTML = users[i].email;
        row.insertCell(3).innerHTML = '<button id="delete" onclick="deleteUser('+users[i].id+')">Delete</button>';
        row.insertCell(3).innerHTML += '<button>Edit</button>';
        row.insertCell(3).innerHTML += '<button onclick="getUserTask('+users[i].id+')">Tasks</button>';
    }
}

function getUser(id) {
    userXhr.open("GET", "http://localhost/app.php/user/"+id);
    userXhr.send();
}

function getUsers() {
    userXhr.open("GET", "http://localhost/app.php/user");
    userXhr.send();
}

/**
 *
 * @param name
 * @param email
 */
function createUser(name, email) {
    userXhr.open("POST", 'http://localhost/app.php/user');
    userXhr.send("{name: "+name+", email: "+email+"}");
}

function updateUser(id, email, name) {
    userXhr.open("PUT", 'http://localhost/app.php/user/'+id);
    userXhr.send("{name: "+name+", email: "+email+"}");
}

function deleteUser(id) {
    userXhr.open("DELETE", 'http://localhost/app.php/user/'+id);
    userXhr.send();
}