
// JavaScript functions for interactivity

// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', () => {
    // Add event listeners to buttons
    const hiringBtn = document.querySelector('.btn-outline');
    const jobSeekerBtn = document.querySelector('.btn-primary');
    const applyButtons = document.querySelectorAll('.btn-outline-small');
    const postJobBtn = document.querySelector('.btn-primary-large');
    
    // Simple click handlers to demonstrate functionality
    // In a real application, these would navigate to specific pages or open forms
    
    if (hiringBtn) {
      hiringBtn.addEventListener('click', () => {
        alert('Navigating to hiring page...');
      });
    }
    
    if (jobSeekerBtn) {
      jobSeekerBtn.addEventListener('click', () => {
        alert('Navigating to job seeker page...');
      });
    }
    
    if (applyButtons) {
      applyButtons.forEach(button => {
        button.addEventListener('click', (e) => {
          // Get the job title from the closest job card
          const jobCard = e.target.closest('.job-card');
          const jobTitle = jobCard ? jobCard.querySelector('.job-title').textContent : 'this job';
          alert(`Applying for ${jobTitle}...`);
        });
      });
    }
    
    if (postJobBtn) {
      postJobBtn.addEventListener('click', () => {
        alert('Opening job posting form...');
      });
    }
    
    // Make the page responsive and add additional interactions as needed
    function handleResize() {
      // Add responsive behavior beyond CSS if needed
      const viewportWidth = window.innerWidth;
      
      // Example: Adjust elements based on viewport width
      if (viewportWidth <= 768) {
        // Mobile adjustments if needed
      } else if (viewportWidth <= 1024) {
        // Tablet adjustments if needed
      } else {
        // Desktop adjustments if needed
      }
    }
    
    // Call once on load and add listener for window resize
    handleResize();
    window.addEventListener('resize', handleResize);
});  