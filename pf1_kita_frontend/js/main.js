'use strict'

//parametor사용하기 위해 onclick 사용! 
function showmodal(prof) {
    if(prof == 'lee'){
        var modal = document.getElementById('leeModal');
        var img = document.getElementById('leeImage');
        var idx = 0;
    } else {
        var modal = document.getElementById('hwangModal');
        var img = document.getElementById("hwangImage");
        var idx = 1;
    }
    modal.style.display = "block";

    // // When the user clicks x , close it
    // document.getElementsByClassName('close').onclick = function() {
    //     modal.style.display = "none";
    // } //이거 이상해!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

// When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
        modal.style.display = "none";
        }
    }
}

// Get the modal
var modal = document.getElementById('id');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
    modal.style.display = "none";
    }
}


// Get the modal
var modal = document.getElementById('signup');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
    modal.style.display = "none";
    }
}



// When the user clicks the image, open the modal 
// img.onclick = function() {
//     modal.style.display = "block";
// }

// When the user clicks on <span> (x), close the modal
// span.onclick = function() {
//     modal.style.display = "none";
// }
//Q x누르면 닫히지 않음.

// When the user clicks anywhere outside of the modal, close it
// window.onclick = function(event) {
//     if (event.target == modal) {
//     modal.style.display = "none";
//     }
// }

// //각각 하지 않고 parametor (위에 참조)

// // Get the leeModal
// var modal = document.getElementById("leeModal");

// // Get the image that opens the modal
// var img = document.getElementById("leeImage");

// //OR

// // Get the hwangModal
// var modal = document.getElementById("hwangModal");

// // Get the image that opens the modal
// var img = document.getElementById("hwangImage");


//Accordion Javascript
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
acc[i].addEventListener("click", function() {
/* Toggle between adding and removing the "active" class,
to highlight the button that controls the panel */
this.classList.toggle("active");

/* Toggle between hiding and showing the active panel */
var panel = this.nextElementSibling;
if (panel.style.display === "block") {
    panel.style.display = "none";
} else {
    panel.style.display = "block";
}
});
}


