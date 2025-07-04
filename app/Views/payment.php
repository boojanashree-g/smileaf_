<button id="rzp-button1" hidden></button>

<div class="loader"
    style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.8); z-index: 9999; display: flex; justify-content: center; align-items: center;">
    <img width="40px" src="<?= base_url('public/assets/img/favicon.png') ?>" alt="Loading..." />
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>

    var options = {
        "key": "<?= esc($key_id) ?>",
        "amount": "<?= esc($order['amount']) ?>",
        "currency": "INR",
        "name": "Smileaf",
        "description": "Transaction",
        "image": "<?= base_url() ?>public/assets/img/favicon.png",
        "order_id": "<?= esc($order['id']) ?>",
        "callback_url": "<?= base_url() ?>payment-status",
        "prefill": {
            "name": "<?= esc($customerdata['name']) ?>",
            "email": "<?= esc($customerdata['email']) ?>",
            "contact": "<?= esc($customerdata['number']) ?>"
        },
        "notes": <?= json_encode([
            "address" => $customerdata['address'],
            "user_id" => $customerdata['user_id'],
            "order_id" => $customerdata['order_id'],
            "username" => $customerdata['name']
        ]) ?>,

        "theme": {
            "color": "#2d7438"
        },
        "modal": {
            "ondismiss": function () {


                var cancelOrderID = "<?= esc($order['id']) ?>";

                var error_data = {
                    reason: "User dismissed the payment modal",
                    order_id: "<?= esc($cancel_orderid) ?>",
                    razorpay_order_id: cancelOrderID,

                };
                var error_query = new URLSearchParams(error_data).toString();
                window.location.href = "<?= base_url('payment-cancelled') ?>?" + error_query;
            }
        },
        "handler": function (response) {

            document.querySelector(".loader").style.display = "block";

            var payment_data = {
                razorpay_payment_id: response.razorpay_payment_id,
                razorpay_order_id: response.razorpay_order_id,
                razorpay_signature: response.razorpay_signature,
                order_id: "<?= esc($order['id']) ?>"
            };

            // Send a POST request to your server
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "<?= base_url() ?>payment-status", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onload = function () {
                if (xhr.status === 200) {
                    try {
                        var res = JSON.parse(xhr.responseText);

                        if (res.code === 200 && res.status === 'success') {
                            window.location.href = "<?= base_url('success') ?>";
                        } else {
                            document.querySelector(".loader").style.display = "none";
                            alert("Payment verification failed. Please contact support.");
                            console.error("Error: ", res.message);
                        }
                    } catch (e) {
                        document.querySelector(".loader").style.display = "none";
                        alert("Invalid response from server.");
                        console.error("Invalid JSON response:", xhr.responseText);
                    }
                } else {
                    document.querySelector(".loader").style.display = "none";
                    alert("Server error. Try again.");
                    console.error("HTTP Error: ", xhr.status, xhr.statusText);
                }
            };


            xhr.onerror = function () {
                document.querySelector(".loader").style.display = "none";
                alert("Payment request failed. Check your internet connection.");
                console.error("Request failed. Status: ", xhr.status);
            };


            var data = new URLSearchParams(payment_data).toString();
            xhr.send(data);

        }
    };

    var rzp1 = new Razorpay(options);

    var InternalOrderId = "<?= esc($customerdata['order_id']) ?>";
    var RazorpayOrderId = "<?= esc($order['id']) ?>";

    rzp1.on('payment.failed', function (response) {
        var error_data = {
            code: response.error.code,
            description: response.error.description,
            source: response.error.source,
            step: response.error.step,
            reason: response.error.reason,
            order_id: InternalOrderId,
            razorpay_order_id: RazorpayOrderId,
            payment_id: response.error.metadata.payment_id
        };

        var error_query = new URLSearchParams(error_data).toString();
        window.location.href = "<?= base_url('payment-failed') ?>?" + error_query;
    });


    document.getElementById('rzp-button1').onclick = function (e) {
        rzp1.open();
        e.preventDefault();
    };

    document.getElementById('rzp-button1').click();



</script>