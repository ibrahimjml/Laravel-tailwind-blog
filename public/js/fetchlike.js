
  let btn =document.querySelector('.likeBTN');
  function fetchLike(postID){
    

let options ={
 method: 'POST',
 headers :{
  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
  'Content-Type': 'application/json'
 }
}

fetch(`/post/${postID}/like` ,options)

.then(response=>response.json())
.then((data) => {
 if(data.liked){
  let likescount = document.getElementById('likes-count').innerText;
  document.getElementById('likes-count').innerText=parseInt(likescount) + 1;
  btn.textContent ="Unlike";
  randomhearts();
 }else{
  let likescount = document.getElementById('likes-count').innerText;
  document.getElementById('likes-count').innerText= parseInt(likescount) - 1;
   btn.textContent="Like";
   
   
 }
});
  }

    
     
 
 
  
 
