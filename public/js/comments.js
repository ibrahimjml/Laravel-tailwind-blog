// hide / show input reply form
document.addEventListener('DOMContentLoaded', function() {
  document.body.addEventListener('click', (eo)=> {
    if (eo.target.classList.contains('reply-btn')) {
      let form = eo.target.closest('.comment, .reply').querySelector('.reply-form');
      if (form.classList.contains('hidden')) {
        form.classList.remove('hidden');
      } else {
        form.classList.add('hidden');
      }
    }
  });
});

// view replies / hide replies in parent node
document.addEventListener('DOMContentLoaded', function() {
  document.body.addEventListener('click', (eo)=> {
    if (eo.target.classList.contains('show-all')) {
      let content = eo.target.closest('.comment, .reply').querySelector('.reply-content');
      let show = eo.target.closest('.comment, .reply').querySelector('.show-all');
      let replyCount = eo.target.getAttribute('data-reply-count');
      if (content.classList.contains('hidden')) {
        show.innerText =` hide ${replyCount} repl${replyCount > 1 ? 'ies' : 'y'}`;
        content.classList.remove('hidden');
      } else {
        content.classList.add('hidden');
        show.innerText =` view ${replyCount} repl${replyCount > 1 ? 'ies' : 'y'}`;
        
      }
    }
  });
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