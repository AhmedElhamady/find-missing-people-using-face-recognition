// show only one task on click on it and hide other
let tasks = document.querySelectorAll(".tasks li");
let task = document.querySelectorAll(".content .task");
// let report = document.querySelector(".tasks .report");
// let user = document.querySelector(".tasks .user");
// let admin = document.querySelector(".tasks .admin");
// let contact = document.querySelector(".tasks .contact");
tasks.forEach(function(ele) {
    ele.addEventListener("click", function(e) {
        e.stopPropagation();
        tasks.forEach(e=> e.classList.remove("clicked"))
        ele.classList.add("clicked");
        task.forEach(function(task){
            task.classList.remove("clicked");
        })
        document.querySelector(ele.dataset.task).classList.add("clicked");
        localStorage.setItem("target", ele.dataset.task)
    })
})
let target = localStorage.getItem("target");
if(target!==null) {
    tasks.forEach(e=> e.classList.remove("clicked"));
    tasks.forEach(function(e) {
        if(e.dataset.task == target)
            e.classList.add("clicked");
    })
    task.forEach(task=> task.classList.remove("clicked"));
    document.querySelector(target).classList.add("clicked");
}
// for users too 
let fltr = document.querySelectorAll(".fltr div");
let fltrUsers = document.querySelectorAll(".content .fltr-users");
// console.log(fltr);
// console.log(fltrUsers);
fltr.forEach(function(ele) {
    ele.addEventListener("click", function(e) {
        e.stopPropagation();
        fltr.forEach(e=> e.classList.remove("clicked"))
        ele.classList.add("clicked");
        fltrUsers.forEach(function(fltrUser){
            fltrUser.classList.remove("clicked");
        })
        document.querySelector(ele.dataset.task).classList.add("clicked");
        localStorage.setItem("target-user", ele.dataset.task);
    })
})
let targetUser = localStorage.getItem("target-user");
if(targetUser!==null) {
    fltr.forEach(e=> e.classList.remove("clicked"));
    fltr.forEach(function(e) {
        if(e.dataset.task == targetUser)
            e.classList.add("clicked");
    })
    fltrUsers.forEach(task=> task.classList.remove("clicked"));
    document.querySelector(targetUser).classList.add("clicked");
}

// request ajax
let btnsMore = document.querySelectorAll(".report .operation .more");
let modelView = document.querySelector(".model-view");
let overlay = document.querySelector(".overlay");
let close = document.querySelector(".model-view .close");
btnsMore.forEach(function(btn) {
    btn.addEventListener("click", function() {
        let request = new XMLHttpRequest();
        request.open("POST", "view-report.php");
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        // request.setRequestHeader("Content-type", "application/json");
        let data = "id="+`${this.dataset.id}`;
        request.send(data);
        overlay.classList.add("start");
        modelView.classList.add("start");
        close.addEventListener("click", function (){
            overlay.classList.remove("start");
            modelView.classList.remove("start");
        })
        request.onreadystatechange = function() {
            if (request.readyState === 4 && request.status === 200) {
                // console.log (request)
                // document.querySelector(".model-view .id").innerHTML = request.response;
                const myObjct = JSON.parse(this.responseText);
                modelView.querySelector(".child-name span").innerHTML = myObjct["child-name"];
                modelView.querySelector(".age span").innerHTML = myObjct.age;
                modelView.querySelector(".gender span").innerHTML = myObjct.gender;
                modelView.querySelector(".health-state span").innerHTML = myObjct.health;
                modelView.querySelector(".type span").innerHTML = myObjct.type;
                modelView.querySelector(".date span").innerHTML = myObjct.date;
                modelView.querySelector(".child-city span").innerHTML = myObjct["child-city"];
                modelView.querySelector(".reporter-name span").innerHTML = myObjct["reporter-name"];
                modelView.querySelector(".reporter-city span").innerHTML = myObjct["reporter-city"];
                modelView.querySelector(".phone span").innerHTML = myObjct.phone;
                modelView.querySelector(".ssn span").innerHTML = myObjct.ssn;
                modelView.querySelector(".relation span").innerHTML = myObjct.relevance;
                modelView.querySelector(".id span").innerHTML = myObjct.user.id;
                modelView.querySelector(".email span").innerHTML = myObjct.user.email;
                modelView.querySelector(".name span").innerHTML = myObjct.user.fname +" "+ myObjct.user.lname;
            }
        }
        // request.onload = function() {
        //     // Handle response
        //     console.log(request.responseText);
        // };
        // console.log (this.dataset.id);
    })
})

// delete report
let dels = document.querySelectorAll(".delete");
let deleteReport = document.querySelector(".delete-report");
let cancle = deleteReport.querySelector(".cancle");
let ok = deleteReport.querySelector(".ok");
let id = "";
dels.forEach(ele=>{
    ele.addEventListener("click", function() {
        overlay.style.display="block";
        deleteReport.style.display="flex";
        id = ele.dataset.id;
        ok.href= "delete-report.php?id="+id;
    });
});
cancle.addEventListener("click", function() {
    overlay.style.display="none";
    deleteReport.style.display="none";
    ok.href="";
});
ok.addEventListener("click", function() {
    overlay.style.display="none";
    deleteReport.style.display="none";
});

// show message in contact section
let textShow = document.querySelectorAll(".call .show-text");
textShow.forEach(function(ele) {
    ele.addEventListener("click", function() {
        // console.log(ele);
        if(ele.innerHTML=="Show") {
            ele.innerHTML="Hide";
        } else {
            ele.innerHTML="Show";
        }
        let problem = ele.parentElement.parentElement;
        let message = problem.querySelector(".action");
        message.classList.toggle("active");
    })
})


