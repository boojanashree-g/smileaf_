<!doctype html>
<html class="no-js" lang="zxx">

<?php require("components/head.php") ?>

<body>
    <!--[if lte IE 9]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
    <![endif]-->

    <!-- Add your site or application content here -->

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
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Order Id</th>
                                                                    <th>Date</th>
                                                                    <th>Status</th>
                                                                    <th>Total</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>#A915AFLE4FO</td>
                                                                    <td>Jun 22, 2019</td>
                                                                    <td><span class="badge bg-warning">Pending</span>
                                                                    </td>
                                                                    <td>₹3000</td>
                                                                    <td><a href="#" class=" btn-sm btn-primary"
                                                                            onclick="openOrderModal(1)">View</a></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>#A915AFLE4FO</td>
                                                                    <td>Nov 22, 2019</td>
                                                                    <td><span class="badge bg-success">Approved</span>
                                                                    </td>
                                                                    <td>₹200</td>
                                                                    <td><a href="#" class="btn-sm btn-primary"
                                                                            onclick="openOrderModal(2)">View</a></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>#A915AFLE4FO</td>
                                                                    <td>Jan 12, 2020</td>
                                                                    <td><span class="badge bg-secondary">On Hold</span>
                                                                    </td>
                                                                    <td>₹990</td>
                                                                    <td><a href="#" class="btn-sm btn-primary"
                                                                            onclick="openOrderModal(3)">View</a></td>
                                                                </tr>
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
                                                            data-bs-toggle="modal" id="add-address">Add
                                                            Address</a></p>

                                                    <div class="row m-0">
                                                        <div class="col-md-12 col-12 p-0 address_wrapper">
                                                            <div class="address_card">
                                                                <h4>Default Address
                                                                    <small class="btn-small"><a href="#"
                                                                            class="btn btn-sm btn-outline-secondary"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#editAddressModal"
                                                                            onclick="loadAddressData('default')">Edit</a></small>
                                                                </h4>
                                                                <address>
                                                                    <p><strong>Alex Tuntuni</strong></p>
                                                                    <p>1355 Market St, Suite 900 <br>
                                                                        San Francisco, CA 94103</p>
                                                                    <p>Mobile: (123) 456-7890</p>
                                                                </address>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="other_address">
                                                        <div class="row m-0">
                                                            <div class="col-md-12 col-12">
                                                                <div class="address_card">
                                                                    <h4>Home Address
                                                                        <small class="btn-small"><a href="#"
                                                                                class="btn btn-sm btn-outline-secondary"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#editAddressModal"
                                                                                onclick="loadAddressData('home')">Edit</a></small>
                                                                        <small class="btn-small delete"><a href="#"
                                                                                class="btn btn-sm btn-outline-danger"
                                                                                onclick="confirmDelete('Home Address')">Delete</a></small>
                                                                    </h4>
                                                                    <address>
                                                                        <p><strong>Alex Tuntuni</strong></p>
                                                                        <p>2847 Lombard Street <br>
                                                                            San Francisco, CA 94123</p>
                                                                        <p>Mobile: (123) 456-7890</p>
                                                                        <div class="form-check mt-2">
                                                                            <input type="radio" name="set_default_home"
                                                                                class="form-check-input"
                                                                                id="default_home">
                                                                            <label class="form-check-label"
                                                                                for="default_home">Set as default
                                                                                address</label>
                                                                        </div>
                                                                    </address>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12 col-12">
                                                                <div class="address_card">
                                                                    <h4>Office Address
                                                                        <small class="btn-small"><a href="#"
                                                                                class="btn btn-sm btn-outline-secondary"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#editAddressModal"
                                                                                onclick="loadAddressData('office')">Edit</a></small>
                                                                        <small class="btn-small delete"><a href="#"
                                                                                class="btn btn-sm btn-outline-danger"
                                                                                onclick="confirmDelete('Office Address')">Delete</a></small>
                                                                    </h4>
                                                                    <address>
                                                                        <p><strong>Alex Tuntuni</strong></p>
                                                                        <p>567 Howard Street, Floor 3 <br>
                                                                            San Francisco, CA 94105</p>
                                                                        <p>Mobile: (123) 456-7890</p>
                                                                        <p>Email: alex@company.com</p>
                                                                        <div class="form-check mt-2">
                                                                            <input type="radio"
                                                                                name="set_default_office"
                                                                                class="form-check-input"
                                                                                id="default_office">
                                                                            <label class="form-check-label"
                                                                                for="default_office">Set as default
                                                                                address</label>
                                                                        </div>
                                                                    </address>
                                                                </div>
                                                            </div>
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
                                                                <button class="theme-btn-1 btn-effect-1 text-uppercase"
                                                                    id="btn-account">Save Changes</button>
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
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addAddressModalLabel">Add New Address</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="addAddressForm">
                                            <div class="row">


                                                <div class="col-12 mb-3">
                                                    <label for="addStreetAddress" class="form-label">Address
                                                        *</label>
                                                    <textarea class="form-control-" id="addStreetAddress" rows="4"
                                                        placeholder="House/Flat No, Street Name, Area"
                                                        required></textarea>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="addState" class="form-label">State *</label>
                                                    <select name="" id="">
                                                        <option value="">r</option>
                                                        <option value="">r</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="addCity" class="form-label">City *</label>
                                                     <select name="" id="">
                                                        <option value="">r</option>
                                                        <option value="">r</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6    mb-3">
                                                    <label for="addZipcode" class="form-label">ZIP Code *</label>
                                                    <input type="text" class="form-control" id="addZipcode" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="addCountry" class="form-label">Country *</label>
                                                    <input type="text" class="form-control" id="addCountry"
                                                        value="United States" required>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="setAsDefault">
                                                        <label class="form-check-label" for="setAsDefault">Set as
                                                            default address</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="theme-btn-1 btn-effect-1 text-uppercase"
                                            onclick="saveAddress()">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Address Modal -->
                        <div class="modal fade slide-from-center" id="editAddressModal" tabindex="-1"
                            aria-labelledby="editAddressModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editAddressModalLabel">Edit Address</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="editAddressForm">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="editFullName" class="form-label">Full Name *</label>
                                                    <input type="text" class="form-control" id="editFullName" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="editPhone" class="form-label">Phone Number *</label>
                                                    <input type="tel" class="form-control" id="editPhone" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="editEmail" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="editEmail">
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label for="editStreetAddress" class="form-label">Street Address
                                                        *</label>
                                                    <textarea class="form-control" id="editStreetAddress" rows="3"
                                                        placeholder="House/Flat No, Street Name, Area"
                                                        required></textarea>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="editCity" class="form-label">City *</label>
                                                    <input type="text" class="form-control" id="editCity" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="editState" class="form-label">State *</label>
                                                    <input type="text" class="form-control" id="editState" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="editZipcode" class="form-label">ZIP Code *</label>
                                                    <input type="text" class="form-control" id="editZipcode" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="editCountry" class="form-label">Country *</label>
                                                    <input type="text" class="form-control" id="editCountry" required>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="theme-btn-1 btn-effect-1 text-uppercase"
                                            onclick="updateAddress()">Update</button>
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
                                        <button type="button" class="btn btn-danger"
                                            onclick="deleteAddress()">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Details Modal -->
                        <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-snow">
                                        <h5 class="modal-title text-charcoal" id="orderModalLabel">Order Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-0">
                                        <div class="container-fluid">
                                            <!-- Order Header -->
                                            <div class="row bg-snow p-3">
                                                <div class="col-6 col-md-3">
                                                    <h6 class="text-charcoal mb-0">Order Number</h6>
                                                    <span class="text-pebble" id="orderNumber">#A915AFLE4FO</span>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <h6 class="text-charcoal mb-0">Date</h6>
                                                    <span class="text-pebble" id="orderDate">Aug 5th, 2017</span>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <h6 class="text-charcoal mb-0">Total</h6>
                                                    <span class="text-pebble" id="orderTotal">$19.54</span>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <h6 class="text-charcoal mb-0">Shipped To</h6>
                                                    <span class="text-pebble" id="shippedTo">Late M. Night</span>
                                                </div>
                                            </div>

                                            <!-- Order Status -->
                                            <div class="row p-3 bg-white">
                                                <div class="col-12 col-md-9">
                                                    <div class="alert alert-success p-2 mb-0" id="statusAlert">
                                                        <h6 class="text-green mb-0"><b id="orderStatus">Shipped</b></h6>
                                                        <p class="text-green mb-0 d-none d-md-block" id="deliveryInfo">
                                                            Est. delivery between Aug 5 – Aug 9th, 2017</p>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-3 mt-2 mt-md-0">
                                                    <button class="" id="trackButton">Track Shipment</button>
                                                </div>
                                            </div>

                                            <!-- Order Items -->
                                            <div class="p-3 bg-white" id="orderItems">
                                                <!-- Items will be populated here -->
                                            </div>
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

    <script src="<?php echo base_url() ?>custom/js/myaccount.js"></script>
    <script src="<?php echo base_url() ?>custom/js/address.js"></script>





    <script>
        $("#btn-logout").click(function (e) {
            e.preventDefault();
            localStorage.clear();
            window.location.href = "<?= base_url('logout') ?>";
        })
    </script>
</body>

</html>