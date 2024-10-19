const parag = document.getElementById('parag');
const parag2 = document.getElementById('parag2');
const parag3 = document.getElementById('parag3');


if(parag){
setTimeout(() => {

  parag.style.display="none";
}, 1000);
setTimeout(()=>{
  parag.remove();
  },2000);
}

if(parag2){
setTimeout(() => {
parag2.style.display="none";
}, 3000);
setTimeout(()=>{
parag2.remove();
},3500);
}

if(parag3 && !localStorage.getItem('successmessage')){
  
setTimeout(() => {
  parag3.style.display="none";
}, 3000);

  localStorage.setItem('successmessage', true);
}else if(parag3){
parag3.remove();
}


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

// hide/show table
postButton.addEventListener("click",(eo) => {
  postButton.classList.add('active');
  userButton.classList.remove("active")
  postTable.style.display="table";
  usersTable.style.display="none";
  titleBody.textContent="Posts Table";
})
userButton.addEventListener("click",(eo) => {
  userButton.classList.add("active");
  postButton.classList.remove("active");
  usersTable.style.display="table";
  postTable.style.display="none";
  titleBody.textContent="Users Table"
})