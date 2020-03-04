#galleon_lanka_db_script

#query for viewing stocks
SELECT `item_no`,`type`,`dept`,SUM(qty) as Qty FROM `stocks`  GROUP BY `item_no`,`type`,`dept`

#sithara
CREATE TABLE `galleon_lanka`.`supplier` (
 `sid` INT NOT NULL ,
 `Name` VARCHAR(50) NOT NULL ,
 `Address` VARCHAR(100) NULL ,
 `tpno` VARCHAR(20) NOT NULL ,
 PRIMARY KEY (`sid`))
 ENGINE = MyISAM;

#sithara
CREATE TABLE `galleon_lanka`.`materials` (
 `mid` INT NOT NULL ,
 `Name` VARCHAR(50) NOT NULL ,
 `Type` VARCHAR(20) NOT NULL ,
 `sid` INT NOT NULL ,
 `value` FLOAT NOT NULL ,
 PRIMARY KEY (`mid`))
 ENGINE = MyISAM;

#gima
CREATE TABLE `galleon_lanka`.`finished_products` (
 `fp_id` INT NOT NULL ,
 `Name` VARCHAR(50) NOT NULL ,
 `bom_id` VARCHAR(20) NOT NULL ,
 `value` FLOAT NOT NULL ,
 PRIMARY KEY (`fp_id`))
 ENGINE = MyISAM;

#gima
CREATE TABLE `galleon_lanka`.`employees` (
 `eno` INT NOT NULL ,
 `Name` VARCHAR(50) NOT NULL ,
 `Designation` VARCHAR(20) NOT NULL ,
 `Dept` VARCHAR(20) NOT NULL ,
 `password` VARCHAR(20) NOT NULL ,
 PRIMARY KEY (`eno`))
 ENGINE = MyISAM;

#dan
CREATE TABLE `galleon_lanka`.`customer` (
 `cno` INT NOT NULL ,
 `Name` VARCHAR(50) NOT NULL ,
 `Address` VARCHAR(50) NULL ,
 `tpno` VARCHAR(20) NULL ,
 `type` VARCHAR(20) NOT NULL ,
 PRIMARY KEY (`cno`))
 ENGINE = MyISAM;

#dan
CREATE TABLE `galleon_lanka`.`purchase_orders` (
 `no` INT NOT NULL AUTO_INCREMENT ,
 `po_no` INT NOT NULL ,
 `sid` INT NOT NULL ,
 `mid` INT NOT NULL ,
 `qty` INT NOT NULL ,
 `prep_date` DATE NOT NULL ,
 `amount` INT NOT NULL ,
 `delivery_date` DATE NOT NULL ,
 `prepared_by_(eno)` INT NOT NULL ,
 PRIMARY KEY (`no`))
 ENGINE = MyISAM;

CREATE TABLE `galleon_lanka`.`grn` (
 `no` INT NOT NULL AUTO_INCREMENT ,
 `grn_no` INT NOT NULL ,
 `po_no` INT NOT NULL ,
 `sid` INT NOT NULL ,
 `mid` INT NOT NULL ,
 `qty` INT NOT NULL ,
 `date` DATE NOT NULL ,
 `amount` FLOAT NULL ,
 `prepared_by_(eno)` INT NOT NULL ,
 `remarks` VARCHAR(100) NOT NULL ,
 PRIMARY KEY (`no`))
 ENGINE = MyISAM;

CREATE TABLE `galleon_lanka`.`payment_voucher` (
 `pv_no` INT NOT NULL ,
 `grn_no` INT NULL ,
 `sid` INT NOT NULL ,
 `date` DATE NOT NULL ,
 `amount` FLOAT NOT NULL ,
 `prepared_by_(eno)` INT NOT NULL ,
 `remarks` VARCHAR(100) NULL ,
 PRIMARY KEY ( `pv_no`))
 ENGINE = MyISAM;

CREATE TABLE `galleon_lanka`.`gtn` (
 `no` INT NOT NULL AUTO_INCREMENT ,
 `gtn_no` INT NOT NULL ,
 `item_no` INT NOT NULL ,
 `qty` INT NOT NULL ,
 `remarks` VARCHAR(100) NULL ,
 `from(dept)` VARCHAR(20) NOT NULL ,
 `to(dept)` VARCHAR(20) NOT NULL ,
 `prepared_by` INT NOT NULL ,
 `approved_by` INT NULL ,
 `date` DATE NOT NULL ,
 PRIMARY KEY (`no`))
 ENGINE = MyISAM;

#sajini
CREATE TABLE `galleon_lanka`.`invoice` (
 `no` INT NOT NULL AUTO_INCREMENT ,
 `invoice_no` INT NOT NULL ,
 `cno` INT NOT NULL ,
 `item_no` INT NOT NULL ,
 `remarks` VARCHAR(100) NULL ,
 `qty` INT NOT NULL ,
 `value` FLOAT NOT NULL ,
 `prepared_by` INT NOT NULL ,
 `approved_by` INT NULL ,
 `date` DATE NOT NULL ,
 `po_no` INT NULL ,
 `vehicle_no` INT NULL ,
 `total` FLOAT NOT NULL ,
 PRIMARY KEY (`no`))
 ENGINE = MyISAM;

CREATE TABLE `galleon_lanka`.`cash_receipts` (
 `no` INT NOT NULL AUTO_INCREMENT ,
 `cr_no` INT NOT NULL ,
 `invoice_no` INT NOT NULL ,
 `cno` INT NOT NULL ,
 `remarks` VARCHAR(100) NULL ,
 `amout` FLOAT NOT NULL ,
 `prepared_by` INT NOT NULL ,
 `approved_by` INT NULL ,
 `date` DATE NOT NULL ,
 PRIMARY KEY (`no`))
 ENGINE = MyISAM;

CREATE TABLE `galleon_lanka`.`creditors` (
 `crid` INT NOT NULL ,
 `sid` INT NOT NULL ,
 `amount` FLOAT NOT NULL ,
 `date` DATE NOT NULL ,
 PRIMARY KEY (`crid`))
 ENGINE = MyISAM;

CREATE TABLE `galleon_lanka`.`debtors` (
 `dbid` INT NOT NULL ,
 `cno` INT NOT NULL ,
 `amount` FLOAT NOT NULL ,
 `date` DATE NOT NULL ,
 PRIMARY KEY (`dbid`))
 ENGINE = MyISAM;

#bom
CREATE TABLE `galleon_lanka`.`bom` (
 `no` INT NOT NULL AUTO_INCREMENT ,
 `bom_id` INT NOT NULL ,
 `mid` INT NOT NULL ,
 `qty` INT NOT NULL ,
 PRIMARY KEY (`no`))
 ENGINE = MyISAM;

CREATE TABLE `galleon_lanka`.`stocks` (
 `no` INT NOT NULL AUTO_INCREMENT ,
 `item_no` INT NOT NULL ,
 `qty` INT NOT NULL ,
 `type` VARCHAR(20) NOT NULL ,
 `date` DATE NOT NULL ,
 `dept` VARCHAR(20) NOT NULL ,
 PRIMARY KEY (`no`))
 ENGINE = MyISAM;

INSERT INTO `employees`
(`eno`, `Name`, `Designation`, `Dept`, `password`)
 VALUES
 ('1', 't', 'Manager', 'Manager', '123');

 #altering the employee table
 ALTER TABLE `employees` CHANGE `eno` `eno` INT(11) NOT NULL AUTO_INCREMENT;

 #altering customer table
 ALTER TABLE `customer` CHANGE `cno` `cno` INT(11) NOT NULL AUTO_INCREMENT;

 #altering supplier table
 ALTER TABLE `supplier` CHANGE `sid` `sid` INT(11) NOT NULL AUTO_INCREMENT;

#altered the purchase_orders table
ALTER TABLE `purchase_orders` ADD `approvedBy` INT NULL AFTER `prepared_by_(eno)`;

#altered grn table
ALTER TABLE `grn` ADD `approvedBy` INT NULL AFTER `remarks`;

#altered materials table
ALTER TABLE `materials` CHANGE `mid` `mid` INT(11) NOT NULL AUTO_INCREMENT;

#altered finished products table
ALTER TABLE `finished_products` CHANGE `fp_id` `fp_id` INT(11) NOT NULL AUTO_INCREMENT;

#altered grn table
ALTER TABLE `grn` CHANGE `amount` `amount` FLOAT NOT NULL;
ALTER TABLE `grn` CHANGE `remarks` `remarks` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;
ALTER TABLE `grn` CHANGE `po_no` `po_no` INT(11) NULL;

#altered creditors table
ALTER TABLE `creditors`
  DROP PRIMARY KEY,
   ADD PRIMARY KEY(
     `sid`);

ALTER TABLE `creditors` DROP `crid`;

#altered gtn table
ALTER TABLE `gtn` DROP `to(dept)`;
ALTER TABLE `gtn` CHANGE `from(dept)` `dept` VARCHAR(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `gtn` ADD `type` VARCHAR(20) NOT NULL AFTER `qty`;
ALTER TABLE `gtn` ADD `item_type` VARCHAR(20) NOT NULL AFTER `item_no`;

#altered employees table
ALTER TABLE `employees` ADD `status` VARCHAR(20) NULL AFTER `password`;
UPDATE `employees` SET `status` = 'active' WHERE `employees`.`eno` = 1;
ALTER TABLE `employees` ADD `email` VARCHAR(50) NOT NULL AFTER `password`;

#altered debtor table
ALTER TABLE `debtors`
  DROP PRIMARY KEY,
   ADD PRIMARY KEY(
     `cno`);
ALTER TABLE `debtors` DROP `dbid`;

#altered debtor table
ALTER TABLE `debtors` ADD `no` INT NOT NULL FIRST;
ALTER TABLE `debtors`
  DROP PRIMARY KEY,
   ADD PRIMARY KEY(
     `no`);
ALTER TABLE `debtors` CHANGE `no` `no` INT(11) NOT NULL AUTO_INCREMENT;

#altered creditor table
ALTER TABLE `creditors` ADD `no` INT NOT NULL FIRST;
ALTER TABLE `creditors`
  DROP PRIMARY KEY,
   ADD PRIMARY KEY(
     `no`);
ALTER TABLE `creditors` CHANGE `no` `no` INT(11) NOT NULL AUTO_INCREMENT;
