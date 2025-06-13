<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl">
        <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
            <div class="text-body">
                <a id="footer-link" href="<?= base_url() ?>" target="_blank" class="footer-link">
                    <!-- CODE.. -->
                </a>
            </div>

            <script>
                const year = new Date().getFullYear();
                document.getElementById("footer-link").innerHTML = `Copyrights © ${year} smileaf`;
            </script>
            <!-- <div class="d-none d-lg-inline-block">

                <span>Powered by</span><a href="https://www.appteq.in/" class="footer-link me-4" target="_blank">  Appteq</a>
                
            </div> -->
        </div>
    </div>
</footer>