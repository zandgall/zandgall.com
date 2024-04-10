DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `updateRunner`(IN `id_runner` INT, IN `fName` VARCHAR(50), IN `lName` VARCHAR(50), IN `phone` CHAR(10), IN `gender` VARCHAR(10), IN `sponsorName` VARCHAR(50))
BEGIN
UPDATE runner SET `fName`=fName, `lName`=lName, `phone`=phone, `gender`=gender WHERE `id_runner`=id_runner;
UPDATE sponsor SET `sponsorName`=sponsorName WHERE `id_runner`=id_runner;
END$$
DELIMITER ;