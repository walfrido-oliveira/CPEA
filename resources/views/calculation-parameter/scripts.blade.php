<script>
    document.getElementById("btn_param_analisis_add").addEventListener("click", function() {
        let textAtea = document.getElementById("formula");
        let paramAnalise = document.getElementById("param_analisis_add")
        textAtea.value += paramAnalise.value;
    });
</script>
