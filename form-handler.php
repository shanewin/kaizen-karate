<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Collect form data
  $firstName = htmlspecialchars($_POST['firstName']);
  $lastName = htmlspecialchars($_POST['lastName']);
  $email = htmlspecialchars($_POST['email']);
  $phone = htmlspecialchars($_POST['phone']);
  $moveInDate = htmlspecialchars($_POST['moveInDate']);
  $budget = htmlspecialchars($_POST['budget']);
  $hearAboutUs = htmlspecialchars($_POST['hearAboutUs']);
  $message = htmlspecialchars($_POST['message']);
  $unit = htmlspecialchars($_POST['unit']); // Get the unit information

  // ✅ Server-side validation
  if (empty($firstName) || empty($lastName) || empty($email) || empty($phone)) {
    echo "<p>Please fill out all required fields.</p>";
    exit;
  }

  // Send email
  $to = "your-email@example.com"; // Replace with your email address
  $subject = "New Interest Form Submission for Unit: $unit"; // Include unit in subject
  $body = "Unit: $unit\nFirst Name: $firstName\nLast Name: $lastName\nEmail: $email\nPhone: $phone\nMove-In Date: $moveInDate\nBudget: $budget\nHow Did You Hear: $hearAboutUs\nMessage: $message";
  $headers = "From: no-reply@example.com"; // Replace with a valid sender email

  if (mail($to, $subject, $body, $headers)) {
    echo "<p>Thank you for your interest! We will get back to you soon.</p>";
  } else {
    echo "<p>Sorry, there was an error submitting your form. Please try again later.</p>";
  }
}
?>
