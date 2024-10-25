function toggleDoctorField() {
    var doctorRadio = document.getElementById('doctor');  // The Doctor radio button
    var specializationField = document.getElementById('specializationField');  // Specialization field container
  
    if (doctorRadio.checked) {
        specializationField.classList.remove('hidden');  // Show the specialization field if Doctor is selected
    } else {
        specializationField.classList.add('hidden');  // Hide the specialization field if not Doctor
        document.getElementById('specialization').value = '';  // Clear the selection if hidden
    }
  }
  
    // JavaScript Form Validation Function
    document.addEventListener("DOMContentLoaded", function validateForm() {
        document.getElementById("signup-form").addEventListener("submit", function (e) {
          e.preventDefault();
  
          // Clear previous error messages
          document.getElementById("fname-error").textContent = "";
          document.getElementById("lname-error").textContent = "";
          document.getElementById("password-error").textContent = "";
          document.getElementById("confirm-password-error").textContent = "";
          document.getElementById("birthdate-error").textContent = "";
  
          const firstName = document.getElementById("Fname").value;
          const lastName = document.getElementById("Lname").value;
          const password = document.getElementById("Password").value;
          const confirmPassword = document.getElementById("confirmPassword").value;
          const birthdate = document.getElementById("Birthdate").value;
  
          const namePattern = /^[a-zA-Z]+$/; // Ensures only alphabetical characters
          let hasError = false;
          
          if (!namePattern.test(firstName)) {
            document.getElementById("fname-error").textContent = "First name should contain only alphabetic characters.";
            hasError = true;
          }
  
          if (!namePattern.test(lastName)) {
            document.getElementById("lname-error").textContent = "Last name should contain only alphabetic characters.";
            hasError = true;
          }
  
          if (password !== confirmPassword) {
            document.getElementById("password-error").textContent = "Passwords do not match!";
            document.getElementById("confirm-password-error").textContent = "Passwords do not match!";
            hasError = true;
          }
  
          // Validate that the user is at least 18 years old
          const today = new Date();
          const birthDate = new Date(birthdate);
          let age = today.getFullYear() - birthDate.getFullYear();
          const monthDiff = today.getMonth() - birthDate.getMonth();
          
          if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
          }
  
          if (age < 18) {
            document.getElementById("birthdate-error").textContent = "You must be at least 18 years old to sign up.";
            hasError = true;
          }
  
          if (!hasError) {
            // If no errors, submit the form
            alert("Form submitted successfully!");
            this.submit();
          }
        });
      });