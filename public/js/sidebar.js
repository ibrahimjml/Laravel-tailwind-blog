const sidebar = document.getElementById("sidebar");
const spn = document.getElementById("spn");
const mainadmin = document.querySelector('.admin');
const userButton = document.getElementById("user-btn");
const postButton = document.getElementById("post-btn");
const titleBody = document.getElementById("title-body");
const postTable = document.getElementById("posts-table");
const usersTable = document.getElementById("users-table");

spn.addEventListener("click", () => {

  mainadmin.classList.toggle("collapsed");


  if (mainadmin.classList.contains("collapsed")) {
    spn.innerHTML = "&rightarrow;"; 
  } else {
    spn.innerHTML = "&leftarrow;";
  }


});