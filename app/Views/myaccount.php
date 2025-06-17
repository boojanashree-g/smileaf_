<!doctype html>
<html class="no-js" lang="zxx">

<?php require("components/head.php")?>

<body>
    <!--[if lte IE 9]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
    <![endif]-->

    <!-- Add your site or application content here -->

<!-- Body main wrapper start -->
<div class="body-wrapper">

    <!-- HEADER AREA START (header-5) -->
   <?php require("components/header.php")?>

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
                                            <a class="active show" data-bs-toggle="tab" href="#liton_tab_1_2">Orders <i class="fas fa-file-alt"></i></a>
                                            <a data-bs-toggle="tab" href="#liton_tab_1_4">Address <i class="fas fa-map-marker-alt"></i></a>
                                            <a data-bs-toggle="tab" href="#liton_tab_1_5">Account Details <i class="fas fa-user"></i></a>
                                            <a href="#" onclick="alert('Logout functionality would go here')">Logout <i class="fas fa-sign-out-alt"></i></a>
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
                                                                <td><span class="badge bg-warning">Pending</span></td>
                                                                <td>₹3000</td>
                                                                <td><a href="#" class=" btn-sm btn-primary" onclick="openOrderModal(1)">View</a></td>
                                                            </tr>
                                                            <tr>
                                                                <td>#A915AFLE4FO</td>
                                                                <td>Nov 22, 2019</td>
                                                                <td><span class="badge bg-success">Approved</span></td>
                                                                <td>₹200</td>
                                                                <td><a href="#" class="btn-sm btn-primary" onclick="openOrderModal(2)">View</a></td>
                                                            </tr>
                                                            <tr>
                                                                <td>#A915AFLE4FO</td>
                                                                <td>Jan 12, 2020</td>
                                                                <td><span class="badge bg-secondary">On Hold</span></td>
                                                                <td>₹990</td>
                                                                <td><a href="#" class="btn-sm btn-primary" onclick="openOrderModal(3)">View</a></td>
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
                                                <p>Here are your addresses. Want to add another? <a href="#" class="btn btn-sm btn-outline-primary float-end" data-bs-toggle="modal" data-bs-target="#addAddressModal">Add Address</a></p>
                                                
                                                <div class="row m-0">
                                                    <div class="col-md-12 col-12 p-0 address_wrapper">
                                                        <div class="address_card">
                                                            <h4>Default Address 
                                                                <small class="btn-small"><a href="#" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editAddressModal" onclick="loadAddressData('default')">Edit</a></small>
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
                                                                    <small class="btn-small"><a href="#" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editAddressModal" onclick="loadAddressData('home')">Edit</a></small> 
                                                                    <small class="btn-small delete"><a href="#" class="btn btn-sm btn-outline-danger" onclick="confirmDelete('Home Address')">Delete</a></small>
                                                                </h4>
                                                                <address>
                                                                    <p><strong>Alex Tuntuni</strong></p>
                                                                    <p>2847 Lombard Street <br>
                                                                        San Francisco, CA 94123</p>
                                                                    <p>Mobile: (123) 456-7890</p>
                                                                    <div class="form-check mt-2">
                                                                        <input type="radio" name="set_default_home" class="form-check-input" id="default_home">
                                                                        <label class="form-check-label" for="default_home">Set as default address</label>
                                                                    </div>
                                                                </address>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 col-12">
                                                            <div class="address_card">
                                                                <h4>Office Address 
                                                                    <small class="btn-small"><a href="#" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editAddressModal" onclick="loadAddressData('office')">Edit</a></small> 
                                                                    <small class="btn-small delete"><a href="#" class="btn btn-sm btn-outline-danger" onclick="confirmDelete('Office Address')">Delete</a></small>
                                                                </h4>
                                                                <address>
                                                                    <p><strong>Alex Tuntuni</strong></p>
                                                                    <p>567 Howard Street, Floor 3 <br>
                                                                        San Francisco, CA 94105</p>
                                                                    <p>Mobile: (123) 456-7890</p>
                                                                    <p>Email: alex@company.com</p>
                                                                    <div class="form-check mt-2">
                                                                        <input type="radio" name="set_default_office" class="form-check-input" id="default_office">
                                                                        <label class="form-check-label" for="default_office">Set as default address</label>
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
                                                <p>The following information will be used on the checkout page by default.</p>
                                                <div class="ltn__form-box">
                                                    <form action="#">
                                                        <div class="row mb-4">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Name:</label>
                                                                <input type="text" name="name" class="form-control">
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Mobile:</label>
                                                                <input type="text" name="mobile" class="form-control">
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label"> Email:</label>
                                                                <input type="email" name="display_email" class="form-control" placeholder="example@example.com">
                                                            </div>
                                                        </div>
                                                        <div class="btn-wrapper">
                                                            <button type="submit" class="theme-btn-1 btn-effect-1 text-uppercase">Save Changes</button>
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
                    <div class="modal fade slide-from-center" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addAddressModalLabel">Add New Address</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="addAddressForm">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="addFullName" class="form-label">Full Name *</label>
                                                <input type="text" class="form-control" id="addFullName" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="addPhone" class="form-label">Phone Number *</label>
                                                <input type="tel" class="form-control" id="addPhone" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="addEmail" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="addEmail">
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label for="addStreetAddress" class="form-label">Street Address *</label>
                                                <textarea class="form-control" id="addStreetAddress" rows="3" placeholder="House/Flat No, Street Name, Area" required></textarea>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="addCity" class="form-label">City *</label>
                                                <input type="text" class="form-control" id="addCity" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="addState" class="form-label">State *</label>
                                                <input type="text" class="form-control" id="addState" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="addZipcode" class="form-label">ZIP Code *</label>
                                                <input type="text" class="form-control" id="addZipcode" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="addCountry" class="form-label">Country *</label>
                                                <input type="text" class="form-control" id="addCountry" value="United States" required>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="setAsDefault">
                                                    <label class="form-check-label" for="setAsDefault">Set as default address</label>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="theme-btn-1 btn-effect-1 text-uppercase" onclick="saveAddress()">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Address Modal -->
                    <div class="modal fade slide-from-center"  id="editAddressModal" tabindex="-1" aria-labelledby="editAddressModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editAddressModalLabel">Edit Address</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                                <label for="editStreetAddress" class="form-label">Street Address *</label>
                                                <textarea class="form-control" id="editStreetAddress" rows="3" placeholder="House/Flat No, Street Name, Area" required></textarea>
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
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="theme-btn-1 btn-effect-1 text-uppercase" onclick="updateAddress()">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Confirmation Modal -->
                    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Delete</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete <strong id="deleteAddressName"></strong>?</p>
                                    <p class="text-muted">This action cannot be undone.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-danger" onclick="deleteAddress()">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>

                     <!-- Order Details Modal -->
                    <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-snow">
                                    <h5 class="modal-title text-charcoal" id="orderModalLabel">Order Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                                    <p class="text-green mb-0 d-none d-md-block" id="deliveryInfo">Est. delivery between Aug 5 – Aug 9th, 2017</p>
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
    <script src="<?php echo base_url()?>public/assets/js/plugins.js"></script>
    <!-- Main JS -->
    <script src="<?php echo base_url()?>public/assets/js/main.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

  <script>
      const addressData = {
            default: {
                fullName: 'Alex Tuntuni',
                phone: '(123) 456-7890',
                email: '',
                addressType: 'home',
                streetAddress: '1355 Market St, Suite 900',
                city: 'San Francisco',
                state: 'CA',
                zipcode: '94103',
                country: 'United States'
            },
            home: {
                fullName: 'Alex Tuntuni',
                phone: '(123) 456-7890',
                email: '',
                addressType: 'home',
                streetAddress: '2847 Lombard Street',
                city: 'San Francisco',
                state: 'CA',
                zipcode: '94123',
                country: 'United States'
            },
            office: {
                fullName: 'Alex Tuntuni',
                phone: '(123) 456-7890',
                email: 'alex@company.com',
                addressType: 'office',
                streetAddress: '567 Howard Street, Floor 3',
                city: 'San Francisco',
                state: 'CA',
                zipcode: '94105',
                country: 'United States'
            }
        };

        let currentAddressType = '';

        // Load address data into edit modal
        function loadAddressData(type) {
            currentAddressType = type;
            const data = addressData[type];
            
            document.getElementById('editFullName').value = data.fullName;
            document.getElementById('editPhone').value = data.phone;
            document.getElementById('editEmail').value = data.email;
            document.getElementById('editAddressType').value = data.addressType;
            document.getElementById('editStreetAddress').value = data.streetAddress;
            document.getElementById('editCity').value = data.city;
            document.getElementById('editState').value = data.state;
            document.getElementById('editZipcode').value = data.zipcode;
            document.getElementById('editCountry').value = data.country;
        }

        // Save new address
        function saveAddress() {
            const form = document.getElementById('addAddressForm');
            if (form.checkValidity()) {
                // Here you would normally send data to server
                alert('Address saved successfully!');
                
                // Reset form and close modal
                form.reset();
                const modal = bootstrap.Modal.getInstance(document.getElementById('addAddressModal'));
                modal.hide();
            } else {
                form.reportValidity();
            }
        }

        // Update existing address
        function updateAddress() {
            const form = document.getElementById('editAddressForm');
            if (form.checkValidity()) {
                // Here you would normally send data to server
                alert('Address updated successfully!');
                
                const modal = bootstrap.Modal.getInstance(document.getElementById('editAddressModal'));
                modal.hide();
            } else {
                form.reportValidity();
            }
        }

        // Show delete confirmation
        function confirmDelete(addressName) {
            document.getElementById('deleteAddressName').textContent = addressName;
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            deleteModal.show();
        }

        // Delete address
        function deleteAddress() {
            // Here you would normally send delete request to server
            alert('Address deleted successfully!');
            
            const modal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal'));
            modal.hide();
        }

         const orderData = {
            1: {
                orderNumber: '#ORD001',
                date: 'Jun 22, 2019',
                total: '₹3000',
                shippedTo: 'John Doe',
                status: 'Pending',
                statusClass: 'alert-warning',
                statusTextClass: 'text-warning',
                deliveryInfo: 'Processing your order',
                trackButton: 'Track Order',
                items: [
                    {
                        image: '<?php echo base_url(); ?>public/assets/img/plate_img/combo-pack/square25.jpg',
                        name: '1 x Areca leaf glasses',
                        color: 'Silver',
                        size: '15 inch',
                        price: '₹2500'
                    },
                    {
                        image: '<?php echo base_url(); ?>public/assets/img/plate_img/combo-pack/square25.jpg',
                        name: '1 x  Areca leaf bowls',
                        size: 'Standard',
                        price: '₹500'
                    }
                ]
            },
            2: {
                orderNumber: '#ORD002',
                date: 'Nov 22, 2019',
                total: '₹200',
                shippedTo: 'Jane Smith',
                status: 'Approved',
                statusClass: 'alert-info',
                statusTextClass: 'text-info',
                deliveryInfo: 'Ready for shipment',
                trackButton: 'Track Order',
                items: [
                    {
                        image: '<?php echo base_url(); ?>public/assets/img/plate_img/combo-pack/square25.jpg',
                        name: '1 x Areca leaf plates',
                        size: 'One Size',
                        price: '₹200'
                    }
                ]
            },
            3: {
                orderNumber: '#ORD003',
                date: 'Jan 12, 2020',
                total: '₹990',
                shippedTo: 'Mike Johnson',
                status: 'On Hold',
                statusClass: 'alert-secondary',
                statusTextClass: 'text-secondary',
                deliveryInfo: 'Order temporarily on hold',
                trackButton: 'Track Order',
                items: [
                    {
                        image: '<?php echo base_url(); ?>public/assets/img/plate_img/combo-pack/square25.jpg',
                        name: '10" Square plates',
                        size: '42mm',
                        price: '₹990'
                    }
                ]
            }
        };

        function openOrderModal(orderId) {
            const order = orderData[orderId];
            if (!order) return;

            // Update modal content
            document.getElementById('orderNumber').textContent = order.orderNumber;
            document.getElementById('orderDate').textContent = order.date;
            document.getElementById('orderTotal').textContent = order.total;
            document.getElementById('shippedTo').textContent = order.shippedTo;
            document.getElementById('orderStatus').textContent = order.status;
            document.getElementById('deliveryInfo').textContent = order.deliveryInfo;
            document.getElementById('trackButton').textContent = order.trackButton;

            // Update status alert classes
            const statusAlert = document.getElementById('statusAlert');
            statusAlert.className = `alert p-2 mb-0 ${order.statusClass}`;
            
            const statusText = statusAlert.querySelectorAll('h6, p');
            statusText.forEach(el => {
                el.className = el.className.replace(/text-\w+/, order.statusTextClass);
            });

            // Populate items
            const itemsContainer = document.getElementById('orderItems');
            itemsContainer.innerHTML = '';

            order.items.forEach((item, index) => {
                const itemHTML = `
                    <div class="order-item">
                        <div class="row align-items-center">
                            <div class="col-4 col-md-3">
                                <img src="${item.image}" alt="${item.name}" class="product-img img-fluid">
                            </div>
                            <div class="col-5 col-md-6">
                                <h6 class="text-charcoal mb-1">
                                    <a href="#" class="text-charcoal text-decoration-none">${item.name}</a>
                                </h6>
                                <ul class="list-unstyled text-pebble mb-1 small">
                                    <li><b>Size:</b> ${item.size}</li>
                                </ul>
                                <h6 class="text-charcoal mb-0"><b>${item.price}</b></h6>
                            </div>
                            <div class="col-3 col-md-3 d-none d-md-block">
                                <button class="buy-return-parent">Buy Again</button>
                                <button class="buy-return-parent">Return</button>
                            </div>
                        </div>
                    </div>
                `;
                itemsContainer.innerHTML += itemHTML;
            });

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('orderModal'));
            modal.show();
        }
  </script>
</body>
</html>

