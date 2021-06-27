
DELIMITER $$

CREATE TRIGGER after_active_insert
AFTER INSERT
ON ActiveCustomerLiveToRooms 
FOR EACH ROW
BEGIN
	
    call GetApprovalForCommon(new.BraceletId);
    
END$$

DELIMITER ;