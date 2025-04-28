// Countries data
const countries = [
    { id: 1, name: "United States", flagUrl: "https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/310ff89f1dff8af2e8a965f3f1d0004b43241166?placeholderIfAbsent=true", selected: true },
    { id: 2, name: "United Kingdom", flagUrl: "https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/ea9b135ec0849f3a59662b5bd96bfd4b0dbc5008?placeholderIfAbsent=true", selected: false },
    { id: 3, name: "China", flagUrl: "https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/2cfe57c20dfb273b3473cef35f7ff35cfdc75ad5?placeholderIfAbsent=true", selected: false },
    { id: 4, name: "Russia", flagUrl: "https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/fca9c4ace3664357f9afbdc2e4b909a471f7a1af?placeholderIfAbsent=true", selected: false },
    { id: 5, name: "Australia", flagUrl: "https://cdn.builder.io/api/v1/image/assets/22e8f5e19f8a469193ec854927e9c5a6/84d7c1d487ad1947937ba29db5084ff668eed82d?placeholderIfAbsent=true", selected: false },
];

// Categories data
const categories = [
    { id: 1, name: "Agriculture", selected: true },
    { id: 2, name: "Fashion Accessories", selected: false },
    { id: 3, name: "Furniture", selected: false },
    { id: 4, name: "Trade Services", selected: false },
    { id: 5, name: "Health & Medical", selected: false },
];

// Pagination state
let currentPage = 1;
const itemsPerPage = 12;
const totalItems = 276;
const totalPages = Math.ceil(totalItems / itemsPerPage);

// Handle page change
function changePage(newPage) {
    if (newPage < 1 || newPage > totalPages || newPage === currentPage) {
    return;
    }
    
    currentPage = newPage;
    renderLeads();
    updatePaginationUI();
}

// Update pagination UI based on current page
function updatePaginationUI() {
    const pageButtons = document.querySelectorAll('.page-buttons .page-btn');
    
    // Remove active class from all page buttons
    pageButtons.forEach(button => {
    if (button.getAttribute('data-page')) {
        button.classList.remove('active');
        if (Number(button.getAttribute('data-page')) === currentPage) {
        button.classList.add('active');
        button.setAttribute('aria-current', 'page');
        } else {
        button.removeAttribute('aria-current');
        }
    }
    });
    
    // Update previous/next buttons
    const prevButton = document.getElementById('prev-page');
    const nextButton = document.getElementById('next-page');
    
    if (currentPage === 1) {
    prevButton.disabled = true;
    prevButton.classList.add('disabled');
    } else {
    prevButton.disabled = false;
    prevButton.classList.remove('disabled');
    }
    
    if (currentPage === totalPages) {
    nextButton.disabled = true;
    nextButton.classList.add('disabled');
    } else {
    nextButton.disabled = false;
    nextButton.classList.remove('disabled');
    }
}

// Toggle country selection
function toggleCountry(id) {
    const countryIndex = countries.findIndex(country => country.id === id);
    if (countryIndex !== -1) {
    countries[countryIndex].selected = !countries[countryIndex].selected;
    renderCountries();
    }
}

// Toggle category selection
function toggleCategory(id) {
    const categoryIndex = categories.findIndex(category => category.id === id);
    if (categoryIndex !== -1) {
    categories[categoryIndex].selected = !categories[categoryIndex].selected;
    renderCategories();
    }
}

// Add event listeners
function setupEventListeners() {
    // Pagination buttons
    document.getElementById('prev-page').addEventListener('click', () => changePage(currentPage - 1));
    document.getElementById('next-page').addEventListener('click', () => changePage(currentPage + 1));
    
    // Page number buttons
    document.querySelectorAll('.page-buttons .page-btn[data-page]').forEach(button => {
    button.addEventListener('click', () => {
        const page = Number(button.getAttribute('data-page'));
        changePage(page);
    });
    });
    
    // Country checkboxes
    document.querySelectorAll('.checkbox-item .custom-checkbox[data-id]').forEach(checkbox => {
    checkbox.addEventListener('click', () => {
        const id = Number(checkbox.getAttribute('data-id'));
        if (checkbox.parentElement.closest('fieldset').querySelector('legend').textContent.includes('countries')) {
        toggleCountry(id);
        } else {
        toggleCategory(id);
        }
    });
    });
}

// Initialize the page
function init() {
    setupEventListeners();
    updatePaginationUI();
}

// Start the application when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', init);
