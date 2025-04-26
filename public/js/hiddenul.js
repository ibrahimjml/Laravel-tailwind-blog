const mobilebtn = document.querySelector("#mobile-btn");
const mobilemenu = document.querySelector("#mobile-menu");

const hiddenul = document.getElementById("hiddenul2");
const change = document.getElementById("dropdown");

const notifications = document.getElementById('hidden-notification');
const shownotification = document.getElementById('hover-notification'); 

// show burger menu
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

// show hover menu user info

    change.addEventListener("mousemove",(eo) => {
    hiddenul.style.display="block";
    });
    
    change.addEventListener("mouseout",(eo) => {
      setTimeout(function() {
        if (!hiddenul.matches(':hover')) {
          hiddenul.style.display = "none";
        }
      }, 300); 
    });

    change.addEventListener("mousemove",(eo) => {
      hiddenul.style.display="block";
      });
      
      change.addEventListener("mouseout",(eo) => {
      hiddenul.style.display = "none";
       });
  


// show notification menu info

  shownotification.addEventListener('mousemove', function() {
    notifications.style.display = "block";
  });


  shownotification.addEventListener('mouseout', function() {
    setTimeout(function() {
      if (!notifications.matches(':hover')) {
        notifications.style.display = "none";
      }
    }, 300); 
  });


  notifications.addEventListener('mousemove', function() {
    notifications.style.display = "block";
  });


  notifications.addEventListener('mouseout', function() {
    notifications.style.display = "none";
  });



