-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2020-10-17 16:47:48
-- 服务器版本： 5.7.26
-- PHP 版本： 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `test`
--

-- --------------------------------------------------------

--
-- 表的结构 `prefix_ebcms_cms_category`
--

CREATE TABLE `prefix_ebcms_cms_category` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '节点ID',
  `pid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `type` varchar(20) NOT NULL DEFAULT 'list',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `alias` varchar(255) NOT NULL DEFAULT '' COMMENT '目录',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '关键字',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '简介',
  `page_num` int(10) UNSIGNED NOT NULL DEFAULT '20',
  `order_type` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `tpl_category` varchar(255) NOT NULL DEFAULT '' COMMENT '模板',
  `tpl_content` varchar(255) NOT NULL DEFAULT '' COMMENT '内容页模板',
  `priority` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
  `state` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '是否发布',
  `nav` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `redirect_uri` varchar(255) NOT NULL DEFAULT '' COMMENT '外部链接',
  `body` text,
  `filters` text NOT NULL,
  `fields` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='内容栏目表' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `prefix_ebcms_cms_content`
--

CREATE TABLE `prefix_ebcms_cms_content` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '节点ID',
  `category_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类id',
  `type` varchar(255) NOT NULL DEFAULT '' COMMENT '类型',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `cover` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '关键词',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '摘要',
  `body` text NOT NULL,
  `alias` varchar(255) NOT NULL DEFAULT '' COMMENT '文件名称',
  `tpl` varchar(255) NOT NULL DEFAULT '' COMMENT '模板',
  `click` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '点击量',
  `tags` varchar(255) NOT NULL DEFAULT '',
  `priority` tinyint(3) UNSIGNED NOT NULL DEFAULT '50',
  `top` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '操作时间',
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `state` tinyint(3) UNSIGNED NOT NULL DEFAULT '99' COMMENT '状态',
  `redirect_uri` varchar(255) NOT NULL DEFAULT '',
  `filter0` varchar(40) NOT NULL DEFAULT '',
  `filter1` varchar(40) NOT NULL DEFAULT '',
  `filter2` varchar(40) NOT NULL DEFAULT '',
  `filter3` varchar(40) NOT NULL DEFAULT '',
  `filter4` varchar(40) NOT NULL DEFAULT '',
  `filter5` varchar(40) NOT NULL DEFAULT ''
) ;

-- --------------------------------------------------------

--
-- 表的结构 `prefix_ebcms_cms_tag`
--

CREATE TABLE `prefix_ebcms_cms_tag` (
  `id` int(10) UNSIGNED NOT NULL,
  `content_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '内容ID',
  `tag` varchar(255) NOT NULL DEFAULT '' COMMENT '属性'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='内容属性表' ROW_FORMAT=COMPACT;

--
-- 转储表的索引
--

--
-- 表的索引 `prefix_ebcms_cms_category`
--
ALTER TABLE `prefix_ebcms_cms_category`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `prefix_ebcms_cms_content`
--
ALTER TABLE `prefix_ebcms_cms_content`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `list` (`category_id`,`state`,`id`) USING BTREE,
  ADD KEY `list2` (`state`,`id`) USING BTREE,
  ADD KEY `category_id` (`category_id`,`filter0`),
  ADD KEY `category_id_2` (`category_id`,`filter1`),
  ADD KEY `category_id_3` (`category_id`,`filter2`),
  ADD KEY `category_id_4` (`category_id`,`filter3`),
  ADD KEY `category_id_5` (`category_id`,`filter4`),
  ADD KEY `category_id_6` (`category_id`,`filter5`);
ALTER TABLE `prefix_ebcms_cms_content` ADD FULLTEXT KEY `testfulltext` (`title`,`keywords`,`description`,`tags`,`body`);

--
-- 表的索引 `prefix_ebcms_cms_tag`
--
ALTER TABLE `prefix_ebcms_cms_tag`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `prefix_ebcms_cms_category`
--
ALTER TABLE `prefix_ebcms_cms_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '节点ID';

--
-- 使用表AUTO_INCREMENT `prefix_ebcms_cms_content`
--
ALTER TABLE `prefix_ebcms_cms_content`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '节点ID';

--
-- 使用表AUTO_INCREMENT `prefix_ebcms_cms_tag`
--
ALTER TABLE `prefix_ebcms_cms_tag`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
