// Mobile menu toggle
document.addEventListener("DOMContentLoaded", function() {
    // Set current year in footer
    document.getElementById("currentYear").textContent = new Date().getFullYear();
    
    // Mobile menu toggle
    const mobileToggle = document.getElementById("mobileToggle");
    const navLinks = document.getElementById("navLinks");
    
    if (mobileToggle && navLinks) {
        mobileToggle.addEventListener("click", function() {
            navLinks.classList.toggle("active");
            
            // Change icon based on menu state
            const icon = mobileToggle.querySelector("i");
            if (navLinks.classList.contains("active")) {
                icon.classList.remove("fa-bars");
                icon.classList.add("fa-times");
            } else {
                icon.classList.remove("fa-times");
                icon.classList.add("fa-bars");
            }
        });
    }
    
    // Back to top functionality
    const backToTopButton = document.getElementById("backToTop");
    if (backToTopButton) {
        backToTopButton.addEventListener("click", function() {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });
    }
    
    // Add to cart functionality
    const addToCartButtons = document.querySelectorAll(".product-card button");
    addToCartButtons.forEach(button => {
        button.addEventListener("click", function(e) {
            e.preventDefault();
            
            // Get product info
            const card = this.closest(".product-card");
            const productName = card.querySelector(".product-title").textContent;
            
            // Show alert (in a real app, this would update the cart state)
            alert(`Added "${productName}" to your cart!`);
        });
    });
});