SELECT guiding_parameters.name 'Param. Orietador Ambiental', guiding_parameter_values.guiding_parameter_id 'ID Param. Orietador Ambiental',
analysis_matrices.name 'Matriz',  guiding_parameter_values.analysis_matrix_id 'ID Matriz',
parameter_analyses.analysis_parameter_name 'Param. Análise', guiding_parameter_values.parameter_analysis_id 'ID Param. Análise',
guiding_parameter_ref_values.guiding_parameter_ref_value_id 'Ref. Param. Valor Orientador', guiding_parameter_values.guiding_parameter_ref_value_id 'ID Ref. Param. Valor Orientador',
guiding_values.name 'Tipo Valor Orientador', guiding_values.id 'ID Tipo Valor Orientador',
u1.name 'Unidade Legislação', u1.id 'ID Unidade Legislação', guiding_parameter_values.guiding_legislation_value 'Valor Orientador Legislaçao',
guiding_parameter_values.guiding_legislation_value_1 'Valor Orientador Legislaçao 1', guiding_parameter_values.guiding_legislation_value_2 'Valor Orientador Legislaçao 2', u2.name 'Unidade Análise', u2.id 'ID Unidade Análise', guiding_parameter_values.guiding_analysis_value 'Valor Orientador Análise', guiding_parameter_values.guiding_analysis_value_1 'Valor Orientador Análise 1', guiding_parameter_values.guiding_analysis_value_2 'Valor Orientador Análise 2'
FROM `guiding_parameter_values`
INNER JOIN guiding_parameters ON guiding_parameters.id = guiding_parameter_values.guiding_parameter_id
INNER JOIN analysis_matrices ON analysis_matrices.id = guiding_parameter_values.analysis_matrix_id
INNER JOIN parameter_analyses ON parameter_analyses.id = guiding_parameter_values.parameter_analysis_id
INNER JOIN guiding_parameter_ref_values ON guiding_parameter_ref_values.id = guiding_parameter_values.guiding_parameter_ref_value_id
INNER JOIN guiding_values ON guiding_values.id = guiding_parameter_values.guiding_value_id
INNER JOIN unities u1 ON u1.id = guiding_parameter_values.unity_legislation_id
INNER JOIN unities u2 ON u2.id = guiding_parameter_values.unity_analysis_id
