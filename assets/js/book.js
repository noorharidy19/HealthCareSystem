
function validateForm() {
  let isValid = true;

  // Clear previous error messages
  document.querySelectorAll('.error-message').forEach(el => el.remove());

  // Full Name Validation
  let fullName = document.getElementById('fullName').value.trim();
  if (fullName === "") {
    showError('fullName', 'Please enter your full name.');
    isValid = false;
  }

  // Email Validation
  let email = document.getElementById('email').value.trim();
  let emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
  if (!emailPattern.test(email)) {
    showError('email', 'Please enter a valid email address.');
    isValid = false;
  }

  // Appointment Date Validation
  let appointmentDate = document.getElementById('appointmentDate').value;
  if (appointmentDate === "") {
    showError('appointmentDate', 'Please select an appointment date.');
    isValid = false;
  }

  // Phone Number Validation
  let phoneNumber = document.getElementById('phoneNumber').value.trim();
  let phonePattern = /^[0-9]{10}$/;  // Adjust regex based on your format
  if (!phonePattern.test(phoneNumber)) {
    showError('phoneNumber', 'Please enter a valid 10-digit phone number.');
    isValid = false;
  }

  // Message Validation
  let message = document.getElementById('message').value.trim();
  if (message === "") {
    showError('message', 'Please enter a message.');
    isValid = false;
  }

  return isValid;
}

function showError(inputId, message) {
  let inputElement = document.getElementById(inputId);
  let errorElement = document.createElement('div');
  errorElement.className = 'error-message text-danger';
  errorElement.innerText = message;
  inputElement.parentNode.appendChild(errorElement);
}
 // book.js
document.getElementById('appointmentForm').addEventListener('submit', async (event) => {
  event.preventDefault();  // Prevent default form submission
  
  const formData = new FormData(event.target);

  // Debugging: Log form data to ensure it's captured correctly
  for (let [key, value] of formData.entries()) {
      console.log(key + ": " + value);
  }

  try {
      const response = await fetch('book.php', {
          method: 'POST',  // Send data as a POST request
          body: formData    // Send form data
      });
      
      // Process the response from the server (e.g., update the UI)
      const result = await response.json();
      console.log(result);  // Log the response from the server
      
      // You can handle success/failure logic here
      if (result.success) {
          alert('Appointment booked successfully!');
      } else {
          alert('Error: ' + result.message);
      }
  } catch (error) {
      console.error('Error:', error);
  }
});

const formatTime = (time) => {
  // Ensure time is in HH:mm:ss format
  return time.includes(':') && time.length === 5 ? time + ':00' : time;
};

document.getElementById('appointmentForm').addEventListener('submit', async (event) => {
  event.preventDefault();

  const formData = new FormData(event.target);

  // Format start and end times before submission
  formData.set('start_time', formatTime(formData.get('start_time')));
  formData.set('end_time', formatTime(formData.get('end_time')));

  try {
      const response = await fetch('book.php', {
          method: 'POST',
          body: formData
      });

      const result = await response.json();
      if (result.success) {
          alert('Appointment booked successfully!');
      } else {
          alert('Error: ' + result.message);
      }
  } catch (error) {
      console.error('Error:', error);
  }
});


document.getElementById('doctor_id').addEventListener('change', function() {
  var doctorId = this.value;
  if (doctorId) {
      var xhr = new XMLHttpRequest();
      xhr.open('GET', 'getSlots.php?doctor_id=' + doctorId, true);
      xhr.onload = function() {
          if (xhr.status === 200) {
              var slots = JSON.parse(xhr.responseText);
              var slotSelect = document.getElementById('slot_id');
              slotSelect.innerHTML = '<option value="">Select a Time Slot</option>';
              slots.forEach(function(slot) {
                  var option = document.createElement('option');
                  option.value = slot.slot_id;
                  option.textContent = slot.start_time + ' - ' + slot.end_time;
                  slotSelect.appendChild(option);
              });
          }
      };
      xhr.send();
  }
});
