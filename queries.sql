SELECT guiding_parameters.name 'Param. Orietador Ambiental', guiding_parameter_values.guiding_parameter_id 'ID Param. Orietador Ambiental',
analysis_matrices.name 'Matriz',  guiding_parameter_values.analysis_matrix_id 'ID Matriz',
parameter_analyses.analysis_parameter_name 'Param. Análise', guiding_parameter_values.parameter_analysis_id 'ID Param. Análise',
guiding_parameter_ref_values.guiding_parameter_ref_value_id 'Ref. Param. Valor Orientador', guiding_parameter_values.guiding_parameter_ref_value_id 'ID Ref. Param. Valor Orientador',
guiding_values.name 'Tipo Valor Orientador', guiding_values.id 'ID Tipo Valor Orientador',
u1.name 'Unidade Legislação', u1.id 'ID Unidade Legislação', guiding_parameter_values.guiding_legislation_value 'Valor Orientador Legislaçao',
guiding_parameter_values.guiding_legislation_value_1 'Valor Orientador Legislaçao 1', guiding_parameter_values.guiding_legislation_value_2 'Valor Orientador Legislaçao 2', u2.name 'Unidade Análise', u2.id 'ID Unidade Análise', guiding_parameter_values.guiding_analysis_value 'Valor Orientador Análise', guiding_parameter_values.guiding_analysis_value_1 'Valor Orientador Análise 1', guiding_parameter_values.guiding_analysis_value_2 'Valor Orientador Análise 2'
FROM `guiding_parameter_values`
LEFT JOIN guiding_parameters ON guiding_parameters.id = guiding_parameter_values.guiding_parameter_id
LEFT JOIN analysis_matrices ON analysis_matrices.id = guiding_parameter_values.analysis_matrix_id
LEFT JOIN parameter_analyses ON parameter_analyses.id = guiding_parameter_values.parameter_analysis_id
LEFT JOIN guiding_parameter_ref_values ON guiding_parameter_ref_values.id = guiding_parameter_values.guiding_parameter_ref_value_id
LEFT JOIN guiding_values ON guiding_values.id = guiding_parameter_values.guiding_value_id
LEFT JOIN unities u1 ON u1.id = guiding_parameter_values.unity_legislation_id
LEFT JOIN unities u2 ON u2.id = guiding_parameter_values.unity_analysis_id

select `project_point_matrices`.* from `project_point_matrices` left join `point_identifications` on `point_identifications`.`id` = `project_point_matrices`.`point_identification_id` left join `parameter_analyses` on `parameter_analyses`.`id` = `project_point_matrices`.`parameter_analysis_id` left join `parameter_analysis_groups` as `t1` on `t1`.`id` = `parameter_analyses`.`parameter_analysis_group_id` where `project_point_matrices`.`campaign_id` = ? and `project_point_matrices`.`campaign_id` is not null order by `t1`.`order` asc, `parameter_analyses`.`order` asc
