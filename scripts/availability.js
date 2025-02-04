document.addEventListener("DOMContentLoaded", function () {
    // Dummy Data
    const units = [
      {
        unit: "Unit 2-E",
        type: "2-bed",
        bedBath: "2 Bed / 1 Bath",
        rent: "$4,500",
        images: ["units/unit-2-E.png", "units/unit-2-E.png"],
        description: ["Spacious 2 bedroom with modern finishes.", "Floor-to-ceiling windows.", "Open-concept layout."],
      },
      {
        unit: "Unit 2-F",
        type: "1-bed",
        bedBath: "1 Bed / 1 Bath",
        rent: "$3,200",
        images: ["units/unit-2-F.png", "units/unit-2-F.png"],
        description: ["Bright one-bedroom apartment.", "Granite countertops.", "Large walk-in closet."],
      },
    ];
  
    const tableBody = document.getElementById("unit-table");
    const filterButtons = document.querySelectorAll(".filter-btn");
    const unitModal = new bootstrap.Modal(document.getElementById("unitModal"));
  
    // Populate Table
    function populateTable(filter = "all") {
      tableBody.innerHTML = "";
      const filteredUnits = filter === "all" ? units : units.filter((unit) => unit.type === filter);
      filteredUnits.forEach((unit) => {
        const row = document.createElement("tr");
        row.innerHTML = `
          <td>${unit.unit}</td>
          <td>${unit.bedBath}</td>
          <td>${unit.rent}</td>
        `;
        row.addEventListener("click", () => openModal(unit));
        tableBody.appendChild(row);
      });
    }
  
    // Open Modal with Unit Details
    function openModal(unit) {
      const carouselInner = document.querySelector("#unitCarousel .carousel-inner");
      const unitDescription = document.getElementById("unitDescription");
      const unitInput = document.getElementById("unit");

      // Populate Carousel
      carouselInner.innerHTML = "";
      unit.images.forEach((image, index) => {
        const carouselItem = document.createElement("div");
        carouselItem.classList.add("carousel-item");
        if (index === 0) carouselItem.classList.add("active");
        carouselItem.innerHTML = `<img src="assets/images/${image}" class="d-block w-100" alt="${unit.unit}">`;
        carouselInner.appendChild(carouselItem);
      });

      // Populate Description
      unitDescription.innerHTML = unit.description.map((item) => `<li>${item}</li>`).join("");

      // Set Unit Information in Hidden Input
      unitInput.value = unit.unit;

      // Show Modal
      unitModal.show();
    }
  
    // Filter Buttons
    filterButtons.forEach((button) => {
      button.addEventListener("click", () => {
        filterButtons.forEach((btn) => btn.classList.remove("active"));
        button.classList.add("active");
        populateTable(button.dataset.filter);
      });
    });
  
    // Initial Table Population
    populateTable();
  });