
const showmenu = document.getElementById('openTagModel');
const closemenu = document.getElementById('closeModel');
const menu = document.getElementById("Model");
showmenu.addEventListener('click',()=>{
  if(menu.classList.contains('hidden')){
    menu.classList.remove('hidden');
  }
})
closemenu.addEventListener('click',()=>{
  if(menu.classList.contains('fixed')){
    menu.classList.add('hidden');
  }
})


const addtag = document.getElementById('addtag');

addtag.addEventListener('submit', (eo) => {
    eo.preventDefault();

    const input = addtag.querySelector('input[name="name"]');
    const content = input.value.trim();
    const menu = document.getElementById("Model");
    const table = document.getElementById('tabletags');
    if (!content) return;

    let options = {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ name: content })
    };

    fetch(addtag.action, options)
        .then(response => response.json())
        .then(data => {
            if (data.added === true) {
                menu.classList.add('hidden'); 
                toastr.success(`Tag ${data.hashtag} Added `);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
});

const tags = document.querySelectorAll('.tagsdelete');
tags.forEach(tag=>{
tag.addEventListener('submit',(eo)=>{
eo.preventDefault();
let options = {
        method: 'Delete',
        headers: {
            'X-CSRF-TOKEN': tag.querySelector('input[name="_token"]').value,
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
      
    };
fetch(tag.action,options)
.then(response => response.json())
.then(data => {
            if (data.deleted === true) { 
                toastr.success(data.message);
                tag.closest('tr').remove();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
})
})


const editButtons = document.querySelectorAll('.tagsedit');
const editModal = document.getElementById('editModel');
const closeEditBtn = document.getElementById('closeEditModel');
const editForm = document.getElementById('edittag');
const nameInput = editForm.querySelector('input[name="name"]');
const token = editForm.querySelector('input[name="_token"]').value;

// Open modal and set form action/value
editButtons.forEach(button => {
button.addEventListener('click', () => {
  const tagId = button.dataset.id;
  const tagName = button.dataset.name;

  editForm.action = `/admin/edit/${tagId}`;
  nameInput.value = tagName;

  editModal.classList.remove('hidden');
});
});


editForm.addEventListener('submit', (e) => {
e.preventDefault(); 

let options = {
  method: 'PUT',
  headers: {
    'X-CSRF-TOKEN': token,
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    
  },
  body: JSON.stringify({ name: nameInput.value })
};

fetch(editForm.action, options)
  .then(response => response.json())
  .then(data => {
    if (data.edited === true) {
      toastr.success(data.message);
      editModal.classList.add('hidden');
    
    }
  })
  .catch(error => {
    console.error('Error:', error);
  });
});

// Close modal
closeEditBtn.addEventListener('click', () => {
editModal.classList.add('hidden');
});
