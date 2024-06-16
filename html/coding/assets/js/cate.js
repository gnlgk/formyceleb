document.addEventListener("DOMContentLoaded", function () {
    const categoryTitle = document.getElementById("categoryTitle");
    const menu = document.querySelector(".menu");
    const menuContent = document.querySelector(".menu .menuContent");

    categoryTitle.addEventListener("click", function () {
        if (menu.classList.contains("active")) {
            gsap.to(menuContent, {
                duration: 0.2,
                opacity: 0,
                visibility: "hidden"
            });
            gsap.to(menu, {
                duration: 0.2,
                width: "70px",
                opacity: 0,
                visibility: "hidden",
                onComplete: () => {
                    menu.classList.remove("active");
                }
            });
        } else {
            menu.classList.add("active");
            gsap.timeline()
                .to(menu, {
                    duration: 0.2,
                    width: "calc(100% - 140px)",
                    opacity: 1,
                    visibility: "visible",
                })
                .to(menuContent, {
                    duration: 0.5,
                    opacity: 1,
                    visibility: "visible"
                }, "-=0.1");
        }
    });
});