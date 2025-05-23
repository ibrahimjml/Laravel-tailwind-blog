
function fetchLike(eo) {
  const icon = eo.querySelector('.like-icon');
  const postID = icon.dataset.id;

  fetch(`/post/${postID}/like`, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      'Content-Type': 'application/json'
    }
  })
    .then(response => response.json())
    .then(data => {
      const countSpan = document.querySelector('#likes-count');
      let count = parseInt(countSpan.textContent);


      if (data.liked) {
        icon.classList.remove('far');
        randomhearts();
        icon.classList.add('fas', 'text-red-500');
        countSpan.textContent = count + 1;
      } else {
        icon.classList.remove('fas', 'text-red-500');
        icon.classList.add('far');
        countSpan.textContent = count - 1;
      }
    });
}
