// Utility function to format time to HH:mm:ss
const formatTime = (time) => {
  return time.includes(':') && time.length === 5 ? time + ':00' : time;
};

// Function to display error messages
function showError(inputId, message) {
  const inputElement = document.getElementById(inputId);
  const errorElement = document.createElement('div');
  errorElement.className = 'error-message text-danger';
  errorElement.innerText = message;
  inputElement.parentNode.appendChild(errorElement);
}

// Validation function for form fields
function validateForm() {
  let isValid = true;
  var doctorId = document.getElementById('doctor_id').value;
  if (!doctorId) {
    alert('Please select a doctor.');
    isValid = false; // Prevent form submission
}
  // Clear previous error messages
  document.querySelectorAll('.error-message').forEach((el) => el.remove());

  // Full Name Validation
  const fullName = document.getElementById('fullName').value.trim();
  if (fullName === "") {
    showError('fullName', 'Please enter your full name.');
    isValid = false;
  }

  // Email Validation
  const email = document.getElementById('email').value.trim();
  const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
  if (!emailPattern.test(email)) {
    showError('email', 'Please enter a valid email address.');
    isValid = false;
  }

  // Appointment Date Validation
  const appointmentDate = document.getElementById('appointmentDate').value;
  if (appointmentDate === "") {
    showError('appointmentDate', 'Please select an appointment date.');
    isValid = false;
  }

  // Phone Number Validation
  const phoneNumber = document.getElementById('phoneNumber').value.trim();
  const phonePattern = /^[0-9]{11}$/; // Adjust regex based on your format
  if (!phonePattern.test(phoneNumber)) {
    showError('phoneNumber', 'Please enter a valid 10-digit phone number.');
    isValid = false;
  }

  // Message Validation
  const message = document.getElementById('message').value.trim();
  if (message === "") {
    showError('message', 'Please enter a message.');
    isValid = false;
  }

  return isValid;
}

// Fetch available slots when doctor is selected
document.getElementById('doctor_id').addEventListener('change', function () {
  const doctorId = this.value;
  if (doctorId) {
    fetch(`getSlots.php?doctor_id=${doctorId}`)
      .then((response) => response.json())
      .then((slots) => {
        const slotSelect = document.getElementById('slot_id');
        slotSelect.innerHTML = '<option value="">Select a Time Slot</option>';
        slots.forEach((slot) => {
          const option = document.createElement('option');
          option.value = `${slot.start_time} - ${slot.end_time}`; // Ensure this matches your backend
          option.textContent = `${slot.start_time} - ${slot.end_time}`;
          slotSelect.appendChild(option);
        });
      })
      .catch((error) => console.error('Error fetching slots:', error));
  }
});

// Form submission handler
document.getElementById('appointmentForm').addEventListener('submit', async (event) => {
  event.preventDefault(); // Prevent default form submission

  if (!validateForm()) {
    return; // Exit if validation fails
  }

  const formData = new FormData(event.target);

  try {
    const response = await fetch('book.php', {
      method: 'POST',
      body: formData,
    });

    // Check if the response is OK
    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }

    const result = await response.json();

    if (result.success) {
      alert('Appointment booked successfully!');
      event.target.reset(); // Reset the form on success
    } else {
      alert('Error: ' + result.message);
    }
  } catch (error) {
    console.error('Error submitting the form:', error);
    alert('There was an error processing your request.');
  }
});