// DOM Elements
const searchInput = document.getElementById('searchInput');
const clearSearchBtn = document.querySelector('.clear-search');
const categoryBtns = document.querySelectorAll('.category-btn');
const faqItems = document.querySelectorAll('.faq-item');
const faqCategories = document.querySelectorAll('.faq-category');

// State
let activeCategory = 'all';
let searchQuery = '';

// Initialize FAQ
function initFAQ() {
    // Add event listeners
    addEventListeners();
    
    // Show all items initially
    filterItems();
}

// Add Event Listeners
function addEventListeners() {
    // FAQ item click
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        question.addEventListener('click', () => {
            toggleFAQ(item);
        });
    });
    
    // Search input
    searchInput.addEventListener('input', (e) => {
        searchQuery = e.target.value.toLowerCase();
        clearSearchBtn.classList.toggle('visible', searchQuery.length > 0);
        filterItems();
    });
    
    // Clear search
    clearSearchBtn.addEventListener('click', () => {
        searchInput.value = '';
        searchQuery = '';
        clearSearchBtn.classList.remove('visible');
        filterItems();
    });
    
    // Category buttons
    categoryBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Update active category
            categoryBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            activeCategory = btn.dataset.category;
            
            // Filter items
            filterItems();
        });
    });
}

// Toggle FAQ Item
function toggleFAQ(item) {
    const isActive = item.classList.contains('active');
    
    // Close all items
    faqItems.forEach(faqItem => {
        faqItem.classList.remove('active');
    });
    
    // Open clicked item if it wasn't active
    if (!isActive) {
        item.classList.add('active');
    }
}

// Filter Items
function filterItems() {
    faqItems.forEach(item => {
        const category = item.closest('.faq-category').dataset.category;
        const question = item.querySelector('h3').textContent.toLowerCase();
        const answer = item.querySelector('p').textContent.toLowerCase();
        
        // Check if item matches search query
        const matchesSearch = searchQuery === '' || 
            question.includes(searchQuery) || 
            answer.includes(searchQuery);
        
        // Check if item matches category
        const matchesCategory = activeCategory === 'all' || 
            category === activeCategory;
        
        // Show/hide item
        if (matchesSearch && matchesCategory) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
    
    // Show/hide categories
    faqCategories.forEach(category => {
        const hasVisibleItems = Array.from(category.querySelectorAll('.faq-item'))
            .some(item => item.style.display !== 'none');
        
        category.style.display = hasVisibleItems ? '' : 'none';
    });
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', initFAQ); 