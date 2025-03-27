document.addEventListener("DOMContentLoaded", function () {
  const units = [
    {
      unit: "Unit 2A",
      type: "2-bed",
      bedBath: "2 Bed / 2 Bath",
      rent: "$6,700.00",
      squareFootage: "730 SF",
      outdoor: "Terrace",
      view: "Rear veiw",
      images: ["units/2A.jpg", "units/2A.jpg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Rear veiw.", "Terrace."],
    },
    {
      unit: "Unit 2B",
      type: "1-bed",
      bedBath: "1 Bed / 1 Bath",
      rent: "$4,100.00",
      squareFootage: "545 SF",
      outdoor: "",
      view: "Carlton view",
      images: ["units/2B.jpg", "units/2B.jpg"],
      description: ["Spacious 1 bedroom with modern finishes.", "Carlton view.", ""],
    },
    {
      unit: "Unit 2C",
      type: "1-bed",
      bedBath: "1 Bed / 1 Bath",
      rent: "$4,000.00",
      squareFootage: "492 SF",
      outdoor: "",
      view: "Carlton view",
      images: ["units/2C.jpg", "units/2C.jpg"],
      description: ["Spacious 1 bedroom with modern finishes.", "Carlton view.", ""],
    },
    {
      unit: "Unit 2D",
      type: "1-bed",
      bedBath: "1 Bed / 1 Bath",
      rent: "$4,000.00",
      squareFootage: "472 SF",
      outdoor: "",
      view: "Carlton view",
      images: ["units/2D.jpg", "units/2D.jpg"],
      description: ["Spacious 1 bedroom with modern finishes.", "Carlton view.", ""],
    },
    {
      unit: "Unit 2E",
      type: "2-bed",
      bedBath: "2 Bed / 1 Bath",
      rent: "$5,700.00",
      squareFootage: "647 SF",
      outdoor: "",
      view: "Myrtle veiw corner",
      images: ["units/3D.jpg", "units/3D.jpg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Myrtle veiw corner.", ""],
    },
    {
      unit: "Unit 2F",
      type: "HPD",
      bedBath: "HPD",
      rent: "$3,787.00",
      squareFootage: "HPD SF",
      outdoor: "HPD",
      view: "HPD",
      images: ["units/2F.jpg", "units/2F.jpg"],
      description: ["HPD unit.", "HPD.", "HPD."],
    },
    {
      unit: "Unit 2G",
      type: "HPD",
      bedBath: "HPD",
      rent: "$3,787.00",
      squareFootage: "HPD SF",
      outdoor: "HPD",
      view: "HPD",
      images: ["units/3G.jpg", "units/3G.jpg"],
      description: ["HPD unit.", "HPD.", "HPD."],
    },
    {
      unit: "Unit 2H",
      type: "2-bed",
      bedBath: "2 Bed / 2 Bath",
      rent: "$5,800.00",
      squareFootage: "743 SF",
      outdoor: "",
      view: "Myrtle view",
      images: ["units/3G.jpg", "units/3G.jpg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Myrtle view.", ""],
    },
    {
      unit: "Unit 2I",
      type: "2-bed",
      bedBath: "2 Bed / 2 Bath",
      rent: "$7,000.00",
      squareFootage: "831 SF",
      outdoor: "Terrace",
      view: "Rear veiw",
      images: ["units/2I.jpg", "units/2I.jpg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Rear veiw.", "Terrace."],
    },
    {
      unit: "Unit 2J",
      type: "HPD",
      bedBath: "HPD",
      rent: "$3,787.00",
      squareFootage: "HPD SF",
      outdoor: "HPD",
      view: "HPD",
      images: ["units/2J.jpg", "units/2J.jpg"],
      description: ["HPD unit.", "HPD.", "HPD."],
    },
    {
      unit: "Unit 3A",
      type: "2-bed",
      bedBath: "2 Bed / 2 Bath",
      rent: "$5,800.00",
      squareFootage: "765 SF",
      outdoor: "Balcony",
      view: "Rear veiw",
      images: ["units/3A.jpg", "units/3A.jpg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Rear veiw.", "Balcony."],
    },
    {
      unit: "Unit 3B",
      type: "3-bed",
      bedBath: "3 Bed / 2 Bath",
      rent: "$8,000.00",
      squareFootage: "975 SF",
      outdoor: "Balcony",
      view: "Carlton view",
      images: ["units/3B.jpg", "units/3B.jpg"],
      description: ["Spacious 3 bedroom with modern finishes.", "Carlton view.", "Balcony."],
    },
    {
      unit: "Unit 3C",
      type: "1-bed",
      bedBath: "1 Bed / 1 Bath",
      rent: "$4,200.00",
      squareFootage: "537 SF",
      outdoor: "Balcony",
      view: "Carlton view",
      images: ["units/3C.jpg", "units/3C.jpg"],
      description: ["Spacious 1 bedroom with modern finishes.", "Carlton view.", "Balcony."],
    },
    {
      unit: "Unit 3D",
      type: "2-bed",
      bedBath: "2 Bed / 1 Bath",
      rent: "$5,800.00",
      squareFootage: "647 SF",
      outdoor: "2 Balconies",
      view: "Myrtle veiw corner",
      images: ["units/3D.jpeg", "units/3D.jpeg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Myrtle veiw corner.", "2 Balconies."],
    },
    {
      unit: "Unit 3E",
      type: "HPD",
      bedBath: "HPD",
      rent: "$3,787.00",
      squareFootage: "HPD SF",
      outdoor: "HPD",
      view: "HPD",
      images: ["units/3E.jpg", "units/3E.jpg"],
      description: ["HPD unit.", "HPD.", "HPD."],
    },
    {
      unit: "Unit 3F",
      type: "HPD",
      bedBath: "HPD",
      rent: "$3,787.00",
      squareFootage: "HPD SF",
      outdoor: "HPD",
      view: "HPD",
      images: ["units/8F.jpg", "units/8F.jpg"],
      description: ["HPD unit.", "HPD.", "HPD."],
    },
    {
      unit: "Unit 3G",
      type: "2-bed",
      bedBath: "2 Bed / 2 Bath",
      rent: "$6,000.00",
      squareFootage: "743 SF",
      outdoor: "Balcony",
      view: "Myrtle view",
      images: ["units/3G.jpg", "units/3G.jpg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Myrtle view.", "Balcony."],
    },
    {
      unit: "Unit 3H",
      type: "2-bed",
      bedBath: "2 Bed / 2 Bath",
      rent: "$6,000.00",
      squareFootage: "742 SF",
      outdoor: "Balcony",
      view: "Rear veiw",
      images: ["units/3H.jpg", "units/3H.jpg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Rear veiw.", "Balcony."],
    },
    {
      unit: "Unit 3I",
      type: "HPD",
      bedBath: "HPD",
      rent: "$3,787.00",
      squareFootage: "HPD SF",
      outdoor: "HPD",
      view: "HPD",
      images: ["units/2I.jpg", "units/2I.jpg"],
      description: ["HPD unit.", "HPD.", "HPD."],
    },
    {
      unit: "Unit 4A",
      type: "2-bed",
      bedBath: "2 Bed / 2 Bath",
      rent: "$5,800.00",
      squareFootage: "765 SF",
      outdoor: "Balcony",
      view: "Rear veiw",
      images: ["units/3A.jpg", "units/3A.jpg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Rear veiw.", "Balcony."],
    },
    {
      unit: "Unit 4B",
      type: "3-bed",
      bedBath: "3 Bed / 2 Bath",
      rent: "$8,000.00",
      squareFootage: "975 SF",
      outdoor: "2 Balconies",
      view: "Carlton view",
      images: ["units/3B.jpg", "units/3B.jpg"],
      description: ["Spacious 3 bedroom with modern finishes.", "Carlton view.", "2 Balconies."],
    },
    {
      unit: "Unit 4C",
      type: "1-bed",
      bedBath: "1 Bed / 1 Bath",
      rent: "$4,300.00",
      squareFootage: "537 SF",
      outdoor: "Balcony",
      view: "Carlton view",
      images: ["units/3C.jpg", "units/3C.jpg"],
      description: ["Spacious 1 bedroom with modern finishes.", "Carlton view.", "Balcony."],
    },
    {
      unit: "Unit 4D",
      type: "2-bed",
      bedBath: "2 Bed / 1 Bath",
      rent: "$5,900.00",
      squareFootage: "647 SF",
      outdoor: "2 Balconies",
      view: "Myrtle veiw corner",
      images: ["units/4D.jpg", "units/4D.jpg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Myrtle veiw corner.", "2 Balconies."],
    },
    {
      unit: "Unit 4E",
      type: "HPD",
      bedBath: "HPD",
      rent: "$3,787.00",
      squareFootage: "HPD SF",
      outdoor: "HPD",
      view: "HPD",
      images: ["units/4E.jpg", "units/4E.jpg"],
      description: ["HPD unit.", "HPD.", "HPD."],
    },
    {
      unit: "Unit 4F",
      type: "HPD",
      bedBath: "HPD",
      rent: "$3,787.00",
      squareFootage: "HPD SF",
      outdoor: "HPD",
      view: "HPD",
      images: ["units/4F.jpg", "units/4F.jpg"],
      description: ["HPD unit.", "HPD.", "HPD."],
    },
    {
      unit: "Unit 4G",
      type: "2-bed",
      bedBath: "2 Bed / 2 Bath",
      rent: "$6,000.00",
      squareFootage: "743 SF",
      outdoor: "Balcony",
      view: "Myrtle view",
      images: ["units/3G.jpg", "units/3G.jpg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Myrtle view.", "Balcony."],
    },
    {
      unit: "Unit 4H",
      type: "2-bed",
      bedBath: "2 Bed / 2 Bath",
      rent: "$6,000.00",
      squareFootage: "742 SF",
      outdoor: "Balcony",
      view: "Rear veiw",
      images: ["units/3H.jpg", "units/3H.jpg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Rear veiw.", "Balcony."],
    },
    {
      unit: "Unit 4I",
      type: "HPD",
      bedBath: "HPD",
      rent: "$3,787.00",
      squareFootage: "HPD SF",
      outdoor: "HPD",
      view: "HPD",
      images: ["units/4I.jpg", "units/4I.jpg"],
      description: ["HPD unit.", "HPD.", "HPD."],
    },
    {
      unit: "Unit 5A",
      type: "2-bed",
      bedBath: "2 Bed / 2 Bath",
      rent: "$5,900.00",
      squareFootage: "765 SF",
      outdoor: "Balcony",
      view: "Rear veiw",
      images: ["units/3A.jpg", "units/3A.jpg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Rear veiw.", "Balcony."],
      isLeased: true
    },
    {
      unit: "Unit 5B",
      type: "3-bed",
      bedBath: "3 Bed / 2 Bath",
      rent: "$8,200.00",
      squareFootage: "975 SF",
      outdoor: "Balcony",
      view: "Carlton view",
      images: ["units/3B.jpg", "units/3B.jpg"],
      description: ["Spacious 3 bedroom with modern finishes.", "Carlton view.", "Balcony."],
    },
    {
      unit: "Unit 5C",
      type: "1-bed",
      bedBath: "1 Bed / 1 Bath",
      rent: "$4,400.00",
      squareFootage: "537 SF",
      outdoor: "Balcony",
      view: "Carlton view",
      images: ["units/3C.jpg", "units/3C.jpg"],
      description: ["Spacious 1 bedroom with modern finishes.", "Carlton view.", "Balcony."],
    },
    {
      unit: "Unit 5D",
      type: "2-bed",
      bedBath: "2 Bed / 1 Bath",
      rent: "$5,900.00",
      squareFootage: "647 SF",
      outdoor: "2 Balconies",
      view: "Myrtle veiw corner",
      images: ["units/3D.jpg", "units/3D.jpg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Myrtle veiw corner.", "2 Balconies."],
    },
    {
      unit: "Unit 5E",
      type: "HPD",
      bedBath: "HPD",
      rent: "$3,787.00",
      squareFootage: "HPD SF",
      outdoor: "HPD",
      view: "HPD",
      images: ["units/5E.jpg", "units/5E.jpg"],
      description: ["HPD unit.", "HPD.", "HPD."],
    },
    {
      unit: "Unit 5F",
      type: "HPD",
      bedBath: "HPD",
      rent: "$3,787.00",
      squareFootage: "HPD SF",
      outdoor: "HPD",
      view: "HPD",
      images: ["units/5F.jpg", "units/5F.jpg"],
      description: ["HPD unit.", "HPD.", "HPD."],
    },
    {
      unit: "Unit 5G",
      type: "2-bed",
      bedBath: "2 Bed / 2 Bath",
      rent: "$6,100.00",
      squareFootage: "743 SF",
      outdoor: "Balcony",
      view: "Myrtle view",
      images: ["units/3G.jpg", "units/3G.jpg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Myrtle view.", "Balcony."],
    },
    {
      unit: "Unit 5H",
      type: "2-bed",
      bedBath: "2 Bed / 2 Bath",
      rent: "$6,100.00",
      squareFootage: "742 SF",
      outdoor: "Balcony",
      view: "Rear veiw",
      images: ["units/3H.jpg", "units/3H.jpg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Rear veiw.", "Balcony."],
    },
    {
      unit: "Unit 5I",
      type: "HPD",
      bedBath: "HPD",
      rent: "$3,787.00",
      squareFootage: "HPD SF",
      outdoor: "HPD",
      view: "HPD",
      images: ["units/5I.jpg", "units/5I.jpg"],
      description: ["HPD unit.", "HPD.", "HPD."],
    },
    {
      unit: "Unit 6A",
      type: "2-bed",
      bedBath: "2 Bed / 2 Bath",
      rent: "$6,000.00",
      squareFootage: "765 SF",
      outdoor: "Balcony",
      view: "Rear veiw",
      images: ["units/3A.jpg", "units/3A.jpg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Rear veiw.", "Balcony."],
    },
    {
      unit: "Unit 6B",
      type: "3-bed",
      bedBath: "3 Bed / 2 Bath",
      rent: "$8,200.00",
      squareFootage: "975 SF",
      outdoor: "2 Balconies",
      view: "Carlton view",
      images: ["units/3B.jpg", "units/3B.jpg"],
      description: ["Spacious 3 bedroom with modern finishes.", "Carlton view.", "2 Balconies."],
    },
    {
      unit: "Unit 6C",
      type: "1-bed",
      bedBath: "1 Bed / 1 Bath",
      rent: "$4,400.00",
      squareFootage: "537 SF",
      outdoor: "Balcony",
      view: "Carlton view",
      images: ["units/3C.jpg", "units/3C.jpg"],
      description: ["Spacious 1 bedroom with modern finishes.", "Carlton view.", "Balcony."],
    },
    {
      unit: "Unit 6D",
      type: "2-bed",
      bedBath: "2 Bed / 1 Bath",
      rent: "$6,000.00",
      squareFootage: "647 SF",
      outdoor: "2 Balconies",
      view: "Myrtle veiw corner",
      images: ["units/4D.jpg", "units/4D.jpg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Myrtle veiw corner.", "2 Balconies."],
    },
    {
      unit: "Unit 6E",
      type: "HPD",
      bedBath: "HPD",
      rent: "$3,787.00",
      squareFootage: "HPD SF",
      outdoor: "HPD",
      view: "HPD",
      images: ["units/8E.jpg", "units/8E.jpg"],
      description: ["HPD unit.", "HPD.", "HPD."],
    },
    {
      unit: "Unit 6F",
      type: "HPD",
      bedBath: "HPD",
      rent: "$3,787.00",
      squareFootage: "HPD SF",
      outdoor: "HPD",
      view: "HPD",
      images: ["units/8F.jpg", "units/8F.jpg"],
      description: ["HPD unit.", "HPD.", "HPD."],
    },
    {
      unit: "Unit 6G",
      type: "2-bed",
      bedBath: "2 Bed / 2 Bath",
      rent: "$6,200.00",
      squareFootage: "743 SF",
      outdoor: "Balcony",
      view: "Myrtle view",
      images: ["units/3G.jpg", "units/3G.jpg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Myrtle view.", "Balcony."],
    },
    {
      unit: "Unit 6H",
      type: "2-bed",
      bedBath: "2 Bed / 2 Bath",
      rent: "$6,200.00",
      squareFootage: "742 SF",
      outdoor: "Balcony",
      view: "Rear veiw",
      images: ["units/3H.jpg", "units/3H.jpg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Rear veiw.", "Balcony."],
    },
    {
      unit: "Unit 6I",
      type: "HPD",
      bedBath: "HPD",
      rent: "$3,787.00",
      squareFootage: "HPD SF",
      outdoor: "HPD",
      view: "HPD",
      images: ["units/2I.jpg", "units/2I.jpg"],
      description: ["HPD unit.", "HPD.", "HPD."],
    },
    {
      unit: "Unit 7A",
      type: "3-bed",
      bedBath: "3 Bed / 2 Bath",
      rent: "$10,000.00",
      squareFootage: "1102 SF",
      outdoor: "Terrace",
      view: "Carlton view and Rear",
      images: ["units/7A.jpg", "units/7A.jpg"],
      description: ["Spacious 3 bedroom with modern finishes.", "Carlton view and Rear.", "Terrace."],
    },
    {
      unit: "Unit 7B",
      type: "1-bed",
      bedBath: "1 Bed / 1 Bath",
      rent: "$4,500.00",
      squareFootage: "537 SF",
      outdoor: "Balcony",
      view: "Carlton view",
      images: ["units/3C.jpg", "units/3C.jpg"],
      description: ["Spacious 1 bedroom with modern finishes.", "Carlton view.", "Balcony."],
    },
    {
      unit: "Unit 7C",
      type: "2-bed",
      bedBath: "2 Bed / 1 Bath",
      rent: "$6,200.00",
      squareFootage: "647 SF",
      outdoor: "2 Balconies",
      view: "Myrtle veiw corner",
      images: ["units/3D.jpg", "units/3D.jpg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Myrtle veiw corner.", "2 Balconies."],
    },
    {
      unit: "Unit 7D",
      type: "HPD",
      bedBath: "HPD",
      rent: "$3,787.00",
      squareFootage: "HPD SF",
      outdoor: "HPD",
      view: "HPD",
      images: ["units/3D.jpg", "units/3D.jpg"],
      description: ["HPD unit.", "HPD.", "HPD."],
    },
    {
      unit: "Unit 7E",
      type: "HPD",
      bedBath: "HPD",
      rent: "$3,787.00",
      squareFootage: "HPD SF",
      outdoor: "HPD",
      view: "HPD",
      images: ["units/7E.jpg", "units/7E.jpg"],
      description: ["HPD unit.", "HPD.", "HPD."],
    },
    {
      unit: "Unit 7F",
      type: "2-bed",
      bedBath: "2 Bed / 2 Bath",
      rent: "$6,300.00",
      squareFootage: "743 SF",
      outdoor: "Balcony",
      view: "Myrtle view",
      images: ["units/3G.jpg", "units/3G.jpg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Myrtle view.", "Balcony."],
    },
    {
      unit: "Unit 7G",
      type: "2-bed",
      bedBath: "2 Bed / 2 Bath",
      rent: "$6,300.00",
      squareFootage: "742 SF",
      outdoor: "Balcony",
      view: "Rear veiw",
      images: ["units/3H.jpg", "units/3H.jpg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Rear veiw.", "Balcony."],
    },
    {
      unit: "Unit 7H",
      type: "1-bed",
      bedBath: "1 Bed / 1 Bath",
      rent: "$4,500.00",
      squareFootage: "524 SF",
      outdoor: "Balcony",
      view: "Rear veiw",
      images: ["units/7H.jpg", "units/7H.jpg"],
      description: ["Spacious 1 bedroom with modern finishes.", "Rear veiw.", "Balcony."],
    },
    {
      unit: "Unit 8A",
      type: "1-bed",
      bedBath: "1 Bed / 1 Bath",
      rent: "$4,200.00",
      squareFootage: "408 SF",
      outdoor: "Balcony",
      view: "Rear veiw",
      images: ["units/8A.jpg", "units/8A.jpg"],
      description: ["Spacious 1 bedroom with modern finishes.", "Rear veiw.", "Balcony."],
    },
    {
      unit: "Unit 8B",
      type: "Studio-bed",
      bedBath: "Studio / 1 Bath",
      rent: "$3,800.00",
      squareFootage: "306 SF",
      outdoor: "Terrace",
      view: "Carlton view",
      images: ["units/8B.jpg", "units/8B.jpg"],
      description: ["Spacious Studio bedroom with modern finishes.", "Carlton view.", "Terrace."],
    },
    {
      unit: "Unit 8C",
      type: "1-bed",
      bedBath: "1 Bed / 1 Bath",
      rent: "$5,200.00",
      squareFootage: "514 SF",
      outdoor: "Terrace",
      view: "Myrtle veiw corner",
      images: ["units/8C.jpg", "units/8C.jpg"],
      description: ["Spacious 1 bedroom with modern finishes.", "Myrtle veiw corner.", "Terrace."],
    },
    {
      unit: "Unit 8D",
      type: "HPD",
      bedBath: "HPD",
      rent: "$3,787.00",
      squareFootage: "HPD SF",
      outdoor: "HPD",
      view: "HPD",
      images: ["units/8D.jpg", "units/8D.jpg"],
      description: ["HPD unit.", "HPD.", "HPD."],
    },
    {
      unit: "Unit 8E",
      type: "1-bed",
      bedBath: "1 Bed / 1 Bath",
      rent: "$4,500.00",
      squareFootage: "447 SF",
      outdoor: "Balcony",
      view: "Myrtle view",
      images: ["units/8E.jpg", "units/8E.jpg"],
      description: ["Spacious 1 bedroom with modern finishes.", "Myrtle view.", "Balcony."],
    },
    {
      unit: "Unit 8F",
      type: "1-bed",
      bedBath: "1 Bed / 1 Bath",
      rent: "$4,700.00",
      squareFootage: "463 SF",
      outdoor: "Terrace",
      view: "Myrtle view",
      images: ["units/8F.jpg", "units/8F.jpg"],
      description: ["Spacious 1 bedroom with modern finishes.", "Myrtle view.", "Terrace."],
    },
    {
      unit: "Unit 8G",
      type: "Studio-bed",
      bedBath: "Studio / 1 Bath",
      rent: "$3,500.00",
      squareFootage: "310 SF",
      outdoor: "Terrace",
      view: "Rear veiw",
      images: ["units/8G.jpg", "units/8G.jpg"],
      description: ["Spacious Studio bedroom with modern finishes.", "Rear veiw.", "Terrace."],
    },
    {
      unit: "Unit 8H",
      type: "HPD",
      bedBath: "HPD",
      rent: "$3,787.00",
      squareFootage: "HPD SF",
      outdoor: "HPD",
      view: "HPD",
      images: ["units/8H.jpg", "units/8H.jpg"],
      description: ["HPD unit.", "HPD.", "HPD."],
    },
    {
      unit: "Unit 8I",
      type: "1-bed",
      bedBath: "1 Bed / 1 Bath",
      rent: "$4,400.00",
      squareFootage: "430 SF",
      outdoor: "None",
      view: "Rear veiw",
      images: ["units/8I.jpg", "units/8I.jpg"],
      description: ["Spacious 1 bedroom with modern finishes.", "Rear veiw.", ""],
    },
  ];
  
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

  // Helper Functions
  function showLeasedPopup(unitNumber) {
    if (leasedModal && leasedUnitNumber) {
      leasedUnitNumber.textContent = unitNumber;
      leasedModal.show();
    }
  }

  function openModal(unit) {
    if (!unitModal || !unitDescription || !unitInput) return;
    
    // Skip if unit is leased (shouldn't happen, but just in case)
    if (unit.isLeased) {
      showLeasedPopup(unit.unit);
      return;
    }

    // Set unit details
    unitDescription.innerHTML = unit.description
      .filter(desc => desc.trim() !== "")
      .map(desc => `<li>${desc}</li>`)
      .join("");

    unitInput.value = unit.unit;

    // Show the modal
    unitModal.show();
  }

  function openFloorPlanModal(image) {
    if (!floorPlanModal || !floorPlanImage) return;
    
    floorPlanImage.src = `assets/images/${image}`;
    floorPlanModal.show();
  }

  // Table Population
  function populateTable(filter = "all", page = 1) {
    tableBody.innerHTML = "";

    // Filter and paginate units
    const filteredUnits = units
      .filter(unit => unit.type !== "HPD")
      .filter(unit => filter === "all" || unit.type === filter);

    const paginatedUnits = filteredUnits.slice(
      (page - 1) * rowsPerPage,
      page * rowsPerPage
    );

    // Create table rows
    paginatedUnits.forEach(unit => {
      const row = document.createElement("tr");
      if (unit.isLeased) row.classList.add("leased-row");
      
      row.innerHTML = `
        <td>${unit.unit}</td>
        <td>${unit.bedBath}</td>
        <td>${unit.outdoor}</td>
        <td>${unit.isLeased ? "LEASED" : unit.rent}</td>
        <td>
          <button class="btn btn-sm view-floor-plan" 
                  data-images='${JSON.stringify(unit.images)}' 
                  ${unit.isLeased ? 'disabled' : ''}>
            View
          </button>
        </td>
      `;

      // Row click handler
      row.addEventListener("click", () => {
        if (unit.isLeased) {
          showLeasedPopup(unit.unit);
        } else {
          openModal(unit);
        }
      });

      // Floor plan button handler
      const viewButton = row.querySelector(".view-floor-plan");
      if (viewButton && !unit.isLeased) {
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

  // Pagination Controls
  function updatePaginationControls(totalUnits, page) {
    const paginationContainer = document.getElementById("pagination");
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

  function createPaginationButton(text, onClick, classes) {
    const button = document.createElement("button");
    button.innerText = text;
    button.classList.add(...classes);
    button.addEventListener("click", onClick);
    return button;
  }

  // Modal Functions
  function openModal(unit) {
    try {
      // First check if modal elements exist
      if (!unitModal || !unitDescription || !unitInput) {
        console.error('Required modal elements not found');
        return;
      }
  
      // Set unit details
      unitDescription.innerHTML = unit.description
        .filter(desc => desc.trim() !== "")
        .map(desc => `<li>${desc}</li>`)
        .join("");
  
      unitInput.value = unit.unit;
  
      // Handle form state - NEW SIMPLIFIED VERSION
      const form = document.querySelector("#unitModal form");
      if (form) {
        // Enable all form elements (in case they were previously disabled)
        form.querySelectorAll("input, select, textarea, button").forEach(el => {
          el.disabled = false;
        });
        
        // Remove any leased-form class if present
        form.classList.remove("leased-form");
      }
  
      // Show the modal
      unitModal.show();
      
    } catch (error) {
      console.error('Error opening unit modal:', error);
      // Fallback to alert if modal fails
      alert('Unable to show unit details. Please try again.');
    }
  }
  

  function openFloorPlanModal(image, isLeased = false) {
    floorPlanImage.src = `assets/images/${image}`;
    
    // Clear or create leased overlay
    const modalBody = document.getElementById("floorPlanModal").querySelector(".modal-body");
    const existingOverlay = modalBody.querySelector(".leased-overlay");
    
    if (existingOverlay) existingOverlay.remove();
    if (isLeased) {
      const overlay = document.createElement("div");
      overlay.className = "leased-overlay";
      overlay.innerHTML = '<div class="leased-text">LEASED</div>';
      modalBody.appendChild(overlay);
    }

    floorPlanModal.show();
  }

  // Event Listeners
  filterButtons.forEach(button => {
    button.addEventListener("click", () => {
      filterButtons.forEach(btn => btn.classList.remove("active"));
      button.classList.add("active");
      currentFilter = button.dataset.filter;
      currentPage = 1;
      populateTable(currentFilter, currentPage);
    });
  });

  // Initialize
  const paginationDiv = document.createElement("div");
  paginationDiv.id = "pagination";
  paginationDiv.classList.add("text-center", "mt-4");
  document.querySelector("#availability .container").appendChild(paginationDiv);
  
  populateTable();
});