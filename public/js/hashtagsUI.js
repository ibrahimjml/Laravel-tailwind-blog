
  const input = document.getElementById('hashtagInput');
  const tagContainer = document.getElementById('tagContainer');
  const hiddenInput = document.getElementById('hashtagsHidden');

  let tags = window.initialTags;

  function updateTags() {
    tagContainer.innerHTML = '';
    tags.forEach((tag, index) => {
      if(tag){
        const span = document.createElement('span');
        span.className = 'bg-blue-400 text-slate-300 border border-blue-600 px-2 py-1 rounded-full text-sm flex items-center gap-1';
    
        span.innerHTML = `
          <span>${tag}</span>
          <button type="button" class="text-slate-300 hover:text-red-500" onclick="removeTag(${index})">x</button>
        `;
        tagContainer.appendChild(span);
      }
    
    });
  
    hiddenInput.value = tags.join(',');
  }

  function removeTag(index) {
    tags.splice(index, 1);
    updateTags();
  }
  
  input.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      const tag = input.value.trim();
      const regexTag = /^[A-Za-z0-9_-]+$/;
  
      if (tag && regexTag.test(tag) && !tags.includes(tag)) {
        input.placeholder = 'Type a hashtag and press Enter';
        tags.push(tag);
        updateTags();
        input.value = '';
  
      } else if (!regexTag.test(tag)) {
        
        setTimeout(()=>{
          input.value = '';
          input.placeholder = 'please type a valid hashtag';
        },50)
      }
    }
  });
  
  // Initial render
  updateTags();

    function addSelectedHashtags() {
    const select = document.getElementById('selectedHashtag');
    const selected = [...select.selectedOptions].map(option => option.value.trim());
  
    selected.forEach(tag => {
      if (tag && !tags.includes(tag)) {
        tags.push(tag);
      }
    });
  
    updateTags();
    select.selectedIndex = -1; // clear selected  after adding
  }


