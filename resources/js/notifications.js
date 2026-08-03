// send realtime notification websocket
window.addEventListener("DOMContentLoaded", () => {
    const userId = document.body.dataset.userId;

    if (window.Echo && userId) {
        window.Echo.private(`notifications.${userId}`).notification(
            async (notification) => {
                const response = await fetch(`/notification/render/${notification.id}`);
                const data = await response.json();

                document.querySelectorAll("[data-notification-list]").forEach((list) => {
                        list.insertAdjacentHTML("afterbegin", data.html);
                    });

                document.querySelectorAll("[data-notification-count]").forEach((countElement) => {
                        const count = Number(countElement.textContent.trim()) || 0;
                        countElement.textContent = count + 1;
                    });
            },
        );
    }
});
