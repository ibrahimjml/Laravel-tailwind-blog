// ========== delete|edit comment model ==========
document.addEventListener('DOMContentLoaded', () => {
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
});



// ========== Show/Hide Reply Form ==========
document.addEventListener('DOMContentLoaded', () => {
  document.body.addEventListener('click', (eo) => {
    if (eo.target.classList.contains('reply-btn')) {
      const form = eo.target.closest('.comment, .reply').querySelector('.reply-form');
      form.classList.toggle('hidden');
    }
  });
});


// ========== Show/Hide Edit Form ==========
document.addEventListener('DOMContentLoaded', () => {
  document.body.addEventListener('click', (eo) => {
    if (eo.target.classList.contains('edit-btn')) {
      const form = eo.target.closest('.comment, .reply').querySelector('.edit-form');
      form.classList.toggle('hidden');
    }
  });
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
document.addEventListener('DOMContentLoaded', function() {
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
});
// function update Toatal number comments
function updateCount() {
  const commentCountSpan = document.getElementById('comment-count-number');
  const allVisibleComments = document.querySelectorAll('#wrapper .comment, #wrapper .reply');
  commentCountSpan.textContent = allVisibleComments.length;
} 
function updateReplyCount(parentElement) {
  if (!parentElement) return;

  const isComment = parentElement.classList.contains('comment');
  const isReply = parentElement.classList.contains('reply');

  if (isComment) {
    const replyContent = parentElement.querySelector('.reply-content');
    const replies = replyContent ? replyContent.querySelectorAll('.reply') : [];
    const replyCount = replies.length;

    const replyCountElement = parentElement.querySelector('.show-all.reply-count');
    if (replyCountElement) {
      replyCountElement.dataset.replyCount = replyCount;
      if (replyCount > 0) {
        replyCountElement.innerText = `view ${replyCount} repl${replyCount > 1 ? 'ies' : 'y'}`;
      } else {
        replyCountElement.remove(); // or hide if preferred
      }
    }
  }

  if (isReply) {
    const nested = parentElement.querySelector('.nested-replies');
    const replies = nested ? nested.querySelectorAll('.reply') : [];
    const replyCount = replies.length;

    const replyCountElement = parentElement.querySelector('.view-all');
    if (replyCountElement) {
      replyCountElement.setAttribute('reply-replies-count', replyCount);
      if (replyCount > 0) {
        replyCountElement.innerText = `view ${replyCount} repl${replyCount > 1 ? 'ies' : 'y'}`;
      } else {
        replyCountElement.remove(); // or hide
      }
    }
  }
}


// Ajax Add comment
const AddComment = document.querySelector('form[comment-form]');
AddComment.addEventListener('submit',async (eo)=>{
  eo.preventDefault();
  const postid = AddComment.getAttribute('comment-form');
  const textarea = AddComment.querySelector('textarea[name="content"]');
  const content = textarea.value.trim();
  const Wrapper = document.getElementById('wrapper');
  let options = {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ content })
  };
  try {
    const response = await fetch(`/comment/${postid}`, options);
    if (response.ok) {
      const result = await response.json();
      if(result.commented){
        toastr.options = {
          "closeButton": true,
          "progressBar": true,
          "positionClass": "toast-top-right",
          "timeOut": 2000
        };
        toastr.success("Comment Added ");
      
        textarea.value = '';
        Wrapper.insertAdjacentHTML('afterbegin', result.html);
        updateCount();
      }

    }
  } catch (error) {
    console.error('Delete error:', error);
  }
})


// Ajax edit comment | reply 
document.body.addEventListener('submit', async function(eo) {
  const form = eo.target;
  if (!form.matches('form[edit-comment]')) return;
    eo.preventDefault();
    const commentId = form.getAttribute('edit-comment');
    const textarea = form.querySelector('textarea[name="content"]');
    const content = textarea.value.trim();
    const oldContent = form.closest('.comment, .reply').querySelector('.comment-content');

    const parentInput = form.querySelector('input[name="parent_id"]');
    const parent_id = parentInput ? parentInput.value : null;
    const body = parent_id !== null ? JSON.stringify({ content, parent_id }): JSON.stringify({ content });

    let options = {
      method: 'PUT',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Content-Type': 'application/json'
      },
      body: body
    };

    try {
      const response = await fetch(`/comment/edit/${commentId}`, options);
      if (response.ok) {
        const result = await response.json();
        if(result.Edited){
          toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": 2000
          };
          toastr.success("Comment updated successfully");
        
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
          'Content-Type': 'application/json'
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
      const parentOfThis = parentComment.closest('.comment') || parentComment.closest('.reply');
      parentComment.remove();
      if (parentOfThis) updateReplyCount(parentOfThis);
    }
    updateCount();
     }
  }
  }catch(error){
    console.error('Delete error:', error);
  
  }
  
})

