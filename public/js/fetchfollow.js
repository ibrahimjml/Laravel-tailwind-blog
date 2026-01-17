async function fetchfollow(button) {
  const userId = button.dataset.id;

let options = {
  method: "POST",
    headers: {
      "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
      "Accept": "application/json"
    },
};
try{
  const res = await fetch(`/user/${userId}/togglefollow`,options)

  const data = await res.json();
  document.querySelectorAll(`button.follow[data-id="${userId}"]`)
  .forEach((btn) => {

 btn.classList.remove(
          "bg-gray-200",
          "bg-gray-600",
          "bg-yellow-500",
          "text-black",
          "text-white"
        );
         if (data.status === 1) {
          btn.textContent = "Following";
          btn.classList.add("bg-gray-200", "text-black");
        } else if (data.status === 0) {
          btn.textContent = "Requested";
          btn.classList.add("bg-yellow-500", "text-white");
        } else {
          btn.textContent = "Follow";
          btn.classList.add("bg-gray-600", "text-white");
        }
  });
}catch(error){
  console.error(error);
}


}
