SELECT
guiding_parameters.environmental_guiding_parameter_id 'Param. Orietador Ambiental',
guiding_parameter_values.guiding_parameter_id 'ID Param. Orietador Ambiental',
analysis_matrices.name 'Matriz',
guiding_parameter_values.analysis_matrix_id 'ID Matriz',
parameter_analyses.analysis_parameter_name 'Param. Análise',
guiding_parameter_values.parameter_analysis_id 'ID Param. Análise',
guiding_parameter_ref_values.guiding_parameter_ref_value_id 'Ref. Param. Valor Orientador',
guiding_parameter_values.guiding_parameter_ref_value_id 'ID Ref. Param. Valor Orientador',
guiding_values.name 'Tipo Valor Orientador',
guiding_parameter_values.guiding_value_id 'ID Tipo Valor Orientador',
u2.name 'Unidade Legislação',
guiding_parameter_values.unity_legislation_id 'ID Unidade Legislação',
guiding_parameter_values.guiding_legislation_value 'Valor Orientador Legislaçao',
guiding_parameter_values.guiding_legislation_value_1 'Valor Orientador Legislaçao 1',
guiding_parameter_values.guiding_legislation_value_2 'Valor Orientador Legislaçao 2',
u2.name 'Unidade Análise',
guiding_parameter_values.unity_analysis_id 'ID Unidade Análise',
guiding_parameter_values.guiding_analysis_value 'Valor Orientador Análise',
guiding_parameter_values.guiding_analysis_value_1 'Valor Orientador Análise 1',
guiding_parameter_values.guiding_analysis_value_2 'Valor Orientador Análise 2'
FROM guiding_parameter_values
INNER JOIN guiding_parameters ON guiding_parameters.id = guiding_parameter_values.guiding_parameter_id
INNER JOIN analysis_matrices ON analysis_matrices.id = guiding_parameter_values.analysis_matrix_id
INNER JOIN parameter_analyses ON parameter_analyses.id = guiding_parameter_values.parameter_analysis_id
INNER JOIN guiding_parameter_ref_values ON guiding_parameter_ref_values.id = guiding_parameter_values.guiding_parameter_ref_value_id
INNER JOIN guiding_values ON guiding_values.id = guiding_parameter_values.guiding_value_id
INNER JOIN unities u2 ON u2.id = guiding_parameter_values.unity_legislation_id
INNER JOIN unities u3 ON u3.id = guiding_parameter_values.unity_analysis_id;

SELECT
analysis_parameters.name 'Tipo Param. Análise',
parameter_analyses.analysis_parameter_id 'ID Tipo Param. Análise',
parameter_analyses.cas_rn 'CAS RN',
parameter_analyses.ref_cas_rn 'ref CasRN Param. Análise',
parameter_analyses.analysis_parameter_name 'Nome Param. Análise',
parameter_analysis_groups.name 'Groupo Param. Análise',
parameter_analyses.parameter_analysis_group_id 'ID Groupo Param. Análise',
parameter_analyses.order 'Ordem',
parameter_analyses.decimal_place 'Casa Decimal',
parameter_analyses.final_validity 'Dt. Fim Validade'
FROM `parameter_analyses`
INNER JOIN analysis_parameters ON analysis_parameters.id = parameter_analyses.analysis_parameter_id
INNER JOIN parameter_analysis_groups ON parameter_analysis_groups.id = parameter_analyses.parameter_analysis_group_id;

SELECT
guiding_parameters.environmental_guiding_parameter_id 'Cod. Param. Orientador Ambiental',
guiding_parameters.name 'Nome Param. Orientador',
environmental_areas.name 'Tipo Área Ambiental',
guiding_parameters.environmental_area_id 'ID Tipo Área Ambiental',
environmental_agencies.name 'Órgão Ambiental',
guiding_parameters.environmental_agency_id 'ID Órgão Ambiental'
FROM `guiding_parameters`
INNER JOIN environmental_areas ON environmental_areas.id = guiding_parameters.environmental_area_id
INNER JOIN environmental_agencies ON environmental_agencies.id = guiding_parameters.environmental_agency_id
