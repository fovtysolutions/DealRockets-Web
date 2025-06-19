// Categories data
const categories = [
    {
        title: "Health & Beauty",
        count: 45346,
        items: [
            { name: "Protective Items", count: 569 },
            { name: "Health & Medical", count: 11411 },
            { name: "Beauty & Personal Care", count: 33366 }
        ]
    },
    {
        title: "Bags, Shoes & Accessories",
        count: 4519,
        items: [
            { name: "Luggage, Bags & Cases", count: 2900 },
            { name: "Shoes & Accessories", count: 1619 }
        ]
    },
    {
        title: "Apparel, Textiles & Accessories",
        count: 14564,
        items: [
            { name: "Apparel", count: 5527 },
            { name: "Textile & Leather Product", count: 4263 },
            { name: "Fashion Accessories", count: 1653 },
            { name: "Timepieces, Jewelry, Eyewear", count: 3121 }
        ]
    },
    {
        title: "Electronics",
        count: 15482,
        items: [
            { name: "Industrial Computer & Accessories", count: 3050 },
            { name: "Home Appliance", count: 5751 },
            { name: "Consumer Electronic", count: 3289 },
            { name: "Security & Protection", count: 3392 }
        ]
    },
    {
        title: "Electronic Equipment, Component & ...",
        count: 10729,
        items: [
            { name: "Electronic Equipment & Supplies", count: 8413 },
            { name: "Telecommunication", count: 2316 }
        ]
    },
    {
        title: "Home, Lights & Construction",
        count: 19591,
        items: [
            { name: "Construction & Real Estate", count: 3338 },
            { name: "Home & Garden", count: 11071 },
            { name: "Lights & Lightning", count: 2551 },
            { name: "Furniture", count: 2631 }
        ]
    },
    {
        title: "Gifts, Sports & Toys",
        count: 8439,
        items: [
            { name: "Gifts & Crafts", count: 2028 },
            { name: "Toys & Hobbies", count: 2081 },
            { name: "Sports & Entertainment", count: 4330 }
        ]
    },
    {
        title: "Agriculture & Food",
        count: 15906,
        items: [
            { name: "Agriculture", count: 3859 },
            { name: "Food & Beverage", count: 12047 }
        ]
    },
    {
        title: "Auto & Transportation",
        count: 4583,
        items: [
            { name: "Automobiles & Motorcycles", count: 3694 },
            { name: "Transportation", count: 889 }
        ]
    },
    {
        title: "Machinery, Industrial Parts & Tools",
        count: 29769,
        items: [
            { name: "Machinery", count: 12982 },
            { name: "Industrial Parts & Fabrication Services", count: 10305 },
            { name: "Tools", count: 2119 },
            { name: "Hardware", count: 1303 },
            { name: "Measurement & Analysis Instruments", count: 3060 }
        ]
    },
    {
        title: "Metallurgy, Chemicals, Rubber & Pla...",
        count: 7082,
        items: [
            { name: "Minerals & Metallurgy", count: 1424 },
            { name: "Chemicals", count: 1446 },
            { name: "Rubber & Plastics", count: 1486 },
            { name: "Energy", count: 531 },
            { name: "Environment", count: 2195 }
        ]
    },
    {
        title: "Packaging, Advertising & Office",
        count: 6182,
        items: [
            { name: "Packaging & Printing", count: 3127 },
            { name: "Office & School Supplies", count: 2495 },
            { name: "Service Equipment", count: 560 }
        ]
    }
];

// Function to format numbers with commas
function formatNumber(num) {
    return num.toLocaleString();
}

// Function to create a category card
function createCategoryCard(category) {
    const card = document.createElement('div');
    card.className = 'category-card';
    
    const itemsHtml = category.items.map(item => `
        <div class="category-item">
            <div class="item-left">
                <i class="fas fa-chevron-right item-icon"></i>
                <span class="item-name">${item.name}</span>
            </div>
            <span class="item-count">${formatNumber(item.count)}</span>
        </div>
    `).join('');
    
    card.innerHTML = `
        <div class="category-header">
            <h3 class="category-title">${category.title}</h3>
            <span class="category-count">${formatNumber(category.count)}</span>
        </div>
        <div class="category-items">
            ${itemsHtml}
        </div>
    `;
    
    return card;
}

// Function to render all categories
function renderCategories() {
    const grid = document.getElementById('categoryGrid');
    
    categories.forEach(category => {
        const card = createCategoryCard(category);
        grid.appendChild(card);
    });
}

// Add click event listeners for category items
function addCategoryItemListeners() {
    const categoryItems = document.querySelectorAll('.category-item');
    
    categoryItems.forEach(item => {
        item.addEventListener('click', function() {
            const itemName = this.querySelector('.item-name').textContent;
            console.log(`Clicked on: ${itemName}`);
            // Add your click handling logic here
        });
    });
}

// Search functionality
function initializeSearch() {
    const searchInput = document.querySelector('.search-input');
    const searchBtn = document.querySelector('.search-btn');
    
    function performSearch() {
        const query = searchInput.value.trim();
        if (query) {
            console.log(`Searching for: ${query}`);
            // Add your search logic here
        }
    }
    
    searchBtn.addEventListener('click', performSearch);
    
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            performSearch();
        }
    });
}

// Initialize the application
document.addEventListener('DOMContentLoaded', function() {
    renderCategories();
    addCategoryItemListeners();
    initializeSearch();
});
