/* Add new column project_id in qcuploadinfo table to fetch data on id basis. */

ALTER TABLE `qcuploadinfo` ADD `project_id` INT(11) NOT NULL FIRST;

/* To create indexing on project_id column in qcuploadinfo table */

ALTER TABLE `qcuploadinfo` ADD INDEX(`project_id`);

ALTER TABLE `qcuploadinfo` ADD INDEX(`bugstatus`);

/* To create indexing on pindatabaseid column in project master table*/

ALTER TABLE `projectmaster` ADD INDEX(`pindatabaseid`);

/* To create indexing on bcat column in qcuploadinfo table*/
ALTER TABLE `qcuploadinfo` ADD INDEX(`bcat`);


ALTER TABLE `lmsblob` ADD INDEX(`reqid`);
ALTER TABLE `lmsblob` ADD INDEX(`dev`);
ALTER TABLE `lmsblob` ADD INDEX(`build`);
ALTER TABLE `lmsblob` ADD INDEX(`type`);
ALTER TABLE `lmsblob` ADD INDEX(`priority`);
ALTER TABLE `lmsblob` ADD INDEX(`severity`);
ALTER TABLE `lmsblob` ADD INDEX(`btype`);
ALTER TABLE `lmsblob` ADD INDEX(`module`);
ALTER TABLE `lmsblob` ADD INDEX(`submodule`);

ALTER TABLE `projecttask` ADD INDEX(`id`);

ALTER TABLE `qcreq` ADD INDEX(`id`);

ALTER TABLE `blobt` ADD `project_id` INT(11) NULL AFTER `reviewer`;

ALTER TABLE `blobt` ADD INDEX(`project_id`);

ALTER TABLE `blobt` ADD INDEX(`cat`);

ALTER TABLE `blobt` ADD INDEX(`status`);

ALTER TABLE `blobt` ADD INDEX(`reviewee`);
ALTER TABLE `blobt` ADD INDEX(`reviewer`);

ALTER TABLE `tbl_functional_review` ADD `project_id` INT(11) NULL AFTER `id`;

ALTER TABLE `tbl_functional_review` ADD INDEX(`project_id`);

ALTER TABLE `actionitem` ADD `project_id` INT(11) NULL FIRST;

ALTER TABLE `actionitem` ADD INDEX(`project_id`);


ALTER TABLE `projectmaster` ADD `is_archive` TINYINT(1) NOT NULL DEFAULT '0' AFTER `scmtwo`;

ALTER TABLE `qcuploadinfo` CHANGE `module` `module` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

ALTER TABLE `qcuploadinfo` ADD `chd_id` INT(11) NOT NULL AFTER `project_id`;

ALTER TABLE `qcuploadinfo` ADD INDEX(`chd_id`);

ALTER TABLE `tbl_functional_review` ADD `reject_course` TINYINT(1) NOT NULL DEFAULT '0' AFTER `course_level`;

ALTER TABLE `tbl_functional_review` ADD `phase_closed` TINYINT(1) NOT NULL DEFAULT '0' AFTER `reject_course`, ADD `out_sourced` TINYINT(1) NOT NULL DEFAULT '0' AFTER `phase_closed`;

ALTER TABLE `tbl_functional_review` ADD `statusupdate` VARCHAR(50) NULL AFTER `chdreleasedate`;

ALTER TABLE `projectmaster` ADD UNIQUE(`pin`);

-------------------------------- 22/12/2016 ---------------------------------------
ALTER TABLE `qcuploadinfo` ADD `bscat` VARCHAR(255) NOT NULL AFTER `bcat`;
ALTER TABLE `qcuploadinfo` ADD `function` VARCHAR(255) NOT NULL AFTER `coursestatus`;
-------------------------------- 28/12/2016 ---------------------------------------
ALTER TABLE `tbl_functional_review` CHANGE `developers` `developers_id` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `tbl_functional_review` CHANGE `developers_id` `developers_id` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE `tbl_functional_review` ADD `developers_media` TEXT NULL AFTER `developers_id`, ADD `developers_tech` TEXT NULL AFTER `developers_media`;

------------------------------------------------------11/1/2017---------------------------------------------------------------------------------------------
ALTER TABLE `tbl_functional_review` ADD `slidecount` INT(6) NOT NULL AFTER `pagecount`;

-------------------------------------------------------17/9/2017---------------------------------------------------------------------------------------------
ALTER TABLE `blobt` ADD INDEX(`creationDate`);
ALTER TABLE `tbl_sbreview` ADD `attachment` VARCHAR(500) NULL AFTER `review_submit_date`;

-------------------------------------------------------25/9/2017---------------------------------------------------------------------------------------------
ALTER TABLE `projectmaster` ADD `dev13` VARCHAR(255) NULL AFTER `dev12`;
ALTER TABLE `projectmaster` ADD `dev14` VARCHAR(255) NULL AFTER `dev13`;
ALTER TABLE `projectmaster` ADD `dev15` VARCHAR(255) NULL AFTER `dev14`;
ALTER TABLE `projectmaster` ADD `dev16` VARCHAR(255) NULL AFTER `dev15`;
ALTER TABLE `projectmaster` ADD `dev17` VARCHAR(255) NULL AFTER `dev16`;
ALTER TABLE `projectmaster` ADD `dev18` VARCHAR(255) NULL AFTER `dev17`;
ALTER TABLE `projectmaster` ADD `dev19` VARCHAR(255) NULL AFTER `dev18`;
ALTER TABLE `projectmaster` ADD `dev20` VARCHAR(255) NULL AFTER `dev19`;
ALTER TABLE `projectmaster` ADD `dev21` VARCHAR(255) NULL AFTER `dev20`;
ALTER TABLE `projectmaster` ADD `dev22` VARCHAR(255) NULL AFTER `dev21`;
ALTER TABLE `projectmaster` ADD `dev23` VARCHAR(255) NULL AFTER `dev22`;
ALTER TABLE `projectmaster` ADD `dev24` VARCHAR(255) NULL AFTER `dev23`;
ALTER TABLE `projectmaster` ADD `dev25` VARCHAR(255) NULL AFTER `dev24`;

------------------------------------------------------------9/11/2017-----------------------------------------------------------------------------------
ALTER TABLE `blobt` ADD `rev_attachment` VARCHAR(255) NULL AFTER `severity`;

