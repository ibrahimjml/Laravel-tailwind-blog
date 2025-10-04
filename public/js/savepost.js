function save(eo,postId) {

  const icon = eo.querySelector('i.fa-bookmark'); 
  const span = eo.querySelector('span');

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
        icon.classList.replace('fas','far');
        span.textContent = '+';
        span.classList.replace('text-white','text-gray-600');

      } else if (data.status === 'added') {
        toastr.options = {
          "progressBar": true,
          "positionClass": "toast-top-right",
          "timeOut": 1000
        };
        toastr.success("Bookmark Added ");
        icon.classList.replace('far','fas');
        span.textContent = '✓';
        span.classList.replace('text-gray-600','text-white');
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });
}
