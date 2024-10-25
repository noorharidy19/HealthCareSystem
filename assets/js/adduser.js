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

  function confirmDelete() {
    // Show the modal
    document.getElementById("confirmModal").style.display = "block";

    // Handle confirm delete button
    document.getElementById("confirmDeleteBtn").onclick = function() {
      // Show a confirmation message in the modal
      document.querySelector(".modal-content p").innerText = "User has been deleted.";
      
      // Hide the confirm and cancel buttons after deletion
      document.querySelector(".modal-buttons").style.display = "none";
      
      // Close the modal after a short delay
      setTimeout(() => {
          document.getElementById("confirmModal").style.display = "none";
          // Optionally reset modal content for next use
          document.querySelector(".modal-content p").innerText = "Are you sure you want to delete?";
          document.querySelector(".modal-buttons").style.display = "flex";
      }, 900);
  };

    // Handle cancel button
    document.getElementById("cancelDeleteBtn").onclick = function() {
        document.getElementById("confirmModal").style.display = "none";
    };
}

  function validateForm() {
    let isValid = true;

    // Clear previous error messages
    document.getElementById('userTypeError').innerText = '';
    document.getElementById('nameError').innerText = '';
    document.getElementById('emailError').innerText = '';
    document.getElementById('phoneError').innerText = '';
    document.getElementById('genderError').innerText = '';
    document.getElementById('dobError').innerText = '';
    document.getElementById('addressError').innerText = '';
    document.getElementById('passwordError').innerText = '';
    document.getElementById('specializationError').innerText = '';

    // User Type Validation
    let userType = document.querySelector('input[name="userType"]:checked');
    if (!userType) {
      document.getElementById('userTypeError').innerText = 'Please select a user type.';
      isValid = false;
    } else {
      userType = userType.value;
    }

    // Name Validation
    let name = document.getElementById('name').value.trim();
    if (name === "") {
      document.getElementById('nameError').innerText = 'Please enter the name.';
      isValid = false;
    }

    // Email Validation
    let email = document.getElementById('email').value.trim();
    let emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!emailPattern.test(email)) {
      document.getElementById('emailError').innerText = 'Please enter a valid email address.';
      isValid = false;
    }
    //password
    let password = document.getElementById('password').value.trim();
    let passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    if (!passwordPattern.test(password)) {
      document.getElementById('passwordError').innerText = 'Please enter a valid password.';
      isValid = false;
    }

    // Phone Validation
    let phone = document.getElementById('phone').value.trim();
    let phonePattern = /^[0-9]{10}$/;  // Adjust regex based on your format
    if (!phonePattern.test(phone)) {
      document.getElementById('phoneError').innerText = 'Please enter a valid 10-digit phone number.';
      isValid = false;
    }

    // Gender Validation
    let gender = document.querySelector('input[name="gender"]:checked');
    if (!gender) {
      document.getElementById('genderError').innerText = 'Please select a gender.';
      isValid = false;
    }

    // Date of Birth Validation
    let dob = document.getElementById('dob').value;
    if (dob === "") {
      document.getElementById('dobError').innerText = 'Please enter the date of birth.';
      isValid = false;
    }

    // Address Validation
    let address = document.getElementById('address').value.trim();
    if (address === "") {
      document.getElementById('addressError').innerText = 'Please enter an address.';
      isValid = false;
    }

    // Doctor Specialization Validation (only if Doctor is selected)
    if (userType === "Doctor") {
      let specialization = document.getElementById('specialization').value.trim();
      if (specialization === "") {
        document.getElementById('specializationError').innerText = 'Please enter the doctor\'s specialization.';
        isValid = false;
      }
    }

    return isValid;
  }

 
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
    function validateFormedit() {
      let isValid = true;
    
      // Clear previous error messages
      document.getElementById('nameError').innerText = '';
      document.getElementById('emailError').innerText = '';
      document.getElementById('passwordError').innerText = '';
      document.getElementById('phoneError').innerText = '';
      document.getElementById('dobError').innerText = '';
      document.getElementById('addressError').innerText = '';
    
      // Name Validation
      let name = document.getElementById('name').value.trim();
      if (name === "") {
        document.getElementById('nameError').innerText = 'Please enter the name.';
        isValid = false;
      }
    
      // Email Validation
      let email = document.getElementById('email').value.trim();
      let emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
      if (!emailPattern.test(email)) {
        document.getElementById('emailError').innerText = 'Please enter a valid email address.';
        isValid = false;
      }
    
      // Password Validation
      let password = document.getElementById('password').value.trim();
      if (password === "") {
        document.getElementById('passwordError').innerText = 'Please enter a password.';
        isValid = false;
      }
    
      // Phone Validation
      let phone = document.getElementById('phone').value.trim();
      let phonePattern = /^[0-9]{10}$/;  // Adjust regex based on your format
      if (!phonePattern.test(phone)) {
        document.getElementById('phoneError').innerText = 'Please enter a valid 10-digit phone number.';
        isValid = false;
      }
    
      // Date of Birth Validation
      let dob = document.getElementById('dob').value;
      if (dob === "") {
        document.getElementById('dobError').innerText = 'Please enter the date of birth.';
        isValid = false;
      }
    
      // Address Validation
      let address = document.getElementById('address').value.trim();
      if (address === "") {
        document.getElementById('addressError').innerText = 'Please enter an address.';
        isValid = false;
      }
    
      return isValid;
    }
  