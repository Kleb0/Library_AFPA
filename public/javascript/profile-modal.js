document.addEventListener("DOMContentLoaded", function () {
    const profileContainer = document.querySelector(".profile-container");
    const profileModal = document.querySelector(".profile-modal");

    let timeoutId;

    function showModal() {
        clearTimeout(timeoutId); 
        profileModal.style.display = "block";
    }

    function hideModal() {
        timeoutId = setTimeout(() => {
            profileModal.style.display = "none";
        }, 200); // Délai avant de cacher (en ms)
    }

    if (profileContainer && profileModal) {
        
        profileContainer.addEventListener("mouseenter", showModal);

     
        profileContainer.addEventListener("mouseleave", hideModal);

        profileModal.addEventListener("mouseenter", showModal);

        
        profileModal.addEventListener("mouseleave", hideModal);
    }
});
