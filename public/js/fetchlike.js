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
      const countSpan = eo.querySelector('#likes-count');
      let count = parseInt(countSpan.textContent);

      if (data.liked) {
        icon.classList.remove('fa-regular');
        randomhearts();
        icon.classList.add('fa-solid', 'text-red-500');
        countSpan.textContent = count + 1;
      } else {
        icon.classList.remove('fa-solid', 'text-red-500');
        icon.classList.add('fa-regular');
        countSpan.textContent = count - 1;
      }
    });
}
