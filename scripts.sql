-- Leads Plan

SELECT 
wp_calc_ss_planos.name AS 'plano',
wp_calc_ss_modalidades.name AS 'plano_modalidades',
wp_calc_ss_age_by_price.price_cop,
wp_calc_ss_age_by_price.price_nocop,
wp_calc_ss_categories.name as 'plano_categoria'

FROM wp_calc_ss_age_by_price
INNER JOIN wp_calc_ss_modalidades_has_categories ON wp_calc_ss_age_by_price.modalidades_id = wp_calc_ss_modalidades_has_categories.modalidades_id
INNER JOIN wp_calc_ss_modalidades ON wp_calc_ss_age_by_price.modalidades_id = wp_calc_ss_modalidades.id
INNER JOIN wp_calc_ss_categories ON wp_calc_ss_modalidades_has_categories.categorias_id = wp_calc_ss_categories.id
INNER JOIN wp_calc_ss_planos ON wp_calc_ss_modalidades.planos_id = wp_calc_ss_planos.id

WHERE age_min = 0 AND age_max = 18 AND categorias_id = 2
-- WHERE wp_calc_ss_planos.id = 1 age_min = 0 AND age_max = 18 AND categorias_id = 2

-- Get PLan

SELECT
wp_calc_ss_planos.id as 'id',
wp_calc_ss_planos.name as 'name',
wp_calc_ss_modalidades.id as 'modalidade_id',
wp_calc_ss_modalidades.name as 'modalidade',
wp_calc_ss_age_by_price.id as 'age_id',
wp_calc_ss_age_by_price.age_min,
wp_calc_ss_age_by_price.age_max,
wp_calc_ss_age_by_price.price_cop,
wp_calc_ss_age_by_price.price_nocop,
wp_calc_ss_modalidades_has_categories.categorias_id as 'categoria_id'

FROM wp_calc_ss_planos

INNER JOIN wp_calc_ss_modalidades ON wp_calc_ss_planos.id = wp_calc_ss_modalidades.planos_id
INNER JOIN wp_calc_ss_age_by_price ON wp_calc_ss_age_by_price.modalidades_id = wp_calc_ss_modalidades.id
INNER JOIN wp_calc_ss_modalidades_has_categories ON wp_calc_ss_modalidades_has_categories.modalidades_id = wp_calc_ss_modalidades.id

-- WHERE wp_calc_ss_planos.id = 1;
WHERE wp_calc_ss_planos.slug = 'amil';