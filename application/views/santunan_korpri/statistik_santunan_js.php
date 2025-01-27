<script>
    var $url = window.location.protocol + '//' + window.location.hostname;
    var $select = $("select[name=tahun]");
    $select.on("change", function(e) {
        var _ = $(this);
        var $value = _.val();
        if($value == '') {
            window.location.replace(`${$url}/santunan_korpri/statistik`)
            return false;
        }
        window.location.replace(`${$url}/santunan_korpri/statistik?tahun=${$value}`)
    })
</script>