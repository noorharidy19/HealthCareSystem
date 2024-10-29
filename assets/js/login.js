function validateLoginForm() {
    // Clear previous errors
    document.getElementById("loginEmailOrPhoneError").classList.add("hidden");
    document.getElementById("loginPasswordError").classList.add("hidden");
  
    const emailOrPhone = document.getElementById("loginEmailOrPhone").value;
    const password = document.getElementById("loginPassword").value;
  
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const phonePattern = /^\d{11}$/;
  
    let hasError = false;
  
    // Validate Email or Phone
    if (!emailOrPhone) {
      document.getElementById("loginEmailOrPhoneError").textContent = "Please enter your email or phone number.";
      document.getElementById("loginEmailOrPhoneError").classList.remove("hidden");
      hasError = true;
    } else if (!emailPattern.test(emailOrPhone) && !phonePattern.test(emailOrPhone)) {
      document.getElementById("loginEmailOrPhoneError").textContent = "Enter a valid email or phone number.";
      document.getElementById("loginEmailOrPhoneError").classList.remove("hidden");
      hasError = true;
    }
  
    // Validate Password
    if (!password) {
      document.getElementById("loginPasswordError").textContent = "Enter a valid email or phone number.";
      document.getElementById("loginPasswordError").classList.remove("hidden");
      hasError = true;
    }
  
    return !hasError; // Prevent form submission if there are errors
  }