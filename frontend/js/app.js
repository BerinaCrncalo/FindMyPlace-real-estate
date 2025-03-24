document.addEventListener("DOMContentLoaded", () => {
    const contentDiv = document.getElementById("content");

    // Function to load content dynamically based on the page
    const loadContent = (page) => {
        fetch(`/frontend/views/${page}.html`)
            .then(response => response.text())
            .then(html => {
                contentDiv.innerHTML = html;
            })
            .catch(err => console.log("Error loading page: ", err));
    };

    // Event listeners for navigation links
    document.getElementById("home-link").addEventListener("click", (e) => {
        e.preventDefault();
        loadContent("home");
    });    
    

    document.getElementById("login/register-link").addEventListener("click", (e) => {
        e.preventDefault();
        loadContent("login");
    });

    document.getElementById("register-link").addEventListener("click", (e) => {
        e.preventDefault();
        loadContent("register");
    });

    document.getElementById("about-link").addEventListener("click", (e) => {
        e.preventDefault();
        loadContent("about");
    });

    document.getElementById("profile-link").addEventListener("click", (e) => {
        e.preventDefault();
        loadContent("profile");
    });

    document.getElementById("contact-link").addEventListener("click", (e) => {
        e.preventDefault();
        loadContent("contact");
    });

    document.getElementById("listings-link").addEventListener("click", (e) => {
        e.preventDefault();
        loadContent("listings");
    });

    document.getElementById("add-new-listing-link").addEventListener("click", (e) => {
        e.preventDefault();
        loadContent("add-new-listing");
    });

    document.getElementById("learn-more-link").addEventListener("click", (e) => {
        e.preventDefault();
        loadContent("learn-more");
    });
});
