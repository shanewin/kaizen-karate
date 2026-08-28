document.addEventListener("DOMContentLoaded", function () {
    const toggleButtons = document.querySelectorAll(".toggle-details");
  
    toggleButtons.forEach((button) => {
      button.addEventListener("click", function () {
        const details = this.nextElementSibling;
        if (details.style.display === "block") {
          details.style.display = "none";
          this.textContent = "View Details";
        } else {
          details.style.display = "block";
          this.textContent = "Hide Details";
        }
      });
    });
  });