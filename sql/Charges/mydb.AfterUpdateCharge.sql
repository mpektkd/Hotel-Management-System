DELIMITER $$

CREATE TRIGGER after_charges_update
AFTER UPDATE
ON ServiceCharge 
FOR EACH ROW
BEGIN

	IF new.isPaid = 1 THEN
		UPDATE ActiveCustomerLiveToRooms
			SET TotalBill = TotalBill - new.CostAmount
				where BraceletId=new.BraceletId;
	END IF;

END$$

DELIMITER ;

