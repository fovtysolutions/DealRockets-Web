let currentView = "grid";
const prodList = document.getElementById("prod-list");
const prodGrid = document.getElementById("prod-grid");
prodList.onclick = function () {
    document.getElementById("productGrid").style.display = "none";
    document.getElementById("productList").style.display = "block";
    currentView = "list";
    renderProducts();
};
prodGrid.onclick = function () {
    document.getElementById("productGrid").style.display = "grid";
    document.getElementById("productList").style.display = "none";
    currentView = "grid";
    renderProducts();
};

const filterButton = document.querySelector(".btn.btn-outline-light");
        const filterModal = document.getElementById("filterModal");
      
        filterButton.addEventListener("click", () => {
          filterModal.classList.remove("d-none");
        });
      
        // Optional: Close modal on clicking outside
        filterModal.addEventListener("click", (e) => {
          if (e.target === filterModal) {
            filterModal.classList.add("d-none");
          }
        });


        const products = [
            {
                id: "1",
                imageUrl: "https://cdn.builder.io/api/v1/image/assets/TEMP/f2046ae6215153d7b0d703e1c918fbb102aaa9c7",
                title: "Wholesale Auto tracking CCTV cameras Full Hd Video Life 3mp Baby Monitor Recorder Smart Home Security Camera",
                price: "US$ 2.30 / Piece",
                moq: "400 Piece (MOQ)",
                seller: "Market Union Co.Ltd",
                exhibition: "Exhibited at 2 GS shows",
                rating: 4.9,
                isNew: true
            },
            {
                id: "2",
                imageUrl: "https://cdn.builder.io/api/v1/image/assets/TEMP/f87398fa30b71b3c016f8ff701371eb5985814a4",
                title: "Wholesale High quality Mini camera 4G Low Power 1080P HD Wireless cameras Micro 2600mAh Battery Support Full Netcom 4G mini camera",
                price: "US$ 25.00 - 29.00 / Piece",
                moq: "10 Piece (MOQ)",
                seller: "Wenzhou Ivspeed Co.,Ltd",
                exhibition: "Exhibited at 2 GS shows",
                rating: 4.8
            },
            {
                id: "3",
                imageUrl: "https://cdn.builder.io/api/v1/image/assets/TEMP/fc803b4dcacfd9f48717af05e42325c81d6dba88",
                title: "Wireless camera,Mobile phone remote home wifi 360 degree bulb wireless camera",
                price: "US$ 8.60 - 8.80 / Unit",
                moq: "1000 Piece (MOQ)",
                seller: "Good Seller Co., Ltd (2)",
                exhibition: "Exhibited at 2 GS shows",
                rating: 4.9
            },
            {
                id: "4",
                imageUrl: "https://cdn.builder.io/api/v1/image/assets/TEMP/50e105e7535580eae6c883c0f3bdf4c70c0b5eb0",
                title: "3 million bulb type surveillance camera home wireless WiFi HD 360 panoramic rotating 4G monitor",
                price: "US$ 11.00 - 12.38 / Piece",
                moq: "100 Piece (MOQ)",
                seller: "Good Seller Co., Ltd",
                exhibition: "Exhibited at 2 GS shows",
                rating: 4.5
            },
            {
                id: "5",
                imageUrl: "https://cdn.builder.io/api/v1/image/assets/TEMP/a759d20d20bfe11adcdae73393ecec83ea6cb5e1",
                title: "Wholesale Auto tracking CCT V cameras Full Hd Video Life 3mp Baby Monitor Recorder Smart Home Security Camera",
                price: "US$ 2.30 / Piece",
                moq: "400 Piece (MOQ)",
                seller: "Market Union Co.Ltd",
                exhibition: "Exhibited at 2 GS shows",
                rating: 4.5
            },
            {
                id: "6",
                imageUrl: "https://cdn.builder.io/api/v1/image/assets/TEMP/efedb795e677629b46ee3285210d7e1d2d7dc8ca",
                title: "Wholesale High quality Mini camera 4G Low Power 1080P HD Wireless cameras Micro 2600mAh Battery Support Full Netcom 4G mini camera",
                price: "US$ 25.00 - 29.00 / Piece",
                moq: "10 Piece (MOQ)",
                seller: "Wenzhou Ivspeed Co.,Ltd",
                exhibition: "Exhibited at 2 GS shows",
                rating: 4.2
            },
            {
                id: "7",
                imageUrl: "https://cdn.builder.io/api/v1/image/assets/TEMP/62a776481d3ea02584561dcb1d730f88c5871392",
                title: "Wireless camera,Mobile phone remote home wifi 360 degree bulb wireless camera",
                price: "US$ 8.60 - 8.80 / Unit",
                moq: "1000 Piece (MOQ)",
                seller: "Good Seller Co., Ltd (2)",
                exhibition: "Exhibited at 2 GS shows"
            },
            {
                id: "8",
                imageUrl: "https://cdn.builder.io/api/v1/image/assets/TEMP/e689e9dd0b8292a782c1098107323a33f947a771",
                title: "Wholesale Auto tracking CCTV cameras Full Hd Video Life 3mp Baby Monitor Recorder Smart Home Security Camera",
                price: "US$ 2.30 / Piece",
                moq: "400 Piece (MOQ)",
                seller: "Market Union Co.Ltd",
                exhibition: "Exhibited at 2 GS shows"
            }
        ];
        
        function createProductCard(product) {
            return `
                <div class="product-card">
                    <div class="heart-image">    
                        <div class="circle-container">
                            <img src="/img/Heart (1).png" alt="heart-image">
                        </div>
                    </div>
                    <img src="${product.imageUrl}" alt="${product.title}" class="product-image">
                    <div class="product-info">
                    <div class="d-flex justify-content-between">
                     <p class="new">New</p>
                      ${product.rating ? `
                            <div class="rating">
                                <span style="font-size: 12px;"><i class="bi bi-star-fill start-rating text-warning"></i> </i> ${product.rating.toFixed(1)}/5</span>
                            </div>
                        ` : ''}
                
                     </span>
                    </div>
                        <h3 class="product-title">${product.title}</h3>
                        <div class="product-price">${product.price}</div>
                        <div class="product-moq">${product.moq}</div>
                        <div class="product-seller">${product.seller}</div>
                        <div class="product-exhibition">${product.exhibition}</div>
                        <div class="product-diamond">
                        <img scr="C:\ Users\ abc\ Downloads\ marketplace subcategory\ New folder\ diamond.png" alt="dimaond" class="dimond-img"> 
                        </div>
                       <div>
                       
                        <button class="start-order-btn">Start order</button>
                       </div>
                       
                    </div>
                </div>
            `;
        }
        function createProductCardlist(product) {
            return `
            <div class="product-card1">
                <div class="imagebox col-3">                
                    <div class="heart-image">    
                        <div class="circle-container">
                            <img src="/img/Heart (1).png" alt="heart-image">
                        </div>
                    </div>
                    <img src="${product.imageUrl}" alt="${product.title}" class="product-image1">
                </div>
                <div class="product-info1 col-6">
                <div class="d-flex justify-content-between">
                 <p class="new">New</p>
                  ${product.rating ? `
                        <div class="rating">
                            <span style="font-size: 12px;"><i class="bi bi-star-fill start-rating text-warning"></i> </i> ${product.rating.toFixed(1)}/5</span>
                        </div>
                    ` : ''}
            
                 </span>
                </div>
                    <h3 class="product-title product-title1">${product.title}</h3>
                    <div class="product-price product-price1" style="font-size:12px !important">${product.price}</div>
                    <div class="product-moq product-moq1">${product.moq}</div>
                    <div class="product-seller product-seller1">${product.seller}</div>
                    <div class="product-exhibition product-exhibition1">${product.exhibition}</div>
                  
                   
                </div>
                <div class="col-3">
                  <div class="product-diamond">
                       <img scr="New folder/diamond.png" alt="dimaond" class="dimond-img"> 
                    </div>
                   <div>
                      <button class="start-order-btn" style="padding: 5px 6px !important; ">Start order</button>
                   </div>
                </div>
            </div>
        `;
        }
        function createaddCard(product) {
            return `
                <div class="product-card  double " style ="grid-column: span 2;">
                    <img src="${product.imageUrl}" alt="${product.title}" class="product-image" style=height:auto !important; >
                </div>
            `;
        }
        function renderProducts() {
            const productGrid = document.getElementById('productGrid');
            const productList = document.getElementById('productList');
        
            productGrid.innerHTML = "";
            productList.innerHTML = "";
        
            products.forEach((product, index) => {
                if (currentView === "grid") {
                    if (index < 6) {
                        productGrid.innerHTML += createProductCard(product);
                    } else if (index === 6) {
                        productGrid.innerHTML += createaddCard(product);
                    } else {
                        productGrid.innerHTML += createProductCard(product);
                    }
                } else if (currentView === "list") {
                    if (index < 6) {
                        productList.innerHTML += createProductCardlist(product);
                    } else if (index === 6) {
                        productList.innerHTML += createaddCard(product);
                    } else {
                        productList.innerHTML += createProductCardlist(product);
                    }
                }
            });
        }
        
        // Initialize the page
        document.addEventListener('DOMContentLoaded', () => {
            renderProducts();
        
            // Add event listeners for pagination
            document.querySelectorAll('.page-numbers button').forEach(button => {
                button.addEventListener('click', (e) => {
                    document.querySelector('.page-numbers button.active').classList.remove('active');
                    e.target.classList.add('active');
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            });
        });
        