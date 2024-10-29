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
    function validateForm() {
      
      // Clear previous error messages
      document.getElementById("nameError").textContent = "";
      document.getElementById("phoneError").textContent = "";
      document.getElementById("emailError").textContent = "";
      document.getElementById("passwordError").textContent = "";
      document.getElementById("confirmPasswordError").textContent = "";
      document.getElementById("dobError").textContent = "";
      document.getElementById("genderError").textContent = "";
      document.getElementById("addressError").textContent = "";
  
      const firstName = document.getElementById("name").value;
      const phoneNumber = document.getElementById("phone").value;
      const email = document.getElementById("email").value;
      const password = document.getElementById("password").value;
      const confirmPassword = document.getElementById("confirmPassword").value;
      const birthdate = document.getElementById("dob").value;
      const gender = document.querySelector('input[name="gender"]:checked');
      const address=document.getElementById("address").value;
      
      const namePattern = /^[a-zA-Z]+$/;
      const phonePattern = /^\d{11}$/;
      const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/; // email format
      let hasError = false;
  
      
      if (!firstName) {
        document.getElementById("nameError").textContent = "Name is required.";
        hasError = true;
    } else if (!namePattern.test(firstName)) {
        document.getElementById("nameError").textContent = "Name should contain only alphabetic characters.";
        hasError = true;
    }
  
      
    if (!phoneNumber) {
      document.getElementById("phoneError").textContent = "Phone number is required.";
      hasError = true;
  } else if (!phonePattern.test(phoneNumber)) {
      document.getElementById("phoneError").textContent = "Phone number must be exactly 11 digits and contain only numbers.";
      hasError = true;
  }
  
      
  if (!email) {
    document.getElementById("emailError").textContent = "Email is required.";
    hasError = true;
} else if (!emailPattern.test(email)) {
    document.getElementById("emailError").textContent = "Please enter a valid email address.";
    hasError = true;
}
if (!address) {
  document.getElementById("addressError").textContent = "Address is required.";
  hasError = true;
}
      
      if (!password) {
            document.getElementById("passwordError").textContent = "Password is required.";
            hasError = true;
        }

        if (!confirmPassword) {
            document.getElementById("confirmPasswordError").textContent = "Confirm password is required.";
            hasError = true;
        } else if (password !== confirmPassword) {
            document.getElementById("confirmPasswordError").textContent = "Passwords do not match!";
            hasError = true;
        }
      
      if (!gender) {
          document.getElementById("genderError").textContent = "Please select your gender.";
          hasError = true;
      }
  
      
      if (!birthdate) {
        document.getElementById("dobError").textContent = "Date of birth is required.";
        hasError = true;
    } else {
        const today = new Date();
        const birthDate = new Date(birthdate);
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        
        //age not incremented unless the birthdate selected already occured in the current year
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }

        if (age < 18) {
            document.getElementById("dobError").textContent = "You must be at least 18 years old to sign up.";
            hasError = true;
        }
    }

    
        
  // If there are no errors, return true to allow form submission
  return !hasError;
    }

