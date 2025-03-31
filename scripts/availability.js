document.addEventListener("DOMContentLoaded", function () {
  let units = [];
  const tableBody = document.getElementById("unit-table");
  const filterButtons = document.querySelectorAll(".filter-btn");
  
  // Initialize modals
  const unitModalEl = document.getElementById("unitModal");
  const unitModal = unitModalEl ? new bootstrap.Modal(unitModalEl) : null;
  
  const floorPlanModalEl = document.getElementById("floorPlanModal");
  const floorPlanModal = floorPlanModalEl ? new bootstrap.Modal(floorPlanModalEl) : null;
  
  const leasedModalEl = document.getElementById("leasedModal");
  const leasedModal = leasedModalEl ? new bootstrap.Modal(leasedModalEl) : null;

  // Other elements
  const unitInput = document.getElementById("unitInput");
  const unitDescription = document.getElementById("unitDescription");
  const floorPlanImage = document.getElementById("floorPlanImage");
  const leasedUnitNumber = document.getElementById("leasedUnitNumber");
  

  // Pagination Variables
  let currentPage = 1;
  const rowsPerPage = 10;
  let currentFilter = "all";

  // Show leased unit popup
  function showLeasedPopup(unitNumber) {
    if (leasedModal && leasedUnitNumber) {
      leasedUnitNumber.textContent = unitNumber;
      leasedModal.show();
    }
  }

  // Format currency
  function formatCurrency(amount) {
    if (!amount) return '';
    // Handle both "$6,700.00" and "6700" formats
    if (typeof amount === 'string' && amount.includes('$')) return amount;
    const number = parseFloat(amount.toString().replace(/[^0-9.]/g, ''));
    return isNaN(number) ? '' : '$' + number.toLocaleString('en-US', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    });
  }

  // Fetch units from Google Sheets
  async function fetchUnits() {
    tableBody.innerHTML = `<tr><td colspan="5" class="text-center py-4">Loading units...</td></tr>`;
    
    try {
      const response = await fetch('https://script.google.com/macros/s/AKfycby8buR8Ojm5qU5_YJuoSSdwM6GAQfpvYiZYSa8ohhdX6eJX99zn_QWC6KOnRL_kDu-v/exec');
      
      if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
      
      const data = await response.json();
      units = data;

      // DEBUG: Check what columns exist
      console.log("First unit's columns:", Object.keys(data[0]));
      console.log("Does isLeased exist?", 'isLeased' in data[0]);

      // DEBUG 1: Check raw data from API
      console.log("Raw data for Unit 5A:", 
        data.find(u => u.unit === "Unit 5A"));

      
      
      // Process the data
      units.forEach(unit => {
        // DEBUG 2: Check before processing
        if (unit.unit === "Unit 5A") {
          console.log("Unit 5A before processing - isLeased:", unit.isleased, "Type:", typeof unit.isLeased);
        }

        // Ensure bedBath is properly set (fix for undefined)
        if (!unit.bedBath && unit.type) {
          unit.bedBath = unit.type.includes('1') ? '1 Bed / 1 Bath' :
                         unit.type.includes('2') ? '2 Bed / 2 Bath' :
                         unit.type.includes('3') ? '3 Bed / 2 Bath' :
                         'Studio / 1 Bath';
        }
        
        // Format rent
        unit.formattedRent = formatCurrency(unit.rent);
        
        // Process images
        if (typeof unit.images === 'string') {
          unit.images = unit.images.split(',').map(img => img.trim());
        }
        
        // Process description
        if (typeof unit.description === 'string') {
          unit.description = unit.description.split('.').filter(d => d.trim() !== '').map(d => d.trim() + '.');
        }
        
        // Fix typos
        if (unit.view) unit.view = unit.view.replace('veiw', 'view');
        if (unit.description) {
          unit.description = unit.description.map(d => d.replace('veiw', 'view'));
        }
        
        // Ensure isLeased is properly converted to boolean
        if (typeof unit.isleased === 'string') {
          unit.isLeased = unit.isleased.trim().toLowerCase() === 'true';
        } else if (typeof unit.isleased === 'undefined') {
          unit.isleased = false; // Default to false if undefined
        }
         // DEBUG 3: Check after processing
        if (unit.unit === "Unit 5A") {
          console.log("Unit 5A after processing - isLeased:", unit.isleased, "Type:", typeof unit.isleased);
        }

      });
      
      // DEBUG 4: Check final processed data
    const unit5A = units.find(u => u.unit === "Unit 5A");
    console.log("Final Unit 5A data:", unit5A);
    console.log("All units with isLeased true:", 
      units.filter(u => u.isleased).map(u => u.unit));

      populateTable();
      
    } catch (error) {
      console.error('Error fetching unit data:', error);
      tableBody.innerHTML = `<tr><td colspan="5" class="text-center py-4 text-danger">
        Failed to load data. Please refresh the page.
      </td></tr>`;
    }
  }

  // Populate the table with units
  function populateTable(filter = "all", page = 1) {
    if (!tableBody) return;
    
    if (units.length === 0) {
      tableBody.innerHTML = `<tr><td colspan="5" class="text-center py-4">
        No units available. Please try again later.
      </td></tr>`;
      return;
    }

    tableBody.innerHTML = "";

    const normalizedFilter = filter === "all" ? "all" : filter.replace('-bed', '');

    // Filter units (exclude HPD + apply type filter)
    const filteredUnits = units.filter(unit => {
      const normalizedType = unit.type.trim().toLowerCase();
      return normalizedType !== "hpd" &&  // Exclude HPD units
            (normalizedFilter === "all" || normalizedType === normalizedFilter);
    });

    // Paginate and render...
    const paginatedUnits = filteredUnits.slice(
      (page - 1) * rowsPerPage,
      page * rowsPerPage
    );

    // Create table rows
    paginatedUnits.forEach(unit => {
      // DEBUG 5: Check during row creation
    if (unit.unit === "Unit 5A") {
      console.log("Creating row for Unit 5A - isLeased:", unit.isleased);
    }

      const row = document.createElement("tr");
      if (unit.isleased) {
        row.classList.add("leased-row");
        row.dataset.leased = "true"; // Add data attribute for easier CSS targeting
      }
      
      row.innerHTML = `
        <td>${unit.unit || ''}</td>
        <td>${unit.bedBath || ''}</td>
        <td>${unit.outdoor || ''}</td>
        <td>${unit.isleased ? "LEASED" : (unit.formattedRent || '')}</td>
        <td>
          <button class="btn btn-sm view-floor-plan" 
                  data-images='${JSON.stringify(unit.images)}' 
                  ${unit.isleased ? 'disabled' : ''}>
            View
          </button>
        </td>
      `;

      // Row click handler
      row.addEventListener("click", () => {
        if (unit.isleased) {
          showLeasedPopup(unit.unit);
        } else {
          openModal(unit);
        }
      });

      // Floor plan button handler
      const viewButton = row.querySelector(".view-floor-plan");
      if (viewButton && !unit.isleased && unit.images && unit.images.length > 0) {
        viewButton.addEventListener("click", e => {
          e.stopPropagation();
          const images = JSON.parse(viewButton.dataset.images);
          openFloorPlanModal(images[0]);
        });
      }

      tableBody.appendChild(row);
    });

    updatePaginationControls(filteredUnits.length, page);
  }

  // Update pagination controls (keep your existing function)
  function updatePaginationControls(totalUnits, page) {
    const paginationContainer = document.getElementById("pagination");
    if (!paginationContainer) return;
    
    paginationContainer.innerHTML = "";
    const totalPages = Math.ceil(totalUnits / rowsPerPage);

    // Previous Button
    if (page > 1) {
      const prevButton = createPaginationButton(
        "<< Previous",
        () => {
          currentPage--;
          populateTable(currentFilter, currentPage);
        },
        ["btn", "btn-outline-primary", "mx-2"]
      );
      paginationContainer.appendChild(prevButton);
    }

    // Page Numbers
    for (let i = 1; i <= totalPages; i++) {
      const classes = ["btn", "btn-outline-primary", "mx-1"];
      if (i === page) classes.push("active");
      
      const pageButton = createPaginationButton(
        i,
        () => {
          currentPage = i;
          populateTable(currentFilter, currentPage);
        },
        classes
      );
      paginationContainer.appendChild(pageButton);
    }

    // Next Button
    if (page < totalPages) {
      const nextButton = createPaginationButton(
        "Next >>",
        () => {
          currentPage++;
          populateTable(currentFilter, currentPage);
        },
        ["btn", "btn-outline-primary", "mx-2"]
      );
      paginationContainer.appendChild(nextButton);
    }
  }

  // Create pagination button (keep your existing function)
  function createPaginationButton(text, onClick, classes) {
    const button = document.createElement("button");
    button.innerText = text;
    button.classList.add(...classes);
    button.addEventListener("click", onClick);
    return button;
  }

  // Open unit details modal (keep your existing function)
  function openModal(unit) {
    try {
      if (!unitModal || !unitDescription || !unitInput) return;
      unitDescription.innerHTML = unit.description
        .filter(desc => desc.trim() !== "")
        .map(desc => `<li>${desc}</li>`)
        .join("");
      unitInput.value = unit.unit;
      document.getElementById('unitTitleLabel').textContent = unit.unit || 'Unit';
      document.getElementById('unitThankYouName').textContent = `Unit ${unit.unit}`;

      unitModal.show();
    } catch (error) {
      console.error('Error opening unit modal:', error);
    }
  }

  // Open floor plan modal - FIXED PATH ISSUE
  function openFloorPlanModal(image) {
    if (!floorPlanImage || !floorPlanModal) return;
    
    // Extract filename and use correct path
    const filename = image.split('/').pop();
    floorPlanImage.src = `assets/images/units/${filename}`;
    
    floorPlanModal.show();
  }

  // Initialize
  fetchUnits();

  // Filter button event listeners
  filterButtons.forEach(button => {
    button.addEventListener("click", () => {
      filterButtons.forEach(btn => btn.classList.remove("active"));
      button.classList.add("active");
      currentFilter = button.dataset.filter;
      currentPage = 1;
      populateTable(currentFilter, currentPage);
    });
  });
});