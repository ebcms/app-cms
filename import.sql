CREATE TABLE `prefix_ebcms_cms_category` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '节点ID',
 `pid` int(10) unsigned NOT NULL DEFAULT '0',
 `type` varchar(20) NOT NULL DEFAULT 'list',
 `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
 `alias` varchar(255) NOT NULL DEFAULT '' COMMENT '目录',
 `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '关键字',
 `description` varchar(255) NOT NULL DEFAULT '' COMMENT '简介',
 `page_num` int(10) unsigned NOT NULL DEFAULT '20',
 `tpl_category` varchar(255) NOT NULL DEFAULT '' COMMENT '模板',
 `tpl_content` varchar(255) NOT NULL DEFAULT '' COMMENT '内容页模板',
 `priority` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
 `state` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否发布',
 `nav` tinyint(3) unsigned NOT NULL DEFAULT '1',
 `redirect_uri` varchar(255) NOT NULL DEFAULT '' COMMENT '外部链接',
 `body` text,
 `filters` text NOT NULL,
 `fields` text NOT NULL,
 PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='内容栏目表';
CREATE TABLE `prefix_ebcms_cms_content` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '节点ID',
 `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分类id',
 `type` varchar(255) NOT NULL DEFAULT '' COMMENT '类型',
 `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
 `cover` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
 `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '关键词',
 `description` varchar(255) NOT NULL DEFAULT '' COMMENT '摘要',
 `body` text NOT NULL,
 `extra` text NOT NULL,
 `alias` varchar(255) NOT NULL DEFAULT '' COMMENT '文件名称',
 `tpl` varchar(255) NOT NULL DEFAULT '' COMMENT '模板',
 `click` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击量',
 `tags` varchar(255) NOT NULL DEFAULT '',
 `top` tinyint(3) unsigned NOT NULL DEFAULT '0',
 `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '操作时间',
 `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
 `state` tinyint(3) unsigned NOT NULL DEFAULT '99' COMMENT '状态',
 `redirect_uri` varchar(255) NOT NULL DEFAULT '',
 `filter0` varchar(40) NOT NULL DEFAULT '',
 `filter1` varchar(40) NOT NULL DEFAULT '',
 `filter2` varchar(40) NOT NULL DEFAULT '',
 `filter3` varchar(40) NOT NULL DEFAULT '',
 `filter4` varchar(40) NOT NULL DEFAULT '',
 `filter5` varchar(40) NOT NULL DEFAULT '',
 PRIMARY KEY (`id`) USING BTREE,
 KEY `list` (`category_id`,`state`,`id`) USING BTREE,
 KEY `list2` (`state`,`id`) USING BTREE,
 KEY `category_id` (`category_id`,`filter0`),
 KEY `category_id_2` (`category_id`,`filter1`),
 KEY `category_id_3` (`category_id`,`filter2`),
 KEY `category_id_4` (`category_id`,`filter3`),
 KEY `category_id_5` (`category_id`,`filter4`),
 KEY `category_id_6` (`category_id`,`filter5`),
 FULLTEXT KEY `testfulltext` (`title`,`keywords`,`description`,`tags`,`body`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='内容基本表';
CREATE TABLE `prefix_ebcms_cms_tag` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `content_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '内容ID',
 `tag` varchar(255) NOT NULL DEFAULT '' COMMENT '属性',
 PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='内容属性表';