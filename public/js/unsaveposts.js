function unsavedposts(postId) {

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
      if (data.status === 'removed') {
        toastr.success("Bookmark Removed ");
          const bigContainer = document.getElementById(`post-${postId}`);

          if (bigContainer) {
            bigContainer.remove();
            checkNoSavedPosts();
          }
        
      } 
    })
    .catch(error => {
      console.error('Error:', error);
    });
}
