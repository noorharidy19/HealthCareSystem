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
    