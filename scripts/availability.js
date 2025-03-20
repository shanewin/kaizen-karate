document.addEventListener("DOMContentLoaded", function () {
  const units = [
    {
      unit: "Unit 2A",
      type: "2-bed",
      bedBath: "2 Bed / 2 Bath",
      rent: "$6,700.00",
      squareFootage: "730 SF",
      outdoor: "Terrace 700 SF",
      view: "Rear veiw",
      images: ["units/2A.jpg", "units/2A.jpg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Rear veiw.", "Terrace 700 SF."],
    },
    {
      unit: "Unit 2B",
      type: "1-bed",
      bedBath: "1 Bed / 1 Bath",
      rent: "$4,100.00",
      squareFootage: "545 SF",
      outdoor: "None",
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
      outdoor: "None",
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
      outdoor: "None",
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
      outdoor: "None",
      view: "Myrtle veiw corner",
      images: ["units/2E.jpg", "units/2E.jpg"],
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
      images: ["units/2G.jpg", "units/2G.jpg"],
      description: ["HPD unit.", "HPD.", "HPD."],
    },
    {
      unit: "Unit 2H",
      type: "2-bed",
      bedBath: "2 Bed / 2 Bath",
      rent: "$5,800.00",
      squareFootage: "743 SF",
      outdoor: "None",
      view: "Myrtle view",
      images: ["units/2H.jpg", "units/2H.jpg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Myrtle view.", ""],
    },
    {
      unit: "Unit 2I",
      type: "2-bed",
      bedBath: "2 Bed / 2 Bath",
      rent: "$7,000.00",
      squareFootage: "831 SF",
      outdoor: "Terrace 800 SF",
      view: "Rear veiw",
      images: ["units/2I.jpg", "units/2I.jpg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Rear veiw.", "Terrace 800 SF."],
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
      outdoor: "2 Balcony’s",
      view: "Myrtle veiw corner",
      images: ["units/3D.jpg", "units/3D.jpg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Myrtle veiw corner.", "2 Balcony\u2019s."],
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
      images: ["units/3F.jpg", "units/3F.jpg"],
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
      images: ["units/3I.jpg", "units/3I.jpg"],
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
      images: ["units/4A.jpg", "units/4A.jpg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Rear veiw.", "Balcony."],
    },
    {
      unit: "Unit 4B",
      type: "3-bed",
      bedBath: "3 Bed / 2 Bath",
      rent: "$8,000.00",
      squareFootage: "975 SF",
      outdoor: "2 Balcony’s",
      view: "Carlton view",
      images: ["units/4B.jpg", "units/4B.jpg"],
      description: ["Spacious 3 bedroom with modern finishes.", "Carlton view.", "2 Balcony\u2019s."],
    },
    {
      unit: "Unit 4C",
      type: "1-bed",
      bedBath: "1 Bed / 1 Bath",
      rent: "$4,300.00",
      squareFootage: "537 SF",
      outdoor: "Balcony",
      view: "Carlton view",
      images: ["units/4C.jpg", "units/4C.jpg"],
      description: ["Spacious 1 bedroom with modern finishes.", "Carlton view.", "Balcony."],
    },
    {
      unit: "Unit 4D",
      type: "2-bed",
      bedBath: "2 Bed / 1 Bath",
      rent: "$5,900.00",
      squareFootage: "647 SF",
      outdoor: "2 Balcony’s",
      view: "Myrtle veiw corner",
      images: ["units/4D.jpg", "units/4D.jpg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Myrtle veiw corner.", "2 Balcony\u2019s."],
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
      images: ["units/4G.jpg", "units/4G.jpg"],
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
      images: ["units/4H.jpg", "units/4H.jpg"],
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
      images: ["units/5A.jpg", "units/5A.jpg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Rear veiw.", "Balcony."],
    },
    {
      unit: "Unit 5B",
      type: "3-bed",
      bedBath: "3 Bed / 2 Bath",
      rent: "$8,200.00",
      squareFootage: "975 SF",
      outdoor: "Balcony",
      view: "Carlton view",
      images: ["units/5B.jpg", "units/5B.jpg"],
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
      images: ["units/5C.jpg", "units/5C.jpg"],
      description: ["Spacious 1 bedroom with modern finishes.", "Carlton view.", "Balcony."],
    },
    {
      unit: "Unit 5D",
      type: "2-bed",
      bedBath: "2 Bed / 1 Bath",
      rent: "$5,900.00",
      squareFootage: "647 SF",
      outdoor: "2 Balcony’s",
      view: "Myrtle veiw corner",
      images: ["units/5D.jpg", "units/5D.jpg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Myrtle veiw corner.", "2 Balcony\u2019s."],
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
      images: ["units/5G.jpg", "units/5G.jpg"],
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
      images: ["units/5H.jpg", "units/5H.jpg"],
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
      images: ["units/6A.jpg", "units/6A.jpg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Rear veiw.", "Balcony."],
    },
    {
      unit: "Unit 6B",
      type: "3-bed",
      bedBath: "3 Bed / 2 Bath",
      rent: "$8,200.00",
      squareFootage: "975 SF",
      outdoor: "2 Balcony’s",
      view: "Carlton view",
      images: ["units/6B.jpg", "units/6B.jpg"],
      description: ["Spacious 3 bedroom with modern finishes.", "Carlton view.", "2 Balcony\u2019s."],
    },
    {
      unit: "Unit 6C",
      type: "1-bed",
      bedBath: "1 Bed / 1 Bath",
      rent: "$4,400.00",
      squareFootage: "537 SF",
      outdoor: "Balcony",
      view: "Carlton view",
      images: ["units/6C.jpg", "units/6C.jpg"],
      description: ["Spacious 1 bedroom with modern finishes.", "Carlton view.", "Balcony."],
    },
    {
      unit: "Unit 6D",
      type: "2-bed",
      bedBath: "2 Bed / 1 Bath",
      rent: "$6,000.00",
      squareFootage: "647 SF",
      outdoor: "2 Balcony’s",
      view: "Myrtle veiw corner",
      images: ["units/6D.jpg", "units/6D.jpg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Myrtle veiw corner.", "2 Balcony\u2019s."],
    },
    {
      unit: "Unit 6E",
      type: "HPD",
      bedBath: "HPD",
      rent: "$3,787.00",
      squareFootage: "HPD SF",
      outdoor: "HPD",
      view: "HPD",
      images: ["units/6E.jpg", "units/6E.jpg"],
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
      images: ["units/6F.jpg", "units/6F.jpg"],
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
      images: ["units/6G.jpg", "units/6G.jpg"],
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
      images: ["units/6H.jpg", "units/6H.jpg"],
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
      images: ["units/6I.jpg", "units/6I.jpg"],
      description: ["HPD unit.", "HPD.", "HPD."],
    },
    {
      unit: "Unit 7A",
      type: "3-bed",
      bedBath: "3 Bed / 2 Bath",
      rent: "$10,000.00",
      squareFootage: "1102 SF",
      outdoor: "Terrace 661 SF",
      view: "Carlton view and Rear",
      images: ["units/7A.jpg", "units/7A.jpg"],
      description: ["Spacious 3 bedroom with modern finishes.", "Carlton view and Rear.", "Terrace 661 SF."],
    },
    {
      unit: "Unit 7B",
      type: "1-bed",
      bedBath: "1 Bed / 1 Bath",
      rent: "$4,500.00",
      squareFootage: "537 SF",
      outdoor: "Balcony",
      view: "Carlton view",
      images: ["units/7B.jpg", "units/7B.jpg"],
      description: ["Spacious 1 bedroom with modern finishes.", "Carlton view.", "Balcony."],
    },
    {
      unit: "Unit 7C",
      type: "2-bed",
      bedBath: "2 Bed / 1 Bath",
      rent: "$6,200.00",
      squareFootage: "647 SF",
      outdoor: "2 Balcony’s",
      view: "Myrtle veiw corner",
      images: ["units/7C.jpg", "units/7C.jpg"],
      description: ["Spacious 2 bedroom with modern finishes.", "Myrtle veiw corner.", "2 Balcony\u2019s."],
    },
    {
      unit: "Unit 7D",
      type: "HPD",
      bedBath: "HPD",
      rent: "$3,787.00",
      squareFootage: "HPD SF",
      outdoor: "HPD",
      view: "HPD",
      images: ["units/7D.jpg", "units/7D.jpg"],
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
      images: ["units/7F.jpg", "units/7F.jpg"],
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
      images: ["units/7G.jpg", "units/7G.jpg"],
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
      bedBath: "Studio Bed / 1 Bath",
      rent: "$3,800.00",
      squareFootage: "306 SF",
      outdoor: "Terrace 375 SF",
      view: "Carlton view",
      images: ["units/8B.jpg", "units/8B.jpg"],
      description: ["Spacious Studio bedroom with modern finishes.", "Carlton view.", "Terrace 375 SF."],
    },
    {
      unit: "Unit 8C",
      type: "1-bed",
      bedBath: "1 Bed / 1 Bath",
      rent: "$5,200.00",
      squareFootage: "514 SF",
      outdoor: "Terrace 775",
      view: "Myrtle veiw corner",
      images: ["units/8C.jpg", "units/8C.jpg"],
      description: ["Spacious 1 bedroom with modern finishes.", "Myrtle veiw corner.", "Terrace 775."],
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
      outdoor: "Terrace 275 SF",
      view: "Myrtle view",
      images: ["units/8F.jpg", "units/8F.jpg"],
      description: ["Spacious 1 bedroom with modern finishes.", "Myrtle view.", "Terrace 275 SF."],
    },
    {
      unit: "Unit 8G",
      type: "Studio-bed",
      bedBath: "Studio Bed / 1 Bath",
      rent: "$3,500.00",
      squareFootage: "310 SF",
      outdoor: "Terrace 150 SF",
      view: "Rear veiw",
      images: ["units/8G.jpg", "units/8G.jpg"],
      description: ["Spacious Studio bedroom with modern finishes.", "Rear veiw.", "Terrace 150 SF."],
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
  const unitModal = new bootstrap.Modal(document.getElementById("unitModal"));
  const unitInput = document.getElementById("unitInput"); // Ensure this element exists in your HTML
  const unitImage = document.getElementById("unitImage"); // Ensure this element exists in your HTML

  let currentPage = 1;
  const rowsPerPage = 10;
  let currentFilter = "all";

  // Populate Table with Pagination
  function populateTable(filter = "all", page = 1) {
    tableBody.innerHTML = ""; // Clear previous rows

    // Filter units: Exclude HPD units & apply the selected filter
    const filteredUnits = units
      .filter((unit) => unit.type !== "HPD") // Remove HPD units
      .filter((unit) => filter === "all" || unit.type === filter); // Apply filter

    // Pagination Logic
    const startIndex = (page - 1) * rowsPerPage;
    const endIndex = startIndex + rowsPerPage;
    const paginatedUnits = filteredUnits.slice(startIndex, endIndex);

    // Populate Table with Paginated Results
    paginatedUnits.forEach((unit) => {
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${unit.unit}</td>
        <td>${unit.bedBath}</td>
        <td>${unit.outdoor}</td>
        <td>${unit.rent}</td>
        <td><button class="btn btn-sm view-floor-plan" data-images='${JSON.stringify(unit.images)}'>View</button></td>
      `;
    
      // Add click event to the row to open the unit modal
      row.addEventListener("click", () => openModal(unit));
    
      // Prevent the "View" button from triggering the row click
      const viewButton = row.querySelector(".view-floor-plan");
      viewButton.addEventListener("click", (e) => {
        e.stopPropagation(); // Stop the event from bubbling up to the row
        const images = JSON.parse(viewButton.dataset.images);
        openFloorPlanModal(images[0]); // Display the first image
      });
    
      tableBody.appendChild(row);
    });

    // Update Pagination Controls
    updatePaginationControls(filteredUnits.length, page);
  }

  // Update Pagination Controls
  function updatePaginationControls(totalUnits, page) {
    const paginationContainer = document.getElementById("pagination");
    paginationContainer.innerHTML = ""; // Clear previous buttons

    const totalPages = Math.ceil(totalUnits / rowsPerPage);

    // Previous Button
    if (page > 1) {
      const prevButton = document.createElement("button");
      prevButton.innerText = "<< Previous";
      prevButton.classList.add("btn", "btn-outline-primary", "mx-2");
      prevButton.addEventListener("click", () => {
        currentPage--;
        populateTable(currentFilter, currentPage);
      });
      paginationContainer.appendChild(prevButton);
    }

    // Page Numbers
    for (let i = 1; i <= totalPages; i++) {
      const pageButton = document.createElement("button");
      pageButton.innerText = i;
      pageButton.classList.add("btn", "btn-outline-primary", "mx-1");
      if (i === page) {
        pageButton.classList.add("active");
      }
      pageButton.addEventListener("click", () => {
        currentPage = i;
        populateTable(currentFilter, currentPage);
      });
      paginationContainer.appendChild(pageButton);
    }

    // Next Button
    if (page < totalPages) {
      const nextButton = document.createElement("button");
      nextButton.innerText = "Next >>";
      nextButton.classList.add("btn", "btn-outline-primary", "mx-2");
      nextButton.addEventListener("click", () => {
        currentPage++;
        populateTable(currentFilter, currentPage);
      });
      paginationContainer.appendChild(nextButton);
    }
  }

  // Filter Buttons with Pagination
  filterButtons.forEach((button) => {
    button.addEventListener("click", () => {
      filterButtons.forEach((btn) => btn.classList.remove("active"));
      button.classList.add("active");
      currentFilter = button.dataset.filter;
      currentPage = 1; // Reset to first page when changing filters
      populateTable(currentFilter, currentPage);
    });
  });

  // Open Modal with Unit Details
  function openModal(unit) {
    const unitDescription = document.getElementById("unitDescription");
    unitDescription.innerHTML = unit.description
      .filter(desc => desc.trim() !== "") // Remove empty descriptions
      .map(desc => `<li>${desc}</li>`)
      .join("");
  
    // Set Unit Information in Hidden Input
    unitInput.value = unit.unit;
  
    // Show Modal
    unitModal.show();
  }

  // Add Pagination Container in HTML
  const paginationDiv = document.createElement("div");
  paginationDiv.id = "pagination";
  paginationDiv.classList.add("text-center", "mt-4");
  document.querySelector("#availability .container").appendChild(paginationDiv);

  // Function to open Floor Plan Modal
  function openFloorPlanModal(image) {
    const floorPlanImage = document.getElementById("floorPlanImage");
    floorPlanImage.src = `assets/images/${image}`; // Set the image source

    // Show the modal
    const floorPlanModal = new bootstrap.Modal(document.getElementById("floorPlanModal"));
    floorPlanModal.show();
  } 

  // Initial Table Population
  populateTable();
});