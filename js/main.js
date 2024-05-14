function viewCancelledNotification() {
    var cancelledNotification = document.getElementById("cancelledNotification");
    cancelledNotification.style.display = "block";
}

function closeCancelledNotification() {
    var cancelledNotification = document.getElementById("cancelledNotification");
    cancelledNotification.style.display = "none";
}

function viewRegisteredNotification() {
    var registeredNotification = document.getElementById("registeredNotification");
    registeredNotification.style.display = "block";
}

function closeRegisteredNotification() {
    var registeredNotification = document.getElementById("registeredNotification");
    registeredNotification.style.display = "none";
}

function datePicker() {
    var date = new Date();
    var tdate = date.getDate();
    var month = date.getMonth() + 1;
    if(tdate < 10){
        tdate = '0' + tdate;
    }
    if(month < 10){
        month = '0' + month;
    }
    var year = date.getUTCFullYear();
    var minDate = year + "-" + month + "-" + tdate;
    document.getElementById("returned").setAttribute('min', minDate);
    console.log(minDate);
}