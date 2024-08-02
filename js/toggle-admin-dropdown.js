//Simply toggles the dropdown menu on admin-main
/*
function toggleDropdown() {
    console.log("yep");
    var dropdown = document.getElementById("myDropdown");
    if (dropdown.style.display === "none") {
        dropdown.style.display = "block";
    } else {
        dropdown.style.display = "none";
    }
}*/

document.addEventListener('DOMContentLoaded', function () {
    function toggleDropdown() {
        console.log("yep");
        var dropdown = document.getElementById("myDropdown");
        if (dropdown.style.display === "none") {
            dropdown.style.display = "block";
        } else {
            dropdown.style.display = "none";
        }
    }

    var button = document.querySelector('.dd-button');
    if (button) {
        button.addEventListener('click', toggleDropdown);
    }
});
