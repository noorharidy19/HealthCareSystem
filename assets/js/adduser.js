function toggleDoctorField() {
    var userType = document.getElementById('userType').value;
    var specializationField = document.getElementById('specializationField');
    if (userType === 'Doctor') {
      specializationField.classList.remove('hidden');
    } else {
      specializationField.classList.add('hidden');
      document.getElementById('specialization').value = ''; // Clear field if not Doctor
    }
  }

  // JavaScript Form Validation Function
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
    document.getElementById('specializationError').innerText = '';

    // User Type Validation
    let userType = document.getElementById('userType').value;
    if (userType === "") {
      document.getElementById('userTypeError').innerText = 'Please select a user type.';
      isValid = false;
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

    // Phone Validation
    let phone = document.getElementById('phone').value.trim();
    let phonePattern = /^[0-9]{10}$/;  // Adjust regex based on your format
    if (!phonePattern.test(phone)) {
      document.getElementById('phoneError').innerText = 'Please enter a valid 10-digit phone number.';
      isValid = false;
    }

    // Gender Validation
    let gender = document.getElementById('gender').value;
    if (gender === "") {
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