<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact " dir="ltr"
    data-theme="theme-default" data-assets-path="<?php echo base_url(); ?>assets/"
    data-template="vertical-menu-template" data-style="light">

<?php require "components/head.php"; ?>

<body>
    <div class="layout-wrapper layout-content-navbar  ">
        <div class="layout-container">

            <!-- Menu -->
            <?php require "components/sidenavbar.php"; ?>
            <!-- / Menu -->

            <div class="layout-page">

                <?php require "components/topnavbar.php"; ?>
 

                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">

                        <!-- Page Header -->
                        <div
                            class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                            <h4 class="page-title fw-semibold fs-18 mb-0">Manage Products</h4>
                            <div class="ms-md-1 ms-0">
                                <nav>
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item active" aria-current="page">Manage Products</li>
                                        <li class="breadcrumb-item active" aria-current="page">Product Details</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <!-- Page Header Close -->


                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card custom-card">
                                    <div class="card-header d-grid  d-md-flex justify-content-md-end">
                                        <a type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            id="add-detail">Add
                                            Details</a>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="datatable" class="table table-bordered text-nowrap w-100">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Menu</th>
                                                        <th>SubMenu</th>
                                                        <th>Product Name</th>
                                                        <th>Image</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- data -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                     
                        <!-- Add Modal -->
                        <div class="modal fade" id="product-modal" tabindex="-1" aria-hidden="true">
                               
                            <div class="modal-dialog modal-xl modal-simple">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                        <div class="text-center mb-6">
                                            <h4 class="subcat-title mb-2"></h4>
                                        </div>
                                        <form id="product-form" class="row g-6" onsubmit="return false">
                                            <div class="col-6 col-md-6">
                                                <label class="form-label">Menu</label>
                                                <select class="form-select" for="menu_id" name="menu_id"
                                                    id="menu_id">
                                                    <option value="">Select Menu</option>
                                                    <?php foreach($mainmenu as $menu)
                                                    { ?>
                                                      <option value="<?= $menu['menu_id'] ?>"><?= $menu['menu_name'] ?></option>
                                                    <?php } ?>
                                                
                                                </select>
                                                <span class="error text-danger menu_id mt-5"></span>
                                            </div>

                                            <div class="col-6 col-md-6">
                                                <label class="form-label">Sub Menu</label>
                                                <select class="form-select" for="sub_id" name="sub_id"
                                                    id="sub_id">
                                                  
                                                
                                                </select>
                                                <span class="error text-danger sub_id mt-5"></span>
                                            </div>
                                           

                                            <!--  Filter Start -->
                                            <div class="col-4 col-md-4">
                                                <label class="form-label">Filter Type</label>
                                                <select class="form-select" for="type_id" name="type_id"
                                                    id="type_id">
                                                    <option value="">Select Option</option>
                                                    <?php foreach($filter_type as $type)
                                                    { ?>
                                                      <option value="<?= $type['type_id'] ?>"><?= $type['type_name'] ?></option>
                                                    <?php } ?>
                                                
                                                </select>
                                                <span class="error text-danger type_id mt-5"></span>
                                            </div>

                                            <div class="col-4 col-md-4">
                                                <label class="form-label">Filter Shapes</label>
                                                <select class="form-select" for="shape_id" name="shape_id"
                                                    id="shape_id">

                                                    
                                                    <option value="">Select Option</option>
                                                    <?php foreach($filter_shape as $shape)
                                                    { ?>
                                                      <option value="<?= $shape['shape_id'] ?>"><?= $shape['shape_name'] ?></option>
                                                    <?php } ?>
                                                
                                                </select>
                                                <span class="error text-danger shape_id mt-5"></span>
                                            </div>

                                            <div class="col-4 col-md-4">
                                                <label class="form-label">Filter Size</label>
                                                <select class="form-select" for="size_id" name="size_id"
                                                    id="size_id">
                                                    <option value="">Select Option</option>
                                                    <?php foreach($filter_size as $size)
                                                    { ?>
                                                      <option value="<?= $size['size_id'] ?>"><?= $size['size_name'] ?></option>
                                                    <?php } ?>
                                                
                                                </select>
                                                <span class="error text-danger size_id mt-5"></span>
                                            </div>
                                            <!--  Filter End -->


                                            <div class="col-6 col-md-6">
                                                <label class="form-label" for="prod_name">Product Name</label>
                                                <input type="text" id="prod_name" name="prod_name"
                                                    class="form-control" placeholder="Product Name*" />
                                                <span class="error text-danger prod_name mt-5"></span>
                                            </div>

                                            <div class="col-5 col-md-5">
                                                <label for="main_image" class="form-label">Product Primary Image(Allowed size below 500KB)</label>
                                                <input class="form-control" type="file" id="main_image"
                                                    name="main_image" accept="image/*">
                                               
                                                <span class="error text-danger main_image mt-5"></span>
                                            </div>
                                            <div class="col-1 col-md-1">
                                                 <img src="" id="main_image_url" alt="image" width="80px" height="80px" 
                                                    style="display:none;">
                                            </div>


                                            <div class="col-lg-12 mt-3">
                                                <label for="description" class="form-label">Product
                                                    Description</label>
                                                <input class="form-control" type="text" id="description" name="description"
                                                    placeholder="Product Decription*">
                                                <span class="error text-danger description mt-5"></span>
                                            </div>

                                            <div class="col-lg-12 mt-3">
                                                <label for="product_usage" class="form-label">Product
                                                    Usage</label>
                                                <input class="form-control" type="text" id="product_usage" name="product_usage"
                                                    placeholder="Product Usage*">
                                                <span class="error text-danger product_usage mt-5"></span>
                                            </div> 
                                            
                                            <div class="col-12">
                                                 <label for="images" class="form-label">Product's Secondary Images (Allowed size below 20KB*)</label>
                                                <div class="upload-box">
                                                    <label class="upload-label" for="images"><i class="fa-solid fa-arrow-up-from-bracket"></i>	&nbsp; 	&nbsp; Upload images</label>
                                                    <input type="file" name="images[]" id="images" multiple accept="image/*">
                                                    <div class="preview-imgs" id="preview"></div>    
                                                </div>
                                                <span class="error text-danger images mt-5"></span>
                                            </div>
                                            <div class="col-lg-12 mt-3">
                                                <div class="form-check form-switch mb-2">
                                                    <input class="form-check-input" type="checkbox" id="hasVariant" name="has_variant" value="0">
                                                    <label class="form-check-label">Has Variant?</label>
                                                </div>
                                            </div>
                                                  
                                            <!-- default section -->
                                            <div id="defaultSection" class="row g-3 mt-2">
                                                <h5>Product Variants</h5>
                                                <div class="col-3 col-md-3">
                                                    <input type="number" name="pack_qty"
                                                        class="form-control pack_qty" placeholder="Pack Quantity*" />
                                                    <span class="error text-danger pack_qty mt-5"></span>
                                                </div>

                                                 <div class="col-3 col-md-3">                                                   
                                                    <input type="number"  name="quantity"
                                                        class="form-control quantity" placeholder="Quantity*" />
                                                    <span class="error text-danger quantity mt-5"></span>
                                                </div>


                                                <div class="col-3 col-md-3">
                                                    <input type="number"  name="mrp"
                                                        class="form-control mrp" placeholder="MRP*" />
                                                    <span class="error text-danger mrp mt-5"></span>
                                                </div>
                                                
                                                <div class="col-3 col-md-3">
                                                     <select class="form-select offer_type" for="offer_type" name="offer_type"
                                                    >
                                                    <option value="">Select Offer Type</option>
                                                    <option value="0">None</option>
                                                    <option value="1">Flat Discount</option>
                                                    <option value="2">Percentage</option>
                                                </select>
                                                    <span class="error text-danger offer_type mt-5"></span>
                                                
                                                </div>
                                                  <div class="col-3 col-md-3">
                                                    <input type="text"  name="offer_details"
                                                        class="form-control offer_details" placeholder="Offer Details*" />
                                                    <span class="error text-danger offer_details mt-5"></span>
                                                </div>

                                                <div class="col-3 col-md-3">
                                                    <input type="text"  name="offer_price"
                                                        class="form-control offer_price" placeholder="Offer Price*" />
                                                    <span class="error text-danger offer_price mt-5"></span>
                                                </div>

                                                <div class="col-3 col-md-3">
                                                     <select class="form-select stock_status" for="stock_status" name="stock_status"
                                                    >
                                                    <option value="">Select Stock Status</option>
                                                    <option value="1">Available</option>
                                                    <option value="0">Out of Stock</option>
                                                
                                                </select>
                                                    <span class="error text-danger stock_status mt-5"></span>
                                                </div>

                                               <div class="col-3 col-md-3">
                                                    <input type="text"  name="weight"
                                                        class="form-control weight" placeholder="Weight(g)*" />
                                                    <span class="error text-danger weight mt-5"></span>
                                                </div>
                                            </div>


                                            <!-- Variant Section -->
                                            <div id="variant-container" style="display:none">
                                             <div class="row">
                                                 <div class="col-md-8"><h5>Product Variants</h5></div>
                                                    <div class="col-md-4 text-end mb-3"> <button type="button" class="btn btn-label-success waves-effect add-variant"><i class="fa-solid fa-plus"></i>&nbsp; &nbsp; Add Variant</button></div>
                                             </div>
                                             <div id="variant-list">
                                                <!-- Dynamic Data  -->
                                             </div>
                                               
                                            </div>


                                            <div class="col-12 text-end">
                                                <a class="btn btn-primary text-white" id="btn-submit">Submit</a>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="modal fade" id="status-modal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-simple">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                        <div class="text-center mb-6">
                                            <h4 class="status-title mb-2"></h4>
                                        </div>
                                        <form id="status-form" class="row g-6" onsubmit="return false">
                                            <div class="col-12 col-md-12">
                                                <label class="form-label" for="status">Status</label>
                                                <select id="update-status" class="form-select" name="status">
                                                    <option value="">Select Option</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>

                                                </select>
                                                <span class="error text-danger update-status mt-5"></span>
                                            </div>

                                            <div class="col-12 text-end">
                                                <a class="btn btn-primary text-white" id="submit-status">Submit</a>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- /Modal -->


                        
                    </div>


                   
                </div>

                <!-- Footer -->
                <?php require "components/bottomfooter.php"; ?>
                <!-- / Footer -->

            </div>
        </div>
    </div>
    </div>


     <!-- CK editor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {

            ClassicEditor
                .create(document.querySelector('#description')).then(e => {
                    description = e;
                })
                .catch(error => {
                    console.error(error);
                });
        });


         document.addEventListener('DOMContentLoaded', (event) => {

            ClassicEditor
                .create(document.querySelector('#product_usage')).then(e => {
                    produsage = e;
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
 
    <?php require "components/footer.php"; ?>
    <script src="<?php echo base_url(); ?>public/admin/custom/js/product-detail.js"></script>
    <!-- <! File upload js---->
    <script src="<?php echo base_url() ?>public/admin/js/forms-file-upload.js"></script>
    <script src="<?php echo base_url(); ?>public/admin/custom/js/product.js"></script>



    <!-- Variants js -->
    <script>
        let variantIndex = 0;
        $(".add-variant").click(function () {
            const variantHtml = `
            <div class="variant-block row g-2" data-index="${variantIndex}">
                <div class="row g-3 mt-2">
                    <div class="col-md-3"><input type="number" name="variants[${variantIndex}][pack_qty]" class="form-control pack_qty" placeholder="Pack Quantity*"></div>
                    <div class="col-md-3"><input type="number" name="variants[${variantIndex}][quantity]" class="form-control quantity" placeholder="Quantity*"></div>
                    <div class="col-md-3"><input type="text" name="variants[${variantIndex}][mrp]" class="form-control mrp" placeholder="MRP*"></div>
                    <div class="col-md-3">
                        <select name="variants[${variantIndex}][offer_type]" class="form-select offer_type">
                            <option value="">Select Offer Type</option>
                            <option value="0">None</option>
                            <option value="1">Flat</option>
                            <option value="2">Percentage</option>   
                        </select>
                    </div>
                    <div class="col-md-3"><input type="text" name="variants[${variantIndex}][offer_details]" class="form-control offer_details" placeholder="Offer Details*"></div>
                    <div class="col-md-3"><input type="text" name="variants[${variantIndex}][offer_price]" class="form-control offer_price" placeholder="Offer Price*"></div>
                    <div class="col-md-3">
                        <select name="variants[${variantIndex}][stock_status]" class="form-select stock_status">
                            <option value="1">Available</option>
                            <option value="0">Out Of Stock</option> 
                        </select>
                    </div>
                    <div class="col-md-3"><input type="text" class="form-control weight" name="variants[${variantIndex}][weight]" placeholder="Weight*"></div>
                </div>

                <div class="text-end mt-2">
                    <button type="button" class="btn btn-label-danger waves-effect remove-variant" data-rid="${variantIndex}">
                        <i class="fa-solid fa-trash-arrow-up"></i> &nbsp;&nbsp; Delete
                    </button>
                </div>
                <hr>
            </div>`;

            $("#variant-list").append(variantHtml);
            variantIndex++;
        });

        // delete
        $("#variant-list").on("click", ".remove-variant", function () {
            let deleteIndex = $(this).data("rid");
            console.log("Deleting index:", deleteIndex);

            let containerIndex = $(this).closest(".variant-block").data("index");
            console.log("Container Index:", containerIndex);

            $(this).closest(".variant-block").remove();
        });

        $(".add-variant").click();

        function removeAllVariantBlocks() {
        $("#variant-list").empty();
         variantIndex = 0;
        $(".add-variant").click();
         } 

        function removeVariantBlocks(){
             $("#variant-list").empty();
         variantIndex = 0;
        } 

    </script>

</body>

</html>