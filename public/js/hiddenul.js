const hiddenul2 = document.getElementById("hiddenul2");
const change = document.getElementById("dropdown");
const mobilebtn = document.querySelector("#mobile-btn");
const mobilemenu = document.querySelector("#mobile-menu");


mobilebtn.addEventListener('click', (e) => {
  

  mobilemenu.classList.toggle('hidden');

  if (!mobilemenu.classList.contains('hidden')) {


      const closeMenu = (event) => {

        if (!mobilemenu.contains(event.target) && !mobilebtn.contains(event.target)) {
          mobilemenu.classList.add('hidden');
          document.removeEventListener('click', closeMenu);
        }
      };

      document.addEventListener('click', closeMenu);

  }
});


if(change){
change.addEventListener("mousemove",(eo) => {
hiddenul2.style.display="block";
});

change.addEventListener("mouseout",(eo) => {
hiddenul2.style.display="none";
});
}