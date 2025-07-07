<!doctype html>
<html class="no-js" lang="zxx">

<?php require("components/head.php") ?>


<body>

    <!-- Body main wrapper start -->
    <div class="body-wrapper">

        <!-- HEADER AREA START (header-5) -->
        <?php require("components/header.php") ?>

        <!-- HEADER AREA END -->

        <!-- WISHLIST AREA START -->
        <div class="liton__wishlist-area pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- PRODUCT TAB AREA START -->
                        <div class="ltn__product-tab-area">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="ltn__tab-menu-list mb-50">
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
                                    <div class="col-lg-8">
                                        <div class="tab-content">
                                            <!-- Orders Tab - Now properly active -->
                                            <div class="tab-pane fade active show" id="liton_tab_1_2">
                                                <div class="ltn__myaccount-tab-content-inner">
                                                    <h3>My Orders</h3>
                                                    <div class="table-responsive">

                                                        <?php
                                                        if (count($summary) <= 0) { ?>
                                                            <p> No Orders Placed</p>
                                                            <a href="<?= base_url() ?>"
                                                                class="btn btn-sm btn-outline-primary">Back to
                                                                Purchase</a>

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
                                                                            'New' => 'bg-primary',
                                                                            'Pending' => 'bg-warning',
                                                                            'Shipped' => 'bg-info',
                                                                            'Delivered' => 'bg-success',
                                                                            'Cancelled' => 'bg-danger',
                                                                            'Refund' => 'bg-muted',
                                                                            'Failed' => 'bg-dark',
                                                                        ];

                                                                        $orderClass = $statusBgClasses[$orderStatus] ?? 'bg-light';


                                                                        // Check if return is valid
                                                                        $canReturn = false;
                                                                        if ($orderStatus === 'Delivered') {

                                                                            $deliveredTime = strtotime($orderDetails['delivered_time']);
                                                                            $now = time();
                                                                            $diffDays = floor(($now - $deliveredTime) / (60 * 60 * 24));

                                                                            if ($diffDays <= 7) {
                                                                                $canReturn = true;
                                                                            }

                                                                        }

                                                                        $dispCancel = false;
                                                                        if ($orderStatus === 'New' || $orderStatus === 'Shipped') {
                                                                            $dispCancel = true;
                                                                        }
                                                                        ?>
                                                                        <tr>
                                                                            <td><?= $orderDetails['order_no'] ?></td>
                                                                            <td><?= $orderDetails['order_date'] ?></td>
                                                                            <td><span
                                                                                    class="badge <?= $orderClass ?>"><?= $orderDetails['order_status'] ?></span>
                                                                            </td>
                                                                            <td>₹<?= $orderDetails['order_total_amt'] ?></td>
                                                                            <td>
                                                                                <a class="btn-sm btn-success view-order"
                                                                                    data-orderid="<?= esc($orderDetails['order_id']) ?>">View</a>
                                                                                <?php if ($canReturn): ?>
                                                                                    &nbsp; &nbsp;
                                                                                    <a class="btn-sm btn-warning returnpolicy"
                                                                                        data-status="<?= esc($orderStatus) ?>"
                                                                                        data-deliverytime="<?= esc($orderDetails['delivered_time']) ?>"
                                                                                        data-orderid="<?= esc($orderDetails['order_id']) ?>">Return</a>


                                                                                <?php endif; ?>

                                                                                <?php if ($dispCancel): ?>
                                                                                    &nbsp; &nbsp;
                                                                                    <a class="btn-sm btn-primary cancel-order"
                                                                                        data-status="<?= esc($orderStatus) ?>"
                                                                                        data-orderid="<?= esc($orderDetails['order_id']) ?>">Cancel</a>
                                                                                <?php endif; ?>
                                                                            </td>

                                                                        </tr>

                                                                    <?php }
                                                        } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Address Tab -->
                                            <div class="tab-pane fade" id="liton_tab_1_4">
                                                <div class="ltn__myaccount-tab-content-inner">
                                                    <h3>My Addresses</h3>
                                                    <p>Here are your addresses. Want to add another? <a href="#"
                                                            class="btn btn-sm btn-outline-primary float-end"
                                                            id="add-address">Add
                                                            Address</a></p>
                                                    <div class="other_address">
                                                        <div class="row m-0">
                                                            <?php
                                                            foreach ($address as $i => $data) { ?>
                                                                <div class="col-md-12 col-12">
                                                                    <div class="address_card">
                                                                        <h4>
                                                                            <small class="btn-small"><a
                                                                                    class="btn btn-sm btn-outline-secondary edit-address"
                                                                                    index="<?php echo $i ?>">Edit</a></small>
                                                                            <small class="btn-small delete"><a
                                                                                    class="btn btn-sm btn-outline-danger address-delete"
                                                                                    index="<?php echo $i ?>">Delete</a></small>
                                                                        </h4>
                                                                        <address>
                                                                            <!-- <p><strong>Alex Tuntuni</strong></p> -->
                                                                            <p><?= $data['address'] ?><br>
                                                                                <?= $data['landmark'] ?>,
                                                                                <?= $data['city'] ?><br>
                                                                                <?= $data['dist_name'] ?>,
                                                                                <?= $data['state_title'] ?><br>
                                                                                <?= $data['pincode'] ?><br>
                                                                            </p>

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


                        <!-- Delete Confirmation Modal -->
                        <div class="modal fade" id="deleteConfirmModal" tabindex="-1"
                            aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete <strong id="deleteAddressName"></strong>?</p>
                                        <p class="text-muted">This action cannot be undone.</p>
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


        // Return Product
        $(".returnpolicy").click(function () {
            let status = $(this).data("status");

            let deliveredTime = new Date($(this).data("deliverytime"));

            const now = new Date();

            const diffDays = (now - deliveredTime) / (1000 * 60 * 60 * 24);

            if (status === "Delivered" && diffDays <= 7) {
                alert("Return process initiated for Order ID: " + $(this).data("orderid"));
            } else {
                alert("Return not allowed for this order.");
            }

        })

    </script>


    <script src="<?php echo base_url() ?>custom/js/myaccount.js"></script>

</body>

</html>