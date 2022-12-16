
    <script>
        /*const guidingAnalysisValue = document.getElementById("guiding_analysis_value");
        const guidingAnalysisValue1 = document.getElementById("guiding_analysis_value_1");
        const guidingAnalysisValue2 = document.getElementById("guiding_analysis_value_2");*/

        const guidingLegislationValue = document.getElementById("guiding_legislation_value");
        const guidingLegislationValue1 = document.getElementById("guiding_legislation_value_1");
        const guidingLegislationValue2 = document.getElementById("guiding_legislation_value_2");

        const unityLegislationId = document.getElementById("unity_legislation_id");
        //const unityAnalysisId = document.getElementById("unity_analysis_id");


        function reset() {
            /*guidingAnalysisValue.readOnly = false;
            guidingAnalysisValue1.readOnly = false;
            guidingAnalysisValue2.readOnly = false;*/

            guidingLegislationValue.readOnly = false;
            guidingLegislationValue1.readOnly = false;
            guidingLegislationValue2.readOnly = false;
        }

        function setFields(elem) {
            if(elem.value == 2) {
                guidingLegislationValue.readOnly = true;
                guidingLegislationValue1.readOnly = true;
                guidingLegislationValue2.readOnly = true;

                /*guidingAnalysisValue.readOnly = true;
                guidingAnalysisValue1.readOnly = true;
                guidingAnalysisValue2.readOnly = true;*/

                guidingLegislationValue.value = "VIRTUALMENTE AUSENTE";
                guidingLegislationValue1.value = "PRESENTE";
                guidingLegislationValue2.value = "";

                /*guidingAnalysisValue.value = "";
                guidingAnalysisValue1.value = "";
                guidingAnalysisValue2.value = "";*/

                unityLegislationId.value = 1;
                //unityAnalysisId.value = 1;

                window.customSelectArray['unity_legislation_id'].update();
                window.customSelectArray['unity_analysis_id'].update();
            }

            if(elem.value == 3) {
                guidingLegislationValue.value = "";
                guidingLegislationValue1.value = "";
                guidingLegislationValue2.value = "";

                /*guidingAnalysisValue.value = "";
                guidingAnalysisValue1.value = "";
                guidingAnalysisValue2.value = "";*/

                guidingLegislationValue2.readOnly = true;

                /*guidingAnalysisValue.readOnly = true;
                guidingAnalysisValue1.readOnly = true;
                guidingAnalysisValue2.readOnly = true;*/
            }
        }

        document.getElementById("guiding_value_id").addEventListener("change", function() {
            reset();
            setFields(this);
        });

        window.addEventListener("load", function() {
            setFields(this);
        });
    </script>
