DROP DATABASE IF EXISTS `%DATABASE_NAME%`;
CREATE DATABASE IF NOT EXISTS `%DATABASE_NAME%` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `%DATABASE_NAME%`;


-- Volcando estructura para tabla %DATABASE_NAME%.%DATABASE_PREFIX%blog
DROP TABLE IF EXISTS `%DATABASE_PREFIX%blog`;
CREATE TABLE IF NOT EXISTS `%DATABASE_PREFIX%blog` (
  `uID` smallint(6) NOT NULL AUTO_INCREMENT,
  `uID_usuarios` smallint(6) NOT NULL,
  `uID_estados` tinyint(1) NOT NULL,
  `uID_blog_categorias` smallint(6) NOT NULL,
  `comentarios` tinyint(1) NOT NULL,
  `imagen` varchar(100) DEFAULT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_mod` datetime DEFAULT NULL,
  PRIMARY KEY (`uID`),
  KEY `FK_%DATABASE_PREFIX%blog_%DATABASE_PREFIX%usuarios` (`uID_usuarios`),
  KEY `FK_%DATABASE_PREFIX%blog_%DATABASE_PREFIX%estados` (`uID_estados`),
  KEY `FK_%DATABASE_PREFIX%blog_%DATABASE_PREFIX%blog_categorias` (`uID_blog_categorias`),
  KEY `FK_%DATABASE_PREFIX%blog_%DATABASE_PREFIX%estados_2` (`comentarios`),
  CONSTRAINT `FK_%DATABASE_PREFIX%blog_%DATABASE_PREFIX%blog_categorias` FOREIGN KEY (`uID_blog_categorias`) REFERENCES `%DATABASE_PREFIX%blog_categorias` (`uID`),
  CONSTRAINT `FK_%DATABASE_PREFIX%blog_%DATABASE_PREFIX%estados` FOREIGN KEY (`uID_estados`) REFERENCES `%DATABASE_PREFIX%estados` (`uID`),
  CONSTRAINT `FK_%DATABASE_PREFIX%blog_%DATABASE_PREFIX%estados_2` FOREIGN KEY (`comentarios`) REFERENCES `%DATABASE_PREFIX%estados` (`uID`),
  CONSTRAINT `FK_%DATABASE_PREFIX%blog_%DATABASE_PREFIX%usuarios` FOREIGN KEY (`uID_usuarios`) REFERENCES `%DATABASE_PREFIX%usuarios` (`uID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla %DATABASE_NAME%.%DATABASE_PREFIX%blog: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `%DATABASE_PREFIX%blog` DISABLE KEYS */;
/*!40000 ALTER TABLE `%DATABASE_PREFIX%blog` ENABLE KEYS */;


-- Volcando estructura para tabla %DATABASE_NAME%.%DATABASE_PREFIX%blog_categorias
DROP TABLE IF EXISTS `%DATABASE_PREFIX%blog_categorias`;
CREATE TABLE IF NOT EXISTS `%DATABASE_PREFIX%blog_categorias` (
  `uID` smallint(6) NOT NULL AUTO_INCREMENT,
  `texto` char(50) NOT NULL,
  PRIMARY KEY (`uID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla %DATABASE_NAME%.%DATABASE_PREFIX%blog_categorias: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `%DATABASE_PREFIX%blog_categorias` DISABLE KEYS */;
/*!40000 ALTER TABLE `%DATABASE_PREFIX%blog_categorias` ENABLE KEYS */;


-- Volcando estructura para tabla %DATABASE_NAME%.%DATABASE_PREFIX%blog_categorias_info
DROP TABLE IF EXISTS `%DATABASE_PREFIX%blog_categorias_info`;
CREATE TABLE IF NOT EXISTS `%DATABASE_PREFIX%blog_categorias_info` (
  `uID` smallint(6) NOT NULL AUTO_INCREMENT,
  `uID_blog_categorias` smallint(6) NOT NULL DEFAULT '0',
  `uID_idiomas` smallint(6) NOT NULL,
  `texto` char(50) NOT NULL,
  PRIMARY KEY (`uID`),
  UNIQUE KEY `uID_blog_categorias` (`uID_blog_categorias`,`uID_idiomas`),
  KEY `FK_%DATABASE_PREFIX%blog_categorias_info_%DATABASE_PREFIX%blog_categorias` (`uID_blog_categorias`),
  KEY `FK_%DATABASE_PREFIX%blog_categorias_info_%DATABASE_PREFIX%idiomas` (`uID_idiomas`),
  CONSTRAINT `FK_%DATABASE_PREFIX%blog_categorias_info_%DATABASE_PREFIX%blog_categorias` FOREIGN KEY (`uID_blog_categorias`) REFERENCES `%DATABASE_PREFIX%blog_categorias` (`uID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_%DATABASE_PREFIX%blog_categorias_info_%DATABASE_PREFIX%idiomas` FOREIGN KEY (`uID_idiomas`) REFERENCES `%DATABASE_PREFIX%idiomas` (`uID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla %DATABASE_NAME%.%DATABASE_PREFIX%blog_categorias_info: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `%DATABASE_PREFIX%blog_categorias_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `%DATABASE_PREFIX%blog_categorias_info` ENABLE KEYS */;


-- Volcando estructura para tabla %DATABASE_NAME%.%DATABASE_PREFIX%blog_galeria
DROP TABLE IF EXISTS `%DATABASE_PREFIX%blog_galeria`;
CREATE TABLE IF NOT EXISTS `%DATABASE_PREFIX%blog_galeria` (
  `uID` smallint(6) NOT NULL AUTO_INCREMENT,
  `uID_blog` smallint(6) NOT NULL,
  `uID_estados` tinyint(1) NOT NULL,
  `tipo` enum('video','image') DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `video` varchar(200) NOT NULL,
  `orden` tinyint(4) NOT NULL,
  PRIMARY KEY (`uID`),
  KEY `FK_%DATABASE_PREFIX%blog_galeria_%DATABASE_PREFIX%blog` (`uID_blog`),
  KEY `FK_%DATABASE_PREFIX%blog_galeria_%DATABASE_PREFIX%estados` (`uID_estados`),
  CONSTRAINT `FK_%DATABASE_PREFIX%blog_galeria_%DATABASE_PREFIX%blog` FOREIGN KEY (`uID_blog`) REFERENCES `%DATABASE_PREFIX%blog` (`uID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_%DATABASE_PREFIX%blog_galeria_%DATABASE_PREFIX%estados` FOREIGN KEY (`uID_estados`) REFERENCES `%DATABASE_PREFIX%estados` (`uID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla %DATABASE_NAME%.%DATABASE_PREFIX%blog_galeria: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `%DATABASE_PREFIX%blog_galeria` DISABLE KEYS */;
/*!40000 ALTER TABLE `%DATABASE_PREFIX%blog_galeria` ENABLE KEYS */;


-- Volcando estructura para tabla %DATABASE_NAME%.%DATABASE_PREFIX%blog_info
DROP TABLE IF EXISTS `%DATABASE_PREFIX%blog_info`;
CREATE TABLE IF NOT EXISTS `%DATABASE_PREFIX%blog_info` (
  `uID` smallint(6) NOT NULL AUTO_INCREMENT,
  `uID_idiomas` smallint(6) NOT NULL,
  `uID_blog` smallint(6) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `texto` text NOT NULL,
  PRIMARY KEY (`uID`),
  UNIQUE KEY `uID_idiomas` (`uID_idiomas`,`uID_blog`),
  KEY `FK_%DATABASE_PREFIX%blog_entradas_%DATABASE_PREFIX%blog` (`uID_blog`),
  CONSTRAINT `FK_%DATABASE_PREFIX%blog_entradas_%DATABASE_PREFIX%blog` FOREIGN KEY (`uID_blog`) REFERENCES `%DATABASE_PREFIX%blog` (`uID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_%DATABASE_PREFIX%blog_entradas_%DATABASE_PREFIX%idiomas` FOREIGN KEY (`uID_idiomas`) REFERENCES `%DATABASE_PREFIX%idiomas` (`uID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla %DATABASE_NAME%.%DATABASE_PREFIX%blog_info: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `%DATABASE_PREFIX%blog_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `%DATABASE_PREFIX%blog_info` ENABLE KEYS */;


-- Volcando estructura para tabla %DATABASE_NAME%.%DATABASE_PREFIX%blog_settings
DROP TABLE IF EXISTS `%DATABASE_PREFIX%blog_settings`;
CREATE TABLE IF NOT EXISTS `%DATABASE_PREFIX%blog_settings` (
  `key` char(50) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Volcando datos para la tabla %DATABASE_NAME%.%DATABASE_PREFIX%blog_settings: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `%DATABASE_PREFIX%blog_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `%DATABASE_PREFIX%blog_settings` ENABLE KEYS */;


-- Volcando estructura para tabla %DATABASE_NAME%.%DATABASE_PREFIX%emails
DROP TABLE IF EXISTS `%DATABASE_PREFIX%emails`;
CREATE TABLE IF NOT EXISTS `%DATABASE_PREFIX%emails` (
  `uID` smallint(6) NOT NULL AUTO_INCREMENT,
  `uID_estados` tinyint(1) NOT NULL,
  `uID_emails_tipos` varchar(255) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `oculto` tinyint(1) NOT NULL,
  PRIMARY KEY (`uID`),
  UNIQUE KEY `email` (`email`),
  KEY `FK_%DATABASE_PREFIX%emails_%DATABASE_PREFIX%estados` (`uID_estados`),
  CONSTRAINT `FK_%DATABASE_PREFIX%emails_%DATABASE_PREFIX%estados` FOREIGN KEY (`uID_estados`) REFERENCES `%DATABASE_PREFIX%estados` (`uID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla %DATABASE_NAME%.%DATABASE_PREFIX%emails: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `%DATABASE_PREFIX%emails` DISABLE KEYS */;
/*!40000 ALTER TABLE `%DATABASE_PREFIX%emails` ENABLE KEYS */;


-- Volcando estructura para tabla %DATABASE_NAME%.%DATABASE_PREFIX%emails_logs
DROP TABLE IF EXISTS `%DATABASE_PREFIX%emails_logs`;
CREATE TABLE IF NOT EXISTS `%DATABASE_PREFIX%emails_logs` (
  `uID` bigint(14) NOT NULL AUTO_INCREMENT,
  `uID_emails_tipos` smallint(6) NOT NULL,
  `date` datetime NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text,
  `emails` text,
  `status` char(50) DEFAULT NULL,
  `debug` text,
  PRIMARY KEY (`uID`),
  KEY `FK_%DATABASE_PREFIX%emails_logs_%DATABASE_PREFIX%emails_tipos` (`uID_emails_tipos`),
  CONSTRAINT `FK_%DATABASE_PREFIX%emails_logs_%DATABASE_PREFIX%emails_tipos` FOREIGN KEY (`uID_emails_tipos`) REFERENCES `%DATABASE_PREFIX%emails_tipos` (`uID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla %DATABASE_NAME%.%DATABASE_PREFIX%emails_logs: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `%DATABASE_PREFIX%emails_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `%DATABASE_PREFIX%emails_logs` ENABLE KEYS */;


-- Volcando estructura para tabla %DATABASE_NAME%.%DATABASE_PREFIX%emails_newsletter
DROP TABLE IF EXISTS `%DATABASE_PREFIX%emails_newsletter`;
CREATE TABLE IF NOT EXISTS `%DATABASE_PREFIX%emails_newsletter` (
  `uID` smallint(6) NOT NULL AUTO_INCREMENT,
  `uID_estados` tinyint(1) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `token` char(8) NOT NULL,
  `email` varchar(100) NOT NULL,
  `servicio` char(50) NOT NULL,
  PRIMARY KEY (`uID`),
  UNIQUE KEY `email` (`email`,`servicio`),
  UNIQUE KEY `token` (`token`),
  KEY `FK_%DATABASE_PREFIX%emails_newsletter_%DATABASE_PREFIX%estados` (`uID_estados`),
  CONSTRAINT `FK_%DATABASE_PREFIX%emails_newsletter_%DATABASE_PREFIX%estados` FOREIGN KEY (`uID_estados`) REFERENCES `%DATABASE_PREFIX%estados` (`uID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla %DATABASE_NAME%.%DATABASE_PREFIX%emails_newsletter: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `%DATABASE_PREFIX%emails_newsletter` DISABLE KEYS */;
/*!40000 ALTER TABLE `%DATABASE_PREFIX%emails_newsletter` ENABLE KEYS */;


-- Volcando estructura para tabla %DATABASE_NAME%.%DATABASE_PREFIX%emails_templates
DROP TABLE IF EXISTS `%DATABASE_PREFIX%emails_templates`;
CREATE TABLE IF NOT EXISTS `%DATABASE_PREFIX%emails_templates` (
  `uID` smallint(6) NOT NULL AUTO_INCREMENT,
  `uID_idiomas` smallint(6) NOT NULL,
  `uID_emails_tipos` smallint(6) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`uID`),
  UNIQUE KEY `uID_idiomas` (`uID_idiomas`,`uID_emails_tipos`),
  KEY `FK_%DATABASE_PREFIX%emails_templates_%DATABASE_PREFIX%emails_tipos` (`uID_emails_tipos`),
  CONSTRAINT `FK_%DATABASE_PREFIX%emails_templates_%DATABASE_PREFIX%emails_tipos` FOREIGN KEY (`uID_emails_tipos`) REFERENCES `%DATABASE_PREFIX%emails_tipos` (`uID`),
  CONSTRAINT `FK_%DATABASE_PREFIX%emails_templates_%DATABASE_PREFIX%idiomas` FOREIGN KEY (`uID_idiomas`) REFERENCES `%DATABASE_PREFIX%idiomas` (`uID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla %DATABASE_NAME%.%DATABASE_PREFIX%emails_templates: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `%DATABASE_PREFIX%emails_templates` DISABLE KEYS */;
/*!40000 ALTER TABLE `%DATABASE_PREFIX%emails_templates` ENABLE KEYS */;


-- Volcando estructura para tabla %DATABASE_NAME%.%DATABASE_PREFIX%emails_tipos
DROP TABLE IF EXISTS `%DATABASE_PREFIX%emails_tipos`;
CREATE TABLE IF NOT EXISTS `%DATABASE_PREFIX%emails_tipos` (
  `uID` smallint(6) NOT NULL AUTO_INCREMENT,
  `uID_estados` tinyint(1) NOT NULL,
  `texto` char(50) NOT NULL,
  `variables` text,
  PRIMARY KEY (`uID`),
  KEY `FK_%DATABASE_PREFIX%emails_tipos_%DATABASE_PREFIX%estados` (`uID_estados`),
  CONSTRAINT `FK_%DATABASE_PREFIX%emails_tipos_%DATABASE_PREFIX%estados` FOREIGN KEY (`uID_estados`) REFERENCES `%DATABASE_PREFIX%estados` (`uID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla %DATABASE_NAME%.%DATABASE_PREFIX%emails_tipos: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `%DATABASE_PREFIX%emails_tipos` DISABLE KEYS */;
INSERT INTO `%DATABASE_PREFIX%emails_tipos` (`uID`, `uID_estados`, `texto`, `variables`) VALUES
	(1, 1, '_contact_form_', '{date},{copyright},{name},{email},{phone},{message}');
/*!40000 ALTER TABLE `%DATABASE_PREFIX%emails_tipos` ENABLE KEYS */;


-- Volcando estructura para tabla %DATABASE_NAME%.%DATABASE_PREFIX%estados
DROP TABLE IF EXISTS `%DATABASE_PREFIX%estados`;
CREATE TABLE IF NOT EXISTS `%DATABASE_PREFIX%estados` (
  `uID` tinyint(1) NOT NULL AUTO_INCREMENT,
  `texto` char(20) NOT NULL,
  PRIMARY KEY (`uID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla %DATABASE_NAME%.%DATABASE_PREFIX%estados: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `%DATABASE_PREFIX%estados` DISABLE KEYS */;
INSERT INTO `%DATABASE_PREFIX%estados` (`uID`, `texto`) VALUES
	(0, '_disabled_'),
	(1, '_enabled_');
/*!40000 ALTER TABLE `%DATABASE_PREFIX%estados` ENABLE KEYS */;

-- Volcando estructura para tabla %DATABASE_NAME%.%DATABASE_PREFIX%idiomas
DROP TABLE IF EXISTS `%DATABASE_PREFIX%idiomas`;
CREATE TABLE IF NOT EXISTS `%DATABASE_PREFIX%idiomas` (
  `uID` smallint(6) NOT NULL AUTO_INCREMENT,
  `uID_estados` tinyint(1) NOT NULL,
  `code` char(2) NOT NULL,
  `text` varchar(50) NOT NULL,
  `show_keys` tinyint(1) NOT NULL,
  `defecto` tinyint(1) NOT NULL,
  `order` tinyint(2) NOT NULL,
  PRIMARY KEY (`uID`),
  UNIQUE KEY `abbr` (`code`),
  KEY `FK_%DATABASE_PREFIX%idiomas_%DATABASE_PREFIX%estados` (`uID_estados`),
  CONSTRAINT `FK_%DATABASE_PREFIX%idiomas_%DATABASE_PREFIX%estados` FOREIGN KEY (`uID_estados`) REFERENCES `%DATABASE_PREFIX%estados` (`uID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla %DATABASE_NAME%.%DATABASE_PREFIX%idiomas: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `%DATABASE_PREFIX%idiomas` DISABLE KEYS */;
INSERT INTO `%DATABASE_PREFIX%idiomas` (`uID`, `uID_estados`, `code`, `text`, `show_keys`, `defecto`, `order`) VALUES
	(1, 1, 'es', 'Español', 0, 1, 0),
	(2, 1, 'en', 'English', 0, 0, 1);
/*!40000 ALTER TABLE `%DATABASE_PREFIX%idiomas` ENABLE KEYS */;


-- Volcando estructura para tabla %DATABASE_NAME%.%DATABASE_PREFIX%idiomas_traductor
DROP TABLE IF EXISTS `%DATABASE_PREFIX%idiomas_traductor`;
CREATE TABLE IF NOT EXISTS `%DATABASE_PREFIX%idiomas_traductor` (
  `uID` bigint(20) NOT NULL AUTO_INCREMENT,
  `uID_idiomas` smallint(6) NOT NULL,
  `key` varchar(250) NOT NULL,
  `texto` text,
  `fecha_actualizacion` datetime DEFAULT NULL,
  PRIMARY KEY (`uID`),
  UNIQUE KEY `key` (`key`,`uID_idiomas`),
  KEY `FK_%DATABASE_PREFIX%traductor_%DATABASE_PREFIX%idiomas` (`uID_idiomas`),
  CONSTRAINT `FK_%DATABASE_PREFIX%idiomas_traductor_%DATABASE_PREFIX%idiomas` FOREIGN KEY (`uID_idiomas`) REFERENCES `%DATABASE_PREFIX%idiomas` (`uID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla %DATABASE_NAME%.%DATABASE_PREFIX%idiomas_traductor: ~894 rows (aproximadamente)
/*!40000 ALTER TABLE `%DATABASE_PREFIX%idiomas_traductor` DISABLE KEYS */;
/*!40000 ALTER TABLE `%DATABASE_PREFIX%idiomas_traductor` ENABLE KEYS */;


-- Volcando estructura para tabla %DATABASE_NAME%.%DATABASE_PREFIX%menus
DROP TABLE IF EXISTS `%DATABASE_PREFIX%menus`;
CREATE TABLE IF NOT EXISTS `%DATABASE_PREFIX%menus` (
  `uID` smallint(6) NOT NULL AUTO_INCREMENT,
  `uID_estados` tinyint(1) NOT NULL,
  `template` varchar(100) NOT NULL,
  `tipo` enum('title','link') NOT NULL,
  `texto` varchar(50) NOT NULL,
  `parent` smallint(6) NOT NULL,
  `on_navbar` tinyint(1) NOT NULL DEFAULT '0',
  `on_footer` tinyint(1) NOT NULL DEFAULT '0',
  `orden` tinyint(1) NOT NULL,
  `external_link` text,
  `attributes` text,
  PRIMARY KEY (`uID`),
  KEY `FK_%DATABASE_PREFIX%menus_%DATABASE_PREFIX%estados` (`uID_estados`),
  CONSTRAINT `FK_%DATABASE_PREFIX%menus_%DATABASE_PREFIX%estados` FOREIGN KEY (`uID_estados`) REFERENCES `%DATABASE_PREFIX%estados` (`uID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla %DATABASE_NAME%.%DATABASE_PREFIX%menus: ~7 rows (aproximadamente)
/*!40000 ALTER TABLE `%DATABASE_PREFIX%menus` DISABLE KEYS */;
INSERT INTO `%DATABASE_PREFIX%menus` (`uID`, `uID_estados`, `template`, `tipo`, `texto`, `parent`, `on_navbar`, `on_footer`, `orden`, `external_link`, `attributes`) VALUES
	(1, 0, '1_columns', 'link', '1 columns', 12, 1, 1, 1, NULL, NULL),
	(2, 0, '2_columns', 'link', '2 colmuns', 8, 1, 1, 2, NULL, NULL),
	(3, 0, '3_columns', 'link', '3 columns', 9, 1, 1, 2, NULL, NULL),
	(4, 0, '1_columns_sidebar_right', 'link', '1 columns sibar right', 12, 1, 1, 2, NULL, NULL),
	(5, 0, '1_columns_sidebar_left', 'link', '1 columns sibar left', 12, 1, 1, 2, NULL, NULL),
	(6, 0, '1_columns_sidebar_left', 'title', '1 Columns', 1, 1, 1, 2, NULL, NULL),
	(7, 0, '1_columns_slider', 'link', '1 Columns slider', 12, 1, 1, 2, NULL, NULL);
/*!40000 ALTER TABLE `%DATABASE_PREFIX%menus` ENABLE KEYS */;


-- Volcando estructura para tabla %DATABASE_NAME%.%DATABASE_PREFIX%system_settings
DROP TABLE IF EXISTS `%DATABASE_PREFIX%system_settings`;
CREATE TABLE IF NOT EXISTS `%DATABASE_PREFIX%system_settings` (
  `key` char(50) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla %DATABASE_NAME%.%DATABASE_PREFIX%system_settings: ~42 rows (aproximadamente)
/*!40000 ALTER TABLE `%DATABASE_PREFIX%system_settings` DISABLE KEYS */;
INSERT INTO `%DATABASE_PREFIX%system_settings` (`key`, `value`) VALUES
	('_contact_address_', ''),
	('_contact_email_', ''),
	('_contact_map_icon_', ''),
	('_contact_map_latitude_', ''),
	('_contact_map_longitude_', ''),
	('_contact_phone_', ''),
	('_contact_title_', ''),
	('_mail_charset_', 'utf-8'),
	('_mail_from_email_', ''),
	('_mail_from_name_', ''),
	('_mail_mailpath_', ''),
	('_mail_mailtype_', 'html'),
	('_mail_protocol_', 'mail'),
	('_mail_smtp_host_', 'localhost'),
	('_mail_smtp_pass_', 'test'),
	('_mail_smtp_port_', 'test'),
	('_mail_smtp_user_', 'test'),
	('_seo_description_', ''),
	('_seo_google_analytics_', ''),
	('_seo_keywords_', ''),
	('_seo_title_', ''),
	('_social_facebook_', ''),
	('_social_google_plus_', ''),
	('_social_skype_', ''),
	('_social_twitter_', ''),
	('_system_copyright_', '© 2015'),
	('_system_image_not_available_', 'no_image.png'),
	('_system_image_watermark_', 'watermark.png'),
	('_system_image_watermark_position_', '5'),
	('_system_image_watermark_status_', '0'),
	('_system_image_watermark_transparency_', '70'),
	('_system_theme_backend_', 'default'),
	('_system_theme_backend_style_', 'skin-black fixed'),
	('_system_theme_frontend_', 'default'),
	('_user_forgot_enabled_', '0'),
	('_user_locked_status_', '1'),
	('_user_locked_timeout_', '30'),
	('_user_login_captcha_', '0'),
	('_user_login_enabled_', '1'),
	('_user_login_max_attemps_', '5'),
	('_user_register_automatic_', '0'),
	('_user_register_enabled_', '0');
/*!40000 ALTER TABLE `%DATABASE_PREFIX%system_settings` ENABLE KEYS */;


-- Volcando estructura para tabla %DATABASE_NAME%.%DATABASE_PREFIX%usuarios
DROP TABLE IF EXISTS `%DATABASE_PREFIX%usuarios`;
CREATE TABLE IF NOT EXISTS `%DATABASE_PREFIX%usuarios` (
  `uID` smallint(6) NOT NULL AUTO_INCREMENT,
  `uID_idiomas` smallint(6) NOT NULL,
  `uID_permisos` tinyint(1) NOT NULL,
  `uID_estados` tinyint(1) NOT NULL,
  `nombre` char(32) NOT NULL,
  `apellido` char(32) NOT NULL,
  `email` varchar(70) NOT NULL,
  `password` varchar(200) NOT NULL,
  `register_token` char(40) NOT NULL,
  `register_status` tinyint(1) NOT NULL,
  `remember_token` char(40) DEFAULT NULL,
  `forgot_token` char(40) DEFAULT NULL,
  `forgot_fecha` datetime DEFAULT NULL,
  `forgot_status` tinyint(1) DEFAULT NULL,
  `locked_status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`uID`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `token` (`register_token`),
  KEY `FK_%DATABASE_PREFIX%usuarios_%DATABASE_PREFIX%idiomas` (`uID_idiomas`),
  KEY `FK_%DATABASE_PREFIX%usuarios_%DATABASE_PREFIX%permisos` (`uID_permisos`),
  KEY `FK_%DATABASE_PREFIX%usuarios_%DATABASE_PREFIX%estados` (`uID_estados`),
  CONSTRAINT `FK_%DATABASE_PREFIX%usuarios_%DATABASE_PREFIX%estados` FOREIGN KEY (`uID_estados`) REFERENCES `%DATABASE_PREFIX%estados` (`uID`),
  CONSTRAINT `FK_%DATABASE_PREFIX%usuarios_%DATABASE_PREFIX%idiomas` FOREIGN KEY (`uID_idiomas`) REFERENCES `%DATABASE_PREFIX%idiomas` (`uID`),
  CONSTRAINT `FK_%DATABASE_PREFIX%usuarios_%DATABASE_PREFIX%usuarios_permisos` FOREIGN KEY (`uID_permisos`) REFERENCES `%DATABASE_PREFIX%usuarios_permisos` (`uID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla %DATABASE_NAME%.%DATABASE_PREFIX%usuarios: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `%DATABASE_PREFIX%usuarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `%DATABASE_PREFIX%usuarios` ENABLE KEYS */;


-- Volcando estructura para tabla %DATABASE_NAME%.%DATABASE_PREFIX%usuarios_info
DROP TABLE IF EXISTS `%DATABASE_PREFIX%usuarios_info`;
CREATE TABLE IF NOT EXISTS `%DATABASE_PREFIX%usuarios_info` (
  `uID_usuarios` smallint(6) NOT NULL,
  `cargo` varchar(100) DEFAULT NULL,
  `vat` char(40) DEFAULT NULL,
  `phone` char(30) DEFAULT NULL,
  `mobile_phone` char(30) DEFAULT NULL,
  `fax` char(30) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `description` text,
  `avatar` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`uID_usuarios`),
  CONSTRAINT `FK_%DATABASE_PREFIX%usuarios_info_%DATABASE_PREFIX%usuarios` FOREIGN KEY (`uID_usuarios`) REFERENCES `%DATABASE_PREFIX%usuarios` (`uID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla %DATABASE_NAME%.%DATABASE_PREFIX%usuarios_info: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `%DATABASE_PREFIX%usuarios_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `%DATABASE_PREFIX%usuarios_info` ENABLE KEYS */;


-- Volcando estructura para tabla %DATABASE_NAME%.%DATABASE_PREFIX%usuarios_logs
DROP TABLE IF EXISTS `%DATABASE_PREFIX%usuarios_logs`;
CREATE TABLE IF NOT EXISTS `%DATABASE_PREFIX%usuarios_logs` (
  `uID_usuarios` smallint(6) NOT NULL,
  `uID_usuarios_action` smallint(6) DEFAULT NULL,
  `fecha_register` datetime NOT NULL,
  `fecha_register_token` datetime DEFAULT NULL,
  `fecha_forgot` datetime DEFAULT NULL,
  `fecha_forgot_token` datetime DEFAULT NULL,
  `fecha_login` datetime DEFAULT NULL,
  `fecha_login_remember` datetime DEFAULT NULL,
  `fecha_login_locked` datetime DEFAULT NULL,
  `fecha_login_admin` datetime DEFAULT NULL,
  `fecha_mod` datetime DEFAULT NULL,
  `fecha_mod_password` datetime DEFAULT NULL,
  `fecha_mod_profile` datetime DEFAULT NULL,
  `fecha_mod_profile_info` datetime DEFAULT NULL,
  `fecha_mod_status` datetime DEFAULT NULL,
  `fecha_mod_permissions` datetime DEFAULT NULL,
  PRIMARY KEY (`uID_usuarios`),
  CONSTRAINT `FK_%DATABASE_PREFIX%usuarios_logs_%DATABASE_PREFIX%usuarios` FOREIGN KEY (`uID_usuarios`) REFERENCES `%DATABASE_PREFIX%usuarios` (`uID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla %DATABASE_NAME%.%DATABASE_PREFIX%usuarios_logs: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `%DATABASE_PREFIX%usuarios_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `%DATABASE_PREFIX%usuarios_logs` ENABLE KEYS */;


-- Volcando estructura para tabla %DATABASE_NAME%.%DATABASE_PREFIX%usuarios_permisos
DROP TABLE IF EXISTS `%DATABASE_PREFIX%usuarios_permisos`;
CREATE TABLE IF NOT EXISTS `%DATABASE_PREFIX%usuarios_permisos` (
  `uID` tinyint(1) NOT NULL AUTO_INCREMENT,
  `texto` char(20) NOT NULL,
  `class` char(20) NOT NULL,
  PRIMARY KEY (`uID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla %DATABASE_NAME%.%DATABASE_PREFIX%usuarios_permisos: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `%DATABASE_PREFIX%usuarios_permisos` DISABLE KEYS */;
INSERT INTO `%DATABASE_PREFIX%usuarios_permisos` (`uID`, `texto`, `class`) VALUES
	(1, '_client_', 'default'),
	(3, '_employee_', 'info'),
	(4, '_manager_', 'primary'),
	(5, '_admin_', 'danger');
/*!40000 ALTER TABLE `%DATABASE_PREFIX%usuarios_permisos` ENABLE KEYS */;


-- Volcando estructura para tabla %DATABASE_NAME%.%DATABASE_PREFIX%usuarios_permisos_table
DROP TABLE IF EXISTS `%DATABASE_PREFIX%usuarios_permisos_table`;
CREATE TABLE IF NOT EXISTS `%DATABASE_PREFIX%usuarios_permisos_table` (
  `uID_permisos` tinyint(1) DEFAULT NULL,
  `uID_estados` tinyint(1) DEFAULT NULL,
  `Controller` enum('Dashboard','Emails','Helper','Languages','System_settings','Users','User','Bloger','Gallery') DEFAULT NULL,
  UNIQUE KEY `uID_permisos` (`uID_permisos`,`Controller`),
  KEY `FK_%DATABASE_PREFIX%usuarios_permisos_table_%DATABASE_PREFIX%estados` (`uID_estados`),
  CONSTRAINT `FK_%DATABASE_PREFIX%usuarios_permisos_table_%DATABASE_PREFIX%estados` FOREIGN KEY (`uID_estados`) REFERENCES `%DATABASE_PREFIX%estados` (`uID`),
  CONSTRAINT `FK_%DATABASE_PREFIX%usuarios_permisos_table_%DATABASE_PREFIX%usuarios_permisos` FOREIGN KEY (`uID_permisos`) REFERENCES `%DATABASE_PREFIX%usuarios_permisos` (`uID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla %DATABASE_NAME%.%DATABASE_PREFIX%usuarios_permisos_table: ~16 rows (aproximadamente)
/*!40000 ALTER TABLE `%DATABASE_PREFIX%usuarios_permisos_table` DISABLE KEYS */;
INSERT INTO `%DATABASE_PREFIX%usuarios_permisos_table` (`uID_permisos`, `uID_estados`, `Controller`) VALUES
	(5, 1, 'Languages'),
	(5, 1, 'Helper'),
	(5, 1, 'System_settings'),
	(5, 1, 'Users'),
	(4, 1, 'Emails'),
	(4, 1, 'System_settings'),
	(4, 1, 'Helper'),
	(5, 0, 'Bloger'),
	(4, 0, 'Bloger'),
	(4, 1, 'Languages'),
	(4, 1, 'Users'),
	(5, 1, 'Emails'),
	(5, 1, 'Dashboard'),
	(4, 1, 'User'),
	(5, 1, 'User');
/*!40000 ALTER TABLE `%DATABASE_PREFIX%usuarios_permisos_table` ENABLE KEYS */;


-- Volcando estructura para tabla %DATABASE_NAME%.%DATABASE_PREFIX%usuarios_sessions
DROP TABLE IF EXISTS `%DATABASE_PREFIX%usuarios_sessions`;
CREATE TABLE IF NOT EXISTS `%DATABASE_PREFIX%usuarios_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ci_sessions_id_ip` (`id`,`ip_address`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla %DATABASE_NAME%.%DATABASE_PREFIX%usuarios_sessions: ~159 rows (aproximadamente)
/*!40000 ALTER TABLE `%DATABASE_PREFIX%usuarios_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `%DATABASE_PREFIX%usuarios_sessions` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
