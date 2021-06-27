DELIMITER $$

CREATE TRIGGER before_charges_delete
BEFORE DELETE
ON ServiceCharge 
FOR EACH ROW
BEGIN

		UPDATE ActiveCustomerLiveToRooms
			SET TotalBill = TotalBill - old.CostAmount
				where BraceletId=old.BraceletId;
END$$

DELIMITER ;

