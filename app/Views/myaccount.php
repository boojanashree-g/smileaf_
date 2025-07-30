<!doctype html>
<html class="no-js" lang="zxx">

<?php require("components/head.php") ?>

<style>
.status_btn{
    font-size:14px;
    font-weight:500;
    min-width:75px;
}
.bg-warm-coral {
    background-color: #FF7F50 !important;
}
.bg-mustard-yellow {
    background-color: #F1C40F !important;
}
.bg-warm-orange {
    background-color: #F39C12 !important;
}
.bg-warm-olive {
    background-color: #A3CB38 !important;
}
.bg-warm-red {
    background-color: #E74C3C !important;
}
.bg-sandy-beige {
    background-color: #EDBB99 !important;
}
.bg-burnt-umber {
    background-color: #6E2C00 !important;
}
.btn-view-order {
    background-color: #1ABC9C !important;  /* Warm Teal */
    color: white !important;
    border: none;
    cursor: pointer;
}

.btn-return-policy {
    background-color: #D68910 !important;  /* Golden Amber */
    color: white !important;
    border: none;
    cursor: pointer;
}

.btn-cancel-order {
    background-color: #C0392B !important;  /* Rustic Red */
    color: white !important;
    border: none;
    cursor: pointer;
    /* align-items: center;
    display: flex;
    justify-content: center; */
}

.btn-small{
    position: inherit;
    float:right;
    padding:0;
    
}
#loader-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
 background: rgba(255, 255, 255, 1); 
  backdrop-filter: blur(4px);
  z-index: 9999;
  display: flex;
  justify-content: center;
  align-items: center;
}

.loader {
  border: 6px solid #f3f3f362;
  border-top: 6px solid #3498db;
  border-radius: 50%;
  width: 50px;
  height: 50px;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

</style>
<body>

    <!-- Body main wrapper start -->
    <div class="body-wrapper">

        <!-- HEADER AREA START (header-5) -->
        <?php require("components/header.php") ?>

        <!-- HEADER AREA END -->

        <!-- WISHLIST AREA START -->
        <div class="liton__wishlist-area pb-3">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- PRODUCT TAB AREA START -->
                        <div class="ltn__product-tab-area">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 col-lg-4 mb-4">
                                        <div class="ltn__tab-menu-list ">
                                            <div class="nav">
                                                <a class="active show" data-bs-toggle="tab" href="#liton_tab_1_2">Orders
                                                    <i class="fas fa-file-alt"></i></a>
                                                <a data-bs-toggle="tab" href="#liton_tab_1_4">Address <i
                                                        class="fas fa-map-marker-alt"></i></a>
                                                <a data-bs-toggle="tab" href="#liton_tab_1_5">Account Details <i
                                                        class="fas fa-user"></i></a>
                                                <a id="btn-logout">Logout <i class="fas fa-sign-out-alt"></i></a>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="col-12 col-lg-8 col-md-12">
                                        <div class="tab-content">
                                            <!-- Orders Tab - Now properly active -->
                                            <div class="tab-pane fade active show" id="liton_tab_1_2">
                                                <div class="ltn__myaccount-tab-content-inner">
                                                    <!-- <h3>My Orders</h3> -->
                                                    <div class="table-responsive">
                                                        <?php
                                                        if (count($summary) <= 0) { ?>
                                                            <img src="<?php echo base_url() ?>public/assets/img/empty-box-concept.png" width="200" />
                                                            <h3>No Orders Found</h3>
                                                            <a href="<?= base_url()?>"
                                                                class="btn btn-sm btn-outline-primary back_to_purchase"> Back to Purchase</a>

                                                        <?php } else { ?>
                                                            <table class="table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Order Id</th>
                                                                        <th>Order Date</th>
                                                                        <th>Order Status</th>
                                                                        <th>Total</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>


                                                                    <?php foreach ($summary as $orderID => $orderDetails) {
                                                                        $orderStatus = $orderDetails['order_status'];

                                                                        $statusBgClasses = [
                                                                            'Initiated' => 'bg-secondary', 
                                                                            'New'       => 'bg-warm-coral',   
                                                                            'Pending'   => 'bg-mustard-yellow', 
                                                                            'Shipped'   => 'bg-warm-orange', 
                                                                            'Readytoship'   => 'bg-warm-orange',       
                                                                            'Delivered' => 'bg-warm-olive', 
                                                                            'Cancelled' => 'bg-warm-red',        
                                                                            'Refund'    => 'bg-sandy-beige',
                                                                            'Failed'    => 'bg-burnt-umber',
                                                                            'Returned'   =>'bg-warm-red',
                                                                        ];                                                          


                                                                        $orderClass = $statusBgClasses[$orderStatus] ?? 'bg-light';


                                                                        // Check if return is valid
                                                                        $returnStatus = false;
                                                                        if ($orderStatus === 'Delivered' && $orderDetails['is_returned'] != 1) {

                                                                            $deliveredTime = strtotime($orderDetails['delivered_time']);
                                                                            $now = time();
                                                                            $diffDays = floor(($now - $deliveredTime) / (60 * 60 * 24));

                                                                            if ($diffDays <= 7) {
                                                                                $returnStatus = true;
                                                                                $returnText = $orderDetails['is_returned'] == 1 ? 'Return Requested' : 'Return';
  
                                                                            }
                                                                        }

                                                                        $dispCancel = false;
                                                                        if ($orderStatus === 'New' || $orderStatus === 'Readytoship') {
                                                                            $dispCancel = true;
                                                                        }
                                                                        ?>
                                                                        <tr>
                                                                            <td><?= $orderDetails['order_no'] ?></td>
                                                                            <td><?= $orderDetails['order_date'] ?></td>
                                                                            <td><span
                                                                                    class="badge <?= $orderClass ?> status_btn"><?= $orderDetails['order_status'] ?></span>
                                                                            </td>
                                                                            <td>₹<?= number_format((float)$orderDetails['order_total_amt'], 2)?></td>
                                                                            <td class="action_btn">
                                                                                <a class="btn-sm btn-view-order view-order"
                                                                                data-orderid="<?= esc($orderDetails['order_id']) ?>" title="View Order"><i class='far fa-eye' style='font-size:14px;'></i></a>

                                                                                <?php if ($returnStatus): ?>
                                                                                    &nbsp;&nbsp;
                                                                                    <a class="btn-sm btn-return-policy returnproduct"
                                                                                    data-status="<?= esc($orderStatus) ?>"
                                                                                    data-deliverytime="<?= esc($orderDetails['delivered_time']) ?>"
                                                                                    data-orderid="<?= esc($orderDetails['order_id']) ?>"><?= $returnText?></a>
                                                                                <?php endif; ?>

                                                                                <?php if ($dispCancel): ?>
                                                                                    &nbsp;&nbsp;
                                                                                    <a class="btn-sm btn-cancel-order cancel-order" title="Cancel Order"
                                                                                    data-status="<?= esc($orderStatus) ?>"
                                                                                    data-orderid="<?= esc($orderDetails['order_id']) ?>"><i class='far fa-times-circle'  style='font-size:16px !important;'></i></a>
                                                                                <?php endif; ?>
                                                                            </td>
                                                                        </tr>

                                                                    <?php 
                                                                            }
                                                                        } 
                                                                    ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Address Tab -->
                                            <div class="tab-pane fade" id="liton_tab_1_4">
                                                <div class="ltn__myaccount-tab-content-inner">
                                                    <h3>My Addresses</h3>
                                                    <p class="add-address-tab">Here are your addresses. Want to add another? 
                                                        <a href="#" class="btn btn-sm btn-outline-primary float-end" id="add-address">
                                                            <i class="fas fa-plus d-inline d-sm-none"></i>
                                                            <span class="d-none d-sm-inline">Add Address</span>
                                                        </a>
                                                    </p>
                                                    <div class="other_address">
                                                        <div class="row m-0">
                                                            <?php
                                                            foreach ($address as $i => $data) { ?>
                                                                <div class="col-md-12 col-12 p-0">
                                                                    <div class="address_card mb-0">
                                                                        <h4>
                                                                            <small class="btn-small ">
                                                                                <a class="btn btn-sm btn-outline-secondary edit-address" index="<?= $i ?>">
                                                                                    <i class="fas fa-edit d-inline d-sm-none"></i> <!-- Icon for mobile -->
                                                                                    <span class="d-none d-sm-inline">Edit</span>   <!-- Text for tablet & up -->
                                                                                </a>
                                                                            </small>
                                                                            <small class="btn-small delete me-2">
                                                                                <a class="btn btn-sm btn-outline-danger address-delete" index="<?= $i ?>">
                                                                                    <i class="fas fa-trash-alt d-inline d-sm-none"></i> <!-- Icon for mobile -->
                                                                                    <span class="d-none d-sm-inline">Delete</span>       <!-- Text for tablet & up -->
                                                                                </a>
                                                                            </small>

                                                                        </h4>
                                                                        <address>
                                                                            <div class="form-check mt-2">
                                                                                <input type="radio" name="set_default_home"
                                                                                    class="form-check-input default_address"
                                                                                    id="default_home"
                                                                                    data-addid="<?= $data['add_id'] ?>"
                                                                                    <?php $default = $data['default_addr'];
                                                                                    echo $default == 1 ? "checked" : "" ?>>
                                                                                <label class="form-check-label"
                                                                                    for="default_home">Default
                                                                                    address</label>
                                                                            </div>
                                                                            <!-- <p><strong>Alex Tuntuni</strong></p> -->
                                                                            <p style="padding: 8px 25px; margin-botton:0"><?= $data['address'] ?><br>
                                                                                <?= $data['landmark'] ?>,
                                                                                <?= $data['city'] ?><br>
                                                                                <?= $data['dist_name'] ?>,
                                                                                <?= $data['state_title'] ?><br>
                                                                                <?= $data['pincode'] ?><br>
                                                                            </p>

                                                                            
                                                                        </address>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Account Details Tab -->
                                            <div class="tab-pane fade" id="liton_tab_1_5">
                                                <div class="ltn__myaccount-tab-content-inner">
                                                    <h3>Account Details</h3>
                                                    <p>The following information will be used on the checkout page by
                                                        default.</p>
                                                    <div class="ltn__form-box">
                                                        <form id="account-form">
                                                            <div class="row mb-4">
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label">Name:</label>
                                                                    <input type="text" name="username"
                                                                        class="form-control"
                                                                        value="<?= $userData[0]['username'] ?>">
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label">Mobile:</label>
                                                                    <input type="text" name="number"
                                                                        class="form-control"
                                                                        value="<?= $userData[0]['number'] ?>">
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label"> Email:</label>
                                                                    <input type="email" name="email"
                                                                        class="form-control"
                                                                        value="<?= $userData[0]['email'] ?>">
                                                                </div>
                                                            </div>
                                                            <div class="btn-wrapper">
                                                                <button
                                                                    class="theme-btn-1 btn-effect-1 text-uppercase btn-account">Save
                                                                    Changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="loader-overlay" style="display: none;">
                                <div class="loader"></div>
                        </div>

                        <!-- PRODUCT TAB AREA END -->
                        <!-- Add Address Modal -->
                        <div class="modal fade slide-from-center" id="addAddressModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title address-title">Add New Address</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="addAddressForm">
                                            <div class="row">


                                                <div class="col-12 mb-3">
                                                    <label for="address" class="form-label">Address
                                                        *</label>
                                                    <textarea class="form-control-" id="address" name="address" rows="4"
                                                        placeholder="House/Flat No, Street Name, Area"
                                                        required></textarea>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="addState" class="form-label">State *</label>
                                                    <select class="select-dropdown" name="state_id" id="state_id">
                                                        <option value="">Select State</option>
                                                        <?php for ($i = 0; $i < count($state); $i++) { ?>

                                                            <option value="<?php echo $state[$i]['state_id'] ?>">
                                                                <?php echo $state[$i]['state_title'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="dist_id" class="form-label">District</label>
                                                    <select class="select-dropdown" id="dist_id" name="dist_id">
                                                        <!-- code -->
                                                    </select>
                                                </div>

                                                <div class="col-md-6    mb-3">
                                                    <label for="landmark" class="form-label">Landmark *</label>
                                                    <input type="text" class="form-control" id="landmark"
                                                        name="landmark" placeholder="Landmark" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="addcityCountry" class="form-label">Town/City *</label>
                                                    <input type="text" class="form-control" id="city" name="city"
                                                        placeholder="Town/City" required>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="pincode" class="form-label">Pincode *</label>
                                                    <input type="text" class="form-control" id="pincode" name="pincode"
                                                        placeholder="Pincode" required>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="default_addr" name="default_addr">
                                                        <label class="form-check-label" for="default_addr">Set as
                                                            default address</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="button"
                                            class="theme-btn-1 btn-effect-1 text-uppercase address-save"
                                            id="btn_save">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title" id="deleteConfirmModalLabel" style="color:#fff;">Confirm Deletion</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="mb-0">Are you sure you want to delete this address? This action cannot be undone.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-danger btndelete">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Details Modal -->
                        <div class="modal fade orderModal" id="orderModal" tabindex="-1"
                            aria-labelledby="orderModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <!-- Widened for better alignment -->
                                <div class="modal-content">
                                    <div class="modal-header bg-snow">
                                        <h5 class="modal-title text-charcoal" id="orderModalLabel">Order Details</h5>
                                        <button type="button" class="btn-close" onclick="ModalClose()" data-bs-dismi
                                            ss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body p-0" id="dynamic-order">
                                        <!-- Dynamic rendering -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cancel order Modal -->
                        <!-- First Modal: Confirm Cancel -->
                        <div class="modal fade" id="cancel-modal" tabindex="-1"
                            aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Confirm Cancel Order</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to cancel? <strong id="deleteAddressName"></strong></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <!-- Trigger inner modal -->
                                        <button type="button" class="btn btn-danger btndelete"
                                            id="confirmCancelBtn">Yes</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Second Modal: Reason for Cancel -->
                        <div class="modal fade" id="reason-modal" tabindex="-1" aria-labelledby="reasonModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Cancel Reason</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <textarea class="form-control" id="cancelReason" rows="4"
                                            placeholder="Enter reason for cancellation..."></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-danger"
                                            id="submitCancelReason">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                         <!-- Order Details Modal -->
                        <div class="modal fade return_product_modal" id="return_product_modal" tabindex="-1"
                            aria-labelledby="orderModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                              
                                <div class="modal-content">
                                    <div class="modal-header bg-snow">
                                        <h5 class="modal-title text-charcoal" id="orderModalLabel">Order Details</h5>
                                        <button type="button" class="btn-close" onclick="returnModalClose()" data-bs-dismi
                                            ss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body p-3" id="return-products">
                                       <p id="return-orderno"></p>
                                        
                                        <!-- Dynamic Render -->

                                    </div>
                                </div>
                            </div>
                        </div>
                        

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- WISHLIST AREA START -->

    <!-- FOOTER AREA START -->
    <?php require("components/footer.php") ?>
    <!-- FOOTER AREA END -->
    </div>
    <!-- Body main wrapper end -->

    <!-- All JS Plugins -->
    <script src="<?php echo base_url() ?>public/assets/js/plugins.js"></script>
    <!-- Main JS -->
    <script src="<?php echo base_url() ?>public/assets/js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url() ?>custom/js/address.js"></script>

    <script>
        $(document).ready(function () {
            $('#state_id, #dist_id').show();
            $('.nice-select').remove();

            // Logout button functionality
            $('#btn-logout').on('click', function (e) {
                e.preventDefault();
                localStorage.clear();
                window.location.href = "<?= base_url('logout') ?>";
            });
        });

        function ModalClose() {
            $('.orderModal').modal('hide');
        }
        function returnModalClose() {
            $('.return_product_modal').modal('hide');
        }

     </script>


    <script src="<?php echo base_url() ?>custom/js/myaccount.js"></script>

</body>

</html>