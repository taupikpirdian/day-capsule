<!-- latest jquery-->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<!-- Bootstrap js-->
<script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
<!-- feather icon js-->
<script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>
<!-- scrollbar js-->
<script src="{{ asset('assets/js/scrollbar/simplebar.js') }}"></script>
<script src="{{ asset('assets/js/scrollbar/custom.js') }}"></script>
<!-- Sidebar jquery-->
<script src="{{ asset('assets/js/config.js') }}"></script>
<!-- Plugins JS start-->
<script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
<script src="{{ asset('assets/js/sidebar-pin.js') }}"></script>
<script src="{{ asset('assets/js/slick/slick.min.js') }}"></script>
<script src="{{ asset('assets/js/slick/slick.js') }}"></script>
<script src="{{ asset('assets/js/header-slick.js') }}"></script>
<script src="{{ asset('assets/js/notify/bootstrap-notify.min.js') }}"></script>
<!-- calendar js-->
<script src="{{ asset('assets/js/notify/index.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom1.js') }}"></script>
<script src="{{ asset('assets/js/datepicker/date-range-picker/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/datepicker/date-range-picker/datepicker-range-custom.js') }}"></script>
<script src="{{ asset('assets/js/typeahead/handlebars.js') }}"></script>
<script src="{{ asset('assets/js/typeahead/typeahead.bundle.js') }}"></script>
<script src="{{ asset('assets/js/typeahead-search/handlebars.js') }}"></script>
<script src="{{ asset('assets/js/typeahead-search/typeahead-custom.js') }}"></script>
<script src="{{ asset('assets/js/height-equal.js') }}"></script>
<script src="{{ asset('assets/js/animation/wow/wow.min.js') }}"></script>
<script src="{{ asset('assets/js/height-equal.js') }}"></script>

<script src="{{ asset('assets/js/form-validation-custom.js') }}"></script>
<script src="{{ asset('assets/js/height-equal.js') }}"></script>
<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="{{ asset('assets/js/script.js') }}"></script>
<script src="{{ asset('assets/js/script1.js') }}"></script>
<script src="{{ asset('assets/js/theme-customizer/customizer.js') }}"></script>

<!-- Sweet Alerts js -->
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- toastr -->
<script src="{{ asset('assets/libs/toastr/toastr.min.js') }}"></script>
<!-- select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script src="{{ asset('assets/js/flat-pickr/flatpickr.js') }}"></script>
<script src="{{ asset('assets/js/flat-pickr/custom-flatpickr.js') }}"></script>
<script src="{{ asset('assets/js/height-equal.js') }}"></script>
<!-- Plugin used-->
<script>
    new WOW().init();

    function deleteData(uuid) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this data!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                destroy(uuid);
            }
        });
    }
    if ("{{Session::get('success')}}") {
        toastr.success("Success", "{{Session::get('success')}}");
    }
    if ("{{Session::get('error')}}") {
        toastr.error("error", "{{Session::get('error')}}");
    }
    if ("{{Session::get('info')}}") {
        toastr.warning("error", "{{Session::get('info')}}");
    }

    $(".select2").select2();

    /**
     *
     * function call ajax
     * url string
     * type string
     * data object
     */
     async function callDataWithAjax(url, type, data) {
        var data = {
            "_token": "{{ csrf_token() }}",
            ...data
        }
        return await $.ajax({
            url: url,
            type: type,
            data: data,
        }).then(function(data) {
            return data;
        });
    }

    function formatCurrency(amount){
        const formattedAmount = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(amount);

        return formattedAmount.replace(/\,00$/, '');
    }

    function stringToIntCurrencyPublic(nominalString){
        let numericString = nominalString.replace(/[^\d,]/g, '');
        // // Parse the string as a float
        let floatValue = parseFloat(numericString);
        // // Convert to integer (drop the decimal part)
        let intValue = Math.floor(floatValue);

        return intValue;
    }

    function viewCurrency(nominal, id){
        var currency =  stringToIntCurrencyPublic(nominal);
        if (isNaN(currency)) {
            currency = 0;
        }
        $(`${id}`).val(formatCurrency(currency));
    }

    function getAndSetCurrencyFormat(id){
        var value = $(`${id}`).val();
        $(`${id}`).val(formatCurrency(value));
    }
</script>