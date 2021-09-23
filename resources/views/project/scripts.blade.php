<script>
    window.addEventListener("load", function() {
        document.querySelectorAll(".custom-select").forEach(item => {
            NiceSelect.bind(item, {searchable: true});
        });
    });
</script>
