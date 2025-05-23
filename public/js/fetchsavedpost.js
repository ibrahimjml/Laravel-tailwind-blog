function savedTo(el,postId) {

  const icon = el.querySelector('.bookmark-icon'); 

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
        icon.classList.remove('fas');
        icon.classList.add('far');

      } else if (data.status === 'added') {
        toastr.options = {
          "progressBar": true,
          "positionClass": "toast-top-right",
          "timeOut": 1000
        };
        toastr.success("Bookmark Added ");
        icon.classList.remove('far');
        icon.classList.add('fas');
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });
}
// function check saved posts if == 0 remove hidden from message
function checkNoSavedPosts() {
  const savedPosts = document.querySelectorAll('.saved-post');
  const noSavedMsg = document.getElementById('noSavedMessage');

  if (savedPosts.length === 0 && noSavedMsg) {
    noSavedMsg.classList.remove('hidden');
  }
}