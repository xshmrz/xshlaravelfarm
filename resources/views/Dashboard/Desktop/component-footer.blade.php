<script src="assets/dashboard/js/jquery.min.js"></script>
<script src="assets/dashboard/js/codebase.app.min.js"></script>
<!-- THEME JS -->
<script src="assets/dashboard/js/plugins/datatables/dataTables.min.js"></script>
<script src="assets/dashboard/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="assets/dashboard/js/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/dashboard/js/plugins/datatables-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
<script src="assets/dashboard/js/plugins/datatables-buttons/dataTables.buttons.min.js"></script>
<script src="assets/dashboard/js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
<script src="assets/dashboard/js/plugins/datatables-buttons-jszip/jszip.min.js"></script>
<script src="assets/dashboard/js/plugins/datatables-buttons-pdfmake/pdfmake.min.js"></script>
<script src="assets/dashboard/js/plugins/datatables-buttons-pdfmake/vfs_fonts.js"></script>
<script src="assets/dashboard/js/plugins/datatables-buttons/buttons.print.min.js"></script>
<script src="assets/dashboard/js/plugins/datatables-buttons/buttons.html5.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAQSXd25M6bIKqaUI72nhvlcAGchOS7b0A&libraries=places"></script>
<!-- APP -->
<script src="assets/app.core.min.js"></script>
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
                                                         callback: () => { xsh.redirectTo('dashboard'); }
                                                     });
                            }
                        });
    });
    Authorize.BtnLogout.click(function () {
        Authorize.Logout({
                             data: null,
                             ok  : function (response) {
                                 xsh.showNotification({
                                                          message : response.message,
                                                          callback: () => { xsh.redirectTo('dashboard/login'); }
                                                      });
                             }
                         });
    });
    function initTableWithLoading(dataTableDisplaySelector, loaderText = 'Yükleniyor') {
        const $dataTableDisplay = $(dataTableDisplaySelector);
        const $wrapper          = $dataTableDisplay.parent();
        // Loading div oluştur
        const $loading          = $('<div class="table-loading" style="text-align:center; padding:20px;">' + loaderText + '</div>');
        // Mevcut tabloyu gizle, loading'i ekle
        $wrapper.append($loading);
        // Eğer tabloyu elle dolduruyorsan, tablo hazır olduğunda manuel olarak çağır:
        return {
            done: function () {
                $loading.remove();
                $dataTableDisplay.removeClass('d-none');
            }
        };
    }
    $(document).ready(function () {
        const tableLoader = initTableWithLoading('.dataTableDisplay');
        // Simülasyon: 1.5 saniye sonra tabloyu göster
        setTimeout(() => {
            tableLoader.done();
        }, 1500);
    });
    function initMapPicker(defaultLat = 39.92077, defaultLng = 32.85411) {
        const map      = new google.maps.Map(document.getElementById('map'), {
            center: {lat: defaultLat, lng: defaultLng},
            zoom  : 13
        });
        const geocoder = new google.maps.Geocoder();
        let marker     = new google.maps.Marker({
                                                    map      : map,
                                                    draggable: true,
                                                    position : {lat: defaultLat, lng: defaultLng}
                                                });
        // Marker sürüklenince bilgi güncelle
        marker.addListener('dragend', function () {
            const pos = marker.getPosition();
            updateLocationInfo(pos.lat(), pos.lng());
        });
        // Haritaya tıklanınca marker'ı oraya koy ve bilgi yazdır
        map.addListener('click', function (event) {
            const lat = event.latLng.lat();
            const lng = event.latLng.lng();
            marker.setPosition({lat, lng});
            updateLocationInfo(lat, lng);
        });
        function updateLocationInfo(lat, lng) {
            console.clear();
            console.log('Koordinatlar:', {lat, lng});
            geocoder.geocode({location: {lat, lng}}, function (results, status) {
                if (status === 'OK' && results[0]) {
                    const components  = results[0].address_components;
                    const fullAddress = results[0].formatted_address;
                    const city        = getComponent(components, 'administrative_area_level_1');
                    const district    = getComponent(components, 'administrative_area_level_2');
                    const country     = getComponent(components, 'country');
                    console.log('Adres:', fullAddress);
                    console.log('İl:', city);
                    console.log('İlçe:', district);
                    console.log('Ülke:', country);
                }
                else {
                    console.warn('Adres bulunamadı.');
                }
            });
        }
        function getComponent(components, type) {
            const match = components.find(c => c.types.includes(type));
            return match ? match.long_name : '';
        }
        // İlk başlangıçta göster
        updateLocationInfo(defaultLat, defaultLng);
    }
    $(document).ready(function () {
        initMapPicker();
    });
</script>

