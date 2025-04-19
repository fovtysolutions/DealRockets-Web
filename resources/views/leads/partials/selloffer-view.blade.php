<!-- Bootstrap Modal for Product Details -->
<div class="modal fade" id="productDetailModal" tabindex="-1" aria-labelledby="productDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="height: 40px;">
                <div class="w-100 d-flex justify-content-between">
                    <img src ="/img/Delete.png" alt ="close-btn" class="btn-close mb-1" data-dismiss="modal"
                        aria-label="Close" style="width: 19px; margin-right: 10px;">
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button> --}}
                </div>
            </div>
            <div class="modal-body d-flex flex-column">
              <div class="product-details-col w-100">
                  <table class="table table-bordered">
                      <tr>
                          <td><strong>Rate</strong></td>
                          <td>$100 /Piece</td>
                      </tr>
                      <tr>
                          <td><strong>Size</strong></td>
                          <td>32' Inch</td>
                      </tr>
                      <tr>
                          <td><strong>Type</strong></td>
                          <td>Smart</td>
                      </tr>
                      <tr>
                          <td><strong>Terms</strong></td>
                          <td>Ex Stock</td>
                      </tr>
                      <tr>
                          <td><strong>Payment</strong></td>
                          <td>Ex Stock</td>
                      </tr>
                      <tr>
                          <td><strong>Brand</strong></td>
                          <td>TCL</td>
                      </tr>
                  </table>
              </div>
              <div class="contact-seller-col d-flex flex-row justify-content-between w-100">
                  {{-- <i class="far fa-heart favorite-icon"></i> --}}
                  <div>
                      <div class="seller-name fw-bold">John Doe</div>
                      <div class="mt-0 company-name">Shenzhen Inzok Electron Co.,Ltd</div>
                  </div>
                  <div> <button class="contact-btn view-detail-btn">Contact Seller</button></div>
              </div>
            </div>
        </div>
    </div>
</div>
