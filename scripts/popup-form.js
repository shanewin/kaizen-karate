document.addEventListener("DOMContentLoaded", () => {
  const openPopupBtn = document.getElementById("openEmailPopupBtn"); // "Email List" button
  const closePopupBtn = document.getElementById("closePopupBtn"); // Close button
  const popupForm = document.getElementById("popupForm"); // Pop-up container

  if (!openPopupBtn || !closePopupBtn || !popupForm) {
    console.error("Pop-up form elements not found in the DOM.");
    return;
  }

  // Show the pop-up when clicking "Email List"
  openPopupBtn.addEventListener("click", (event) => {
    event.preventDefault(); // Prevent default link behavior
    popupForm.style.display = "flex"; // Show pop-up
  });

  // Close the pop-up when clicking the close button
  closePopupBtn.addEventListener("click", () => {
    popupForm.style.display = "none";
  });

  // Close the pop-up when clicking outside the form
  popupForm.addEventListener("click", (event) => {
    if (event.target === popupForm) {
      popupForm.style.display = "none";
    }
  });
});
