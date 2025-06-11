<script src="assets/site-pwa/js/lib/bootstrap.bundle.min.js"></script>
<script src="assets/site-pwa/js/plugins/splide/splide.min.js"></script>
<script src="assets/site-pwa/js/jquery.min.js"></script>
<script src="assets/site-pwa/js/base.js"></script>
<script src="assets/app.core.js"></script>
<script src="assets/app.min.js"></script>
<script>
    (function ($, document) {
        $.each(readyQ, function (index, func) {
            $(func);
        });
        $.each(bindReadyQ, function (index, func) {
            $(document).on('ready', func);
        });
    })(jQuery, document);
</script>
<script>
    Authorize.BtnLogin.click(function () {
        var data = xsh.getFormData(Authorize.FrmLogin);
        Authorize.Login({
                            data: data,
                            ok  : function (response) {
                                xsh.showNotification({
                                                         message : response.message,
                                                         callback: () => { xsh.redirectTo('/'); }
                                                     });
                            }
                        });
    });
</script>

