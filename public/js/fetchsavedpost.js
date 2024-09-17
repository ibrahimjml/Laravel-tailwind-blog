function savedTo(postId){
  let save = document.querySelector(`[saved-post-id="${postId}"]`);

  let options = {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({ post_id: postId })
};

fetch(`/saved-post`, options)
    .then(response => response.json())
  
    .then(data => {
        if (data.status == 'removed') {
            save.innerHTML = "save";

        } else if (data.status == 'added') {
            // create element "popup"
            const popup = document.createElement("div");
            const body = document.getElementById("body");
            body.append(popup);
            popup.classList.add("popup");
            popup.innerText="Added to Saved";
          
            setTimeout(() => {
              popup.style.transform = "translateX(-50vw)";
              
            }, 1500)
            
             setTimeout(() => {
               popup.remove();
             }, 2000)

            save.innerHTML = "saved";
          
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });

  
}
