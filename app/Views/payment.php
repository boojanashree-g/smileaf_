<!-- Loader -->
<div class="loader" style="
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.8);
    z-index: 9999;
    justify-content: center;
    align-items: center;
">
    <img width="200px" src="<?= base_url('public/assets/img/loader.gif') ?>" alt="Loading..." />
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
    const options = {
        key: "<?= esc($key_id) ?>",
        amount: "<?= esc($order['amount']) ?>",
        currency: "INR",
        name: "Smileaf",
        description: "Transaction",
        image: "<?= base_url('public/assets/img/favicon.png') ?>",
        order_id: "<?= esc($order['id']) ?>",
        callback_url: "<?= site_url('payment-status') ?>",
        prefill: {
            name: "<?= esc($customerdata['name']) ?>",
            email: "<?= esc($customerdata['email']) ?>",
            contact: "<?= esc($customerdata['number']) ?>"
        },
        notes: <?= json_encode([
            "address" => $customerdata['address'],
            "user_id" => $customerdata['user_id'],
            "order_id" => $customerdata['order_id'],
            "username" => $customerdata['name']
        ]) ?>,
        theme: {
            color: "#2d7438"
        },
        modal: {
            ondismiss: function () {
                const errorData = {
                    reason: "User dismissed the payment modal",
                    order_id: "<?= esc($cancel_orderid) ?>",
                    razorpay_order_id: "<?= esc($order['id']) ?>"
                };
                const query = new URLSearchParams(errorData).toString();

                setTimeout(() => {
                    window.location.href = "<?= site_url('payment-cancelled') ?>?" + query;
                }, 500);
            }
        },
        handler: function (response) {
            document.querySelector(".loader").style.display = "flex";


            setTimeout(() => {
                window.location.href = "<?= site_url('success') ?>";
            }, 500);
        }
    };

    const rzp1 = new Razorpay(options);

    const internalOrderId = "<?= esc($customerdata['order_id']) ?>";
    const razorpayOrderId = "<?= esc($order['id']) ?>";

    rzp1.on('payment.failed', function (response) {
        const errorData = {
            code: response.error.code,
            description: response.error.description,
            source: response.error.source,
            step: response.error.step,
            reason: response.error.reason,
            order_id: internalOrderId,
            razorpay_order_id: razorpayOrderId,
            payment_id: response.error.metadata.payment_id
        };
        const query = new URLSearchParams(errorData).toString();

        setTimeout(() => {
            window.location.href = "<?= site_url('payment-failed') ?>?" + query;
        }, 500);
    });


    window.onload = function () {
        setTimeout(() => {
            rzp1.open();
        }, 300);
    };
</script>