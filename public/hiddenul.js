const hiddenu2 = document.getElementById("hiddenu2");
const change = document.getElementById("dropdown");
const mobilebtn = document.querySelector("#mobile-btn");
const mobilemenu = document.querySelector("#mobile-menu");


mobilebtn.addEventListener('click',()=>{
mobilemenu.classList.toggle('hidden');
} )


if(change){
change.addEventListener("mousemove",(eo) => {
hiddenul2.style.display="block";
});

change.addEventListener("mouseout",(eo) => {
hiddenul2.style.display="none";
});
}