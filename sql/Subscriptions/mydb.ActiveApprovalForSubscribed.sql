
DELIMITER $$

CREATE TRIGGER after_subscription_insert
AFTER INSERT
ON SubscriptionToServices 
FOR EACH ROW
BEGIN
	
    call GetApprovalForSubscribed(new.BraceletId, new.idServices);
    
END$$

DELIMITER ;

