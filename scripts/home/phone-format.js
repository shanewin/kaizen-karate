document.addEventListener("DOMContentLoaded", function () {
  const phoneInputs = document.querySelectorAll(".phone-input");

    phoneInputs.forEach((input) => {
      input.addEventListener("input", function () {
        let x = input.value.replace(/\D/g, '').substring(0, 10); // Only digits
        let formatted = '';

        if (x.length > 0) formatted += '(' + x.substring(0, 3);
        if (x.length >= 4) formatted += ') ' + x.substring(3, 6);
        if (x.length >= 7) formatted += '-' + x.substring(6, 10);

        input.value = formatted;
      });
    });

    const emailInputs = document.querySelectorAll(".email-input");

      emailInputs.forEach((input) => {
        input.addEventListener("input", function () {
          // Remove spaces and convert to lowercase
          input.value = input.value.replace(/\s/g, "").toLowerCase();

          // Optionally: Add simple visual feedback
          if (!input.value.includes("@") || !input.value.includes(".")) {
            input.classList.add("is-invalid");
          } else {
            input.classList.remove("is-invalid");
          }
        });
      });
});
