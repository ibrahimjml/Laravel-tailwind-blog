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




