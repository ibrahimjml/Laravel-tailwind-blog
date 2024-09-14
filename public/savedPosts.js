document.addEventListener('DOMContentLoaded', () => {
  const saveButtons = document.querySelectorAll('.save-post-button');
  const removeButtons = document.querySelectorAll('.remove-saved-post-button');

  saveButtons.forEach(button => {
      button.addEventListener('click', (event) => {
          event.preventDefault();
          const postId = button.dataset.postId;
          fetch(`/posts/${postId}/save`, {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
              }
          }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    button.textContent = 'Saved';
                    button.classList.remove('bg-blue-500');
                    button.classList.add('bg-green-500');
                }
            }).catch(error => console.error('Error:', error));
      });
  });

  removeButtons.forEach(button => {
      button.addEventListener('click', (event) => {
          event.preventDefault();
          const postId = button.dataset.postId;
          fetch(`/saved-posts/${postId}`, {
              method: 'DELETE',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
              }
          }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    button.closest('.post').remove();
                }
            }).catch(error => console.error('Error:', error));
      });
  });
});
