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

  btn.textContent = data.attached ? "Following" : "Follow";
  btn.classList.toggle("bg-gray-200", data.attached);
  btn.classList.toggle("bg-gray-600", !data.attached);
  })
}catch(error){
  console.error(error);
}


}
