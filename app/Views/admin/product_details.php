<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact " dir="ltr"
    data-theme="theme-default" data-assets-path="<?php echo base_url(); ?>assets/"
    data-template="vertical-menu-template" data-style="light">

<?php require "components/head.php"; ?>
<style>
   #defaultSection ,#variant-container{
        padding:20px;
        border : 1px solid #dfdfe3;

    }
   .upload-box {
            border: 2px dashed #888;
            padding: 20px;
            text-align: center;
            background: #f9f9f9;
            border-radius: 5px;
            max-width: 100%;
            margin: auto;
        }

        .upload-box input[type="file"] {
            display: none;
        }

       .upload-label {
    background-color: #c7cce163;
    color: #090814c2;
    padding: 10px 25px;
    cursor: pointer;
    display: inline-block;
    border-radius: 0px;
    margin-bottom: 15px;
}

      .preview-imgs {
     max-width: 100%;
  height: auto;
  display: flex;
  margin: 0 auto 6px;
  border-radius: 4px;
  gap:10px;
}


.preview-box {

   width: 160px;
  padding: 10px;
  border: 1px solid #eee;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
  text-align: center;
  border-radius: 8px;
  box-sizing: border-box;
  overflow: hidden;
}

.remove-btn {
 
    top: 83px;
    right: 115px;
    /* background: red; */
    color: #7367f0;
    border: none;
    /* color: white; */
    /* border-radius: 50%; */
    /* border-radius: 50%; */
    /* height: 144px; */
    font-size: 12px;

}


.preview-imgs div {
    display: flex;
    flex-direction: column;
    align-items: center;
    max-width: 160px;
    border: 2px solid #e6e6e8;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
    padding: 15px;
    border-radius: 8px;
    background-color: #fff;
}

        .preview-imgs img {
            width: 100px;
            height: 100px;
            object-fit: cover;
           
        }

   .preview-box p {
  margin: 4px 0;
  font-size: 13px;
  line-height: 1.4;
  color: #555;
  word-break: break-word;
 
}

.preview-box p:first-of-type {
   max-width: 100%;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  font-size: 14px;
  margin: 0;
  color: #444;
}

.preview-box .img-size {
   font-size: 13px;
  color: #888;
  font-style: italic;
  margin: 2px 0 0;
}

</style>

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
                                                        <th>SubCategory</th>
                                                        <th>Status</th>
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

                                            <div class="col-4 col-md-4">
                                                <label class="form-label">Sub Menu</label>
                                                <select class="form-select" for="submenu_id" name="submenu_id"
                                                    id="submenu_id">
                                                    <option value="">Select Sub Menu</option>
                                                    <?php foreach($submenu as $menu)
                                                    { ?>
                                                      <option value="<?= $menu['sub_id'] ?>"><?= $menu['submenu'] ?></option>
                                                    <?php } ?>
                                                
                                                </select>
                                                <span class="error text-danger submenu_id mt-5"></span>
                                            </div>
                                             <div class="col-4 col-md-4">
                                                <label class="form-label">SubCategory</label>
                                                <select class="form-select" for="subcat_id" name="subcat_id"
                                                    id="subcat_id">
                                                    <option value="">Select Sub Category</option>
                                                    <?php foreach($submenu as $menu)
                                                    { ?>
                                                      <option value="<?= $menu['sub_id'] ?>"><?= $menu['submenu'] ?></option>
                                                    <?php } ?>
                                                
                                                </select>
                                                <span class="error text-danger subcat_id mt-5"></span>
                                            </div>


                                         
                                            <!--  Filter Start -->
                                            <div class="col-4 col-md-4">
                                                <label class="form-label">Filter Type</label>
                                                <select class="form-select" for="menu_id" name="menu_id"
                                                    id="menu_id">
                                                    <option value="">Select Option</option>
                                                    <?php foreach($submenu as $menu)
                                                    { ?>
                                                      <option value="<?= $menu['sub_id'] ?>"><?= $menu['submenu'] ?></option>
                                                    <?php } ?>
                                                
                                                </select>
                                                <span class="error text-danger menu_id mt-5"></span>
                                            </div>

                                            <div class="col-4 col-md-4">
                                                <label class="form-label">Filter Shapes</label>
                                                <select class="form-select" for="submenu_id" name="submenu_id"
                                                    id="submenu_id">
                                                    <option value="">Select Option</option>
                                                    <?php foreach($submenu as $menu)
                                                    { ?>
                                                      <option value="<?= $menu['sub_id'] ?>"><?= $menu['submenu'] ?></option>
                                                    <?php } ?>
                                                
                                                </select>
                                                <span class="error text-danger submenu_id mt-5"></span>
                                            </div>
                                             <div class="col-4 col-md-4">
                                                <label class="form-label">Filter Size</label>
                                                <select class="form-select" for="subcat_id" name="subcat_id"
                                                    id="subcat_id">
                                                    <option value="">Select Option</option>
                                                    <?php foreach($submenu as $menu)
                                                    { ?>
                                                      <option value="<?= $menu['sub_id'] ?>"><?= $menu['submenu'] ?></option>
                                                    <?php } ?>
                                                
                                                </select>
                                                <span class="error text-danger subcat_id mt-5"></span>
                                            </div>
                                            <!--  Filter End -->




                                            <div class="col-6 col-md-6">
                                                <label class="form-label" for="prod_name">Product Name</label>
                                                <input type="text" id="prod_name" name="prod_name"
                                                    class="form-control" placeholder="Product Name*" />
                                                <span class="error text-danger prod_name mt-5"></span>
                                            </div>

                                            <div class="col-5 col-md-5">
                                                <label for="main_image" class="form-label">Product Image</label>
                                                <input class="form-control" type="file" id="main_image"
                                                    name="main_image">
                                               
                                                <span class="error text-danger main_image mt-5"></span>
                                            </div>
                                            <div class="col-1 col-md-1">
                                                 <img src="" id="main_image_url" alt="image" width="80px"
                                                    style="display:none;">
                                            </div>


                                            



                                            <div class="col-lg-12 mt-3">
                                                <label for="prod_desc" class="form-label">Product
                                                    Description</label>
                                                <input class="form-control" type="text" id="prod_desc" name="prod_desc"
                                                    placeholder="Product Decription*">
                                                <span class="error text-danger prod_desc mt-5"></span>
                                            </div>

                                            <div class="col-lg-12 mt-3">
                                                <label for="prod_usage" class="form-label">Product
                                                    Usage</label>
                                                <input class="form-control" type="text" id="prod_usage" name="prod_usage"
                                                    placeholder="Product Usage*">
                                                <span class="error text-danger prod_usage mt-5"></span>
                                            </div> 
                                            
                                            <div class="col-12">
                                                 <label for="prod_usage" class="form-label">Images (Allowed size below 20KB*)</label>
                                                <div class="upload-box">
                                                    <label class="upload-label" for="images"><i class="fa-solid fa-arrow-up-from-bracket"></i>	&nbsp; 	&nbsp; Upload images</label>
                                                    <input type="file" name="images[]" id="images" multiple accept="image/*">
                                                    <div class="preview-imgs" id="preview"></div>
                                                    
                                                    
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mt-3">
                                                <div class="form-check form-switch mb-2">
                                                    <input class="form-check-input" type="checkbox" id="hasVariant">
                                                    <label class="form-check-label" for="">Has Variant?</label>
                                                </div>
                                            </div>
                                                  
                                            <!-- default section -->
                                            <div id="defaultSection" class="row">
                                                <div class="col-6 col-md-6">
                                                    <label class="form-label" for="pack_qty">Pack Quantity</label>
                                                    <input type="text" id="pack_qty" name="pack_qty"
                                                        class="form-control" placeholder="Pack Quantity*" />
                                                    <span class="error text-danger pack_qty mt-5"></span>
                                                </div>

                                                 <div class="col-6 col-md-6">
                                                    <label class="form-label" for="quantity">Quantity</label>
                                                    <input type="text" id="quantity" name="quantity"
                                                        class="form-control" placeholder="Quantity*" />
                                                    <span class="error text-danger quantity mt-5"></span>
                                                </div>


                                                <div class="col-3 col-md-3">
                                                    <label class="form-label" for="mrp">MRP</label>
                                                    <input type="text" id="mrp" name="mrp"
                                                        class="form-control" placeholder="MRP*" />
                                                    <span class="error text-danger mrp mt-5"></span>
                                                </div>
                                                <div class="col-3 col-md-3">
                                                    <label class="form-label" for="offer_type">Offer Type</label>
                                                     <select class="form-select" for="submenu_id" name="submenu_id"
                                                    id="submenu_id">
                                                    <option value="">Select Type</option>
                                                    <?php foreach($submenu as $menu)
                                                    { ?>
                                                      <option value="<?= $menu['sub_id'] ?>"><?= $menu['submenu'] ?></option>
                                                    <?php } ?>
                                                
                                                </select>
                                                    <span class="error text-danger offer_type mt-5"></span>
                                                </div>
                                                  <div class="col-3 col-md-3">
                                                    <label class="form-label" for="offer_details">Offer Details</label>
                                                    <input type="text" id="offer_details	" name="offer_details	"
                                                        class="form-control" placeholder="Offer type*" />
                                                    <span class="error text-danger offer_details mt-5"></span>
                                                </div>

                                                   <div class="col-3 col-md-3">
                                                    <label class="form-label" for="offer_details">Offer Price</label>
                                                    <input type="text" id="offer_details" name="offer_details	"
                                                        class="form-control" placeholder="Offer type*" />
                                                    <span class="error text-danger offer_details mt-5"></span>
                                                </div>


                                                 <div class="col-6 col-md-6">
                                                    <label class="form-label" for="stock_status">Stock Status</label>
                                                    <input type="text" id="stock_status" name="stock_status"
                                                        class="form-control" placeholder="Pack Quantity*" />
                                                    <span class="error text-danger stock_status mt-5"></span>
                                                </div>

                                                 <div class="col-6 col-md-6">
                                                    <label class="form-label" for="weight">Weight</label>
                                                    <input type="text" id="weight" name="weight"
                                                        class="form-control" placeholder="weight*" />
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
                                                <a class="btn btn-primary text-white" id="btn-submit"></a>

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
                .create(document.querySelector('#prod_desc')).then(e => {
                    prodDesc = e;
                })
                .catch(error => {
                    console.error(error);
                });
        });


         document.addEventListener('DOMContentLoaded', (event) => {

            ClassicEditor
                .create(document.querySelector('#prod_usage')).then(e => {
                    prodDesc = e;
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



    <!-- Multiple File uplaod -->
  <script>
    let selectedFiles = [];

    function formatFileSize(bytes) {
        const kb = bytes / 1024;
        return kb < 1024 ? kb.toFixed(2) + ' KB' : (kb / 1024).toFixed(2) + ' MB';
    }

    $(document).ready(function () {
        $('#images').on('change', function (e) {
            const files = Array.from(e.target.files);
            const $preview = $('#preview');

            files.forEach(file => {
                selectedFiles.push(file);
                const reader = new FileReader();

                reader.onload = function (event) {
                    const $container = $('<div>').addClass('preview-box');
                    const $img = $('<img>').attr('src', event.target.result);
                    const size = formatFileSize(file.size);

                    const $caption = $('<p>').text(file.name);
                    const $sizeCaption = $('<p>').addClass('img-size').text(`(${size})`);

                    const $removeBtn = $('<button>').addClass('remove-btn').text('Remove');
                    $removeBtn.on('click', function () {
                        $container.remove();
                        selectedFiles = selectedFiles.filter(f => f !== file);
                    });

                    $container.append($img, $caption, $sizeCaption, $removeBtn);
                    $preview.append($container);
                };

                reader.readAsDataURL(file);
            });

          
            $(this).val('');
        });

        $('form').on('submit', function (e) {
            e.preventDefault();

            const formData = new FormData();
            selectedFiles.forEach(file => {
                formData.append('images[]', file);
            });

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    alert("Upload complete");
                    location.reload();
                },
                error: function () {
                    alert("Upload failed");
                }
            });
        });
    });
  </script>


<!-- Variants js -->
 <script>
    let variantIndex = 0;

    $(".add-variant").click(function () {
        const variantHtml = `
        <div class="variant-block row g-2" data-index="${variantIndex}">
            <div class="row g-3 mt-2">
                <div class="col-md-3"><input type="text" name="variants[${variantIndex}][pack_qty]" class="form-control" placeholder="Pack Quantity*"></div>
                <div class="col-md-3"><input type="text" name="variants[${variantIndex}][quantity]" class="form-control" placeholder="Quantity*"></div>
                <div class="col-md-3"><input type="text" name="variants[${variantIndex}][mrp]" class="form-control" placeholder="MRP*"></div>
                <div class="col-md-3">
                    <select name="variants[${variantIndex}][offer_type]" class="form-select">
                        <option value="0">None</option>
                        <option value="1">Flat</option>
                        <option value="2">Percentage</option>   
                    </select>
                </div>
                <div class="col-md-3"><input type="text" name="variants[${variantIndex}][offer_details]" class="form-control" placeholder="Offer Details*"></div>
                <div class="col-md-3"><input type="text" name="variants[${variantIndex}][offer_price]" class="form-control" placeholder="Offer Price*"></div>
                <div class="col-md-3">
                    <select name="variants[${variantIndex}][stock_status]" class="form-select">
                        <option value="1">Available</option>
                        <option value="0">Out Of Stock</option> 
                    </select>
                </div>
                <div class="col-md-3"><input type="text" class="form-control" name="variants[${variantIndex}][weight]" placeholder="Weight*"></div>
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
</script>








</body>

</html>