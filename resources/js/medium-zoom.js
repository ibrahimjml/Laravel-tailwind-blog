import mediumZoom from 'medium-zoom';

window.addEventListener('DOMContentLoaded', () => {
    mediumZoom(".published-content img", {
        margin: 50,
        background: "#000",
    }).on("opened", () => {
        document.querySelector(".medium-zoom-overlay").style.zIndex = "50";
        document.querySelector(".medium-zoom-overlay").style.background =
            "rgba(0,0,0,0.9)";
        document.querySelector(".medium-zoom-image--opened").style.zIndex =
            "50";
    });
});
