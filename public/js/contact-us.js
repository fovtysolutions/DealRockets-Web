// Initialize the Choices.js library for the country dropdown
const countryDropdown = new Choices('#countryCode', {
    searchEnabled: false, // Disable search for simplicity
    itemSelectText: '',
  });

  // Handle country code change
  document.getElementById('countryCode').addEventListener('change', function() {
    const countryCode = this.value;
    document.getElementById('phone').value = countryCode + ' ';
  });