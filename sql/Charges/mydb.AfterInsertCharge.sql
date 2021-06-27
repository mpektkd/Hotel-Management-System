DELIMITER $$

CREATE TRIGGER after_charges_insert
AFTER INSERT
ON ServiceCharge 
FOR EACH ROW
BEGIN

	IF new.isPaid = 0 THEN
	update ActiveCustomerLiveToRooms
		set TotalBill = TotalBill + new.CostAmount
			where BraceletId=new.BraceletId;
            
	END IF;
            
END$$

DELIMITER ;