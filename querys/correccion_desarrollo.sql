SELECT
	*
FROM
	personal_refrigerio;

SELECT
	*
FROM
	refrigerio;

SELECT
	id,
	lower(nombre) as nombre,
	icono
FROM
	menu
where
	estado = 1
GROUP by
	nombre;

-- ========================= MENU ========================
-- INSERT INTO
-- 	`menu` (`nombre`, `icono`, `estado`)
-- VALUES
-- 	('PERSONAL', 'icon-users', 1);
-- INSERT INTO
-- 	`menu` (`nombre`, `icono`, `estado`)
-- VALUES
-- 	('MANTENIMIENTO', 'icon-pencil-ruler', 1);
-- INSERT INTO
-- 	`menu` (`nombre`, `icono`, `estado`)
-- VALUES
-- 	('TIPOLOGIA', 'icon-toggle', 1);
-- INSERT INTO
-- 	`menu` (`nombre`, `icono`, `estado`)
-- VALUES
-- 	('PROGRAMA', 'icon-eyedropper2', 1);
-- INSERT INTO
-- 	`menu` (`nombre`, `icono`, `estado`)
-- VALUES
-- 	('GESTION', 'icon-phone-wave', 1);
-- ========================= SUBMENU ========================
-- INSERT INTO
-- 	`submenu` (`id_menu`, `nombre`, `url`, `estado`)
-- VALUES
-- 	(3, 'USUARIO', 'datatable_basic.php', 1);
-- INSERT INTO
-- 	`submenu` (`id_menu`, `nombre`, `url`, `estado`)
-- VALUES
-- 	(3, 'SUCURSAL', 'datatable_sucursal.php', 1);
-- INSERT INTO
-- 	`submenu` (`id_menu`, `nombre`, `url`, `estado`)
-- VALUES
-- 	(3, 'HORARIO', 'datatable_horario.php', 1);
-- INSERT INTO
-- 	`submenu` (`id_menu`, `nombre`, `url`, `estado`)
-- VALUES
-- 	(4, 'CARTERA', 'datatable_cartera.php', 1);
-- INSERT INTO
-- 	`submenu` (`id_menu`, `nombre`, `url`, `estado`)
-- VALUES
-- 	(4, 'CLIENTE', 'datatable_cliente.php', 1);
-- INSERT INTO
-- 	`submenu` (`id_menu`, `nombre`, `url`, `estado`)
-- VALUES
-- 	(4, 'MENU', 'datatable_menu.php', 1);
-- INSERT INTO
-- 	`submenu` (`id_menu`, `nombre`, `url`, `estado`)
-- VALUES
-- 	(5, 'ACCION', 'datatable_accion.php', 1);
-- INSERT INTO
-- 	`submenu` (`id_menu`, `nombre`, `url`, `estado`)
-- VALUES
-- 	(5, 'CATEGORIA', 'datatable_categoria.php', 1);
-- INSERT INTO
-- 	`submenu` (`id_menu`, `nombre`, `url`, `estado`)
-- VALUES
-- 	(5, 'EFECTO', 'datatable_efecto.php', 1);
-- INSERT INTO
-- 	`submenu` (`id_menu`, `nombre`, `url`, `estado`)
-- VALUES
-- 	(5, 'MOTIVO', 'datatable_motivo.php', 1);
-- INSERT INTO
-- 	`submenu` (`id_menu`, `nombre`, `url`, `estado`)
-- VALUES
-- 	(5, 'CONTACTO', 'datatable_contacto.php', 1);
-- INSERT INTO
-- 	`submenu` (`id_menu`, `nombre`, `url`, `estado`)
-- VALUES
-- 	(6, 'CAMPAÑA', 'datatable_campana.php', 1);
-- INSERT INTO
-- 	`submenu` (`id_menu`, `nombre`, `url`, `estado`)
-- VALUES
-- 	(6, 'PAGO', 'datatable_pago.php', 1);
-- INSERT INTO
-- 	`submenu` (`id_menu`, `nombre`, `url`, `estado`)
-- VALUES
-- 	(6, 'CUOTA', 'datatable_cuota.php', 1);
-- INSERT INTO
-- 	`submenu` (`id_menu`, `nombre`, `url`, `estado`)
-- VALUES
-- 	(6, 'TELEFONO', 'datatable_telefono.php', 1);
-- INSERT INTO
-- 	`submenu` (`id_menu`, `nombre`, `url`, `estado`)
-- VALUES
-- 	(6, 'DIRECCION', 'datatable_direccion.php', 1);
-- INSERT INTO
-- 	`submenu` (`id_menu`, `nombre`, `url`, `estado`)
-- VALUES
-- 	(6, 'INFOADC', 'datatable_infoadc.php', 0);
-- INSERT INTO
-- 	`submenu` (`id_menu`, `nombre`, `url`, `estado`)
-- VALUES
-- 	(6, 'TABLE', 'datatable_table.php', 1);
-- INSERT INTO
-- 	`submenu` (`id_menu`, `nombre`, `url`, `estado`)
-- VALUES
-- 	(7, 'MI BANDEJA', 'datatable_mi_bandeja.php', 1);
-- INSERT INTO
-- 	`submenu` (`id_menu`, `nombre`, `url`, `estado`)
-- VALUES
-- 	(4, 'FORMULARIO CX', 'formulario.php', 0);
-- =================================================================