var taskXhr = new XMLHttpRequest();
var tasks = [];
taskXhr.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
        tasks = JSON.parse(this.responseText)['message'];
        refereshTasks();
    }
    if (this.readyState === 4 && this.status !== 200) {

    }
};

function clearTasks() {
    var table = document.getElementById("task");
    while (table.rows.length > 0) {
        table.deleteRow(0);
    }
}

function refereshTasks() {
    clearTasks();
    var table = document.getElementById("task");
    var row = table.insertRow();
    row.insertCell(0).innerHTML = 'Id';
    row.insertCell(1).innerHTML = 'Title';
    row.insertCell(2).innerHTML = 'Description';
    row.insertCell(3).innerHTML = 'Creation Date';
    row.insertCell(4).innerHTML = 'Status';
    for (i = 0; i < tasks.length; i++) {
        row = table.insertRow(i + 1);
        row.insertCell(0).innerHTML = tasks[i].id;
        row.insertCell(1).innerHTML = tasks[i].title;
        row.insertCell(2).innerHTML = tasks[i].description;
        row.insertCell(3).innerHTML = tasks[i].creationDate;
        row.insertCell(4).innerHTML = tasks[i].status;

        row.insertCell(5).innerHTML = '<button id="delete" onclick="deleteTask('+tasks[i].id+')"></button>';
        row.insertCell(5).innerHTML += '<button>Editer</button>'
    }

}

function getUserTask(user_id) {
    taskXhr.open("GET", "http://localhost/app.php/task?user_id="+user_id);
    taskXhr.send();
}