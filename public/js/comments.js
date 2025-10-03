// ========== delete|edit comment model ==========

  document.body.addEventListener('click', (eo) => {
    const modelBtn = eo.target.closest('.opencommentmodel-btn');
    const commentBlock = eo.target.closest('.comment, .reply');

    if (modelBtn && commentBlock) {

      document.querySelectorAll('.commentmodel').forEach(modal => modal.classList.add('hidden'));

      const model = commentBlock.querySelector('.commentmodel');
      if (model) model.classList.toggle('hidden');
      return; 
    }

    if (!eo.target.closest('.commentmodel')) {
      document.querySelectorAll('.commentmodel').forEach(modal => modal.classList.add('hidden'));
    }
  });




// ========== Show/Hide Reply Form ==========

  document.body.addEventListener('click', (eo) => {
    if (eo.target.classList.contains('reply-btn')) {
      const form = eo.target.closest('.comment, .reply').querySelector('.reply-form');
      form.classList.toggle('hidden');
    }
  });



// ========== Show/Hide Edit Form ==========

  document.body.addEventListener('click', (eo) => {
    if (eo.target.classList.contains('edit-btn')) {
      const form = eo.target.closest('.comment, .reply').querySelector('.edit-form');
      form.classList.toggle('hidden');
    }
  });




// view replies / hide replies in parent node
document.body.addEventListener('click', (eo)=> {
  if (eo.target.classList.contains('show-all')) {
    const show = eo.target;
    const content = show.closest('.comment')?.querySelector('.reply-content');
    const count = parseInt(show.dataset.replyCount);

    if (!content || isNaN(count)) return;

    if (content.classList.contains('hidden')) {
      show.innerText = `hide ${count} repl${count > 1 ? 'ies' : 'y'}`;
      content.classList.remove('hidden');
    } else {
      content.classList.add('hidden');
      show.innerText = `view ${count} repl${count > 1 ? 'ies' : 'y'}`;
    }
  }
});

// view replies / hide replies inside nested replies

  document.body.addEventListener('click', (eo)=> {
    if (eo.target.classList.contains('view-all')) {
      let nested_content = eo.target.closest('.reply').querySelector('.nested-replies');
      let view = eo.target.closest('.reply').querySelector('.view-all');
      let repliesCount = eo.target.getAttribute('reply-replies-count');
      if (nested_content.classList.contains('hidden')) {
        view.innerText =` hide ${repliesCount} repl${repliesCount > 1 ? 'ies' : 'y'}`;
        nested_content.classList.remove('hidden');
      } else {
        nested_content.classList.add('hidden');
        view.innerText =` view ${repliesCount} repl${repliesCount > 1 ? 'ies' : 'y'}`;
        
      }
    }
  });
// update count based on addcomment/reply/delete
function updateCount(increment = 0) {
    const commentCountSpan = document.getElementById('comment-count-number');
    let currentCount = parseInt(commentCountSpan.dataset.count) || 0;
    currentCount += increment;
    
    commentCountSpan.dataset.count = currentCount;
    commentCountSpan.textContent = `(${currentCount})`;
}

// Ajax Add comment
const AddComment = document.querySelector('form[comment-form]');
AddComment.addEventListener('submit',async (eo)=>{
  eo.preventDefault();
  const postid = AddComment.getAttribute('comment-form');
  const textarea = AddComment.querySelector('textarea[name="content"]');
  const buttonSubmit = AddComment.querySelector('button[type=submit]');
  const originalText = buttonSubmit.textContent;
  const content = textarea.value.trim();
  const Wrapper = document.getElementById('wrapper');

  if(!content){
    toastr.error('please type a comment');
    return;
  }
  
  let options = {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    },
    body: JSON.stringify({ content })
  };
  try {
        // show spinner
        buttonSubmit.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        buttonSubmit.disabled = true;
    const response = await fetch(`/comment/${postid}`, options);
    if (response.ok) {
      const result = await response.json();
      if(result.commented){

        toastr.success("Comment Added ");
        textarea.value = '';
        Wrapper.insertAdjacentHTML('afterbegin', result.html);
        updateCount(1);
        // remove spinner
        buttonSubmit.textContent = originalText;
        buttonSubmit.disabled = false;
      }

    }else{
      throw new error('error something happened')
    }
  } catch (error) {
    console.error('Delete error:', error);
  }
});
// Ajax reply to comment
document.body.addEventListener('submit', async (eo) => {
  if (!eo.target.matches('form.reply-form')) return;
  
  eo.preventDefault();
  const form = eo.target;
  const commentID = form.getAttribute('comment-id');
  const textarea = form.querySelector('textarea[name="content"]');
  const buttonSubmit = form.querySelector('button[type=submit]');
  const originalText = buttonSubmit.textContent;
  const content = textarea.value.trim();
  const parentInput = form.querySelector('input[name="parent_id"]');
  const parent_id = parentInput.value;
  const body = JSON.stringify({ content, parent_id });

  let wrapper = document.getElementById(`wrapper-${commentID}`);
  if (!wrapper) {
    wrapper = form.closest('.reply')?.querySelector('.nested-replies');
  }

if(!content){
  toastr.error('please type a reply');
  form.classList.add('hidden');
  return;
}
  const options = {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    },
    body: body
  };



  try {
      // add spinner
      buttonSubmit.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
      buttonSubmit.disabled = true;

      const response = await fetch(`/reply/${commentID}`, options);
      const result = await response.json();

    if (result.error) {
      toastr.error(result.error);
      textarea.value = '';
      form.classList.add('hidden');
      return;
    }

    if (result.replied) {
    
      toastr.success("Reply added successfully");

      textarea.value = '';
      form.classList.add('hidden');
      wrapper.classList.remove('hidden');
      wrapper.insertAdjacentHTML('afterbegin', result.html);
      updateCount(1);
      // remove spinner
      buttonSubmit.textContent = originalText;
      buttonSubmit.disabled = false;
    }
  } catch (error) {
    console.error('Reply error:', error);
    toastr.error('Something went wrong.');
  }
});

// Ajax edit comment | reply 
document.body.addEventListener('submit', async function(eo) {
  const form = eo.target;
  if (!form.matches('form[edit-comment]')) return;
    eo.preventDefault();
    const commentId = form.getAttribute('edit-comment');
    const textarea = form.querySelector('textarea[name="content"]');
    const buttonSubmit = form.querySelector('button[type=submit]');
    const originalText = buttonSubmit.textContent;
    const content = textarea.value.trim();
    const oldContent = form.closest('.comment, .reply').querySelector('.comment-content');

    const parentInput = form.querySelector('input[name="parent_id"]');
    const parent_id = parentInput ? parentInput.value : null;
    const body = parent_id !== null ? JSON.stringify({ content, parent_id }): JSON.stringify({ content });

    let options = {
      method: 'PUT',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Content-Type': 'application/json',
          'Accept': 'application/json'
      },
      body: body
    };

    try {
        // add spinner
        buttonSubmit.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        buttonSubmit.disabled = true;
      const response = await fetch(`/comment/edit/${commentId}`, options);
      if (response.ok) {
        const result = await response.json();
        if(result.Edited){
          toastr.success("Comment updated successfully");
          // remove spinner
          buttonSubmit.textContent = originalText;
          buttonSubmit.disabled = true;
        
          if (oldContent) {
            oldContent.textContent = content;
            form.classList.add('hidden');
          }
        }

      }
    } catch (error) {
      console.error('Delete error:', error);
    }

})


// Ajax delete comment | reply
document.body.addEventListener('submit', async function(eo) {
  const form = eo.target;
  if (!form.matches('form[delete-comment]')) return;

    eo.preventDefault();
    const commentId = form.getAttribute('delete-comment');
    let options = {
      method: 'Delete',
      headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Content-Type': 'application/json',
            'Accept': 'application/json'
      },
      body: JSON.stringify({ id: commentId })
  };
  try{
  
    const response = await fetch(`/comment/${commentId}`,options)
     if(response.ok){
      const result = await response.json();
     if(result.deleted){
      toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": 2000
      };
      toastr.success("Comment deleted successfully");
      updateCount();
    // remove big container if its a comment or reply 
    let parentComment = form.closest('.reply') || form.closest('.comment');
    if (parentComment) {
    
      parentComment.remove();
      
    }
    updateCount(-1);
     }
  }
  }catch(error){
    console.error('Delete error:', error);
  
  }
  
})

