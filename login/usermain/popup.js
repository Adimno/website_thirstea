function openPopup(productName, productImage) {
        const popup = document.getElementById("popup");
        const productNameElement = document.getElementById("product-name");
        const productImageElement = document.getElementById("product-image");

        productNameElement.textContent = productName;
        productImageElement.src = productImage;

        // Display the popup
        popup.style.display = "block";
    }

    // Function to close the popup
    function closePopup() {
        const popup = document.getElementById("popup");
        popup.style.display = "none";
    }

    // Event listener for product name clicks
    const productLinks = document.querySelectorAll(".product-link");
    productLinks.forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault();
            const productName = this.getAttribute("data-product-name");
            const productImage = this.getAttribute("data-product-image");
            openPopup(productName, productImage);
        });
    });

    // Event listener for the close button
    const closePopupButton = document.getElementById("close-popup");
    closePopupButton.addEventListener("click", closePopup);