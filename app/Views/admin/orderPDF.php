<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<style>
    .top_rw {
        background-color: #f4f4f4;
    }

    .td_w {}

    button {
        padding: 5px 10px;
        font-size: 14px;
    }

    .invoice-box {
        max-width: 890px;
        margin: auto;
        padding: 10px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 14px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }

    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
        border-bottom: solid 1px #ccc;
    }

    .invoice-box table td {
        padding: 5px;
        vertical-align: middle;
    }

    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }

    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }

    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }

    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
        font-size: 12px;
    }

    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.item td {
        border-bottom: 1px solid #eee;
    }

    .invoice-box table tr.item.last td {
        border-bottom: none;
    }

    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }

    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }

        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }

    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }

    .rtl table {
        text-align: right;
    }

    .rtl table tr td:nth-child(2) {
        text-align: left;
    }

    .amt-details td {
        border: none !important;
    }
</style>

<body>

    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top_rw">
                <td colspan="2">
                    <h2 style="margin-bottom: 0px;"> Tax invoice</h2>
                    <span style=""><b>GSTIN:</b>&nbsp; 33CWBPS9039N2ZV </span>
                </td>
                <td style="width:30%; margin-right: 10px;">
                    <b>Order No</b><?= $order_no ?>
                </td>
            </tr>
            <tr class="top">
                <td colspan="6">
                    <table>
                        <tr>
                            <td>
                                <b> Sold By :&nbsp; Smileaf </b> <br>
                                3/142,Near Varadaraja Mills(Unit 2),SundakkamPalayam,Nambiyam Palayam Post,
                                Avinashi,Tirupur,Tamilnadu, India - 641670.<br>
                                <b>Email :</b>&nbsp;info@smileaf.in <br>
                                <b>Phone:</b>&nbsp;9842578248 <br>
                                <b>Order Date:</b><?= $order_date ?><br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="">
                <td style="width:75% ;vertical-align: top;">
                    <b>Shipping Address:</b><br>
                    <?= $user_details['address'] ?><br>
                    <?= $user_details['landmark'] ?>,
                    <?= $user_details['city'] ?>,
                    <?= $user_details['dist_name'] ?>,
                    <?= $user_details['state_title'] ?> - <?= $user_details['pincode'] ?><br>
                </td>
                <td style="width:25% ;vertical-align: top;text-align:left;">
                    <b>Customer Details:</b><br>
                    <strong><?= $user_details['username'] ?></strong><br>
                    <?= $user_details['email'] ?><br>
                    <?= $user_details['number'] ?><br>

                </td>
            </tr>

            <tr>
                <td colspan="3" style="margin-top:20%;padding:3px">
                    <table cellspacing="0px" cellpadding="2px">
                        <tr class="heading">
                            <td style="width:1%;">
                                S.No
                            </td>
                            <td style="width:5%; text-align:left;">
                                Items
                            </td>
                            <td style="width:30%; text-align:left;">
                                ProductName
                            </td>
                            <td style="width:10%; text-align:left;">
                                MRP
                            </td>
                            <td style="width:10%; text-align:left;">
                                OfferPrice
                            </td>

                            <td style="width:10%; text-align:left;">
                                Quantity
                            </td>
                            <td style="width:10%; text-align:left;">
                                TotalPrice
                            </td>
                        </tr>
                        <?php foreach ($items as $i => $item) { ?>
                            <tr class="item" style="margin-top:5px">

                                <td style="width:10%; text-align:left;">
                                    <?= $i + 1 ?>
                                </td>
                                <td style="width:10%; text-align:left;">
                                    <img width="50px" src="<?= base_url() ?><?= $item['main_image'] ?>" alt="product-img" />
                                </td>
                                <td style="width:15%; text-align:left;">
                                    <?= $item['prod_name'] ?><br>
                                    <sub>Pack Qty: <?= $item['pack_qty'] ?></sub>
                                </td>
                                <td style="width:15%; text-align:left;">
                                    <?= $item['prod_price'] ?>
                                </td>
                                <td style="width:15%; text-align:left;">
                                    <?= $item['offer_price'] ?>
                                </td>
                                <td style="width:15%; text-align:left;">
                                    <?= $item['quantity'] ?>
                                </td>
                                <td style="width:15%; text-align:left;">
                                    <?= $item['sub_total'] ?>

                            </tr>
                        <?php } ?>

                        <!-- Note Row -->


                        <tr class="item amt-details">

                            <td colspan="4" style="text-align:justify;margin-top:0">
                                <strong style="font-size:15px">Notes:</strong><br>
                                This system-generated invoice requires no signature; Smileaf products are eco-friendly
                                and made from natural.


                            </td>
                            <td style="text-align: right" colspan="2">
                                <b>Sub Total :</b>
                            </td>
                            <td colspan="1" style="text-align: left">
                                <?= $order_sub_total ?>
                            </td>
                        </tr>
                        <tr class="item amt-details">
                            <td colspan="4"></td>
                            <td style="text-align: right" colspan="2">
                                <b>CGST(Includes) :</b>
                            </td>
                            <td colspan="1" style="text-align: left">
                                <?= $cgst ?>
                            </td>
                        </tr>
                        <tr class="item amt-details">
                            <td colspan="4"></td>
                            <td style="text-align: right" colspan="2">
                                <b>SGST(Includes) :</b>
                            </td>
                            <td colspan="1" style="text-align: left">
                                <?= $sgst ?>
                            </td>
                        </tr>
                        <tr class="item amt-details">
                            <td colspan="4"></td>
                            <td style="text-align: right" colspan="2">
                                <b>Discount :</b>
                            </td>
                            <td colspan="1" style="text-align: left">
                                <?= ((int) $discount_amt != 0) ? '-' . $discount_amt : '-' ?>
                            </td>
                        </tr>
                        <tr class="item amt-details">
                            <td colspan="4"></td>
                            <td style="text-align: right" colspan="2">
                                <b>Shipping :</b>
                            </td>
                            <td colspan="1" style="text-align: left">
                                <?= ((int) $courier_charge != 0) ? $courier_charge : 'Free' ?>
                            </td>
                        </tr>
                        <tr class="item amt-details">
                            <td colspan="4"></td>
                            <td style="text-align: right" colspan="2">
                                <b>Total Price :</b>
                            </td>
                            <td colspan="1" style="text-align: left">
                                <?= $order_total_amt ?>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="7"
                                style="padding: 20px; text-align: center; font-family: Arial, sans-serif; font-size: 14px; border-top: 1px solid #ccc;">
                                <strong
                                    style="font-size: 16px; display: block; margin-bottom: 5px; color: #07641fff;">Thank
                                    you for your purchase!</strong>
                                We truly appreciate your trust in <strong>Smileaf</strong>.<br>
                                We're committed to delivering eco-conscious, quality products.<br>
                                <em>We look forward to serving you again!</em>
                            </td>
                        </tr>



                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>


</html>